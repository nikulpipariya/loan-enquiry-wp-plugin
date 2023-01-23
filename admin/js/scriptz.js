jQuery(document).ready(function(e) {
    var ajaxurl = location.protocol + "//" + location.host + '/wp-admin/admin-ajax.php';
});
jQuery(document).on('change', '#check_all_record', function() {
    if (jQuery('#check_all_record').is(":checked")) {
        jQuery('.bank_id.check-column input').prop('checked', true);
        jQuery('selected_record')
    } else {
        jQuery('.bank_id.check-column input').prop('checked', false);
    }
    return false;
});
jQuery(document).on('click', '.delete_record.button', function() {
    var i = jQuery(this).attr('id');
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'delete_bank_record',
            id: i,
        },
        success: function(output) {
            //alert(output);
            jQuery('.bank_container tbody').html(output);
        }
    });
});
jQuery(document).on('submit', '#add_bank', function(e) {
    var check_input = check_bank_input();
    if (!check_input) {
        return false;
    }
    var states = jQuery('#states option:selected').toArray().map(item => item.text).join('/');
    var bank_logo = jQuery('#bank_logo').prop('files')[0];
    form_data = new FormData();
    form_data.append('bank_logo', bank_logo);
    form_data.append('action', 'add_bank_data');
    entered_data = jQuery(this).serialize();
    entered_data += '&state=' + states;
    form_data.append('post_data', entered_data);
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        processData: false,
        contentType: false,
        data: form_data,
        success: function(output) {
            // alert(output);
            if (output == 'error') {
                console.log(output);
                alert('error occured');
            } else {
                console.log(output);
                jQuery('');
                jQuery("#add_bank").trigger('reset');
                destroy_text_editor();
                generate_text_editor();
            }
        },
        error: function(e) {
            console.log(e);
        }
    });
    return false;
});
jQuery(document).on('click', '.update_record.button', function(e) {
    var bank_id = jQuery(this).attr('id');
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'get_bank_data',
            bank_id: bank_id,
        },
        success: function(output) {
            // console.log(output);
            var bank = jQuery.parseJSON(output);
            jQuery('input[name="bankid"]').val(bank[0]['id']);
            jQuery('#name').val(bank[0]['name']);
            jQuery('#name').val(bank[0]['name']);
            jQuery('#email').val(bank[0]['email']);
            if (bank[0]['state']) {
                var states = bank[0]['state'].split(',');
                jQuery('#states').multiselect('destroy');
                states.forEach((item) => {
                    item = item.replaceAll(' ', '-');
                    jQuery('#states option[value="' + item + '"]').attr("selected", "selected");
                });
                jQuery('#states').multiselect();
                jQuery('.multiselect-container').attr('id', 'state_multiselect');
            } else {
                var states = bank[0]['state'];
            }
            // states = states.replaceAll(' ', '-');
            // jQuery("#states").val(states).change();
            jQuery('#min_loan_amount').val(bank[0]['min_loan_amount']);
            jQuery('#max_loan_amount').val(bank[0]['max_loan_amount']);
            jQuery('#min_interest').val(bank[0]['min_interest']);
            jQuery('#max_interest').val(bank[0]['max_interest']);
            jQuery('#min_tenture').val(bank[0]['min_tenture']);
            jQuery('#max_tenture').val(bank[0]['max_tenture']);
            jQuery('#min_annual_turnover').val(bank[0]['min_annual_turnover']);
            jQuery('#fee').val(bank[0]['fee']);
            jQuery('#min_age_of_bussiness').val(bank[0]['min_age_of_bussiness']);
            destroy_text_editor();
            jQuery('#documents').val(bank[0]['documents']);
            jQuery('#pros').val(bank[0]['pros']);
            jQuery('#cons').val(bank[0]['cons']);
            jQuery('#fees').val(bank[0]['fees']);
            jQuery('.logo_image img').attr('src', bank[0]['logourl']);
            generate_text_editor();
            jQuery('#bank_edit_form').css('display', 'block');
            jQuery('.overlay').css('display', 'block');
            const screenHeight = screen.height - 250;
            jQuery('#bank_edit_form').css('height', '0px');
            jQuery('#bank_edit_form').animate({ height: screenHeight }, 500);
        },
        error: function(e) {
            alert(e);
        }
    });
});
jQuery(document).on('click', '.close', function() {
    jQuery('#bank_edit_form').animate({ height: 0 }, 500);
    setTimeout(() => {
        jQuery('#bank_edit_form').css('display', 'none');
        jQuery('.overlay').css('display', 'none');
    }, 500);

});

jQuery(document).on('submit', '#update_bank', function() {
    var check_input = check_bank_input();
    if (!check_input) {
        return false;
    }
    var states = jQuery('#states option:selected').toArray().map(item => item.text).join('/');
    var bank_logo = jQuery('#bank_logo').prop('files')[0];
    form_data = new FormData();
    form_data.append('bank_logo', bank_logo);
    form_data.append('action', 'update_bank_data');
    entered_data = jQuery(this).serialize();
    entered_data += '&state=' + states;
    form_data.append('post_data', entered_data);
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        processData: false,
        contentType: false,
        data: form_data,
        success: function(output) {
            // alert(output);
            jQuery('.bank_container tbody').html(output);
            jQuery('#bank_edit_form').animate({ height: 0 }, 500);
            setTimeout(() => {
                jQuery('#bank_edit_form').css('display', 'none');
                jQuery('.overlay').css('display', 'none');
            }, 500);
            jQuery('#states option').removeAttr("selected");
            jQuery('#states').multiselect();
            document.getElementById('update_bank').reset();
        },
        error: function(e) {
            alert(e);
        }
    });
    return false;
});

jQuery(document).on('click', '.delete-user button', function(e) {
    var user_id = jQuery(this).attr('id');
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'delete_user_record',
            id: user_id,
        },
        success: function(output) {
            jQuery('.bank_container tbody').html(output);
        }
    });
    return false;
});

jQuery(document).on('click', '.getDateRangeData', function() {
    var dateRange = jQuery('.dateRange').html();
    if (dateRange != 'All Records') {
        var dateRange = dateRange.split('To'),
            startDate = dateRange[0].trim().split('/').reverse().join('-'),
            endDate = dateRange[1].trim().split('/').reverse().join('-');
    } else {
        var startDate = 'all',
            endDate = 'all'
    }
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'getDateRangeData',
            startDate: startDate,
            endDate: endDate,
        },
        success: function(output) {
            if (output == 'No Data Found') {
                var output = `<tr><td style="font-size: 2.5rem !important;height: 10em !important" colspan="9">${output}<td></tr>`;
                jQuery('.bank_container table tbody').html(output);
            } else {
                jQuery('.bank_container table tbody').html(output);
                download_table_as_csv('userList');
            }
            return false;
        }
    })
});

jQuery(document).on('click', '.downloadInquiry', function() {
    var dateRange = jQuery('.dateRange').html();
    if (dateRange != 'All Records') {
        var dateRange = dateRange.split('To'),
            startDate = dateRange[0].trim().split('/').reverse().join('-'),
            endDate = dateRange[1].trim().split('/').reverse().join('-');
    } else {
        var startDate = 'all',
            endDate = 'all'
    }
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'downloadInquiry',
            startDate: startDate,
            endDate: endDate,
        },
        success: function(output) {
            if (output == 'No Data Found') {
                var output = `<tr><td style="font-size: 2.5rem !important;height: 10em !important" colspan="9">${output}<td></tr>`;
                jQuery('.bank_container table tbody').html(output);
            } else {
                jQuery('.bank_container table tbody').html(output);
                download_table_as_csv('userInquiry');
            }
            return false;
        }
    })
});

jQuery(document).on('click', '#filter_user .submit', (e) => {
    e.preventDefault();
    var data = jQuery('#filter_user').serialize();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'filter_user_record',
            filterData: data,
        },
        success: function(output) {
            if (output == 'No Data Found') {
                var output = `<tr><td style="font-size: 2.5rem !important;height: 10em !important" colspan="9">${output}<td></tr>`;
                jQuery('.bank_container table tbody').html(output);
            } else {
                jQuery('.bank_container table tbody').html(output);
            }
            return false;
        }
    })
});
jQuery(document).on('click', '#filter_inquiry .submit', (e) => {
    e.preventDefault();
    var data = jQuery('#filter_inquiry').serialize();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'filter_user_inquiry',
            filterData: data,
        },
        success: function(output) {
            if (output == 'No Data Found') {
                var output = `<tr><td style="font-size: 2.5rem !important;height: 10em !important" colspan="9">${output}<td></tr>`;
                jQuery('.bank_container table tbody').html(output);
            } else {
                jQuery('.bank_container table tbody').html(output);
            }
            return false;
        }
    })
});

// Validation
function check_bank_input() {
    var name = jQuery('#name').val();
    var email = jQuery('#email').val();
    var min_loan_amount = jQuery('#min_loan_amount').val();
    var max_loan_amount = jQuery('#max_loan_amount').val();
    var fee = jQuery('#fee').val();
    var min_interest = jQuery('#min_interest').val();
    var max_interest = jQuery('#max_interest').val();
    var min_annual_turnover = jQuery('#min_annual_turnover').val();
    var min_tenture = jQuery('#min_tenture').val();
    var max_tenture = jQuery('#max_tenture').val();
    var states = jQuery('#states option:selected').toArray().map(item => item.text).join('');
    var min_age_of_bussiness = jQuery('#min_age_of_bussiness').val();
    var documents = jQuery('#documents').val();
    var pros = jQuery('#pros').val();
    var cons = jQuery('#cons').val();
    var fees = jQuery('#fees').val();
    if (name == '') { error_input('name'); return false; } else { success_input('name'); };
    if (email == '') { error_input('email'); return false; } else { success_input('email'); };
    if ((min_loan_amount == '') || (++min_loan_amount > ++max_loan_amount)) { error_input('min_loan_amount'); return false; } else { success_input('min_loan_amount'); };
    if (max_loan_amount == '') { error_input('max_loan_amount'); return false; } else { success_input('max_loan_amount'); };
    if (fee == '') { error_input('fee'); return false; } else { success_input('fee'); };
    if ((min_interest == '') || (++min_interest > ++max_interest)) { error_input('min_interest'); return false; } else { success_input('min_interest'); };
    if (max_interest == '') { error_input('max_interest'); return false; } else { success_input('max_interest'); };
    if (min_annual_turnover == '') { error_input('min_annual_turnover'); return false; } else { success_input('min_annual_turnover'); };
    if ((min_tenture == '') || (++min_tenture > ++max_tenture)) { error_input('min_tenture'); return false; } else { success_input('min_tenture'); };
    if (max_tenture == '') { error_input('max_tenture'); return false; } else { success_input('max_tenture'); };
    if (states == '') { error_input('state_multiselect'); return false; } else { success_input('state_multiselect'); };
    if (min_age_of_bussiness == '') { error_input('min_age_of_bussiness'); return false; } else { success_input('min_age_of_bussiness'); };
    if (documents == '') { error_input('bank_docs'); return false; } else { success_input('bank_docs'); };
    if (pros == '') { error_input('bank_pros'); return false; } else { success_input('bank_pros'); };
    if (cons == '') { error_input('bank_cons'); return false; } else { success_input('bank_cons'); };
    if (fees == '') { error_input('bank_fees'); return false; } else { success_input('bank_fees'); };
    return true;
}

error_input = (id) => {
    jQuery('input').css('border', '1px solid #ccc');
    jQuery('#' + id).css('border', '1px solid red');
    var element = document.getElementById(id);
    element.focus();
    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
    return false;
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


jQuery(document).ready(function() {
    generate_text_editor();
});

function generate_text_editor() {
    jQuery('#documents').summernote({
        placeholder: '',
        tabsize: 0,
        height: 150
    });
    jQuery('#pros').summernote({
        placeholder: '',
        tabsize: 0,
        height: 150
    });
    jQuery('#cons').summernote({
        placeholder: '',
        tabsize: 0,
        height: 150
    });
    jQuery('#fees').summernote({
        placeholder: '',
        tabsize: 0,
        height: 150
    });
};
jQuery(document).on('click', '.bank_details', function() {
    var classes = jQuery(this).attr('class');
    var c = jQuery(this).attr('data-id');
    if (classes.indexOf('active') > -1) {
        jQuery(this).removeClass('active');
        jQuery(`.other_details.${c}`).fadeOut();
        return;
    } else {
        var h = jQuery(`.other_details.${c}`).outerHeight();
        jQuery(this).addClass('active');
        jQuery(`.other_details`).css('display', 'none');
        jQuery(`.other_details.${c}`).fadeIn();
    }
});

function destroy_text_editor() {
    jQuery('#documents').summernote('destroy');
    jQuery('#pros').summernote('destroy');
    jQuery('#cons').summernote('destroy');
    jQuery('#fees').summernote('destroy');
};

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
jQuery(document).ready(function() {
    var listitems;
    jQuery.each(states, function(key, value) {
        key = value.replaceAll(' ', '-');
        listitems += '<option value=' + key + '>' + value + '</option>';
    });
    jQuery('#states').append(listitems);
    jQuery('#states_filter').append(listitems);
    jQuery('#states').multiselect();
    jQuery('.multiselect-container').attr('id', 'state_multiselect');
});

// jQuery(document).on('click', '.downloadData', function(e) {
//     download_table_as_csv('userList');
//     return false;
// });

// Quick and simple export target #table_id into a csv
function download_table_as_csv(table_id, separator = ',') {
    // Select rows from table_id
    var rows = document.querySelectorAll('table#' + table_id + ' tr');
    // Construct csv
    var csv = [];
    for (var i = 0; i < rows.length; i++) {
        var row = [],
            cols = rows[i].querySelectorAll('td, th');
        for (var j = 0; j < cols.length - 1; j++) {
            // Clean innertext to remove multiple spaces and jumpline (break csv)
            var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
                // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
            data = data.replace(/"/g, '""');
            // Push escaped string
            row.push('"' + data + '"');
        }
        csv.push(row.join(separator));
    }
    var csv_string = csv.join('\n');
    // Download it
    var filename = 'export_' + table_id + '_' + new Date().toLocaleDateString() + '.csv';
    var link = document.createElement('a');
    link.style.display = 'none';
    link.setAttribute('target', '_blank');
    link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};

jQuery(document).ready(function() {
    $('#userList').DataTable();
    $('#userInquiry').DataTable();
    var form = jQuery('.containe_header');
    jQuery('.containe_header').remove();
    jQuery('#userList_filter').after(form);
    jQuery('#userInquiry_filter').after(form);
});

jQuery(function() {

    var start = moment().subtract(56, 'days');
    var end = moment();

    function cb(start, end) {
        jQuery('#reportrange span').html(start.format('D/M/YYYY') + ' To ' + end.format('D/M/YYYY'));
    }

    jQuery('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'All Records': [moment().subtract(56, 'days'), moment()],
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
    jQuery('#reportrange .dateRange').text('All Records');
});
jQuery(document).on('click', 'li[data-range-key="All Records"]', function() {
    jQuery('#reportrange .dateRange').text('All Records');
});