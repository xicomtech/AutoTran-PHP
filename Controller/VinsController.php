<?php
App::uses('AppController', 'Controller');
   /**
	 * Vin Controller
	 *
	 * Purpose : Manage vin activity
	 * @project Auto Tran
	 * @since 17-October-2013
	 * @author : Santosh Gupta
	 */

class VinsController extends AppController
{
	var $components = array('Export');
	
	public function beforeFilter(){
		
		parent::beforeFilter();
		$auth_allow = array('csv_download' , 'front_csv_upload','admin_csv_upload');
		$this->define_access($auth_allow);				
	}

  /**
	* Method Name : admin_index	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 17-October-2013
	* Description : Manage vin
	*/
	public function admin_index()
	{
		$conditions	 = 	array();
		$joins		 = 	array();
	
		// If search through vin #
		if ( !empty($this->request->query['keyword']) )
		{
			$keyword = trim($this->request->query['keyword']);
			$sql = "Vin.vin_number LIKE '%" . $keyword . "%'";
			$conditions = array($sql);
		}
	
		$this->paginate = array(
				'joins' => $joins,
				'conditions' => $conditions,
				'order' => 'Vin.created desc',
				'recursive' => 1,
				'limit' => ADMIN_PAGE_LIMIT,
		);
		$data = $this->paginate('Vin');
		//~ pr($data);
		//~ die;
		$this->set( compact('data') );
	}
	
  /**
	* Method Name : admin_csv_upload
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 29-October-2013
	* Description : Add vin using csv file and create the load
	*/
	function admin_csv_upload()
	{
		$this->loadModel('CsvFile');
		if ($this->request->is('post'))
		{
			if (!empty($this->request->data))
			{			
				 $path_parts = pathinfo($this->request->data['Vin']['file']['name']);				 
				 if ($path_parts['extension'] == 'csv')
				 {
					 //Upload the file
					 $upload_dir = UPLOAD_DIR;
					 $filename = strtotime(date('Y-m-d H:i:s')).'.csv';
					 if(move_uploaded_file($this->request->data['Vin']['file']['tmp_name'], $upload_dir.$filename))
					 {
						$this->Session->setFlash(__('Data saved successfully'),'default',array(),'success');
						
						//Read csv
						$i = 0;$result = array();$j=0;
						if (($handle = fopen($upload_dir.$filename, "r")) !== FALSE) 
						{
							while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
							{
								pr($data);
									exit;
								if ($i != 0)
								{
									if ($i == 1)
									{	
										//Find the driver id
										$this->loadModel('User');
										$driver = $this->User->find('first', 
														array(
																'conditions'=> array('User.role'=>'user', 'User.user_type'=>'driver', 'User.user_id' => trim($data[0]))
														)
												);
										$driver_id = '';
										if (isset($driver['User']['id']))
										{
											$driver_id = $driver['User']['id'];
										}
										else
										{
											$save_user_info =  array(); // here we save the user detail in user table when not found in DB											
											$save_user_info['User']['user_id'] = trim($data[0]);
											$this->User->save($save_user_info);
											$driver_id = $this->User->getLastInsertId();
											$this->User->id = '';
										}
										
										//Create the load if not exist
										$this->loadModel('Load');
										$this->Load->recursive	=	-1;
										$load = $this->Load->find('first',
										array('conditions'=>array('Load.load'=>trim($data[0]).'-'.trim($data[3]) ),
										'fields'	=>	array('id' , 'load')));
										
										if (empty($load))
										{
											//~ Create the load
											$load['Load']['load'] 			= trim($data[0]).'-'.trim($data[3]);
											$load['Load']['user_id'] 		= $driver_id;
											$load['Load']['truck_number'] 	= trim($data[1]);
											$load['Load']['ship_date'] 		= trim($data[24]);
											$load['Load']['estdeliverdate'] = (!empty($data[25]) ? trim($data[25]) : '');
											$load['Load']['status'] 		= 0;
											
											if (isset($load['Load']))
											{
												$this->Load->create();
												$this->Load->save($load);
												$load_id = $this->Load->getLastInsertId();
												$this->Load->id = '';
											}
										}
										else
										{
											$load_id = $load['Load']['id'];
										}
										
									}
									
									//Check if vin exist
									$exists = $this->Vin->find('first',array('conditions'=>array('Vin.vin_number'=>trim($data[2]))));									
									
									if (!$exists)
									{
										$result['Vin'][$j]['load_id'] 		= $load_id;
										$result['Vin'][$j]['vin_number'] 	= trim($data[2]);
										$result['Vin'][$j]['ldnbr'] 		= trim($data[3]);
										$result['Vin'][$j]['ldseq'] 		= trim($data[4]);
										$result['Vin'][$j]['pro'] 			= trim($data[5]);
										$result['Vin'][$j]['ldpos'] 		= trim($data[6]);
										$result['Vin'][$j]['backdrv'] 		= trim($data[7]);
										$result['Vin'][$j]['callback'] 		= trim($data[8]);
										$result['Vin'][$j]['rldspickup'] 	= trim($data[9]);
										$result['Vin'][$j]['bckhlnbr'] 		= trim($data[10]);										
										$result['Vin'][$j]['lot'] 			= trim($data[13]);
										$result['Vin'][$j]['rowbay'] 		= trim($data[14]);
										$result['Vin'][$j]['rte1'] 			= trim($data[15]);
										$result['Vin'][$j]['rte2'] 			= trim($data[16]);
										$result['Vin'][$j]['von'] 			= trim($data[17]);
										$result['Vin'][$j]['body'] 			= trim($data[18]);
										$result['Vin'][$j]['weight'] 		= trim($data[19]);
										$result['Vin'][$j]['color'] 		= trim($data[20]);
										$result['Vin'][$j]['colordes'] 		= trim($data[21]);
										$result['Vin'][$j]['type'] 			= trim($data[22]);
										$result['Vin'][$j]['fillers'] 		= trim($data[23]);
										$j++;
									}
								}
								$i++;
							}
							$csvfilename['CsvFile']['name']		=	$this->request->data['Vin']['file']['name'];
							$csvfilename['CsvFile']['type']		=	'vin';
							$csvfilename['CsvFile']['count']	=	$j;
							$csvfilename['CsvFile']['created']		=	date('Y-m-d H:i:s');
							
							$this->CsvFile->save($csvfilename['CsvFile']);
							
							if (isset($result['Vin']))
							{
								$this->Vin->create();
								$this->Vin->saveAll($result['Vin']);
							}
							fclose($handle);
						}
						if ( unlink($upload_dir.$filename) )
						{
							$this->Session->setFlash(__('Vin saved successfully'),'default',array(),'success');
							$this->redirect(array ('action' => 'admin_index'));
						}
						else
						{
							$this->Session->setFlash(__('File not deleted'),'default',array(),'success');
							$this->redirect(array ('action' => 'admin_index'));
						}
					  }
					  else
					  {
						  
						$this->Session->setFlash(__('File is not uploaded successfully'),'default',array(),'error');
						$this->redirect(array ('action' => 'index'));
					  } 
				}
				else
				{
					$this->Session->setFlash(__('File extension is wrong'),'default',array(),'error');
					$this->redirect(array ('action' => 'index'));
				}
			}
		}
	}
	
  
  /**
	* Method Name : admin_view	 
	* Author Name : Santosh Gupta
	* Inputs : $id
	* Output : void
	* Date : 16-October-2013
	* Description : Show vin detail
	*/
	public function admin_view($id = null)
	{
		$this->Vin->id = $id;
		if (!$this->Vin->exists())
		{
			throw new NotFoundException(__('Invalid Vin'));
		}

		$data = $this->Vin->find('first', array('fields' => 'Vin.*','conditions' => array('Vin.id' => $id)));
		$this->set(compact('data'));
	}
	
  /**
	* Method Name : admin_edit	 
	* Author Name : Santosh Gupta
	* Inputs : $id
	* Output : void
	* Date : 16-October-2013
	* Description : Edit vin
	*/
	public function admin_edit($id = null)
	{
		$this->Vin->id = $id;
		if (!$this->Vin->exists())
		{
			throw new NotFoundException(__('Invalid vin'));
		}
		
		if (!empty($this->request->data))
		{
			if ($this->Vin->save($this->request->data))
			{
				$this->Session->setFlash(__('The vin has been updated successfully'));
				$this->redirect(array ('action' => 'index'));
			}
			else
			{
				$errors = $this->Vin->validationErrors;
				$this->set('invalidfields', $errors);
				$this->Session->setFlash(__('The vin could not be saved. Please, try again.'));
			}
		}
		else
		{
			
			$this->Vin->bindModel(array('hasMany' => array('VinImages' )), true);
			
			$this->request->data = $this->Vin->read(null, $id);
			
			//Get the list of loads
			$this->loadModel('Load');
			
			
			$loads = $this->Load->find('list',array('conditions'=>array('Load.status'=>0),'fields'=>array('id','load'),'order'=>'Load.id'));
			
			$this->set(compact('loads'));
		}
		//Get the list of dealers
		$this->loadModel('Dealer');
		$dealers = $this->Dealer->find('list',array('conditions'=>array('Dealer.status'=>1),'fields'=>array('Dealer.id','Dealer.customer_name'),'order'=>'Dealer.id'));
		$this->set('dealers', $dealers);
	}
	
  /**
	* Method Name : admin_delete	 
	* Author Name : Santosh Gupta
	* Inputs : $id
	* Output : void
	* Date : 16-October-2013
	* Description : Delete Vin
	*/
	public function admin_delete($id = null)
	{
		$this->Vin->id = $id;
		if (!$this->Vin->exists())
		{
			throw new NotFoundException(__('Invalid vin'));
		}
		if ($this->Vin->delete())
		{
			$this->Session->setFlash(__('Vin deleted successfully'));
			$this->redirect(array ('action' => 'index', 'admin' => true));
		}
		$this->Session->setFlash(__('Vin was not deleted'));
		$this->redirect(array ('action' => 'index', 'admin' => true));
	}

  /**
	* Method Name : admin_add	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 16-October-2013
	* Description : Add vin
	*/
	public function admin_add()
	{
		if ($this->request->is('post'))
		{
			if ($this->Vin->save($this->request->data))
			{
				$this->Session->setFlash(__('The vin has been added successfully'));
				$this->redirect(array ('action' => 'index'));
			}
			else
			{
				$errors = $this->Vin->validationErrors;
				$this->set('invalidfields', $errors);
				$this->Session->setFlash(__('The vin could not be saved. Please, try again.'));
			}
		}
		//Get the list of dealers
		$this->loadModel('Dealer');
		$dealers = $this->Dealer->find('list',array('conditions'=>array('Dealer.status'=>1),'fields'=>array('Dealer.id','Dealer.customer_name'),'order'=>'Dealer.id'));
		$this->set('dealers', $dealers);
	}
	
	/**
	* Method Name : admin_assign	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 18-October-2013
	* Description : Assign vins to user
	*/
	public function admin_assign()
	{
		if ($this->request->is('post'))
		{
			$i = 0;
			if ( !empty($this->request->data['Vin']['vin_list']) && !empty($this->request->data['Vin']['user_id']))
			{
				foreach ($this->request->data['Vin']['vin_list'] as $data)
				{
					$save_data['Vin'][$i]['id'] = $data;
					$save_data['Vin'][$i]['is_assigned'] = 1;
					$save_data['Vin'][$i]['user_id'] = $this->request->data['Vin']['user_id'];
					$i++;
				}
				
				if ($this->Vin->saveAll($save_data['Vin']))
				{
					$this->Session->setFlash(__('The vin has been assigned successfully'));
					$this->redirect(array ('action' => 'index'));
				}
				else
				{
					$errors = $this->Drivervin->validationErrors;
					$this->set('invalidfields', $errors);
					$this->Session->setFlash(__('The vin could not be assigned. Please, try again.'));
				}
			}
			else
			{
				$this->Session->setFlash(__('Invalid request'));
				$this->redirect(array ('action' => 'admin_assign'));
			}
		}
		
		//Get the list of vins
		$vins = $this->Vin->find('list',array('conditions'=>array('Vin.is_assigned'=>0,'Vin.is_shipped'=>0),'fields'=>array('id','vin_number'),'order'=>'vin_number'));
		$this->set(compact('vins'));
		
		//Get the list of drivers
		$this->loadModel('User');
		$users = $this->User->find('list',array('conditions'=>array('user_type'=>'driver','status'=>1),'fields'=>array('id','full_name'),'order'=>'full_name'));
		$this->set(compact('users'));
		
	}
	
	public function admin_view_vin($load_id = null)
	{
		$this->Vin->unbindModel(array('belongsTo' => array('Dealer')));
		
		$this->paginate = array(
				'conditions' => array('load_id' => $load_id),
				'order' => 'Vin.created desc',
				'limit' => ADMIN_PAGE_LIMIT,
		);
		$vins = $this->paginate('Vin');		
		$this->set('vins', $vins);	
		$this->set('load_id', $load_id);	
	}
	
	public function admin_confirm_vin($load_id = null, $vin_id = null)
	{
		$this->Vin->id = $vin_id;
		if ($this->Vin->saveField('status', '1'))
		{
			$this->Session->setFlash(__('The vin has been loaded successfully.'));
		}	
		else
		{
			$this->Session->setFlash(__('The vin could not be loaded. Please, try again.'));
		}
		$this->redirect(array('controller' => 'vins', 'action' => 'view_vin', $load_id));
	}
	
	public function csv_download()
	{
		$this->autoRender	=	false;
		$this->Vin->recursive	=	-1;
		$data = $this->Vin->find('all');
		$this->Export->exportCsv($data);
	}
	
	public function front_csv_upload()
	{
		$this->autoLayout	=	false;
		$this->loadModel('CsvFile');		
		
		$this->paginate = array(
				'conditions'	=>	array('type'	=>	'vin'),
				'order' => 'id desc',
				'limit' => ADMIN_PAGE_LIMIT,
		);
		$csvfiles = $this->paginate('CsvFile');	
		
		$this->set(compact('csvfiles'));
		if ($this->request->is('post'))
		{
			if (!empty($this->request->data))
			{	
				 
				 $path_parts = pathinfo($this->request->data['Vin']['file']['name']);				 
				 if ($path_parts['extension'] == 'csv')
				 {
					 //Upload the file
					 $upload_dir = UPLOAD_DIR;
					 $filename = strtotime(date('Y-m-d H:i:s')).'.csv';
					 if(move_uploaded_file($this->request->data['Vin']['file']['tmp_name'], $upload_dir.$filename))
					 {
						$this->Session->setFlash(__('Data saved successfully'),'default',array(),'success');
						
						//Read csv
						$i = 0;$result = array();$j=0;
						if (($handle = fopen($upload_dir.$filename, "r")) !== FALSE) 
						{
							while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
							{
								if ($i != 0)
								{
									if ($i == 1)
									{	
										//Find the driver id
										$this->loadModel('User');
										$driver = $this->User->find('first', 
														array(
																'conditions'=> array('User.role'=>'user', 'User.user_type'=>'driver', 'User.user_id' => trim($data[0]))
														)
												);
										$driver_id = '';
										if (isset($driver['User']['id']))
										{
											$driver_id = $driver['User']['id'];
										}
										else
										{
											$save_user_info =  array(); // here we save the user detail in user table when not found in DB											
											$save_user_info['User']['user_id'] = trim($data[0]);
											$this->User->save($save_user_info);
											$driver_id = $this->User->getLastInsertId();
											$this->User->id = '';
										}
										
										//Create the load if not exist
										$this->loadModel('Load');
										$this->Load->recursive	=	-1;
										$load = $this->Load->find('first',
										array('conditions'=>array('Load.load'=>trim($data[0]).'-'.trim($data[3]) ),
										'fields'	=>	array('id' , 'load')));
										
										if (empty($load))
										{
											//~ Create the load
											$load['Load']['load'] 			= trim($data[0]).'-'.trim($data[3]);
											$load['Load']['user_id'] 		= $driver_id;
											$load['Load']['truck_number'] 	= trim($data[1]);
											$load['Load']['ship_date'] 		= trim($data[24]);
											$load['Load']['estdeliverdate'] = (!empty($data[25]) ? trim($data[25]) : '');
											$load['Load']['status'] 		= 0;
											
											if (isset($load['Load']))
											{
												$this->Load->create();
												$this->Load->save($load);
												$load_id = $this->Load->getLastInsertId();
												$this->Load->id = '';
											}
										}
										else
										{
											$load_id = $load['Load']['id'];
										}
										
									}
									
									//Check if vin exist
									$exists = $this->Vin->find('first',array('conditions'=>array('Vin.vin_number'=>trim($data[2]))));									
									
									if (!$exists)
									{
										$result['Vin'][$j]['load_id'] 		= $load_id;
										$result['Vin'][$j]['vin_number'] 	= trim($data[2]);
										$result['Vin'][$j]['ldnbr'] 		= trim($data[3]);
										$result['Vin'][$j]['ldseq'] 		= trim($data[4]);
										$result['Vin'][$j]['pro'] 			= trim($data[5]);
										$result['Vin'][$j]['ldpos'] 		= trim($data[6]);
										$result['Vin'][$j]['backdrv'] 		= trim($data[7]);
										$result['Vin'][$j]['callback'] 		= trim($data[8]);
										$result['Vin'][$j]['rldspickup'] 	= trim($data[9]);
										$result['Vin'][$j]['bckhlnbr'] 		= trim($data[10]);										
										$result['Vin'][$j]['lot'] 			= trim($data[13]);
										$result['Vin'][$j]['rowbay'] 		= trim($data[14]);
										$result['Vin'][$j]['rte1'] 			= trim($data[15]);
										$result['Vin'][$j]['rte2'] 			= trim($data[16]);
										$result['Vin'][$j]['von'] 			= trim($data[17]);
										$result['Vin'][$j]['body'] 			= trim($data[18]);
										$result['Vin'][$j]['weight'] 		= trim($data[19]);
										$result['Vin'][$j]['color'] 		= trim($data[20]);
										$result['Vin'][$j]['colordes'] 		= trim($data[21]);
										$result['Vin'][$j]['type'] 			= trim($data[22]);
										$result['Vin'][$j]['fillers'] 		= trim($data[23]);
										$j++;
									}
								}
								$i++;
							}
						
							$csvfilename['CsvFile']['name']		=	$this->request->data['Vin']['file']['name'];
							$csvfilename['CsvFile']['count']	=	$j;
							$csvfilename['CsvFile']['created']		=	date('Y-m-d H:i:s');
							
							$this->CsvFile->save($csvfilename['CsvFile']);
							
							if (isset($result['Vin']))
							{
								$this->Vin->create();
								$this->Vin->saveAll($result['Vin']);
							}
							fclose($handle);
						}
						if ( unlink($upload_dir.$filename) )
						{
							$this->Session->setFlash(__('Vin saved successfully'),'default',array(),'success');
							$this->redirect(array ('action' => 'front_csv_upload'));
						}
						else
						{
							$this->Session->setFlash(__('File not deleted'),'default',array(),'success');
							$this->redirect(array ('action' => 'front_csv_upload'));
						}
					  }
					  else
					  {
						  
						$this->Session->setFlash(__('File is not uploaded successfully'),'default',array(),'error');
						$this->redirect(array ('action' => 'front_csv_upload'));
					  } 
				}
				else
				{
					$this->Session->setFlash(__('File extension is wrong'),'default',array(),'error');
					$this->redirect(array ('action' => 'front_csv_upload'));
				}
			}
		}
		
		
	}
}
