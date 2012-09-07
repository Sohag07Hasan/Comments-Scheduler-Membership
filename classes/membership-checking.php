<?php
/*
 * Handles curl request from the customers' site
 * */

class mcp_membership_contrer{
	
	const api_key = "Comment_Scheduler_api";
	const web_key = "Comment_Scheduler_domain";
	
	/*
	 * init function
	 * */
	static function init(){
		add_action('init', array(get_class(), 'parse_request'));
		add_action('show_user_profile', array(get_class(), 'show_user_profile'));
	}
	
	/*
	 * parse the curl request
	 * */
	static function parse_request(){
		/*
		$user = get_userdata(9);
		var_dump($user->roles[0]);
		die();
		*/
		
		if(isset($_POST[self::api_key])){			
									
			if(self::is_valid()){
				echo "yes";
			}
			else{
				echo "no";
			}
			
			exit;
		}
	}
	
	/**
	 * returns 1 if the api key is valid
	 * reurn 0 therwise
	 * */
	static function is_valid(){
		$key_value = $_POST[self::api_key];
		$site = $_POST[self::web_key];
		$api_key = self::api_key;
		
		global $wpdb;
		$user_id = $wpdb->get_var("SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '$api_key' AND meta_value = '$key_value'");
		//echo $user_id;
		//die();
		if($user_id){
			$user = get_userdata($user_id);
			if($user->roles[0] == 's2member_level1'){
				$url = get_user_meta($user_id, self::web_key, true);
				if($url){
					if($site == $url){
						return true;
					}
				}
				else{
					update_user_meta($user_id, self::web_key, $site);
					return true;
				}
			}
			elseif($user->roles[0] == 's2member_level2'){
				return true;
			}
			else{
				return false;
			}
		}
		
		return false;
	}
	
	/*
	 * shwo api credentials for the s2 membership level
	 * */
	static function show_user_profile($profileuser){
		if(function_exists('current_user_is')){
			if(self::current_user_has_membership()){
				$api_key = self::get_api_key($profileuser->ID);
				$domain = self::get_membership_status($profileuser);
				include MCPMMEMBERSHIP_DIR . '/includes/profile-page.php';
			}
		}
	}
	
	
	/*
	 * checking if current user has membership
	 * */
	static function current_user_has_membership(){
		return current_user_is('s2member_level1') || current_user_is('s2member_level2');
	}
	
	/*
	 * get membership status
	 * */
	static function get_membership_status($profileuser){
		$status = "";
		switch ($profileuser->roles[0]){
			case 's2member_level1' :
				$status = self::get_domain($profileuser->ID);
				break;
			case 's2member_level1' :
				$status = "Unlimited domains";
				break;
		}
		
		return $status;
	}
	
	
	/**
	 * returns the api key
	 * */
	static function get_api_key($user_id = null){
		return get_user_meta($user_id, self::api_key, true);
	}
	
	/*
	 * returns the domain name
	 * */
	static function get_domain($user_id = NULL){
		return get_user_meta($user_id, self::web_key, true);
	}
	
}