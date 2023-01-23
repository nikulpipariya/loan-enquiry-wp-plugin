<?php
function bank_calculator() {
    $calculator = '<div class="bank_calculator">
    <div class="left_container"><p class="heading">Know your EMI now</p>
    <div class="amountBox cal_row">
        <p class="tag">Required Loan Amount</p>
		<div class="label">
			<div class="decAmount"><i class="fa fa-minus" aria-hidden="true"></i></div>
				<div><p class="tagTitle">
					<span class="currency">₹ </span><span class="amount">50000</span></p>
				</div>
			<div class="incAmount"><i class="fa fa-plus" aria-hidden="true"></i></div>
		</div>
        <input type="range" min="50000" max="20000000" value="50000" step="5000" class="range" id="r_loan_amount" name="r_loan_amount">
    </div>
    <div class="durationBox cal_row">
        <p class="tag">Required Loan Duration</p>
		<div class="label">
			<div class="decMonth"><i class="fa fa-minus" aria-hidden="true"></i></div>
				<div>
					<p class="tagTitle"><span class="duration">6</span><span> Months</span></p>
				</div>
			<div class="incMonth"><i class="fa fa-plus" aria-hidden="true"></i></div>
		</div>
        <input type="range" min="6" max="60" value="6" class="range" id="loan_duration" name="loan_duration">
    </div>
    <div class="intrestBox cal_row">
        <p class="tag">Loan Interest Rate</p>
		<div class="label">
			<div class="decInt"><i class="fa fa-minus" aria-hidden="true"></i></div>
				<div>
					<p class="tagTitle"><span class="intrest">10</span><span> %</span></p>
				</div>
			<div class="incInt"><i class="fa fa-plus" aria-hidden="true"></i></div>
		</div>
        <input type="range" min="10" max="36" value="10" step="0.01" class="range" id="intrestRate" name="intrestRate">
    </div>
    </div>
    <div class="right_container">
    <div class="cal_output">
        <div class="cal_row">
            <p class="tag">EMI Installment <span class="star">*</span></p>
            <p class="tagTitle"><span class="currency">₹ </span><span class="emi_amount">8,578.07</span></p>
        </div>
        <div class="cal_row">
            <p class="tag">Total Payable <span class="star">*</span></p>
            <p class="tagTitle"><span class="currency">₹ </span><span class="total_amount">51,468.42</span></p>
        </div>
        <div class="cal_row">
            <p class="tag">* Starting at 1.25% monthly reducing interest rate. Apply now to know your exact EMI & interest rate.</p>
        </div>
        <div class="cal_row footer">
            <button class="apply" id="applyForm">APPLY NOW</button>
        </div>
    </div>
    </div>
    </div>';
    return $calculator;
}
add_shortcode('EMICalculator','bank_calculator');

function get_bank_name(){
  
    global $wpdb;
    $table_name = $wpdb->prefix . BANK_PLUGIN_DATA;
    $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name" );
    $bank_data = array();
    $options = '';
    foreach ($retrieve_data as $data) {
        $options .= '<option id="'.$data->id.'" value="'.$data->bank_name.'">'.$data->bank_name.'</option>';
    }
    return $options;
}

function bank_form_shortcode() { 
    $form = '<div class="multistep_form">
	<div class="overlay hidden"><div class="loader"><span class="loader-18"> </span></div></div>
    <div class="flex-container space-between form-nav">
        <span class="form_step step1 active"><span>1</span></span>
        <span class="form_step step2"><span>2</span></span>
        <span class="form_step step3"><span>3</span></span>
    </div>';

    $form .= '<form class="bank_form active" id="step1">
    <div class="flex-container form_row">
        <div>
            <label>First Name (as per PAN)<span class="astrick">*</span></label>
            <input type="text" placeholder="Manish" name="fname" id="fname" class="">
        </div>
        <div>
            <label>Last Name (as per PAN)<span class="astrick">*</span></label>
            <input type="text" placeholder="Kumar" name="lname" id="lname" class="">
        </div>
    </div>
        <div class="form_row">
            <label>Email <span class="astrick">*</span></label>
            <input type="text" placeholder="e.g yourname@gmail.com" name="email" id="email" class="">
        </div>
        <div class="form_row">
            <label>Your Phone Number <span class="astrick">*</span></label>
            <div class="flex-container phone">
                <input type="tel" placeholder="e.g 9998121315" name="phone" id="phone" class="" value="">
                <button id="get_otp" class="form button" type="button">SEND OTP</button>
            </div>
        </div>
        <div class="form_row">
            <input type="text" placeholder="Enter Your OTP e.g 12345" name="otp" id="otpInput" class="">
            <span class="otp error tooltip"><span class="tooltip-text">Please Enter Valid OTP</span></span>
        </div>
    <input type="submit" class="step1 submit" data-next="step2" value="Next">
    </form>';

    $form .= '<form class="bank_form" id="step2">
    <div class="form_row">
        <label>Type of Customer <span class="astrick">*</span></label>
        <div class="radio_group">
        <div>
            <input type="radio" id="small & medium" value="small & medium" name="customer_type" required>
            <label for="small & medium">Small and Medium Enterprise</label>
        </div>
        <div>
            <input type="radio" id="Running Online/Offli ne Business" value="Running Online/Offli ne Business" name="customer_type" required>
            <label for="Running Online/Offli ne Business">Running Online/Offline Business</label>
        </div>
        <div>
            <input type="radio" id="In need of Working Capital Loan" value="In need of Working Capital Loan" name="customer_type" required>
            <label for="In need of Working Capital Loan">In need of Working Capital Loan</label>
        </div>
        </div>
    </div>

    <div class="form_row">
        <label>Loan Requirement <span class="astrick">*</span></label>
        <input type="number" placeholder="e.g. 1,30,000" name="Loan Requirement" id="loan_amount" class="" value="">
        <span class="loan_amount tooltip"><span class="tooltip-text">One Crore Only</span></span>
    </div>
    <div class="flex-container form_row">
        <div>
            <label>City<span class="astrick">*</span></label>
            <input type="text" placeholder="City Name" name="city" id="city" class="">
        </div>
        <div>
            <label>State<span class="astrick">*</span></label>
			<select name="states" id="states">
				<option disabled val="" selected>Select State</option>
			</select>
        </div>
    </div>
    <div class="flex-container form_row">
        <input type="button" class="submit navigation" data-next="step1" value="previous">
        <input type="submit" class="submit fill" data-next="step3" value="Next">
    </div>
</form>';

$form .= '<form class="bank_form" id="step3">
<div class="form_row">
    <label>Age of Business <span class="astrick">*</span></label>
    <div class="radio_group">
       <select id="age_of_bussiness" name="Age_of_Business" required>
            <option value="6-12">6m - 1y</option>
            <option value="12-24">1y - 2y</option>
            <option value="24-36" selected>2y - 3y</option>
            <option value="36-48">3y - 4y</option>
       </select>
    </div>
</div>
<div class="form_row">
    <label>Business Registration Type/proof <span class="astrick">*</span></label>
    <div class="radio_group">
        <div>
            <input type="radio" id="Proprietorship Firm" value="Proprietorship Firm" name="Business Registration Type/proof" required>
            <label for="Proprietorship Firm">Proprietorship Firm</label>
        </div>
        <div>
            <input type="radio" id="Partnership or LLP Firm" value="Partnership or LLP Firm" name="Business Registration Type/proof" required>
            <label for="Partnership or LLP Firm">Partnership or LLP Firm</label>
        </div>
        <div>
            <input type="radio" id="Private Limited and Public Limited Company" value="Private Limited and Public Limited Company" name="Business Registration Type/proof" required>
            <label for="Private Limited and Public Limited Company">Private Limited and Public Limited Company</label>
        </div>
    </div>
</div>
<div class="form_row">
    <label>Annual Business Turnover <span class="astrick">*</span></label>
    <div class="radio_group">
        <div>
            <input type="radio" id="Less than 12 Lakhs" value="Less than 12 Lakhs" name="annual_turnover" required>
            <label for="Less than 12 Lakhs">Less than 12 Lakhs</label>
        </div>
        <div>
            <input type="radio" id="More than 12 Lakhs" value="More than 12 Lakhs" name="annual_turnover" required>
            <label for="More than 12 Lakhs">More than 12 Lakhs</label>
        </div>
    </div>
</div>
<div class="flex-container form_row">
    <input type="button" class="submit navigation" data-next="step2" value="previous">
    <input type="submit" class="submit fill" data-next="step4" value="Check Eligibility">
</div>
</form>';
$form .= '<form class="bank_form output" id="step4">
<div class="form_row">
    <p class="heading">Bussiness Loan Details</p>
</div>
<div class="form_row">
    <table><tbody>
    <tr><td>Interest Rate</td><td>:</td><td><span class="minIntrest">0</span>% To <span class="maxIntrest">0</span>% p.a. Onwards</td></tr>
    <tr><td colspan=3><hr></td></tr>
    <tr><td>Loan Amount</td><td>:</td><td>Up to Rs. <span class="loanAmount">0</span></td></tr>
    <tr><td colspan=3><hr></td></tr>
    <tr><td>Loan Tenure</td><td>:</td><td>Up to <span class="loanTenture">0</span> years</td></tr>
    <tr><td colspan=3><hr></td></tr>
    <tr><td>Processing Fee</td><td>:</td><td>0% - <span class="proccessingFee">0</span>% of the loan amount + GST</td></tr>
    <tr><td colspan=3><hr></td></tr>
    </tbody></table>
</div>
<div>
    <input type="button" class="submit navigation fill" data-next="step1" value="Check Again">
</div>
<p class="error_msg">Sorry! You are not Eligble.</p>
</form>';
    $form .= '
    <div class="bank_form_popup error">
        <div class="popup_content">
        <div class="errorsg">You have already Submitted Application.</div>
        <div><ul class="applied_bank_list">
        </ul><span id="appliedBanks" class="hide"></span></div>
        <div style="display:flex;justify-content:center;gap:15px">
            <button class="procced" value="yes">Yes</button>
            <button class="cancel" value="no">No</button>
        </div>
        </div>
    </div></div>';
    return $form;
    }

add_shortcode('bank-form', 'bank_form_shortcode');
function bank_list_shortcode(){
    $list = '<div class="bank_form_popup success">
    <div class="popup_content">
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_3wo4gag4.json"  background="transparent"  speed="1"  style="width: 300px; height: 300px;"></lottie-player>
    </div>
</div>';
    $list .= '<div class="repeat"><button class="submit navigation fill" data-next="step1">Check Again</button>
    </div>';
    $list .='<div class="bank_list"></div>';
    return $list;
}
add_shortcode('bank-list', 'bank_list_shortcode');
?>

