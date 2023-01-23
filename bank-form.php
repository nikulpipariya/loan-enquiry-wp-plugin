<?php
/**
 * Plugin Name: Bank Form
 * Plugin URI: https://xyz.com/
 * Description: Bank form for user inquiry about loan.
 * Version: 1.1.0
 * Author: XYZ
 * Author URI: https://xyz.com/
 * License: GPL
 */
define( 'BANK_PLUGIN_DATA', 'bank_details');
define( 'USER_DATA', 'bank_users');
define( 'USER_INQUIRY', 'bank_user_inquiry');
define( 'BANK_PLUGIN', __FILE__ );

define( 'BANK_PLUGIN_DIR', untrailingslashit( dirname( BANK_PLUGIN ) ) );

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

register_activation_hook( __FILE__, 'bank_form');

function bank_form(){
	global $wpdb;
 
	$table_name = $wpdb->prefix . BANK_PLUGIN_DATA;
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
	id bigint(20) NOT NULL AUTO_INCREMENT,
	name varchar(50),
	email varchar(50),
	state TEXT NOT NULL,
	min_loan_amount int(100),
	max_loan_amount int(100),
	min_interest varchar(50),
	max_interest varchar(50),
	min_tenture varchar(50),
	max_tenture varchar(50),
	min_annual_turnover varchar(50),
	fee varchar(50),
	min_age_of_bussiness int(50),
	documents TEXT NOT NULL,
	pros TEXT NOT NULL,
	cons TEXT NOT NULL,
	fees TEXT NOT NULL,
	logo varchar(50),
	PRIMARY KEY id (id)
	) $charset_collate;";
	
	$table_name_2 = $wpdb->prefix . USER_DATA;
	$sql_2 = "CREATE TABLE IF NOT EXISTS $table_name_2 (
	id bigint(20) NOT NULL AUTO_INCREMENT,
	First_name varchar(50),
	Last_name varchar(50),
	Email varchar(50),
	Phone varchar(50),
	Type_of_customer varchar(50),
	Loan_requirement varchar(50),
	city varchar(50),
	state varchar(50),
	Age_of_business varchar(50),
	Business_registration_type_proof varchar(50),
	Annual_turnover varchar(50),
	date date DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY id (id)
	) $charset_collate;";
	
	$table_name_3 = $wpdb->prefix . USER_INQUIRY;
	$sql_3 = "CREATE TABLE IF NOT EXISTS $table_name_3 (
	id bigint(20) NOT NULL AUTO_INCREMENT,
	user_id varchar(20),
	bank_id varchar(20),
	Phone varchar(100),
	Type_of_customer varchar(50),
	Loan_requirement varchar(100),
	city varchar(50),
	state varchar(50),
	Age_of_business varchar(50),
	Business_registration_type_proof varchar(50),
	Annual_turnover varchar(50),
	date date DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY id (id)
	) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
	dbDelta($sql);
	dbDelta($sql_2);
	dbDelta($sql_3);
}

function delete_plugin_database_tables(){
  global $wpdb;
  $tableArray = [   
    $wpdb->prefix . BANK_PLUGIN_DATA,
    $wpdb->prefix . USER_DATA,
	$wpdb->prefix . USER_INQUIRY
 ];

foreach ($tableArray as $tablename) {
   $wpdb->query("DROP TABLE IF EXISTS $tablename");
}
}
register_uninstall_hook(__FILE__, 'delete_plugin_database_tables');

require_once BANK_PLUGIN_DIR . '/init.php';

function bank_form_init_session() {
	if ( ! session_id() ) {
		session_start();
	}
}
// Start session on init hook.
add_action( 'init', 'bank_form_init_session' );