<?php
	/**
	 * Elgg social commerce - index page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @author ray peaslee
	 * @copyright twentyfiveautumn.com 2015
	 * @link http://twentyfiveautumn.com/
	 * @version elgg 1.9.4
	 **/ 
	
	gatekeeper();
	$page_owner = elgg_get_logged_in_user_entity();

	$title = $page_owner == $_SESSION['user'] ? elgg_view_title(elgg_echo('stores:your')) : elgg_view_title($page_owner->username . "'s " . elgg_echo('products'));
		
	elgg_set_context('search');
	$search_viewtype = get_input('search_viewtype');
	$limit = $search_viewtype == 'gallery' ? 20 : 10;
	$view = get_input('view');
	$filter = get_input("filter") ? get_input("filter") : 'active';
		
	switch($filter){
		case "active":	
			$content = elgg_list_entities_from_metadata(array(
				'status' => 1,
				'type_subtype_pairs' => array('object' => 'stores'),
				'owner_guid' => elgg_get_page_owner_guid(),
				'limit' => $limit,
				));
			break;
			case "deleted":	$content = elgg_list_entities_from_metadata(array(
				'status' => 0,
				'type_subtype_pairs' => array('object' => 'stores'),
				'owner_guid' => elgg_get_page_owner_guid(),
				'limit' => $limit,
				));
			break;
	}
	if(empty($content)){ $content = '<div>'.elgg_echo('no:data').'</div>';}
	
	$content = '<div class="contentWrapper stores">'.$content.'</div>';
	
	elgg_set_context('stores');
	$sidebar .= elgg_view("socialcommerce/sidebar");
	$sidebar .= gettags();
		
	$params = array(
		'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		);
	$body = elgg_view_layout('one_sidebar', $params);
	echo elgg_view_page(elgg_echo("stores:your"), $body);
