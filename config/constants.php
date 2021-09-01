<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

	/*	Leads Internal Status  */
define('int_lead_Measurement_Info_Req', 1);
define('int_lead_Ready_to_Schedule', 2);
define('int_lead_Measurement_Scheduled', 3);
define('int_lead_Measurement_Completed', 4);
define('int_lead_Need_More_Info_to_Start', 5);
define('int_lead_Not_Started', 6);
define('int_lead_Started', 7);
define('int_lead_Ready_for_QC', 8);
define('int_lead_Revision_Required', 9);
define('int_lead_Approved_for_Deck', 10);
define('int_lead_Completed', 11);
define('int_lead_Hold_On_Design', 12);
define('int_lead_QC_Check', 13);
define('int_lead_Revision_Completed', 14);
define('int_lead_Sent_to_Customer', 15);
define('int_lead_Final_Paperwork', 16);
define('int_lead_New', 17);
define('int_lead_Appointment_Pending', 18);

/* Leads status */
define('lead_Contacted_Call_back_Pending',2);
define('lead_Contacted_Paperwork_Pending',3);
define('lead_Contacted_Appointment_Scheduled',4);
define('lead_Quote_Proactive_In_Design',5);
define('lead_Quote_Quoted_Presented',6);
define('lead_Contract_Won',7);
define('lead_Lost_sale',8);
define('lead_Contacted_Schedule_In_Home_Appointment',10);
define('lead_Presentation_Lead',11);

/* User Groups */
define('PST','webbninja2@gmail.com,webbninja01@gmail.com');
define('PMT','webbninja2@gmail.com,webbninja01@gmail.com');
define('ST' ,'webbninja2@gmail.com,webbninja01@gmail.com');
define('QT' ,'webbninja2@gmail.com,webbninja01@gmail.com');
define('DT' ,'webbninja2@gmail.com,webbninja01@gmail.com');
define('vendor_id',1);

$orderSt = json_encode( 
	array(
		'Quote',
		'Pre-Order',
		'Order Review',
		'Order',
		'Order Sent',
		'Order In Manufacturing',
		'Order Scheduled',
		'Order Delivered',
		'Order Commission',
		'Order Closed',
		'Lost Sale'
	) 
);
define('order_statuses', $orderSt );

$lead_actions = json_encode( array( 
	'You' => array(
		'You Called',
		'You Emailed',
		'You Sent SMS',
		'You Create Layout/Pricing',
		'You Visited Customer',
	),
	'Customer' => array(
		'Customer Emailed',
		'Customer Left Voicemail',
		'Customer Visited',
		'Customer Sent Layout',
		'Customer Sent SMS'
	) )
);
define('lead_last_action', $lead_actions );

$next_actions = json_encode( array(
	'You' => array(
		'Call Customer',
		'Email Customer',
		'SMS Customer',
		'Create Layout/Pricing',
	),
	'Customer' => array(
		'Customer to Email',
		'Customer to SMS',
		'Customer to Visit Showroom',
		'Customer to Call',
		'Customer to Send Layout',
		'Customer to Send Item List'
	) ) 
);
define('lead_next_action', $next_actions );

define('order_tax', 6.625 );