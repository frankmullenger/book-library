<?php

global $project;
$project = 'mysite';

global $database;
$database = 'library';
 
// Use _ss_environment.php file for configuration
require_once("conf/ConfigureFromEnv.php");
global $databaseConfig;

// Set the current theme
SSViewer::set_theme('library');

// Set the site locale
i18n::set_locale('en_US');

//Remove report admin area
CMSMenu::remove_menu_item('ReportAdmin');

//Dev environment set in _ss_environment.php
if (Director::isDev()) {
	
	//Error reporting
	ini_set('display_errors', 1);
	ini_set("log_errors", 1);
	error_reporting(E_ALL | E_STRICT);
	
	//Logging
	SS_Log::add_writer(new SS_LogFileWriter(dirname(__FILE__).'/errors.log'));
	SS_Log::add_writer(new SS_LogEmailWriter(SS_DEV_EMAIL), SS_Log::ERR, '<=');
	
	//Emails
	Email::send_all_emails_to(SS_DEV_EMAIL);
	//Email::setAdminEmail(SS_DEV_EMAIL);
	
	//Caching
	SSViewer::flush_template_cache();
	//$_GET['flush'] = 1;
}
