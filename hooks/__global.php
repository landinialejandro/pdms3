<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks

if (!function_exists('mkbuttons')){
    require (dirname(__FILE__).'/_mk/_mkbuttons.php');
}
if (!function_exists('getDataTable')){
    require (dirname(__FILE__).'/myLib.php');
}

	function login_ok($memberInfo, &$args){
        updateSqlViews();
		return '';
	}

	function login_failed($attempt, &$args){

	}

	function member_activity($memberInfo, $activity, &$args){
		switch($activity){
			case 'pending':
				break;

			case 'automatic':
				break;

			case 'profile':
				break;

			case 'password':
				break;

		}
	}

	function sendmail_handler(&$pm){

	}

        
