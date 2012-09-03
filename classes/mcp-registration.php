<?php
/*
 * S2 plugin handles the registration process and this class extned the registration process  
 * 
 */

class mcp_registration{
	
	static function init(){
		//hooks from S2 member
		add_action('ws_plugin__s2member_after_configure_user_registration', array(get_class(), 'configure_user_registration'));	
	}
	
	static function configure_user_registration($vars){
		
	}
	
}