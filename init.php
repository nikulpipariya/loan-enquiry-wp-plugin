<?php

if ( is_admin() ) {
	require_once BANK_PLUGIN_DIR . '/admin/admin.php';
} else {
	require_once BANK_PLUGIN_DIR . '/includes/functions.php';
}

add_action('admin_menu', 'bank_form_menu');
function bank_form_menu(){
	add_menu_page( 'Bank Details', 'Bank Details', 'manage_options', 'bank_list', 'bank_list', 'dashicons-bank', 6);
	add_submenu_page('bank_list', 'Add Bank', 'Add Bank', 'manage_options','add_bank','add_bank');
	add_submenu_page('bank_list', 'Users', 'All users', 'manage_options','users_list','users_list');
	add_submenu_page('bank_list', 'All Users Inquiry', 'All Users Inquiry', 'manage_options','users_inquiry','users_inquiry');
	add_submenu_page('bank_list', 'Shortcodes', 'Shortcodes', 'manage_options','user_form','user_form');
}
function check_bank_page(){
	if(isset( $_GET['page'] ) && $_GET['page'] == 'bank_list' || isset( $_GET['page'] ) && $_GET['page'] == 'add_bank' || isset( $_GET['page'] ) && $_GET['page'] == 'user_form' || isset( $_GET['page'] ) && $_GET['page'] == 'users_list' || isset( $_GET['page'] ) && $_GET['page'] == 'users_inquiry'){
		return true;
	}else{
		return false;
	}
}
if ( check_bank_page() ) {
	wp_enqueue_style( 'bank-form-style', plugins_url( 'admin/css/style.css', __FILE__ ), false, '1.0', 'all' ); // Inside a plugin
	wp_enqueue_style( 'bootsrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css', false, '1.0', 'all' );
	wp_enqueue_style( 'summernot-css', 'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css', false, '1.0', 'all' );
	wp_enqueue_style( 'bootstrap-multiselect-css', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.1/css/bootstrap-multiselect.min.css', false, '1.0', 'all' );
	wp_enqueue_style( 'cloud-tables-css', 'https:////cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css', false, '1.0', 'all' );
	wp_enqueue_style( 'date-range-picker-css', 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css', false, '1.0', 'all' );
	
	wp_enqueue_script( 'bank-form-script', plugin_dir_url( __FILE__ ) . 'admin/js/scriptz.js', array(), '1.0' );
	wp_enqueue_script( 'jquery3.5','https://code.jquery.com/jquery-3.5.1.min.js', array(), '1.0' );
	wp_enqueue_script( 'bootstrapjs','https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js', array(), '1.0' );
	wp_enqueue_script( 'summernotejs','https://unpkg.com/summernote@0.8.20/dist/summernote.js', array(), '1.0' );
	wp_enqueue_script( 'bootstrap-multiselect-js','https://unpkg.com/bootstrap-multiselect@1.1.0/dist/js/bootstrap-multiselect.js', array(), '1.0' );
	wp_enqueue_script( 'cloud-tables-script','https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js', array(), '1.0' );
	wp_enqueue_script( 'moment-script','https://cdn.jsdelivr.net/momentjs/latest/moment.min.js', array(), '1.0' );
	wp_enqueue_script( 'date-range-picker-script','https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js', array(), '1.0' );
	
}
function enqueue_scripts_and_styles_function(){
	wp_enqueue_style( 'bank-form-style', plugins_url( 'assets/css/style.css', __FILE__ ), array(), null, 'all');
	wp_enqueue_script( 'bank-form-script', plugin_dir_url( __FILE__ ) . 'assets/js/script.js', array('jquery'), '','true' );
}
add_action('wp_enqueue_scripts', 'enqueue_scripts_and_styles_function');

add_action( 'wp_head', 'wpse_add_inline_script' );
function wpse_add_inline_script() {
  echo '<script>' . PHP_EOL;
  $ajaxurl = admin_url('admin-ajax.php');
  echo "var ajaxurl = '$ajaxurl';";
  echo '</script>' . PHP_EOL;
}
?>