<?php
/*
 * S2 plugin handles the registration process and this class extned the registration process  
 * 
 */

class mcp_registration{
	
	const api_key = "Comment_Scheduler_api";
	
	static function init(){
		//hooks from S2 member
		add_action('ws_plugin__s2member_after_configure_user_registration', array(get_class(), 'configure_user_registration'));	
	}
	
	static function configure_user_registration($vars){
		$user = $vars['user'];
		
		$role = $vars['current_role'];
		$current_role = self::check_membership_role($role);
		
		if($current_role){
			$api_key = self::generate_api_key();
			update_user_meta($user->ID, self::api_key, $api_key);			
		}
	}
	
	
	/*
	 * returns the first two roles
	 * else return 0
	 * */
	static function check_membership_role($role){
		$current_role = null;
		switch ($role){
			case 's2member_level1' :
				$current_role = $role;
				break;
			case 's2member_level2' :
				$current_role = $role;
				break;			
		}
		
		return $current_role;
	}
	
	
	static function generate_api_key( $length = 9 ) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';		
	
		$password = '';
		for ( $i = 0; $i < $length; $i++ ) {
			$password .= substr($chars, wp_rand(0, strlen($chars) - 1), 1);
		}

		return self::is_unique($password);
	}
	
	/*
	 * it will check if the api key is unique
	 * */
	static function is_unique($api_key){
		global $wpdb;
		$key_name = self::api_key;
		if($wpdb->get_row("SELECT * FROM $wpdb->usermeta WHERE meta_key = '$key_name' value = '$api_key'")){
			return self::generate_api_key();
		}
		
		return $api_key;
	}
		
	
	 
}