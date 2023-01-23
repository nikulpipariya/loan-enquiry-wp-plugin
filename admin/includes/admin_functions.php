<?php
// All Pages

#Main Bank List Page
function bank_list(){
?>
<div class="bank_container top">
<div class="wrap">
<div class="overlay"></div>
<div id="bank_edit_form">
    <span class="close"><span class="dashicons dashicons-no-alt"></span></span>
    <div class="bank_update_form"> 
        <div class="wrap">
            <form class="update_bank" id="update_bank">
            <div class="full-w"><label>Bank Name : </label>
                <input type="text" placeholder="Bank Name" name="name" id="name" value=""></div>
            <div class="flex-collum-3">
                <input type="hidden" name="bankid" value="">
                <div><label>Email : </label>
                <input type="email" placeholder="Email" name="email" id="email" value=""></div>
                <div><label>Minimum Loan Amount: </label>
                <input type="number" placeholder="Minimum Loan Amount" name="min_loan_amount" min="0" id="min_loan_amount" value=""></div>
                <div><label>Maximum Loan Amount: </label>
                <input type="number" placeholder="Maximum Loan Amount" name="max_loan_amount" min="0" id="max_loan_amount" value=""></div>
                <div><label>Processing Fee : </label>
                <input type="number" placeholder="Processing Fee" step="0.01" max="100" name="fee" min="0" id="fee" value=""></div>
                <div><label>Minimum Interest Rate : </label>
                <input type="number" placeholder="Minimum Interest Rate" name="min_interest" min="0" step="0.01" max="100" id="min_interest" value=""></div>
                <div><label>Maximum Interest Rate : </label>
                <input type="number" placeholder="Maximum Interest Rate" name="max_interest" min="0" step="0.01" max="100" id="max_interest" value=""></div>
                <div><label>Minimum Annual Turnover</label>
                <input type="number" placeholder="e.g. 100000" name="min_annual_turnover" min="0" id="min_annual_turnover"></div>
                <div><label>Minimum Loan tenture : </label>
                <input type="number" placeholder="Minimum Loan tenture" name="min_tenture" min="0" id="min_tenture" value=""></div>
                <div><label>Maximum Loan tenture : </label>
                <input type="number" placeholder="Maximum Loan tenture" name="max_tenture" min="0" id="max_tenture" value=""></div>
                <div><label>Minimum Age of Business : </label>
                <input type="number" placeholder="Minimum Age of Business( Months )" name="min_age_of_bussiness" min="0" id="min_age_of_bussiness" value=""></div>
            </div>
            <div class="flex-collum-1-4">
                <label>Select State</label>
                <SELECT multiple="multiple" id="states" name="states">
                </SELECT>
            </div>
            <div class="row">
                <div><label>Required Documents</label>
                    <textarea name="documents" id="documents" value=""></textarea></div>
                    <div><label>Pros</label>
                    <textarea name="pros" id="pros" value=""></textarea></div>
                    <div><label>Cons</label>
                    <textarea name="cons" id="cons" value=""></textarea></div>
                    <div><label>Fess & Charges</label>
                    <textarea name="fees" id="fees" value=""></textarea></div>
            </div>
                <div class="logo_image"><label>Bank Logo : </label><div><img src="" width="80px" height="80px"> <input type="file" id="bank_logo" name="bank_logo" accept="image/svg,image/png, image/jpeg"></div></div>
                <span class="form_button"><input type="submit" class="submit button button-primary" value="Update" data-id=""> </span>
            </form>
        </div>
    </div>
</div>
<table class="wp-list-table widefat fixed striped table-view-list">
<thead>
	<th class="manage-column column-title column-primary sortable desc">Logo</th><th>Name</th><th>Email</th><th>Loan Amount</th><th>Interest</th><th>Tenture</th><th>Fee</th><th>Min Turnover</th><th>Min. Bussiness Age</th><th>State</th><th>&nbsp</th>
</thead>    
<tbody>
<?php   
	fetch_bankData();
    echo '</tbody></table></div></div>';
}

#Add Bank Form Page
function add_bank(){
    ?>
    <div class="bank_container top">
        <div class="wrap">
        <h2 class="text-center">Add New Bank</h2>
            <form name="post" class="add_bank" id="add_bank" enctype="multipart/form-data" action="" method="post">
                    <div class="full-w"><label>Name</label>
                    <input type="text" placeholder="Bank Name" name="name" id="name"></div>
                    <div class="flex-collum-3">
                    <div><label>Email</label>
                    <input type="email" placeholder="Email" name="email" id="email"></div>
                    <div><label>Minimum Loan Amount</label>
                    <input type="number" placeholder="e.g. 100000" name="min_loan_amount" min="0" id="min_loan_amount"></div>
                    <div><label>Maximum Loan Amount</label>
                    <input type="number" placeholder="e.g. 500000" name="max_loan_amount" min="0" id="max_loan_amount"></div>
                    <div><label>Processing Fee</label>
                    <input type="number" placeholder="e.g. 0.6" name="fee" step=".01" min="0" max="100" id="fee"></div>
                    <div><label>Minimum Interest Rate</label>
                    <input type="number" placeholder="e.g. 1.2" name="min_interest" min="0" step=".01" max="100" id="min_interest"></div>
                    <div><label>Maximum Interest Rate</label>
                    <input type="number" placeholder="e.g. 8.7" name="max_interest" min="0" step=".01" max="100" id="max_interest"></div>
                    <div><label>Minimum Annual Turnover</label>
                    <input type="number" placeholder="e.g. 100000" name="min_annual_turnover" min="0" id="min_annual_turnover"></div>
                    <div><label>Minimum Loan tenture</label>
                    <input type="number" placeholder="e.g. 1" name="min_tenture" min="0" id="min_tenture"></div>
                    <div><label>Maximum Loan tenture</label>
                    <input type="number" placeholder="e.g. 5" name="max_tenture" min="0" id="max_tenture"></div>
                    <div><label>Minimum Age of Business : </label>
                <input type="number" placeholder="Minimum Age of Business (Months)" name="min_age_of_bussiness" min="0" id="min_age_of_bussiness" value=""></div>
                </div>
                <div class="flex-collum-1-4">
                    <label>Select State</label>
                    <SELECT multiple="multiple" id="states" name="states">
                    </SELECT>
                </div>
                <div class="row">
                <div id="bank_docs"><label class="textarea_label">Required Documents</label>
                <textarea name="documents" id="documents"></textarea></div>
                <div id="bank_pros"><label class="textarea_label">Pros</label>
                <textarea name="pros" id="pros"></textarea></div>
                <div id="bank_cons"><label class="textarea_label">Cons</label>
                <textarea name="cons" id="cons"></textarea></div>
                <div id="bank_fees"><label class="textarea_label">Fess & Charges</label>
                <textarea name="fees" id="fees"></textarea></div></div>
                <input type="file" id="bank_logo" name="bank_logo" accept="image/png, image/jpeg">
                <span class="form_button">
                <input type="submit" class="submit button button-primary" value="Add Bank">
                <button class="button button-primary"><a href="<?php echo get_admin_url() ?>admin.php?page=bank_list"> View All Bank</a> </button>
                </span>
            </form>
        </div>
    </div>
<?php
}

#User List Page
function users_list(){
    ?>
    <div class="bank_container top full"><div class="wrap">
<div class="containe_header">
    <form id="filter_user" action="" type="POST">
        <div class="filter_input">
            <label>Loan Requirement Amount</label>
            <select name="load_requirement"><option selected>All</option>
            <option value="0 - 100000">0 - 1 Lakh</option>
            <option value="100000 - 200000">1 Lakh - 2 Lakh</option>
            <option value="200000 - 300000">2 Lakh - 3 Lakh</option>
            <option value="300000 - 400000">3 Lakh - 4 Lakh</option>
            <option value="400000 - 500000">4 Lakh - 5 Lakh</option>
            <option value="500000 - 1000000">5 Lakh - 10 Lakh</option>
            <option value="1000000 - 5000000">10 Lakh - 50 Lakh</option>
            </select>
        </div>
        <div class="filter_input">
            <label>Age Of Business(Wintage)</label>
            <select name="age_of_bussiness"><option selected>All</option><option value="6-12">6m - 1y</option><option value="12-24">1y - 2y</option><option value="24-36">2y - 3 y</option><option value="36-48">3y - 4y</option></select>
        </div>
        <div class="filter_input">
            <label>Annual Turover</label>
            <select name="annual_turnover"><option selected>All</option><option>Less than 12 Lakhs</option><option>More than 12 Lakhs</option></select>
        </div>
        <div class="filter_input">
            <label>State</label>
            <select id="states_filter" name="states"><option selected>All</option></select>
        </div>
        <div class="filter">
        <button class="button action submit">Filter</button>
        </div>
    </form>
    <div class="export_user">
    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
        <div><i class="fa fa-calendar"></i></div>
        <div><span class="dateRange"></span> <i class="fa fa-caret-down"></i></div>
    </div>
    <button class="button action getDateRangeData">Download</button>
</div>
</div>
    <table class="wp-list-table widefat striped table-view-list" id="userList">
    <thead>
        <!-- <th class="">ID</th> -->
        <th>Name</th><th>Email</th><th>Phone</th><th>Customer Type</th><th>Loan Require</th><th>City</th><th>State</th><th>Age of business(Wintage)</th><th>Register Type</th><th>Turn Over</th><th>&nbsp</th>
    </thead>    
    <tbody>    
<?php 
    fetch_users();
    echo '</tbody></table><div class="footer"><button class="button action downloadData">Download Data</button><div></div></div>';
}

#User List Page
function users_inquiry(){
    ?>
    <div class="bank_container top full"><div class="wrap">
<div class="containe_header">
    <form id="filter_inquiry" action="" type="POST">
        <div class="filter_input">
            <label>Loan Requirement Amount</label>
            <select name="load_requirement"><option selected>All</option>
            <option value="0 - 100000">0 - 1 Lakh</option>
            <option value="100000 - 200000">1 Lakh - 2 Lakh</option>
            <option value="200000 - 300000">2 Lakh - 3 Lakh</option>
            <option value="300000 - 400000">3 Lakh - 4 Lakh</option>
            <option value="400000 - 500000">4 Lakh - 5 Lakh</option>
            <option value="500000 - 1000000">5 Lakh - 10 Lakh</option>
            <option value="1000000 - 5000000">10 Lakh - 50 Lakh</option>
            </select>
        </div>
        <!-- <div class="filter_input">
            <label>State</label>
            <select id="states_filter" name="states"><option selected>All</option></select>
        </div> -->
        <div class="filter">
        <button class="button action submit">Filter</button>
        </div>
    </form>
    <div class="export_user">
    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
        <div><i class="fa fa-calendar"></i></div>
        <div><span class="dateRange"></span> <i class="fa fa-caret-down"></i></div>
    </div>
    <button class="button action downloadInquiry">Download</button>
</div>
</div>
    <table class="wp-list-table widefat striped table-view-list" id="userInquiry">
    <thead>
        <!-- <th class="">ID</th> -->
        <th>User Phone</th><th>Bank Name</th><th>Loan Required</th><th>Customer Type</th><th>City</th><th>State</th><th>Business Age</th><th>Business Type</th><th>Annual Turnover</th>
    </thead>    
    <tbody>    
<?php 
    get_user_inquiry();
    echo '</tbody></table><div class="footer"><button class="button action downloadData">Download Data</button><div></div></div>';
}

#User Form ShortCode page
function user_form(){
    echo '<div class="bank_container grid center">
    <div class="wrap shortcode">
    <table>
        <tbody>
        <tr>
            <td><label>Inquiry Form</label></td>
            <td><input type="text" value="[bank-form]" readonly></td>
        </tr>
        <tr>
            <td><label>EMI Calculator</label></td>
            <td><input type="text" value="[EMICalculator]" readonly></td>
        </tr>
        <tr>
            <td> <label>Bank List</label></td>
            <td><input type="text" value="[bank-list]" readonly></td>
        </tr>
        </tbody>
    </table>
    </div></div>';
}
//End of Pages

function fetch_users(){
    global $wpdb;
    $table_name = $wpdb->prefix . USER_DATA;
    $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name" );
    $bank_data = array();
    $bank_data_table = '';
    $id = 1;
    foreach ($retrieve_data as $data) {
        // $bank_data_table .= '<tr><td class="row_id">'.$id.'</td>';
        $bank_data_table .= '<tr><td class="bank_name">'.$data->First_name.' '.$data->Last_name.'</td>';
        $bank_data_table .= '<td class="Email">'.$data->Email.'</td>';
        $bank_data_table .= '<td class="Phone">'.$data->Phone.'</td>';
        $bank_data_table .= '<td class="customer">'.$data->Type_of_customer.'</td>';
        $bank_data_table .= '<td class="Requirment">'.$data->Loan_requirement.'</td>';
        $bank_data_table .= '<td class="city">'.$data->city.'</td>';
        $bank_data_table .= '<td class="state">'.$data->state.'</td>';
        $bank_data_table .= '<td class="bussiness_age">'.$data->Age_of_business.'</td>';
        $bank_data_table .= '<td class="register_type">'.$data->Business_registration_type_proof.'</td>';
        $bank_data_table .= '<td class="turnover">'.$data->Annual_turnover.'</td>';
		$bank_data_table .= '<td class="delete-user"><button class="button button-primary" id="'.$data->id.'">Delete</button></td></tr>';
        $id++;
    }
    echo $bank_data_table;
}
function fetch_bankData(){
    global $wpdb;
    $table_name = $wpdb->prefix . BANK_PLUGIN_DATA;
    $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name" );
    $bank_data = array();
    $bank_data_table = '';
    $id = 1;
    foreach ($retrieve_data as $data) {
        $logo_url = wp_get_attachment_image_src( $data->logo, 'thumbnail' )[0];
        $logo = '<div class="logo" style="background-image:url('.$logo_url.');"></div>';
        $bank_data_table .= '<tr><td class="fee row_id">'.$logo.'</td>';
        $bank_data_table .= '<td class="name">'.$data->name.'</td>';
        $bank_data_table .= '<td class="email">'.$data->email.'</td>';
		$bank_data_table .= '<td class="max_loan_amount" >'.$data->min_loan_amount.' To '.$data->max_loan_amount.'</td>';
        $bank_data_table .= '<td class="interest">'.$data->min_interest.' To '.$data->max_interest.'</td>';
        $bank_data_table .= '<td class="min_tenture">'.$data->min_tenture.' To '.$data->max_tenture.'</td>';
        $bank_data_table .= '<td class="fee">'.$data->fee.'</td>';
        $bank_data_table .= '<td class="min_annual_turnover">'.$data->min_annual_turnover.'</td>';
        $bank_data_table .= '<td class="min_age_of_bussiness">'.$data->min_age_of_bussiness.'</td>';
        $bank_data_table .= '<td class="state">'.$data->state.'</td>';
        $bank_data_table .= '<td class="change_record" colspan="2"><button class="delete_record button button-primary" id="'.$data->id.'">Delete</button><button class="update_record button button-primary" id="'.$data->id.'">Edit</button><span class="bank_details" data-id="'.$data->id.'">Details<span class="dashicons dashicons-arrow-down-alt2"></span></span></td>';
        $bank_data_table .= '<tr class="other_details '.$data->id.'">
        <td colspan="5"><p>Documents Required</p>'.$data->documents.'</td>';
        $bank_data_table .= '<td colspan="5"><p>Pros</p>'.$data->pros.'</td></tr>';
        $bank_data_table .= '<tr class="other_details '.$data->id.'">
        <td colspan="5"><p>Cons</p>'.$data->cons.'</td>';
        $bank_data_table .= '<td colspan="5"><p>Processing Fees</p>'.$data->fees.'</td></tr>';
        $id++;
    }
    echo $bank_data_table;
}


//Ajax Request

add_action('wp_ajax_add_bank_data', 'add_bank_data');
function add_bank_data(){
    global $wpdb;
    if($_FILES){
        $file_name = $_FILES['bank_logo']['name'];
        $file_temp = $_FILES['bank_logo']['tmp_name'];

        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents( $file_temp );
        $filename = basename( $file_name );
        $filetype = wp_check_filetype($file_name);
        $filename = time().'.'.$filetype['ext'];

        if ( wp_mkdir_p( $upload_dir['path'] ) ) {
          $file = $upload_dir['path'] . '/' . $filename;
        }
        else {
          $file = $upload_dir['basedir'] . '/' . $filename;
        }

        file_put_contents( $file, $image_data );
        $wp_filetype = wp_check_filetype( $filename, null );
        $attachment = array(
          'post_mime_type' => $wp_filetype['type'],
          'post_title' => sanitize_file_name( $filename ),
          'post_content' => '',
          'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment( $attachment, $file );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        wp_update_attachment_metadata( $attach_id, $attach_data );
    }
    parse_str($_POST["post_data"], $_POST);
    $state = preg_replace('/[^A-Za-z0-9. -]/', ',', $_POST['state']);
    $table_name = $wpdb->prefix . BANK_PLUGIN_DATA;
    $insert_array = array(
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'state' => $state,
        'min_loan_amount' => $_POST['min_loan_amount'],
        'max_loan_amount' => $_POST['max_loan_amount'],
		'min_interest' => $_POST['min_interest'],
        'max_interest' => $_POST['max_interest'],
        'min_tenture' => $_POST['min_tenture'],
		'max_tenture' => $_POST['max_tenture'],
        'fee' => $_POST['fee'],
        'min_age_of_bussiness' => $_POST['min_age_of_bussiness'],
        'min_annual_turnover' => $_POST['min_annual_turnover'],
        'documents' => $_POST['documents'],
        'pros' => $_POST['pros'],
        'cons' => $_POST['cons'],
        'fees' => $_POST['fees'],
        'logo' => $attach_id);
    $success = $wpdb->insert($table_name,$insert_array);
    if($success){
        echo 'success';
    }else{
        echo 'error';
    }
    exit();
}



add_action('wp_ajax_update_bank_data', 'update_bank_data');
function update_bank_data(){
    global $wpdb;
    parse_str($_POST["post_data"], $_POST);
    $table_name = $wpdb->prefix . BANK_PLUGIN_DATA;
    $id =$_POST['bankid'];
    $setNull = $wpdb->update($table_name,array('state' => ''),array( 'ID' => $id ));
    $state = preg_replace('/[^A-Za-z0-9. -]/', ',', $_POST['state']);
    if($_FILES){
        $file_name = $_FILES['bank_logo']['name'];
        $file_temp = $_FILES['bank_logo']['tmp_name'];

        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents( $file_temp );
        $filename = basename( $file_name );
        $filetype = wp_check_filetype($file_name);
        $filename = time().'.'.$filetype['ext'];

        if ( wp_mkdir_p( $upload_dir['path'] ) ) {
          $file = $upload_dir['path'] . '/' . $filename;
        }
        else {
          $file = $upload_dir['basedir'] . '/' . $filename;
        }

        file_put_contents( $file, $image_data );
        $wp_filetype = wp_check_filetype( $filename, null );
        $attachment = array(
          'post_mime_type' => $wp_filetype['type'],
          'post_title' => sanitize_file_name( $filename ),
          'post_content' => '',
          'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment( $attachment, $file );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        wp_update_attachment_metadata( $attach_id, $attach_data ); 
        $data = $wpdb->get_results("SELECT * FROM $table_name WHERE ID = $id");
        wp_delete_attachment($data[0]->logo);
        $update_array = array(
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'state' => $state,
            'min_loan_amount' => $_POST['min_loan_amount'],
            'max_loan_amount' => $_POST['max_loan_amount'],
            'min_interest' => $_POST['min_interest'],
            'max_interest' => $_POST['max_interest'],
            'min_tenture' => $_POST['min_tenture'],
            'max_tenture' => $_POST['max_tenture'],
            'fee' => $_POST['fee'],
            'min_age_of_bussiness' => $_POST['min_age_of_bussiness'],
            'min_annual_turnover' => $_POST['min_annual_turnover'],
            'documents' => $_POST['documents'],
            'pros' => $_POST['pros'],
            'cons' => $_POST['cons'],
            'fees' => $_POST['fees'],
            'logo' =>$attach_id);
    }else{
        $update_array = array(
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'state' => $state,
            'min_loan_amount' => $_POST['min_loan_amount'],
            'max_loan_amount' => $_POST['max_loan_amount'],
            'min_interest' => $_POST['min_interest'],
            'max_interest' => $_POST['max_interest'],
            'min_tenture' => $_POST['min_tenture'],
            'max_tenture' => $_POST['max_tenture'],
            'fee' => $_POST['fee'],
            'min_age_of_bussiness' => $_POST['min_age_of_bussiness'],
            'min_annual_turnover' => $_POST['min_annual_turnover'],
            'documents' => $_POST['documents'],
            'pros' => $_POST['pros'],
            'cons' => $_POST['cons'],
            'fees' => $_POST['fees'],);
    }
    $result = $wpdb->update($table_name,$update_array,array( 'ID' => $id ));
    if($result == '1'){
        fetch_bankData();
        exit();
    }else{
        exit();
    }
}


add_action('wp_ajax_get_bank_data', 'get_bank_data');
function get_bank_data(){
    if(isset($_POST['bank_id'])){
        global $wpdb;
        $table_name = $wpdb->prefix . BANK_PLUGIN_DATA;
        $bank_info = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM " . $table_name . " 
                WHERE id = '".$_POST['bank_id']."'")
        );
        if ( $bank_info > 0){
            $logo_url = wp_get_attachment_image_src( $bank_info[0]->logo, 'thumbnail' )[0];
            $bank_info[0]->logourl = $logo_url;
            echo json_encode($bank_info);
            exit();
        }else{
            echo 'error';
            exit();
        }
    }
    fetch_bankData();
    exit();

}


add_action('wp_ajax_delete_bank_record', 'delete_bank_record');
function delete_bank_record(){
    global $wpdb;
    $table_name = $wpdb->prefix . BANK_PLUGIN_DATA;
    $id = $_POST['id'];
    $data = $wpdb->get_results("SELECT * FROM $table_name WHERE ID = $id");
    wp_delete_attachment($data[0]->logo);
    $data= $wpdb->delete( $table_name, array( 'id' => $id ) );
    if($data){
        fetch_bankData();
    }else{
        echo 'Can\'t Delete';
    }
    
    exit(); 
}


add_action('wp_ajax_delete_user_record', 'delete_user_record');
function delete_user_record(){
    global $wpdb;
    $table_name = $wpdb->prefix . USER_DATA;
    $id = $_POST['id'];
    $data= $wpdb->delete( $table_name, array( 'id' => $id ) );
    if($data){
        fetch_users();
    }else{
        echo 'Can\'t Delete';
    }
    
    exit(); 
}
add_action('wp_ajax_filter_user_record','filter_user_record');
function filter_user_record(){
    parse_str($_POST['filterData'],$_POST);
    $loan_requirement =  explode(' - ',$_POST['load_requirement']);
    $age_of_bussiness = $_POST['age_of_bussiness'];
    $annual_turnover = $_POST['annual_turnover'];
    $states = $_POST['states'];
    $states = str_replace('-',' ',$states);
    
    if($loan_requirement[0] == 'All'){
        $loan_requirement[0] = 'Loan_requirement';
        $loan_requirement[1] = 'Loan_requirement';
    }
    if($age_of_bussiness == 'All'){
        $age_of_bussiness = 'Age_of_business';
    }else{
        $age_of_bussiness = "'$age_of_bussiness'";
    }
    if($annual_turnover == 'All'){
        $annual_turnover = 'Annual_turnover';
    }else{
        $annual_turnover = "'$annual_turnover'";
    }
    if($states == 'All'){
        $states = 'state';
    }else{
        $states = "'$states'";
    }
    global $wpdb;
    $table_name = $wpdb->prefix . USER_DATA;
    $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE
     `Loan_requirement` BETWEEN $loan_requirement[0] AND $loan_requirement[1] AND `Age_of_business` = $age_of_bussiness AND `Annual_turnover` = $annual_turnover AND `state` = $states" );
    if($retrieve_data){
        $bank_data = array();
        $bank_data_table = '';
        $id = 1;
        foreach ($retrieve_data as $data) {
            // $bank_data_table .= '<tr><td class="row_id">'.$id.'</td>';
            $bank_data_table .= '<tr><td class="bank_name">'.$data->First_name.' '.$data->Last_name.'</td>';
            $bank_data_table .= '<td class="Email">'.$data->Email.'</td>';
            $bank_data_table .= '<td class="Phone">'.$data->Phone.'</td>';
            $bank_data_table .= '<td class="customer">'.$data->Type_of_customer.'</td>';
            $bank_data_table .= '<td class="Requirment">'.$data->Loan_requirement.'</td>';
            $bank_data_table .= '<td class="city">'.$data->city.'</td>';
            $bank_data_table .= '<td class="state">'.$data->state.'</td>';
            $bank_data_table .= '<td class="bussiness_age">'.$data->Age_of_business.'</td>';
            $bank_data_table .= '<td class="register_type">'.$data->Business_registration_type_proof.'</td>';
            $bank_data_table .= '<td class="turnover">'.$data->Annual_turnover.'</td>';
            $bank_data_table .= '<td class="delete-user"><button class="button button-primary" id="'.$data->id.'">Delete</button></td></tr>';
            $id++;
        }
    }else{
        $bank_data_table = 'No Data Found';
    }
    
    echo $bank_data_table;
    exit();
}
add_action('wp_ajax_noprive_getDateRangeData','getDateRangeData');
add_action('wp_ajax_getDateRangeData','getDateRangeData');
function getDateRangeData(){
    $startdate = $_POST['startDate'];
    $enddate = $_POST['endDate'];
    global $wpdb;
    $table_name = $wpdb->prefix . USER_DATA;
    if($startdate == 'all'){
        $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name" );
    }else{
        $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE
    `date` BETWEEN '$startdate\'T00:00:00.00' AND '$enddate\'T00:00:00.00' " );
    }
    if($retrieve_data){
        $bank_data = array();
        $bank_data_table = '';
        $id = 1;
        foreach ($retrieve_data as $data) {
            // $bank_data_table .= '<tr><td class="row_id">'.$id.'</td>';
            $bank_data_table .= '<tr><td class="bank_name">'.$data->First_name.' '.$data->Last_name.'</td>';
            $bank_data_table .= '<td class="Email">'.$data->Email.'</td>';
            $bank_data_table .= '<td class="Phone">'.$data->Phone.'</td>';
            $bank_data_table .= '<td class="customer">'.$data->Type_of_customer.'</td>';
            $bank_data_table .= '<td class="Requirment">'.$data->Loan_requirement.'</td>';
            $bank_data_table .= '<td class="city">'.$data->city.'</td>';
            $bank_data_table .= '<td class="state">'.$data->state.'</td>';
            $bank_data_table .= '<td class="bussiness_age">'.$data->Age_of_business.'</td>';
            $bank_data_table .= '<td class="register_type">'.$data->Business_registration_type_proof.'</td>';
            $bank_data_table .= '<td class="turnover">'.$data->Annual_turnover.'</td>';
            $bank_data_table .= '<td class="delete-user"><button class="button button-primary" id="'.$data->id.'">Delete</button></td></tr>';
            $id++;
        }
    }else{
        $bank_data_table = 'No Data Found';
    }
    
    echo $bank_data_table;
    exit();
}
add_action('wp_ajax_noprive_downloadInquiry','downloadInquiry');
add_action('wp_ajax_downloadInquiry','downloadInquiry');
function downloadInquiry(){
    $startdate = $_POST['startDate'];
    $enddate = $_POST['endDate'];
    global $wpdb;
    $table_name = $wpdb->prefix . USER_INQUIRY;
    if($startdate == 'all'){
        $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name" );
    }else{
        $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE
    `date` BETWEEN '$startdate\'T00:00:00.00' AND '$enddate\'T00:00:00.00' " );
    }
    if($retrieve_data){
        $bank_data_table = '';
        foreach ($retrieve_data as $inquiry) {
            global $wpdb;
            $table_name = $wpdb->prefix . USER_DATA;
            $userData = $wpdb->get_results( "SELECT * FROM $table_name WHERE ID = $inquiry->user_id" );
            $bank_data_table .= '<tr><td class="phone">'.$inquiry->Phone.'</td>';
    
            global $wpdb;
            $table_name = $wpdb->prefix . BANK_PLUGIN_DATA;
            $bankData = $wpdb->get_results( "SELECT * FROM $table_name WHERE ID = $inquiry->bank_id" );
            $bank_data_table .= '<td class="bank_name">'.$bankData[0]->name.'</td>';
            $bank_data_table .= '<td class="loan_require">'.$inquiry->Loan_requirement.'</td>';
            $bank_data_table .= '<td class="loan_require">'.$inquiry->Type_of_customer.'</td>';
            $bank_data_table .= '<td class="loan_require">'.$inquiry->city.'</td>';
            $bank_data_table .= '<td class="loan_require">'.$inquiry->state.'</td>';
            $bank_data_table .= '<td class="loan_require">'.$inquiry->Age_of_business.'</td>';
            $bank_data_table .= '<td class="loan_require">'.$inquiry->Business_registration_type_proof.'</td>';
            $bank_data_table .= '<td class="loan_require">'.$inquiry->Annual_turnover.'</td></tr>';
        }
    }else{
        $bank_data_table = 'No Data Found';
    }
    
    echo $bank_data_table;
    exit();
}
add_action('wp_ajax_filter_user_inquiry','filter_user_inquiry');
function filter_user_inquiry(){
    parse_str($_POST['filterData'],$_POST);
    $loan_requirement =  explode(' - ',$_POST['load_requirement']);
    if($loan_requirement[0] == 'All'){
        $loan_requirement[0] = 'Loan_requirement';
        $loan_requirement[1] = 'Loan_requirement';
    }
    global $wpdb;
    $table_name = $wpdb->prefix . USER_INQUIRY;
    $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE
     `Loan_requirement` BETWEEN $loan_requirement[0] AND $loan_requirement[1]" );
    $bank_data_table = '';
    if($retrieve_data){
        foreach($retrieve_data as $inquiry){
            global $wpdb;
            $table_name = $wpdb->prefix . USER_DATA;
            $userData = $wpdb->get_results( "SELECT * FROM $table_name WHERE ID = $inquiry->user_id" );
            $bank_data_table .= '<tr><td class="phone">'.$inquiry->Phone.'</td>';

            global $wpdb;
            $table_name = $wpdb->prefix . BANK_PLUGIN_DATA;
            $bankData = $wpdb->get_results( "SELECT * FROM $table_name WHERE ID = $inquiry->bank_id" );
            $bank_data_table .= '<td class="bank_name">'.$bankData[0]->name.'</td>';
            $bank_data_table .= '<td class="loan_require">'.$inquiry->Loan_requirement.'</td>';
            $bank_data_table .= '<td class="loan_require">'.$inquiry->Type_of_customer.'</td>';
            $bank_data_table .= '<td class="loan_require">'.$inquiry->city.'</td>';
            $bank_data_table .= '<td class="loan_require">'.$inquiry->state.'</td>';
            $bank_data_table .= '<td class="loan_require">'.$inquiry->Age_of_business.'</td>';
            $bank_data_table .= '<td class="loan_require">'.$inquiry->Business_registration_type_proof.'</td>';
            $bank_data_table .= '<td class="loan_require">'.$inquiry->Annual_turnover.'</td></tr>';
        }
    }
    else{
        $bank_data_table = 'No Data Found';
    }
     echo $bank_data_table;
     exit();
}
function get_user_inquiry(){
    global $wpdb;
    $table_name = $wpdb->prefix . USER_INQUIRY;
    $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name" );
    $inquiryData = '';
    foreach($retrieve_data as $inquiry){
        global $wpdb;
        $table_name = $wpdb->prefix . USER_DATA;
        $userData = $wpdb->get_results( "SELECT * FROM $table_name WHERE ID = $inquiry->user_id" );
        $bank_data_table .= '<tr><td class="phone">'.$inquiry->Phone.'</td>';

        global $wpdb;
        $table_name = $wpdb->prefix . BANK_PLUGIN_DATA;
        $bankData = $wpdb->get_results( "SELECT * FROM $table_name WHERE ID = $inquiry->bank_id" );
        $bank_data_table .= '<td class="bank_name">'.$bankData[0]->name.'</td>';
        $bank_data_table .= '<td class="loan_require">'.$inquiry->Loan_requirement.'</td>';
        $bank_data_table .= '<td class="loan_require">'.$inquiry->Type_of_customer.'</td>';
        $bank_data_table .= '<td class="loan_require">'.$inquiry->city.'</td>';
        $bank_data_table .= '<td class="loan_require">'.$inquiry->state.'</td>';
        $bank_data_table .= '<td class="loan_require">'.$inquiry->Age_of_business.'</td>';
        $bank_data_table .= '<td class="loan_require">'.$inquiry->Business_registration_type_proof.'</td>';
        $bank_data_table .= '<td class="loan_require">'.$inquiry->Annual_turnover.'</td></tr>';
    }
    echo $bank_data_table;
}
?>