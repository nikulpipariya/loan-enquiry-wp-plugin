<?php
require_once BANK_PLUGIN_DIR . '/admin/includes/admin_functions.php';

/* 
Add User Data 
Step Form
*/

add_action('wp_ajax_nopriv_add_user_data', 'add_user_data');
add_action('wp_ajax_add_user_data', 'add_user_data');
function add_user_data (){
if($_POST['fForm']){
    global $wpdb;
    parse_str($_POST["fForm"], $_POST);
    global $wpdb;
    $table_name = $wpdb->prefix . USER_DATA;
    $phone = $_POST['phone'];
    $user_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE Phone = '$phone'" );
    $setNull = array(
        'First_name' => NULL,
        'Last_name' => NULL,
        'Email' => NULL,);
    $insert_array = array(
        'First_name' => $_POST['fname'],
        'Last_name' => $_POST['lname'],
        'Email' => $_POST['email'],
        'Phone' => $_POST['phone']);
    if($user_data){
        $success = $wpdb->update($table_name,$setNull,array("Phone" => $phone));
        $success = $wpdb->update($table_name,$insert_array,array("Phone" => $phone));
    }else{
        $success = $wpdb->insert($table_name,$insert_array);
    }
    if($success){
        $response = ['response'=>"success"];
        echo json_encode($response);
        exit();
    }
    exit();
}
if($_POST['sForm']){
    global $wpdb;
    parse_str($_POST["sForm"], $_POST);
    $table_name = $wpdb->prefix . USER_DATA;
    $phone = $_POST['phone'];
    $user_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE Phone = '$phone'" );
    $setNull = array(
        'Type_of_Customer' => NULL,
        'Loan_requirement' => NULL,
        'city' => NULL,
        'state' => NULL,);
    $update_array = array(
        'Type_of_Customer' => $_POST['customer_type'],
        'Loan_requirement' => $_POST['Loan_Requirement'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],);
    if($user_data){
        $success = $wpdb->update($table_name,$setNull,array("Phone" => $phone));
        $success = $wpdb->update($table_name,$update_array,array( 'phone' =>  $phone));
    }else{
        $success = $wpdb->update($table_name,$update_array,array( 'phone' =>  $phone));
    }
    if($success){
        $response = ['response'=>"success"];
        echo json_encode($response);
        //send_mail($data);
        exit();
    }
    exit();
}
if($_POST['tForm']){
    global $wpdb;
    parse_str($_POST["tForm"], $_POST);
    $table_name = $wpdb->prefix . USER_DATA;
    $phone = $_POST['phone'];
    $user_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE Phone = '$phone'" );
    $setNull = array(
        'Age_of_business' => NULL,
        'Business_registration_type_proof' => NULL,
        'Annual_turnover' => NULL);
    $update_array = array(
        'Age_of_business' => $_POST['Age_of_Business'],
        'Business_registration_type_proof' => $_POST['Business_Registration_Type/proof'],
        'Annual_turnover' => $_POST['annual_turnover']);
    if($user_data){
        $success = $wpdb->update($table_name,$setNull,array("Phone" => $phone));
        $success = $wpdb->update($table_name,$update_array,array( 'phone' =>  $phone));
    }else{
        $success = $wpdb->update($table_name,$update_array,array( 'phone' =>  $phone));
    }
    if($success){
        $response = ['response'=>"success"];
        echo json_encode($response);
//         send_mail($_POST);
        exit();
    }
    exit();
}
exit();
}


/* 
Display List of Banks to user
*/

add_action('wp_ajax_getBankList','getBankList');
add_action('wp_ajax_nopriv_getBankList','getBankList');
function getBankList(){
    global $wpdb;
    $phone = $_POST['userPhone'];

    $table_name = $wpdb->prefix.USER_DATA;
    //User Entry.
    $userData = $wpdb->get_results("SELECT * FROM $table_name WHERE Phone = $phone");

    //Get Inquired Banks (user Entry != inquired banks)
    $table_name = $wpdb->prefix.USER_INQUIRY;
    $userInquiry = $wpdb->get_results("SELECT * FROM $table_name WHERE phone = $phone");
    $appliedBanks = array(); //sent inquiry bank ids

    if($userInquiry){
        $phone = $userData[0]->Phone;
        $Type_of_customer = $userData[0]->Type_of_customer;
        $Loan_requirement = $userData[0]->Loan_requirement;
        // $city = $userData[0]->city;
        $state = $userData[0]->state;
        $Age_of_business = $userData[0]->Age_of_business;
        $Business_registration_type_proof = $userData[0]->Business_registration_type_proof;
        $Annual_turnover = $userData[0]->Annual_turnover;
        
        $userPrevInquiry = $wpdb->get_results("SELECT * FROM $table_name WHERE Phone = '$phone' AND
        Type_of_customer = '$Type_of_customer' AND
        Loan_requirement = '$Loan_requirement' AND
        state = '$state' AND
        Age_of_business = '$Age_of_business' AND
        Business_registration_type_proof = '$Business_registration_type_proof' AND
        Annual_turnover = '$Annual_turnover'");

        if($userPrevInquiry){
            foreach($userPrevInquiry as $appliedBank){
                array_push($appliedBanks,$appliedBank->bank_id);
            }
        }
    }        
    $loanAmount = $userData[0]->Loan_requirement;
    $states = $userData[0]->state;
    $age_of_bussiness = $userData[0]->Age_of_business;
    $age_of_bussiness = explode('-',$age_of_bussiness);
    $annual_turn_over = $userData[0]->Annual_turnover;

    $table_name = $wpdb->prefix.BANK_PLUGIN_DATA;
    if($annual_turn_over == 'More than 12 Lakhs'){
        $banks = $wpdb->get_results("SELECT * from $table_name WHERE min_age_of_bussiness <= $age_of_bussiness[1] AND min_loan_amount <= $loanAmount AND max_loan_amount > $loanAmount AND state LIKE '%$states%'");
    }else{
        $banks = $wpdb->get_results("SELECT * from $table_name WHERE min_age_of_bussiness <= $age_of_bussiness[1] AND min_loan_amount <= $loanAmount AND max_loan_amount > $loanAmount AND state LIKE '%$states%' AND min_annual_turnover < 1200000");
    }
    if(!$banks){
        $data = ['response'=>'error','msg'=>'You are not Eligibal'];
        echo json_encode($data);
        exit();
    }
    $intrestRate = array();
    $loanAmount = array();
    $loanTenture = array();
    $proccessingFee = array();
    $bankListItem = '';
    $bankListItem .= '<div class="bankListHeader"><input type="checkbox" id="selectAllBanks"><span>Select All Lenders</span></div>';
    foreach ($banks as $bank) {
        $logo_url = wp_get_attachment_image_src( $bank->logo, 'thumbnail' )[0];
        
        if(in_array($bank->id,$appliedBanks)){
            $applyLink = '<button class="applied" data-id="">Applied</button>';
            $applyCheckBox = '<input type="checkbox" class="" name="select_bank" data-attr="" disabled>';
        }else{
            $applyLink = '<button class="bankApply" data-id="'.$bank->id.'" data-mail="'.$bank->email.'">Apply Now</button>';
            $applyCheckBox = '<input type="checkbox" class="select_bank" data-mail="'.$bank->email.'" name="select_bank" data-attr="bank'.$bank->id.'">';
        }
        $bankItem = array(
            '$applyCheck' => $applyCheckBox,
            '$bankId' => $bank->id,
            '$logo_src' => $logo_url,
            '$bankTitle' => $bank->name,
            '$bankEmail' => $bank->email,
            '$minInterest' => $bank->min_interest,
            '$maxInterest' => $bank->max_interest,
            '$proccessingFee' => $bank->fee,
            '$minLoanAmount' => $bank->min_loan_amount,
            '$maxLoanAmount' => $bank->max_loan_amount,
            '$minTenture' => $bank->min_tenture,
            '$maxTenture' => $bank->max_tenture,
            '$annualTurnover' => $bank->min_annual_turnover,
            '$minAgeofBussiness' => $bank->min_age_of_bussiness,
            '$state' => $bank->state,
            '$documents' => $bank->documents,
            '$pros' => $bank->pros,
            '$cons' => $bank->cons,
            '$fees' => $bank->fees,
            '$apply' => $applyLink,
            );
            $bankItemTemplate = '<div class="banks">$applyCheck<div class="bank_item" id="bank$bankId"><div class="itemData"><div class="row_items"><div class="logo"><img src="$logo_src"></div><div><p class="title">$bankTitle</p><p class="subtitle">Bussiness Loan</p></div></div><div class="row_items"><div><p class="subtitle">Interest Rate Range</p><p class="title">$minInterest - $maxInterest</p><p class="subtitle">Fixed</p></div><div><p class="subtitle">Processing Fee Range</p><p class="title">Up to $proccessingFee</p><p class="subtitle">One time fee</p></div></div><div class="row_items"><div><p class="subtitle">Loan Amount</p><p class="title">Up to Rs. $maxLoanAmount</p></div><div><p class="subtitle">Tenure Range</p><p class="title">$minTenture - $maxTenture Months</p></div></div><div class="row_items"><div class="bank_action">$apply<button data-id="$bankId" class="toogleDetails">Details</button></div></div></div><div class="otherDetails"><div><p class="title">Documents Required</p>$documents</div><div><p class="title">Pros</p>$pros</div><div><p class="title">Cons</p>$cons</div><div><p class="title">Processing Fees</p>$fees</div></div></div></div>';

            $bankListItem .= strtr($bankItemTemplate, $bankItem);
            array_push($intrestRate,$bank->min_interest,$bank->max_interest);
            array_push($loanAmount,$bank->min_loan_amount,$bank->max_loan_amount);
            array_push($loanTenture,$bank->min_tenture,$bank->max_tenture);
            array_push($proccessingFee,$bank->fee);
    }
    $bankListItem .= '<div class="bankListFooter"><div class="bank_action"><button id="applySelectedBanks">Apply</button></div></div>';
    $data = ['response'=>'success','data'=>$bankListItem,'minIntrest'=>min($intrestRate),'maxIntrest'=>max($intrestRate),'loanAmount'=>max($loanAmount),'loanTenture'=>max($loanTenture),'proccessingFee'=>max($proccessingFee)];
    echo json_encode($data);
    exit();

}

/* 
Add Inquiry In Database
*/

add_action('wp_ajax_addInquiry','addInquiry');
add_action('wp_ajax_nopriv_addInquiry','addInquiry');
function addInquiry(){
    global $wpdb;
    $table_name = $wpdb->prefix . USER_INQUIRY;
    $table_name_2 = $wpdb->prefix . USER_DATA;
    $phone = $_POST['phone'];
    $bankId = $_POST['bankId'];
    $loanAmount = $_POST['loan_amount'];
    $user_data = $wpdb->get_results( "SELECT * FROM $table_name_2 WHERE Phone = '$phone'" );
    if($_POST['bankIds']){
        $bankIDs = explode(',',$_POST['bankIds']);
        foreach($bankIDs as $bankid){
            $insert_array = array(
                'user_id' => $user_data[0]->id,
                'bank_id' => $bankid,
                'Phone' => $user_data[0]->Phone,
                'Type_of_customer' => $user_data[0]->Type_of_customer,
                'Loan_requirement' => $user_data[0]->Loan_requirement,
                'city' => $user_data[0]->city,
                'state' => $user_data[0]->state,
                'Age_of_business' => $user_data[0]->Age_of_business,
                'Business_registration_type_proof' => $user_data[0]->Business_registration_type_proof,
                'Annual_turnover' => $user_data[0]->Annual_turnover,
            );
            $success = $wpdb->insert($table_name,$insert_array);
        }
        if($success){
            echo json_encode(array('response'=>'success'));
            exit();
        }
    }
    $insert_array = array(
        'user_id' => $user_data[0]->id,
        'bank_id' => $_POST['bankId'],
        'Phone' => $user_data[0]->Phone,
        'Type_of_customer' => $user_data[0]->Type_of_customer,
        'Loan_requirement' => $user_data[0]->Loan_requirement,
        'city' => $user_data[0]->city,
        'state' => $user_data[0]->state,
        'Age_of_business' => $user_data[0]->Age_of_business,
        'Business_registration_type_proof' => $user_data[0]->Business_registration_type_proof,
        'Annual_turnover' => $user_data[0]->Annual_turnover,
    );
    $success = $wpdb->insert($table_name,$insert_array);
    if($success){
        echo json_encode(array('response'=>'success'));
        exit();
    }
}


/* 
OTP Sending and Verification
*/

add_action('wp_ajax_nopriv_sendUserOTP','sendUserOTP');
add_action('wp_ajax_sendUserOTP','sendUserOTP');
function sendUserOTP(){
    if ( ! session_id() ) {
        session_start();
    }
   $validTill = 120;
   $phone = $_POST['phone'];
    if(!$_SESSION['phone']){
        echo sendOTP($phone);
        exit();
    }
    if($_SESSION['phone'] != $phone){
        echo sendOTP($phone);
        exit();
    }
    else{
        //Check if OTP is expired.
        $timestamp =  $_SERVER["REQUEST_TIME"];
        if(($timestamp - $_SESSION['otptime']) > $validTill){
            //Send renew OTP
            echo sendOTP($phone);
            exit();
        }else{
            //OTP Already Sended
            echo json_encode(array('response'=>'Sended','validTill'=>$validTill));
            exit();
        }
    }
    exit();
}

add_action('wp_ajax_nopriv_verifyOTP','verifyOTP');
add_action('wp_ajax_verifyOTP','verifyOTP');
function verifyOTP(){
    $validTill = 120;
    $otp = $_POST['otp'];
    $phone = $_POST['phone'];
    //$otp == $_SESSION['otp']
    if($otp == $otp){
        if($phone == $_SESSION['phone']){
            $timestamp =  $_SERVER["REQUEST_TIME"];
            if(($timestamp - $_SESSION['otptime']) > $validTill){
                echo json_encode(array('response'=>'Expired','msg'=>'OTP Expired! Resend OTP'));
            }else{
                echo json_encode(array('response'=>'Verified'));
            }
        }else{
            echo json_encode(array('response'=>'Invalid Phone','msg'=>'OTP & Phone Number Missmatch. Resend OTP'));
        }
    }else{
        echo json_encode(array('response'=>'Invalid','msg'=>'Please Enter Valid OTP!'));
    }
    exit();
}

function sendOTP($phone){
    $validTill = 120;
    $otp = substr(str_shuffle("0123456789"), 0, 5);

    //Implement SMS API Gateway
    //strpos($response,"Successfully")

    $_SESSION['phone'] = $phone;
    $timestamp =  $_SERVER["REQUEST_TIME"];
    $_SESSION['otptime'] = $timestamp;
    $_SESSION['otp'] = $otp;
    $timestamp =  $_SERVER["REQUEST_TIME"];
    $response = json_encode(array('response'=>'Sent','validTill'=>$validTill,'msg'=>$response));
    
    return $response;
}

/* 
Send Mail to Bank & Admin
*/

add_action('wp_ajax_sendMail','sendMail');
add_action('wp_ajax_nopriv_sendMail','sendMail');
function sendMail(){
	global $wpdb;
    $table_name = $wpdb->prefix . USER_DATA;
	$table_name_2 = $wpdb->prefix . BANK_PLUGIN_DATA;
    $phone = $_POST['phone'];
    $bankid = $_POST['bankID'];
    $user_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE Phone = '$phone'" );
    if($_POST['bankIDs']){
		$bankIDs = explode(',',$_POST['bankIDs']);
        $banknames = '';
		foreach($bankIDs as $bankid){
			$bankData = $wpdb->get_results( "SELECT * FROM $table_name_2 WHERE ID = '$bankid'" );
			send_mail_bank(json_encode($user_data),$bankData[0]->email,$bankData[0]->name);
            $banknames .= $bankData[0]->name.', ';
		}
        send_mail_user(json_encode($user_data),$banknames);
		exit();
    }
	$bankData = $wpdb->get_results( "SELECT * FROM $table_name_2 WHERE ID = '$bankid'" );
    send_mail_user(json_encode($user_data),$bankData[0]->name);
    send_mail_bank(json_encode($user_data),$bankData[0]->email,$bankData[0]->name);
	exit();
}


// add_filter( 'wp_mail_from', 'my_mail_from' );
// function my_mail_from( $email ) {
// 	return get_option('admin_email');
// }

function send_mail_user($data,$bankname){
	$data = json_decode($data);
	$headers = array('Content-Type: text/html; charset=UTF-8');
	$mail_contents = "<h3 style='color:#eb4770'>Hello, ".get_bloginfo( 'name' )."</h3><h4 style='color:#000'>Please find below loan requirment of the user.</h4>";
	$mail_contents .= "<table cellspacing='0' cellpadding='0' style='border-collapse:collapse;font-size:0.6rem;margin:0;padding:0'><tbody>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Name</td><td style='text-align:end;font-wight:400'>".$data[0]->First_name.' '.$data[0]->Last_name."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Email</td><td style='text-align:end;font-wight:400'>".$data[0]->Email."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Phone Number</td><td style='text-align:end;font-wight:400'>".$data[0]->Phone."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Type of Customer</td><td style='text-align:end;font-wight:400'>".$data[0]->Type_of_customer."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Loan Requirement</td><td style='text-align:end;font-wight:400'>".$data[0]->Loan_requirement."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>City</td><td style='text-align:end;font-wight:400'>".$data[0]->city."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>State</td><td style='text-align:end;font-wight:400'>".$data[0]->state."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Age of Business</td><td style='text-align:end;font-wight:400'>".$data[0]->Age_of_business." Months</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Business Registration Type/proof</td><td style='text-align:end;font-wight:400'>".$data[0]->Business_registration_type_proof."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Annual Turnover</td><td style='text-align:end;font-wight:400'>".$data[0]->Annual_turnover."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Applied Bank</td><td style='text-align:end;font-wight:400'>".$bankname."</td></tr>";
    $mail_contents .= "<tr><td colspan='2' style='text-align:end;font-wight:400;font-wight:3rem;padding:20px 0px 20px 0px;'><b>Thanks, StartupYo Team</b></td></tr>";
    $mail_contents .= "</table></tbody>";
	wp_mail( get_option('admin_email'), 'Loan Application', $mail_contents,$headers);
}

function send_mail_bank($data,$bank_email,$bankname){
	$data = json_decode($data);
	$headers = array('Content-Type: text/html; charset=UTF-8');
	$mail_contents = "<h3 style='color:#eb4770'>Hello, ".$bankname."</h3><h4 style='color:#000'>Please find below loan requirment of the user.</h4>";
	$mail_contents .= "<table cellspacing='0' cellpadding='0' style='border-collapse:collapse;font-size:0.6rem;margin:0;padding:0'><tbody>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Name</td><td style='text-align:end;font-wight:400'>".$data[0]->First_name.' '.$data[0]->Last_name."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Email</td><td style='text-align:end;font-wight:400'>".$data[0]->Email."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Phone Number</td><td style='text-align:end;font-wight:400'>".$data[0]->Phone."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Type of Customer</td><td style='text-align:end;font-wight:400'>".$data[0]->Type_of_customer."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Loan Requirement</td><td style='text-align:end;font-wight:400'>".$data[0]->Loan_requirement."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>City</td><td style='text-align:end;font-wight:400'>".$data[0]->city."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>State</td><td style='text-align:end;font-wight:400'>".$data[0]->state."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Age of Business</td><td style='text-align:end;font-wight:400'>".$data[0]->Age_of_business." Months</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Business Registration Type/proof</td><td style='text-align:end;font-wight:400'>".$data[0]->Business_registration_type_proof."</td></tr>";
    $mail_contents .= "<tr><td style='padding:7px 0px 7px 0px;'>Annual Turnover</td><td style='text-align:end;font-wight:400'>".$data[0]->Annual_turnover."</td></tr>";
    $mail_contents .= "<tr><td colspan='2' style='text-align:end;font-wight:400;font-wight:3rem;padding:20px 0px 20px 0px;'><b>Thanks, StartupYo Team</b></td></tr>";
    $mail_contents .= "</table></tbody>";
	wp_mail( $bank_email, 'Loan Application', $mail_contents,$headers);	
}

?>
