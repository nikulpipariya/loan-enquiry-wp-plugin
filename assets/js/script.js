function navigateForm(id) {
    jQuery(`.form_step`).removeClass('active');
    jQuery(`.form_step.${id}`).addClass('active');
    jQuery('.bank_form').removeClass('active');
    jQuery(`#${id}`).addClass('active');
}

function popup_error(msg = '', bankName = '', ) {
    jQuery('.bank_form_popup.error').addClass('active');
    jQuery('.bank_form_popup.error .errorsg').text(msg);
    jQuery('.applied_bank_list').text('');
    if (bankName) {
        bankName.split(',').map((bankName) => jQuery('.applied_bank_list').append('<li>' + bankName + '</li>'));
    }
}
jQuery(document).on('submit', '#step1', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var fname = jQuery('#fname').val(),
        lname = jQuery('#lname').val(),
        email = jQuery('#email').val(),
        phone = jQuery('#phone').val();
    if (fname == '') { error_input('fname'); return false; } else { success_input('fname'); };
    if (/[^a-zA-Z]/.test(fname)) { error_input('fname'); return false; } else { success_input('fname'); };
    if (lname == '') { error_input('lname'); return false; } else { success_input('lname'); };
    if (/[^a-zA-Z]/.test(lname)) { error_input('lname'); return false; } else { success_input('lname'); };
    if (email == '' || emailCheck(email)) { error_input('email'); return false; } else { success_input('email'); };
    if (phone == '' || phone.length < 10 || phone.length > 10) { error_input('phone'); return false; } else { success_input('phone'); };
    var otp = jQuery('#otpInput').val();
    //Check if otp is sened;
    var otpattr = jQuery('#get_otp').attr('otp');
    if (!otpattr) {
        error_input('get_otp');
        return false;
    }
    var formData = jQuery(this).serialize();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'verifyOTP',
            otp: otp,
            phone: phone,
        },
        success: function(output) {
            success_input('get_otp');
            var output = JSON.parse(output);
            if (output['response'] != 'Verified') {
                jQuery('.otp.error').css('z-index', '99');
                jQuery('.otp.error').animate({ opacity: '1' });
                jQuery('.otp.error .tooltip-text').text(output['msg']);
            } else {
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'add_user_data',
                        fForm: formData,
                    },
                    success: function(output) {
                        var output = JSON.parse(output);
                        if (output['response'] == 'success') {
                            navigateForm('step2')
                            return false;
                        }
                        if (output['response'] == 'requiredata') {
                            jQuery('#phone').val(output['phone']);
                            navigateForm('step2');
                            return false;
                        }
                    }
                });
            }
        }
    });
});

jQuery(document).on('submit', '#step2', function(e) {
    jQuery('#get_otp').attr('');
    e.preventDefault();
    e.stopPropagation();
    var loan_amount = jQuery('#loan_amount').val(),
        city = jQuery('#city').val(),
        states = jQuery('#states').find(':selected').text(),
        phone = jQuery('#phone').val();
    if (loan_amount == '') { error_input('loan_amount'); return false; } else { success_input('loan_amount'); };
    if (city == '') { error_input('city'); return false; } else { success_input('city'); };
    if (/[^a-zA-Z]/.test(city)) { error_input('city'); return false; } else { success_input('city'); };
    if (states == 'Select State') { error_input('states'); return false; } else { success_input('states'); };
    var formData = jQuery(this).serialize();
    formData += '&state=' + states;
    formData += '&phone=' + phone;
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'add_user_data',
            sForm: formData,
        },
        success: function(output) {
            var output = JSON.parse(output);
            if (output['response'] == 'success') {
                navigateForm('step3')
                return false;
            } else {

                return false;
            }
        }
    });
});
jQuery(document).on('submit', '#step3', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var phone = jQuery('#phone').val();
    var formData = jQuery(this).serialize();
    formData += '&phone=' + phone;
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'add_user_data',
            tForm: formData,
        },
        success: function(output) {
            var output = JSON.parse(output);
            if (output['response'] == 'success') {
                var phone = jQuery('#phone').val();
                jQuery('.form-nav').css('display', 'none');
                getBankList(phone);
                jQuery('.overlay').removeClass('hidden');
                setTimeout(function() {
                    navigateForm('step4');
                    jQuery('.overlay').addClass('hidden');
                    jQuery('.bank_list').fadeIn();
                }, 00)
            } else {

            }
        },
        error: function(err) {
            console.log(err);
        }
    });
});
jQuery(document).on('click', '.bankApply', function() {
    var btn = jQuery(this);
    var bankId = jQuery(this).attr('data-id');
    var bankEmailid = jQuery(this).attr('data-mail');
    var phone = jQuery('#phone').val();
    var loan_amount = jQuery('#loan_amount').val();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'addInquiry',
            bankId: bankId,
            phone: phone,
            loan_amount: loan_amount,
        },
        success: function(output) {
            var output = JSON.parse(output);
            if (output['response'] == 'success') {
                sendMail('', bankId);
                jQuery(`input[data-attr="bank${bankId}"]`).removeClass('select_bank').attr('disabled', true);
                jQuery('#step4').removeClass('error');
                jQuery(btn).addClass('applied').removeClass('bankApply').attr('data-id', '');
                jQuery(btn).text('Applied');
                jQuery('.bank_form_popup.success').addClass('active');
                jQuery('.bank_form_popup.success .popup_content').css('display', 'block');
                jQuery('.bank_form_popup.success .popup_content').css('transform', 'scale(1)');
                let player = document.querySelector("lottie-player");
                player.play();
                setTimeout(function() {
                    jQuery('.bank_form_popup.success').removeClass('active');
                    jQuery('.bank_form_popup.success .popup_content').css('display', 'none');
                    player.stop();
                }, 1500)
            }
            if (output['response'] == 'error') {
                jQuery('#step4').addClass('error');
                jQuery('.bank_list').html('');
            }
        }
    });
});
jQuery(document).on('click', '#selectAllBanks', function(e) {
    var bankCheck = jQuery('.select_bank');
    bankCheck.prop('checked', !bankCheck.prop('checked'));
});

jQuery(document).on('click', '#applySelectedBanks', function(e) {
    var phone = jQuery('#phone').val();
    var loan_amount = jQuery('#loan_amount').val();
    var selectedBank = new Array();
    jQuery("input:checkbox[name=select_bank]:checked").each(function(e) {
        var bankID = jQuery(this).attr('data-attr');
        bankID = bankID.replace('bank', '');
        selectedBank.push(bankID);
    });
    selectedBank = selectedBank.join(',');
    if (selectedBank == '') {
        return false;
    }
    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        data: {
            action: "addInquiry",
            bankIds: selectedBank,
            phone: phone,
            loan_amount: loan_amount,
        },
        success: function(output) {
            var output = JSON.parse(output);
            if (output['response'] == 'success') {
                sendMail('multiple', '');
                jQuery("input:checkbox[name=select_bank]:checked").each(function(e) {
                    jQuery(this).attr('disabled', true);
                    jQuery(this).prop('checked', !jQuery(this).prop('checked')).removeClass('select_bank');
                    var bankID = jQuery(this).attr('data-attr');
                    jQuery(`#${bankID} .bank_action .bankApply`).addClass('applied').removeClass('bankApply').text('Applied');
                });
                jQuery('#step4').removeClass('error');
                jQuery('.bank_form_popup.success').addClass('active');
                jQuery('.bank_form_popup.success .popup_content').css('display', 'block');
                jQuery('.bank_form_popup.success .popup_content').css('transform', 'scale(1)');
                let player = document.querySelector("lottie-player");
                player.play();
                setTimeout(function() {
                    jQuery('.bank_form_popup.success').removeClass('active');
                    jQuery('.bank_form_popup.success .popup_content').css('display', 'none');
                    player.stop();
                }, 1500);
            }
            if (output['response'] == 'error') {
                jQuery('#step4').addClass('error');
                jQuery('.bank_list').html('');
            }
        }
    });
});

function sendMail(type, id) {
    if (type == 'multiple') {
        var selectedBank = new Array();
        jQuery("input:checkbox[name=select_bank]:checked").each(function(e) {
            var bankID = jQuery(this).attr('data-attr');
            bankID = bankID.replace('bank', '');
            selectedBank.push(bankID);
        });
        selectedBank = selectedBank.join(',');
        if (selectedBank == '') {
            return false;
        }
    } else {
        var bankid = id;
    }
    var phone = jQuery('#phone').val();
    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        data: {
            action: "sendMail",
            phone: phone,
            bankIDs: selectedBank,
            bankID: bankid,
        },
        success: function(output) {

        }
    });
}

function getBankList(userPhone = null) {
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'getBankList',
            userPhone: userPhone,
        },
        success: function(output) {
            var output = JSON.parse(output);
            if (output['response'] == 'success') {
                jQuery('.multistep_form').closest('section').css('display', 'none');
                jQuery('.bank_list').closest('section').css('display', 'block');
                jQuery('.repeat').addClass('active');
                jQuery('#step4').removeClass('error');
                jQuery('.output .minIntrest').text(output['minIntrest']);
                jQuery('.output .maxIntrest').text(output['maxIntrest']);
                jQuery('.output .loanAmount').text(output['loanAmount']);
                jQuery('.output .loanTenture').text(output['loanTenture']);
                jQuery('.output .proccessingFee').text(output['proccessingFee']);
                jQuery('.bank_list').html(output['data']);
                jQuery('.bank_list').fadeIn();
                var element = document.querySelector('.bank_list');
                element.scrollIntoView({ 'behavior': "smooth", 'block': "center" });
                return false;
            }
            if (output['response'] == 'error') {
                jQuery('#step4').addClass('error');
                jQuery('.bank_list').html('');
            }
        }
    })
}
jQuery(document).on('click', '.toogleDetails', function() {
    var bankId = '#bank' + jQuery(this).attr('data-id');
    var height = jQuery(bankId + '.otherDetails').outerHeight();
    jQuery(bankId + '.otherDetails').css({ 'height': '0', 'overflow': 'hidden' });
    if (jQuery(bankId + ' .otherDetails.active').length) {
        jQuery('.otherDetails').removeClass('active');
        return false;
    }
    jQuery('.otherDetails').removeClass('active');
    jQuery(bankId + '.otherDetails').animate({ height: height }, 1000);
    jQuery(bankId + ' .otherDetails').addClass('active');
    var element = document.querySelector(bankId);
    element.scrollIntoView({ 'behavior': "smooth", 'block': "center" });
});


jQuery(document).on('click', '.submit.navigation', function(e) {
    var next_step = jQuery(this).attr('data-next');
    if (next_step == 'step1') {
        jQuery('.multistep_form').closest('section').css('display', 'block');
        jQuery('.multistep_form').removeClass('hide');
        jQuery('.repeat').removeClass('active');
        jQuery('.form-nav').css('display', 'flex');
        jQuery('.bank_list').html('');
        jQuery('.bank_list').closest('section').css('display', 'none');
    }
    jQuery(`.form_step`).removeClass('active');
    jQuery(`.form_step.${next_step}`).addClass('active');
    jQuery('.bank_form').removeClass('active');
    jQuery(`#${next_step}`).addClass('active');
    return false;
});

error_input = (id) => {
    jQuery('#' + id).css('border', '1px solid red');
};
emailCheck = (email) => {
    if (email.includes('@') & email.includes('.')) {
        return false;
    } else {
        return true;
    }
}
success_input = (id) => {
    jQuery('#' + id).css('border', '1px solid #ccc');
}

function countDown(sec, id) {
    var text = jQuery(`#${id}`).text();
    jQuery(`#${id}`).css('pointer-events', 'none');
    var interval;
    interval = setInterval(function() {
        sec--;
        var time = Math.floor(sec / 60) + ":" + (sec % 60 ? sec % 60 : '00');
        jQuery(`#${id}`).text(time);
        if (sec == 0) {
            jQuery(`#${id}`).css('pointer-events', 'all');
            jQuery(`#${id}`).text(text);
            clearInterval(interval);
        }
    }, 1000);
}
jQuery(document).on('click', '#get_otp', function(e) {
    jQuery(this).attr('otp', 'sended');
    var phone = jQuery('#phone').val();
    if (phone == '' || phone.length < 10 || phone.length > 10) { error_input('phone'); return false; } else { success_input('phone'); };
    jQuery('#otpInput').fadeIn();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'sendUserOTP',
            phone: phone,
        },
        success: function(output) {
            console.log(output);
            var output = JSON.parse(output);
            var validTill = output['validTill'];
            countDown(validTill, 'get_otp');
        }
    });
});
jQuery(document).ready(function() {
    var height = jQuery(`.bank_form.active`).get(0).scrollHeight + 50;
    jQuery(`.bank_form.active`).animate({ height: height }, 500);
});

jQuery(document).on('click', '.popup_content .cancel', function() {
    jQuery('.bank_form_popup').removeClass('active');
    jQuery('.bank_form')[0].reset();
});
jQuery(document).on('click', '.popup_content .procced', function() {
    var bank_ids = jQuery('#appliedBanks').text(),
        phone = jQuery('#phone').val();
    getBankList(bank_ids, phone);
    jQuery('.bank_form_popup').removeClass('active');
    // jQuery('.bank_form')[0].reset();
});

var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];
var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

function inWords(num) {
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return;
    var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
    return str;
}

jQuery(document).on('input', '#loan_amount', function() {
    var amount = jQuery('#loan_amount').val();
    if (amount != '') {
        jQuery('.tooltip').css('z-index', '99');
        jQuery('.tooltip').animate({ opacity: '1' });
        amountInWords = inWords(amount);
        if (amountInWords == 'overflow') {
            amountInWords = 'Please Enter Valid Amount';
        } else {
            amountInWords = amountInWords + ' rupees';
        }
        jQuery('.loan_amount .tooltip-text').text(amountInWords);
    } else {
        jQuery('.tooltip').animate({ opacity: '0' });
    }
});

var states = {
    "AN": "Andaman and Nicobar Islands",
    "AP": "Andhra Pradesh",
    "AR": "Arunachal Pradesh",
    "AS": "Assam",
    "BR": "Bihar",
    "CG": "Chandigarh",
    "CH": "Chhattisgarh",
    "DN": "Dadra and Nagar Haveli",
    "DD": "Daman and Diu",
    "DL": "Delhi",
    "GA": "Goa",
    "GJ": "Gujarat",
    "HR": "Haryana",
    "HP": "Himachal Pradesh",
    "JK": "Jammu and Kashmir",
    "JH": "Jharkhand",
    "KA": "Karnataka",
    "KL": "Kerala",
    "LA": "Ladakh",
    "LD": "Lakshadweep",
    "MP": "Madhya Pradesh",
    "MH": "Maharashtra",
    "MN": "Manipur",
    "ML": "Meghalaya",
    "MZ": "Mizoram",
    "NL": "Nagaland",
    "OR": "Odisha",
    "PY": "Puducherry",
    "PB": "Punjab",
    "RJ": "Rajasthan",
    "SK": "Sikkim",
    "TN": "Tamil Nadu",
    "TS": "Telangana",
    "TR": "Tripura",
    "UP": "Uttar Pradesh",
    "UK": "Uttarakhand",
    "WB": "West Bengal"
};

jQuery(window).click(function() {
    jQuery('.tooltip').animate({ opacity: '0' });
    jQuery('.tooltip').css('z-index', '-1');
});

jQuery(document).ready(function() {
    var listitems;
    jQuery.each(states, function(key, value) {
        listitems += '<option value=' + key + '>' + value + '</option>';
    });
    jQuery('#states').append(listitems);
});

document.querySelectorAll(".range").forEach(function(el) {
    el.oninput = function() {
        var valPercent = (el.valueAsNumber - parseInt(el.min)) /
            (parseInt(el.max) - parseInt(el.min));
        var style = 'background-image: -webkit-gradient(linear, 0% 0%, 100% 0%, color-stop(' + valPercent + ', #e1194b), color-stop(' + valPercent + ', #eee));';
        el.style = style;
    };
    el.oninput();
});


// P x R x (1+R)^N / [(1+R)^N-1] where-
// P = Principal loan amount
// N = Loan tenure in months
// R = Monthly interest rate

function calculateEMI() {
    var P = jQuery('#r_loan_amount').val();
    var N = jQuery('#loan_duration').val();
    var R = jQuery('#intrestRate').val();
    R = R / 12 / 100;
    var emi = P * R * (1 + R) ** N / ((1 + R) ** N - 1);
    return emi;
}

function totalAmount(emi) {
    var amount = emi * jQuery('#loan_duration').val();
    return amount;
}

function seprateAmount(amount) {
    return Number(parseFloat(amount).toFixed(2)).toLocaleString('en', {
        minimumFractionDigits: 2
    });
}
jQuery(document).on('input', '#r_loan_amount', function() {
    var amount = jQuery(this).val();
    jQuery('.amountBox .amount').text(amount);
    var emi = calculateEMI();
    var amount = totalAmount(emi);
    jQuery('.cal_output .emi_amount').text(seprateAmount(emi));
    jQuery('.cal_output .total_amount').text(seprateAmount(amount));
});
jQuery(document).on('input', '#loan_duration', function() {
    var duration = jQuery(this).val();
    jQuery('.durationBox .duration').text(duration);
    var emi = calculateEMI();
    var amount = totalAmount(emi);
    jQuery('.cal_output .emi_amount').text(seprateAmount(emi));
    jQuery('.cal_output .total_amount').text(seprateAmount(amount));
});
jQuery(document).on('input', '#intrestRate', function() {
    var intrest = jQuery(this).val();
    jQuery('.intrestBox .intrest').text(intrest);
    var emi = calculateEMI();
    var amount = totalAmount(emi);
    jQuery('.cal_output .emi_amount').text(seprateAmount(emi));
    jQuery('.cal_output .total_amount').text(seprateAmount(amount));
});
jQuery(document).on('click', '.incAmount', function() {
    var amount = jQuery('#r_loan_amount').val();
    if (amount == '20000000') {
        return false;
    }
    amount = parseFloat(amount) + 5000;
    jQuery('.amountBox .amount').html(amount);
    jQuery('#r_loan_amount').val(amount);
    jQuery('#r_loan_amount').trigger("input");
});
jQuery(document).on('click', '.decAmount', function() {
    var amount = jQuery('#r_loan_amount').val();
    if (amount == '50000') {
        return false;
    }
    amount = parseFloat(amount) - 5000;
    jQuery('.amountBox .amount').html(amount);
    jQuery('#r_loan_amount').val(amount);
    jQuery('#r_loan_amount').trigger("input");
});

jQuery(document).on('click', '.incMonth', function() {
    var amount = jQuery('#loan_duration').val();
    amount = parseFloat(amount) + 1;
    jQuery('.durationBox .duration').html(amount);
    jQuery('#loan_duration').val(amount);
    jQuery('#loan_duration').trigger("input");
});
jQuery(document).on('click', '.decMonth', function() {
    var amount = jQuery('#loan_duration').val();
    amount = parseFloat(amount) - 1;
    jQuery('.durationBox .duration').html(amount);
    jQuery('#loan_duration').val(amount);
    jQuery('#loan_duration').trigger("input");
});

jQuery(document).on('click', '.incInt', function() {
    var amount = jQuery('#intrestRate').val();
    amount = parseFloat(amount) + 0.01;
    jQuery('.intrestBox .intrest').html(amount);
    jQuery('#intrestRate').val(amount);
    jQuery('#intrestRate').trigger("input");
});
jQuery(document).on('click', '.decInt', function() {
    var amount = jQuery('#intrestRate').val();
    amount = parseFloat(amount) - 0.01;
    jQuery('.intrestBox .intrest').html(amount);
    jQuery('#intrestRate').val(amount);
    jQuery('#intrestRate').trigger("input");
});


jQuery(document).on('click', '#applyForm', function() {
    var form = document.querySelector('.multistep_form');
    form.scrollIntoView({ 'behaviour': 'smooth', 'block': 'center' });
});