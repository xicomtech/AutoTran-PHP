<?php
App::uses('AppController', 'Controller');
   /**
	 * Api Controller
	 *
	 * Purpose : Manage api activity
	 * @project Auto Tran
	 * @since 17-October-2013
	 * @author : Santosh Gupta
	 */

class ApisController extends AppController
{
	public $components = array('Uploader','Upload');
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow();	
	}
	
  /**
	* Method Name : login	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 17-October-2013
	* Description : Driver login
	*/
	public function login()
	{
		$this->ApiConnect->check_valid_request($this->request);			
		$user_id = $this->request->data['user_id']; // driver_id, dealer_id		
		$this->loadModel('User');
		$this->User->unbindModel(array('hasMany' => array('Load')));
		$user_data = $this->User->find('first',array('conditions'=>array('User.user_id'=>$user_id,'User.status'=>STATUS_ACTIVE)));
		
		if (empty($user_data))
		{
			$status = 'Failure';
			$message = 'User not found';
			$user_data = '';
		}
		else
		{
			$status = 'Success';
			$message = 'User found';
			$user_data = $user_data;
		}
		$this->set(array('status' => $status, 'message' => $message,'data' => $user_data, '_serialize' => array('status', 'message', 'data')));
	}
	
  /**
	* Method Name : dispatch	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 24-October-2013
	* Description : Show the shipped count within interval days
	*/
	public function dispatch()
	{
		//$this->ApiConnect->check_valid_request($this->request);	
		
		$driver_id = $this->request->data['driver_id'];
		
		//Count the number of shipped load within a interval
		$this->loadModel('Load');
		$shipped_count = $this->Load->find('count', array('conditions' => array('Load.ship_date BETWEEN DATE_SUB(NOW(), INTERVAL '.INTERVAL_DAYS.' DAY) AND NOW()' ,'Load.user_id'=>$driver_id,'Load.status'=>STATUS_SHIPPED)));
		$data['shipped_count'] = $shipped_count;
		
		if ($shipped_count == 0)
		{
			$status = 'Failure';
			$message = 'No record found';
		}
		else
		{
			$status = 'Success';
			$message = 'Data found';
		}
		
		$this->set(array('status' => $status, 'message' => $message,'data' => $data, '_serialize' => array('status', 'message', 'data')));
	}
	
  /**
	* Method Name : pick_load	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 22-October-2013
	* Description : Dashboard screen to show the number of loads
	*/
	public function pick_load()
	{
		$status = true;
		//$this->ApiConnect->check_valid_request($this->request);	
		
		$user_type = $this->request->data['user_type']; // dealer, driver		
		$user_id = $this->request->data['user_id'];  // driver_id, dealer_id
		
		$load_data = array();
		//Unshipped load
		$this->loadModel('Load');
		$this->Load->unbindModel(array('hasMany' => array('Vin')));
		
		if ($user_type == UserType::UserDealer)
		{
			$this->loadModel('Dealer');
			$dealer_info = $this->Dealer->find('first', array('conditions' => array('user_id' => $user_id)));
			if (count($dealer_info))
			{
				$user_id = $dealer_info['Dealer']['id'];
			} 	
			else
			{
				$status = false;
			}		
			$fields = array('Load.id', 'Load.truck_number', 'Load.ship_date', 'Load.estdeliverdate', 'Load.status', 'Load.load');
			$conditions = array('Load.dealer_id' => $user_id, 'Load.status' => STATUS_UNSHIPPED);
			$this->Load->unbindModel(array('belongsTo' => array('Dealer')));
		}
		else if ($user_type == UserType::UserDriver)
		{
			$fields = array('Load.*');
			$conditions = array('Load.user_id' => $user_id, 'Load.status' => STATUS_UNSHIPPED);
		}		
		if ($status)
		{
			$load_data = $this->Load->find('all', array('conditions' => $conditions,'fields' => $fields));
			if (empty($load_data))
			{
				$status = 'Failure';
				$message = 'No load found';
			}
			else
			{
				$status = 'Success';
				$message = 'Load found';
			}
		}
		else
		{
			$status = 'Failure';
			$message = 'Invalid delear Id.';
		}
		
		$this->set(array('status' => $status, 'message' => $message,'data' => $load_data, '_serialize' => array('status', 'message', 'data')));	
	}
	
  /**
	* Method Name : vin_list	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 18-October-2013
	* Description : Show the vin list of the load
	*/
	public function vin_list()
	{
		//$this->ApiConnect->check_valid_request($this->request);	
		
		$load_id = $this->request->data['load_id'];
		
		$this->loadModel('Vin');
		$this->Vin->bindModel(array('belongsTo' => array('Dealer')));
		$vin_list = $this->Vin->find('all',array('conditions'=>array('Vin.load_id'=>$load_id),'fields'=>array('Vin.*', 'Dealer.customer_name', 'Position.position')));
		
		if (empty($vin_list))
		{
			$status = 'Failure';
			$message = 'Vin not found for this load';
		}
		else
		{
			$status = 'Success';
			$message = 'Vin found';
		}
		$this->set(array('status' => $status, 'message' => $message,'data' => $vin_list, '_serialize' => array('status', 'message', 'data')));	
	}
	
	/**
	 * Method Name : dealer_detail
	 * Author Name : Vivek Kumar
	 * Inputs : None
	 * Output : void
	 * Date : 05-December-2013
	 * Description : Is used to fetch all the dealer detail
	 */
	
	public function dealer_detail()
	{
		$this->layout = '';
		$this->ApiConnect->check_valid_request($this->request);				
		$dealer_id = $this->request->data['dealer_id'];		
		$this->loadModel('Dealer');
		$dealer_detail = $this->Dealer->findById($dealer_id);		
		if (empty($dealer_detail))
		{
			$status = 'Failure';
			$message = 'Dealer not found';
		}
		else
		{
			$status = 'Success';
			$message = 'Dealer found';
		}
		$this->set(array('status' => $status, 'message' => $message,'data' => $dealer_detail, '_serialize' => array('status', 'message', 'data')));
	}
	
	/**
	 * Method Name : upload multiple images
	 * Author Name : Neha Sachan
	 * Inputs : $_FILES array
	 * Output : saved
	 * Date : 5 March 2014 , Wednesday
	 * Description : saving all vins images 
	 */		
	function upload_images($details	, $imageName  , $reference_id , $uploadPath )
	{					
		$config['upload_path'] 	 = $uploadPath ;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']		 = '240000000';	
		$this->Upload->initializes($config);		
		if ($this->Upload->do_upload($imageName))
		{							
			$imgdata_arr 	= $this->Upload->data();	
			$uploadedImageName = $reference_id.'_'.uniqid().$imgdata_arr['file_ext'];
			$img_path_as_id = $imgdata_arr['file_path'] . $uploadedImageName;										
			if (copy($imgdata_arr['full_path'], $img_path_as_id))
			{
				unlink($imgdata_arr['full_path']);
				$data['VinImage']['vin_id']  	  = $reference_id ;
				$data['VinImage']['image'] 		  = $uploadedImageName;			
				$data['VinImage']['modified']     = date('Y-m-d h:i:s');
				$this->VinImage->create();
				$this->VinImage->save($data);
				$message = array('status'	=>	PICTURE_UPLOADED_SUCCESS ,'data'	=>	$imageName ) ;
			}
			else
			{
				$message = array('status'	=>	PICTURE_UPLOADED_FAILED ,'data'	=>	$imageName ) ;
			}									
		}
		else
		{
			$message = array('status'	=>	PICTURE_UPLOADED_FAILED ,'data'	=>	$imageName ) ;
		}
		return $message ;
	}
	
	/**
	 * Method Name : load_inspection
	 * Author Name : Vivek Kumar
	 * Inputs : None
	 * Output : void
	 * Date : 05-December-2013
	 * Description : Is used to updated the vin detail.
	 */
	
	public function load_inspection()
	{
		//$this->ApiConnect->check_valid_request($this->request);
	
		$data = array();
		$image_status = true;
		$load_id					= trim($this->request->data['load_id']);
		
		/*
		if (isset($_FILES['notes_image']['error']) && ($_FILES['notes_image']['error'] == 0))
		{
			$response = $this->validate_picture($_FILES['notes_image']); // method define in AppController.php file
			$user_id = $this->request->data['user_id'];
			if ($response['status'] == 'success')
			{
				if (!is_dir(WWW_ROOT.NOTES_IMG_DIR. DS .$load_id))
				{
					mkdir(WWW_ROOT.NOTES_IMG_DIR. DS .$load_id, 0777);
				}
				$x =  explode('.', $_FILES['notes_image']['name']);
				$image_ext = '.'.strtolower(end($x));
				$new_img_name = $load_id.$image_ext;
				$picture_name = WWW_ROOT.NOTES_IMG_DIR. DS . $load_id. DS . $new_img_name;
				if (copy($_FILES['notes_image']['tmp_name'], $picture_name))
				{
					$status = $this->create_all_thumbs('Load', $picture_name, WWW_ROOT . NOTES_IMG_DIR. DS . $load_id); //method define in AppController.php file
					if ($status)
					{
						$message = 'Success';
						$image_status = true;
					}
					else
					{
						$message = PICTURE_UPLOADED_FAILED;
						$image_status = false;
					}
				}
				else
				{
					$message = PICTURE_UPLOADED_FAILED;
					$image_status = false;
				}
			}
			else
			{
				$message = $response['message'];
				$image_status = false;
			}
		}
		else
		{
			$message = INVALID_PICTURE_FORMAT;
			$image_status = false;
		} */
		
		
		if ($image_status)
		{
			$this->loadModel('Vin');
			$this->loadModel('VinImage');
			$this->Vin->id 					= trim($this->request->data['vin_id']);
			$load['Vin']['facing'] 			= trim($this->request->data['facing']);
			$load['Vin']['notes']			= trim($this->request->data['notes']);
			$load['Vin']['ats'] 			= trim($this->request->data['ats']);
			$load['Vin']['position_id'] 	= trim($this->request->data['position_id']);
			$load['Vin']['driver_comment']  = (!empty($this->request->data['driver_comment']) ? trim($this->request->data['driver_comment']) : '');
			$load['Vin']['dealer_commemt']  = (!empty($this->request->data['dealer_commemt']) ? trim($this->request->data['dealer_commemt']) : '');
			$load['Vin']['rejected_by']		= (!empty($this->request->data['rejected_by']) ? trim($this->request->data['rejected_by']) : '');
			$load['Vin']['status'] 			= $this->request->data['status'];		
			$user_type 						= $this->request->data['user_type'];
			
			if ($this->Vin->save($load))
			{					
				$uploadPath	=	WWW_ROOT.VIN_IMAGES. DS .$load_id ;
				
				if (!is_dir(WWW_ROOT.VIN_IMAGES. DS .$load_id ))
				{
					mkdir(WWW_ROOT.VIN_IMAGES. DS .$load_id, 0777);
				}
				
				$returnforuploadmessage	=	array();
				foreach($_FILES	as	$files	=>	$details)
				{
					$returnforuploadmessage[]	 =	$this->upload_images($details , $files   , $this->Vin->id  , $uploadPath );		
				}
				$data['image_status']	=	$returnforuploadmessage ;
				
				$total_vins = $this->Vin->find('count', array('conditions' => array('Vin.load_id' => $load_id)));
				$vin_status = $this->Vin->find('count', array('conditions' => array('Vin.status' => 3, 'Vin.load_id' => $load_id)));
				$data['status'] = ($total_vins - $vin_status) ? 1 : 0;
				$message = 'Vin delivered successfully.';
				/*if ($user_type == UserType::UserDriver)
				{
					$vin_status = $this->Vin->find('count', array('conditions' => array('Vin.status' => 1, 'Vin.load_id' => $load_id)));				
					$data['status'] = ($total_vins - $vin_status) ? 1 : 0;				
					$message = 'Vin inspected successfully.';
				}
				else if ($user_type == UserType::UserDealer)
				{
					$vin_status = $this->Vin->find('count', array('conditions' => array('Vin.status' => 3, 'Vin.load_id' => $load_id)));
					$data['status'] = ($total_vins - $vin_status) ? 1 : 0;
					$message = 'Vin delivered successfully.';
				}*/			
				$status = 'Success';
			}
			else
			{
				$message = ($user_type == UserType::UserDriver) ? 'Vin inspection fail.' : 'Vin delivered fail';
				$status = 'Failure';
			}
		}
		else 
		{
			$status = 'Failure';
		}
		$this->set(array('status' => $status, 'message' => $message,'data' => $data, '_serialize' => array('status', 'message', 'data')));
	}
	
  /**
	* Method Name : vin_detail	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 18-October-2013
	* Description : Vin detail
	*/
	public function vin_detail()
	{
		$this->layout = '';
		$vin_id = '';
		//$this->ApiConnect->check_valid_request($this->request);
		$this->loadModel('Vin');
		if (isset($this->request->data['vin_number']))
		{			
			$vin_number = $this->request->data['vin_number'];
			$vin_data = $this->Vin->find('first', array('conditions' => array('vin_number' => $vin_number)));
			if (!empty($vin_data))
			{
				$vin_id = $vin_data['Vin']['id'];
			}	
		}	
		else if (isset($this->request->data['vin_id']))
		{		
			$vin_id = $this->request->data['vin_id'];
		}
		$this->Vin->unBindModel(array('belongsTo' => array('Dealer', 'Load')));
		$vin_detail = $this->Vin->findById($vin_id);
		
		if (empty($vin_detail))
		{
			$status = 'Failure';
			$message = 'Vin not found';
		}
		else
		{
			$status = 'Success';
			$message = 'Vin found';
		}
		$this->set(array('status' => $status, 'message' => $message,'data' => $vin_detail, '_serialize' => array('status', 'message', 'data')));	
	}
	
  /**
	* Method Name : area_code	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 29-October-2013
	* Description : Fetch area code
	*/
	public function area_code()
	{
		//$this->ApiConnect->check_valid_request($this->request);
		
		$this->loadModel('AreaCode');		
		if (isset($this->request->data['area_code']) && trim($this->request->data['area_code'] != ''))
		{
			$area_code = $this->request->data['area_code'];
			$data = $this->AreaCode->find('first',array('conditions'=>array('AreaCode.status'=>STATUS_ACTIVE, 'AreaCode.parent_id !='=>0, 'AreaCode.code'=>$area_code),'fields'=>array('AreaCode.code')));
		}
		else
		{
			$data = $this->AreaCode->find('all',array('conditions'=>array('AreaCode.status'=>STATUS_ACTIVE,'AreaCode.parent_id'=>0),'fields'=>array('AreaCode.*')));
		}		
		if (empty($data))
		{
			$status = 'Failure';
			$message = 'Area code not found';
		}
		else
		{
			$status = 'Success';
			$message = 'Area code found';
		}
		$this->set(array('status' => $status, 'message' => $message,'data' => $data, '_serialize' => array('status', 'message', 'data')));	
	}
	
  /**
	* Method Name : type_code	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 29-October-2013
	* Description : Fetch type code
	*/
	public function type_code()
	{
		//$this->ApiConnect->check_valid_request($this->request);
		
		$this->loadModel('TypeCode');
		
		if (isset($this->request->data['type_code']) && trim($this->request->data['type_code'] != ''))
		{
			$type_code = $this->request->data['type_code'];
			$data = $this->TypeCode->find('first',array('conditions' => array('TypeCode.status' => STATUS_ACTIVE, 'TypeCode.code' => $type_code), 'fields' => array('TypeCode.id', 'TypeCode.code')));
		}
		else
		{
			$data = $this->TypeCode->find('all', array('conditions' => array('TypeCode.status' => STATUS_ACTIVE), 'fields' => array('TypeCode.*')));
		}
		
		if (empty($data))
		{
			$status = 'Failure';
			$message = 'Type code not found';
		}
		else
		{
			$status = 'Success';
			$message = 'Type code found';
		}
		$this->set(array('status' => $status, 'message' => $message,'data' => $data, '_serialize' => array('status', 'message', 'data')));	
	}
	
  /**
	* Method Name : severity_code	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 29-October-2013
	* Description : Fetch severity code
	*/
	public function severity_code()
	{
		//$this->ApiConnect->check_valid_request($this->request);
		
		$this->loadModel('SeverityCode');
		
		if (isset($this->request->data['severity_code']) && trim($this->request->data['severity_code'] != ''))
		{
			$severity_code = $this->request->data['severity_code'];
			$data = $this->SeverityCode->find('first',array('conditions'=>array('SeverityCode.status'=>STATUS_ACTIVE,'SeverityCode.code'=>$severity_code),'fields'=>array('SeverityCode.id', 'SeverityCode.code')));
		}
		else
		{
			$data = $this->SeverityCode->find('all',array('conditions'=>array('SeverityCode.status'=>STATUS_ACTIVE),'fields'=>array('SeverityCode.*')));
		}
		
		if (empty($data))
		{
			$status = 'Failure';
			$message = 'Severity code found';
		}
		else
		{
			$status = 'Success';
			$message = 'Severity code found';
		}
		$this->set(array('status' => $status, 'message' => $message,'data' => $data, '_serialize' => array('status', 'message', 'data')));	
	}
	
  /**
	* Method Name : special_code	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 29-October-2013
	* Description : Fetch special code
	*/
	public function special_code()
	{
		//$this->ApiConnect->check_valid_request($this->request);
		
		$this->loadModel('SpecialCode');
		$data = $this->SpecialCode->find('all',
					array('conditions' => array('SpecialCode.status' => STATUS_ACTIVE),
						   'fields' => array('SpecialCode.*', 'areaCode.code', 'typeCode.code', 'severityCode.code')
						)
				);
		
		if (empty($data))
		{
			$status = 'Failure';
			$message = 'Special code not found';
		}
		else
		{
			$status = 'Success';
			$message = 'Special code found';
		}
		$this->set(array('status' => $status, 'message' => $message,'data' => $data, '_serialize' => array('status', 'message', 'data')));	
	}
	
	/**
	 * Method Name : final_inspection
	 * Author Name : Vivek Kumar
	 * Inputs : None
	 * Output : void
	 * Date : 05-December-2013
	 * Description : Is used to final the inspection of truck loaded or not.
	 */
	
	public function final_inspection()
	{
		//$this->ApiConnect->check_valid_request($this->request);
		
		$load_id = $this->request->data['load_id'];
		$user_type = $this->request->data['user_type'];		
		$this->loadModel('Load');
		$this->Load->id = $load_id;
		if ($user_type == UserType::UserDealer)
		{
			$load['Load']['dealer_signature'] = $this->request->data['signature'];
			$load['Load']['dealer_comment'] = $this->request->data['comment'];
			$load['Load']['status'] = 1;
		}
		else if ($user_type == UserType::UserDriver)
		{
			$load['Load']['supervisor_signature'] = $this->request->data['signature'];
			$load['Load']['supervisor_comment'] = $this->request->data['comment'];
		}
		if ($this->Load->save($load))
		{
			$status = 'Success';
			$message = ($user_type == UserType::UserDriver) ? 'Your truck succesfully loaded with vins/cars.' : 'Your all vins successfully delivered.';
		}
		else
		{
			$status = 'Failure';
			$message = 'Oops, your request not completed due to some internal reasons. Please try after some time.';;
		}
		$this->set(array('status' => $status, 'message' => $message,'_serialize' => array('status', 'message')));	
	} 
	
	/* Method Name : vin_message	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 5-November-2013
	* Description : Fetch vin message
	*/
	public function vin_message()
	{
		//$this->ApiConnect->check_valid_request($this->request);
		
		$this->loadModel('VinMessage');
		$data = $this->VinMessage->find('all',array('conditions'=>array('VinMessage.status'=>STATUS_ACTIVE),'fields'=>array('VinMessage.*')));
		
		if (empty($data))
		{
			$status = 'Failure';
			$message = 'Vin message not found';
		}
		else
		{
			$status = 'Success';
			$message = 'Vin message found';
		}
		$this->set(array('status' => $status, 'message' => $message,'data' => $data, '_serialize' => array('status', 'message', 'data')));	
	}

  /**
	* Method Name : dashboard	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 22-October-2013
	* Description : Dashboard screen to show the number of loads
	*/
	public function dashboard()
	{
		//$this->ApiConnect->check_valid_request($this->request);	
		
		$driver_id = $this->request->data['driver_id'];
		
		$this->loadModel('Vin');
		$vin_count = $this->Vin->find('count',array('conditions'=>array('Vin.user_id'=>$driver_id,'Vin.is_shipped'=>0)));
		
		if (empty($vin_count))
		{
			$status = 'Failure';
			$message = 'No load found';
		}
		else
		{
			$status = 'Success';
			$message = 'Load found';
		}
		$this->set(array('status' => $status, 'message' => $message,'data' => $vin_count, '_serialize' => array('status', 'message', 'data')));	
	}
	
  /**
	* Method Name : position	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 12-November-2013
	* Description : Fetch position
	*/
	public function position()
	{
		//$this->ApiConnect->check_valid_request($this->request);		
		$this->loadModel('Position');		
		if (isset($this->request->data['position']) && trim($this->request->data['position'] != ''))
		{
			$postion = $this->request->data['position'];
			$data = $this->Position->find('first', array('conditions'=>array('Position.position' => $postion),'fields'=>array('Position.position', 'Position.id')));
		}
		else
		{
			$data = $this->Position->find('all',array('fields'=>array('Position.position', 'Position.id')));
		}
		
		if (empty($data))
		{
			$status = 'Failure';
			$message = 'Position not found';
		}
		else
		{
			$status = 'Success';
			$message = 'Position found';
		}
		$this->set(array('status' => $status, 'message' => $message,'data' => $data, '_serialize' => array('status', 'message', 'data')));	
	}

	public function notes()
	{
		//$this->ApiConnect->check_valid_request($this->request);
		$this->loadModel('Note');
		$data = $this->Note->find('all',array('fields'=>array('Note.notes')));
		
		if (empty($data))
		{
			$status = 'Failure';
			$message = 'Notes not found';
		}
		else
		{
			$status = 'Success';
			$message = 'Notes found';
		}
		$this->set(array('status' => $status, 'message' => $message,'data' => $data, '_serialize' => array('status', 'message', 'data')));
	}
}
