<?php 
/**
 * Elgg Webservices plugin 
 * 
 * @package Webservice
 * @author Mark Harding / Kramnorth
 *
 */

/**
 * Web service to get messages inbox
 *
 * @param string $limit  (optional) default 10
 * @param string $offset (optional) default 0
 *
 * @return array $file Array of files uploaded
 */
function messages_inbox($limit = 10, $offset = 0) {	

		$user = get_loggedin_user();
		$params = array(
			'type' => 'object',
			'subtype' => 'messages',
			'metadata_name' => 'toId',
			'metadata_value' => $user->guid,
			'owner_guid' => $user->guid,
			'full_view' => false,
						);
	
	
	$list = elgg_get_entities($params);
	if($list) {
		foreach($list as $single ) {
			$message[$single->guid]['subject'] = $single->title;
			
			$from = get_entity($single->fromId);
			$message[$single->guid]['from']['guid'] = $from->guid;
			$message[$single->guid]['from']['name'] = $from->name;
			$message[$single->guid]['from']['avatar_url'] = get_entity_icon_url($from,'small');
			
			$message[$single->guid]['timestamp'] = $single->time_created;
			
			$message[$single->guid]['description'] = $single->description;
			
			if($single->readYet){
			$message[$single->guid]['read'] = "yes";
			}else{
			$message[$single->guid]['read'] = "no";
			}
		}
	}
	else {
	 	$message['error']['message'] = elgg_echo('file:none');
	}
	return $message;
}
	
expose_function('messages.inbox',
				"messages_inbox",
				array(
					  'limit' => array ('type' => 'int', 'required' => false),
					  'offset' => array ('type' => 'int', 'required' => false),
					),
				"Get messages inbox",
				'GET',
				true,
				true);
				
                ?>