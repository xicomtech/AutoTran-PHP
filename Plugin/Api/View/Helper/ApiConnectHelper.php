<?php
/**
 * Connect Helpers, This file includes various function for front end use that can be used in website
 * Author : Anuj Kumar
 * Created Date : 5 May 2012
 * Modified By : Shrikant Dhyani
 */
 
App::uses('Helper', 'View');
 
class ApiConnectHelper extends Helper
{	
	public $helpers = array('Html', 'Session');

/**
 * Default constructer of helper, This is called automatically
 * Author : Anuj kumar
 * Created : 5 May 2012
 */
	function __construct($options = null) 
	{       
		parent::__construct($options);        
	}		
	
	function show_response($data, $type = '')
	{
		$response = array();
		
		if ( $type == 'false' )
		{			
			$response['success'] = 'false';
		}
		else
		{
			$response['success'] = 'true';
		}
		$response['data'] = $data;
		return json_encode($response);
	}
}
