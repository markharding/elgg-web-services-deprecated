<?php
/**
 * Elgg Webservices plugin 
 * 
 * @package Webservice
 * @author Mark Harding
 *
 */

/**
 * Heartbeat web service
 *
 * @return string $response Hello
 */
function site_test() {
	$response['success'] = true;
	$response['message'] = "Hello";
	return $response;
} 

expose_function('site.test',
				"site_test",
				array(),
				"Get site information",
				'GET',
				false,
				false);

/**
 * Web service to get site information
 *
 * @return string $url URL of Elgg website
 * @return string $sitename Name of Elgg website
 * @return string $language Language of Elgg website
 * @return string $enabled_services List of enabled services
 */
function site_getinfo() {
	$site = elgg_get_config('site');

	$siteinfo['url'] = elgg_get_site_url();
	$siteinfo['sitename'] = $site->name;
	$siteinfo['language'] = elgg_get_config('language');
	$siteinfo['enabled_services'] = $enabled = unserialize(elgg_get_plugin_setting('enabled_webservices', 'web_services'));
	
	//return OAuth info
	if(elgg_is_active_plugin('oauth',0) == true){
		$siteinfo['OAuth'] = "running";
	} else {
		$siteinfo['OAuth'] = "no";
	}
	
	return $siteinfo;
} 

expose_function('site.getinfo',
				"site_getinfo",
				array(),
				"Get site information",
				'GET',
				false,
				false);
				
/**
 * Retrive river feed
 *
 * @return array $river_feed contains all information for river
 */			
function site_river_feed($limit){
	
	global $jsonexport;
	
	elgg_view_river_items();

	return $jsonexport['activity'];
	
}
expose_function('site.river_feed',
				"site_river_feed",
				array('limit' => array('type' => 'int', 'required' => 'no')),
				"Get river feed",
				'GET',
				false,
				false);
				
/**
 * Performs a search of the elgg site
 *
 * @return array $results search result
 */
 
function site_search($query){
	
	//temp values
	//these will be added to expose soon
	$search_type = 'all';
	$entity_type = ELGG_ENTITIES_ANY_VALUE;
	$entity_subtype = ELGG_ENTITIES_ANY_VALUE;
	
	$params = array(
					'query' => $query,
					'search_type' => $search_type,
					'type' => $entity_type,
					'subtype' => $entity_type,
					);
					
	$types = get_registered_entity_types();
	
	//store the result in here
	

	foreach ($types as $type => $subtypes) {
	
		// pull in default type entities with no subtypes
		$params['type'] = $type;
		//$params['subtype'] = ELGG_ENTITIES_NO_VALUE;

		$results = elgg_trigger_plugin_hook('search', $type, $params, array());
		if ($results === FALSE) {
			// someone is saying not to display these types in searches.
			continue;
		}
		
		if($results['count']){
			foreach($results['entities'] as $single){
		
				//search matched critera
				/*
				$result['search_matched_title'] = $single->getVolatileData('search_matched_title');
				$result['search_matched_description'] = $single->getVolatileData('search_matched_description');
				$result['search_matched_extra'] = $single->getVolatileData('search_matched_extra');
				*/
				if($type == 'group' || $type== 'user'){
				$result['title'] = $single->name;	
				} else {
				$result['title'] = $single->title;
				}
				$result['guid'] = $single->guid;
				$result['type'] = $single->type;
				$result['subtype'] = get_subtype_from_id($single->subtype);
				
				$result['avatar_url'] = get_entity_icon_url($single,'small');
				
				$return[$type] = $result;
			}
		}
	}

	return $return;
}
expose_function('site.search',
				"site_search",
				array('query' => array('type' => 'string')),
				"Perform a search",
				'GET',
				false,
				false);