<?php
/**
 * ApiConnect Component: Used for secure Json api connect
 * Author : Anuj Kumar
 * Created Date : 14 June 2012
 */
class ApiConnectComponent extends Component
{
	/**
	 * This function initalize ths component, Used for default settings
	 * Author : Anuj Kumar
	 * Created Date : 14 June 2012
	 */
	public function initialize(Controller $Controller, $settings = array())
	{
		$this->Controller = $Controller;
		$this->_set($settings);
	}
	
	/**
	 * Purpose : set views for api result based on extention, user need to include view files in priscribed folders.
	 * Author : Anuj Kumar
	 * Created : June 15 2012
	 */
	public function set_view($t)
	{		
		if($t->request->params['ext'] == 'json')
		{
			$t->render('/Json/data');
		}
		if($t->request->params['ext'] == 'xml')
		{
			$t->render('\Xml\data');die;
		}
	}
	
	/**
	 * Purpose : This is main function for checking secure requests, This functions checks request to be valid on basis of parameters passed and hash algorithms
	 * Author : Anuj Kumar
	 * Created : June 15 2012
	 */	
	public function check_valid_request($request)
	{
		//No need to check this in controller side, this works only with json or xml views
		if($request->params['ext'] == 'json' || $request->params['ext'] == 'xml')
		{		
			//Check that request is post, otherwise reject
			if($request->is('post'))
			{
				$url = $request->url;
				$url_params = explode('/', $url);
				$c_url='';
				//Get all url elements
				foreach($url_params as $params)
				{
					if(!empty($params))
					{
						$c_url .= $params.':';
					}
				}				
				$post_params = $request->data;
				
				$token = '';
				$timestamp = '';
				//Get all passed parameters, seprate timtstamp and token for security purpose
				
				// Sort the array keys except token and timestamp
				$token = $resp_token = $post_params['token'];
				$timestamp = $resp_timestamp = $post_params['timestamp'];
				unset($post_params['token']);
				unset($post_params['timestamp']);
				
				
				//Error : If token not appended with request
				if(empty($token))				
				{
					echo $this->status_faliure("Token not found"); die;
				}
				//Error if timestamp is not appended with request
				if(empty($timestamp))				
				{
					echo $this->status_faliure("Invalid request"); die;
				}				
				//Check expiry of request
				$expiry =  Configure::read('expiry_seconds'); 
				
				if( ($this->get_utc() - $timestamp) > $expiry )
				{
					echo $this->status_faliure("Token expired, please try again"); die;
				}
				//append private key with this.
				$private_key = Configure::read('api_private_key'); 
				
				$c_url.= $private_key;				
				
				$check_string = $this->hash_ssa($c_url);
				
				if($token == $check_string)
				{
					return true;
				}
				else
				{
					echo $this->status_faliure("Token not valid"); die;
					//echo $check_string;die;
				}
			}
			else
			{
				echo $this->status_faliure("Not a valid 'POST' request"); die;
			}
		}
	}
	
	public function generate_token_hash($url)
	{
		
	}
	
	public function status_faliure($data)
	{
		return json_encode(array('success' => 'false', 'message' => $data));
	}
	
	public function status_success($data)
	{
		return json_encode(array('success' => 'true', 'message' => $data));
	}
	
	public function hash_ssa($string) 
    {	
        //echo $this->status_success($string); die;
		$salt = Configure::read('api_private_key'); 
		//return $string;
		//$hash = base64_encode( sha1($string . $salt, true) . $salt );
        $hash = base64_encode( sha1($string) . $salt ); 
        return $hash; 
    }
	
	public function get_utc()
	{
		$utc_str = gmdate("M d Y H:i:s", time());	
		$utc = strtotime($utc_str);
		return $utc;
	}
}
