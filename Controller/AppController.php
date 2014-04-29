<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $helpers = array ('Api.ApiConnect', 'Form', 'Html', 'Session', 'Time');
    public $components = array ('Api.ApiConnect','Session', 'Auth', 'RequestHandler', 'Cookie', 'Image');
    
    
/**
 * AppController::beforeFilter 
 * main authenticatinon applied in this function using checkAuth method
 */
    function beforeFilter()
    {
    	$this->params['webURL'] = Router::url('/', true);
    	$this->params['imgURL'] = Router::url('/images', true);
    	
    	$referer = $this->referer();
    	$refererlogout = array ('controller' => 'users', 'action' => 'login');
    	
    	if (strpos($referer, 'admin') !== false)
    	{
    		$referer = array ('controller' => 'users', 'action' => 'index', 'admin' => true);
    	}
    	
    	$remember = $this->Cookie->read('user_rem');
    	
    	if ( !empty($remember ) && is_array($remember))
    	{
    		$this->set('remember', $remember);
    	}
    	else
    	{
    		$this->set('remember', null);
    	}
    	
    	$this->Auth->authenticate = array ("Custom");
    	if ($this->params['prefix'] == 'admin')
    	{
    		$this->layout = 'admin';
    		$this->theme = 'Admin';
    	}
    }
    
/**
 * AppController::beforeRender 
 * common parameters are set in this controller to 
 * be used in further extened controller views
 */
    function beforeRender()
    {
    	$this->params['userInfo'] = $this->Auth->user();
    	$this->set('params', $this->params);
	}




/**
 *  CURL Request
 */ 
	function file_get_contents_curl($url, $post = null, $headers = null)
	{
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		if ($post !== null)
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		if ($headers !== null)
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}
		
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
		{
			//Stop cURL from verifying the peer's and host's certificate.
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		}

		$data = curl_exec($ch);
		curl_close($ch);

		return $data;
	}
	
	function define_access($auth_allow= NULL)
	{
		
		if ($auth_allow !== NULL)
		{
			$this->Auth->allow($auth_allow);
		}		
	}
	
	/* Method Name : validate_picture()
	 * Author Name : Vivek Kumar
	* Creation Date : 06-12-2013
	* Description : is used to validate the picture size and extension.
	*/
	
	function validate_picture($picture_data, $allowed_size = MAX_UPLOAD_PICTURE_SIZE)
	{
		$result = array();
		if ($picture_data['size'] == 0)
		{
			$result['status'] = 'failed';
			$result['message'] = SELECT_FILE;
		}
		else
		{
			$valid_formats = explode(',',VALID_FORMATS);
			$name = $picture_data['name'];
			$size = $picture_data['size'];
			$ext = substr(strrchr($name, '.'), 1);
			if (in_array(strtolower($ext),$valid_formats))
			{
				if ($size < $allowed_size)
				{
					$result['status'] = 'success';
				}
				else
				{
					$result['status'] = 'failed';
					$result['message'] = 'Sorry, you cannot upload files larger than '.($allowed_size/(1024*1024)).' MB.';
				}
			}
			else
			{
				$result['status'] = 'failed';
				$result['message'] = INVALID_PICTURE_FORMAT;
			}
		}
	
	}

	
	/* Method Name : create_all_thumbs()
	 * Author Name : Vivek Kumar
	* Creation Date : 26-12-2013
	* Description : is used to CREATE ALL THUMBS FOR SIZES SPECIFIED IN THE MODEL OR CUSTOM PASSED IN PARAMETER.
	*/
	function create_all_thumbs($model_name, $img_loc, $thumb_subloc = '', $custom_thumbs = null, $aspect_ratio = '')
	{
		$thumb_sizes = array();
	
		if($aspect_ratio)
		{
			$aspect_ratio = '';
		}
	
		if (!empty($this->$model_name->thumb_sizes))
		{
			$thumb_sizes = $this->$model_name->thumb_sizes;
		}
		else if (!empty($custom_thumbs) && count($custom_thumbs))
		{
			//If array is given that means we are expecting the sizes defined in the parameter itself
			if (is_array($custom_thumbs))
			{
				$thumb_sizes = $custom_thumbs;
			}
		}
		else
		{
			//try to load
			$this->loadModel($model_name);
			$thumb_sizes = $this->$model_name->thumb_sizes;
		}
	
		if(count($thumb_sizes))
		{
			foreach($thumb_sizes as $size)
			{
				$size_arr = @explode('x', $size);
	
				$aspect_ratio = '';
	
				if(empty($size_arr[1]))
				{
					$aspect_ratio = 'width';
				}
	
				/*echo $img_loc.'----'.$size_arr[0].'----'.$size_arr[1].'----'.$thumb_subloc.'----'.$aspect_ratio;
				 exit;*/
	
				$this->Image->resize($img_loc, $size_arr[0], $size_arr[1], $thumb_subloc, $aspect_ratio);
			}
	
			return true;
		}
	
		return false;
	}
	
}
