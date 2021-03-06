<?php
	/**
	 * Elgg address - add/edit
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	 
	$user = elgg_get_logged_in_user_entity();
		
	$firstname = get_input('first_name');
	$lastname = get_input('last_name');
	$address_line_1 = get_input('address_line_1');
	$address_line_2 = get_input('address_line_2');
	$city = get_input('city');
	$state = get_input('state');
	$country = get_input('country');
	$pincode = get_input('pincode');
	$phoneno = get_input('phoneno');
	$address_guid = get_input('address_guid');
			
	if(empty($firstname)){
		$error_field .= ", ".elgg_echo("first:name");
	}
	if(empty($lastname)){
		$error_field .= ", ".elgg_echo("last:name");
	}
	if(empty($address_line_1)){
		$error_field .= ", ".elgg_echo("address:line:1");
	}
	
	if(empty($city)){
		$error_field .= ", ".elgg_echo("city");
	}
	if(empty($state)){
		$error_field .= ", ".elgg_echo("state");
	}
	if(empty($country)){
		$error_field .= ", ".elgg_echo("country");
	}
	if(empty($pincode)){
		$error_field .= ", ".elgg_echo("pincode");
	}
	
	if(!empty($error_field)){
		$error_field = substr($error_field,2);
		register_error(sprintf(elgg_echo("address:validation:null"),$error_field));
	}else{

		if(isset($address_guid)){
			//	we know it's an edit
			$address = get_entity($address_guid);
			$address->title = $firstname.' '.$lastname;
			$address->first_name = $firstname;
			$address->last_name = $lastname;
			$address->address_line_1 = $address_line_1;
			$address->address_line_2 = $address_line_2;
			$address->city = $city;
			$address->state = $state;
			$address->country = $country;
			$address->pincode = $pincode;
			if(!empty($phoneno)) {$address->phoneno = $phoneno;}
		
			if($result = $address->save()) {
				system_message(elgg_echo("address:saved"));
			}else{
				register_error(elgg_echo("address:edit:failed"));
			}
			forward(elgg_get_config('url').'socialcommerce/'.$user->username.'/address/');
		}
		
		//	save a new address
		$address = new ElggObject();
		$address->subtype = 'address';
		$address->title = $firstname.' '.$lastname;
		$address->first_name = $firstname;
		$address->last_name = $lastname;
		$address->address_line_1 = $address_line_1;
		$address->address_line_2 = $address_line_2;
		$address->city = $city;
		$address->state = $state;
		$address->country = $country;
		$address->pincode = $pincode;
		if(!empty($phoneno)) {$address->phoneno = $phoneno;}
		//	access_id is always private
		$address->access_id = ACCESS_PRIVATE;
		//	for now the container_guid & owner_guid is always the logged in user
		$address->container_guid = $user->guid;
		$address->owner_guid = $user->guid;
						
		if($result = $address->save()) {
			system_message(elgg_echo("address:saved"));
		}else{
			register_error(elgg_echo("address:addfailed"));
		}
	}
	forward(elgg_get_config('url').'socialcommerce/'.$user->username.'/address/');
