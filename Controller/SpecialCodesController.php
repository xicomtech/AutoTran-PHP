<?php
App::uses('AppController', 'Controller');
   /**
	 * Special Codes Controller
	 *
	 * Purpose : Manage type code activity
	 * @project Auto Tran
	 * @since 30-October-2013
	 * @author : Santosh Gupta
	 */

class SpecialCodesController extends AppController
{
	public $components = array();
	
	public function beforeFilter(){
		parent::beforeFilter();
	}

  /**
	* Method Name : admin_index
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 29-October-2013
	* Description : Manage type codes
	*/
	public function admin_index()
	{
		$conditions	 = 	array();
		$joins		 = 	array();
		
		// If search through description
		if ( !empty($this->request->query['keyword']) )
		{
			$keyword = trim($this->request->query['keyword']);
			$sql = "SpecialCode.description LIKE '%" . $keyword . "%'";
			$conditions[] = array($sql);
		}
		
		$this->paginate = array(
				'joins' => $joins,
				'conditions' => $conditions,
				'order' => 'SpecialCode.created desc',
				'recursive' => 1,
				'limit' => ADMIN_PAGE_LIMIT
		);
		$data = $this->paginate('SpecialCode');
		
		$this->set( compact('data') );
	}
	
	/**
	* Method Name : admin_add
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 29-October-2013
	* Description : Add admin special code using csv file
	*/
	public function admin_csv_upload()
	{
		if ($this->request->is('post'))
		{
			if (!empty($this->request->data))
			{		
				$this->loadModel('AreaCode');	
				$this->loadModel('TypeCode');
				$this->loadModel('SeverityCode');
				 $path_parts = pathinfo($this->request->data['SpecialCode']['file']['name']);
				
				 if ($path_parts['extension'] == 'csv')
				 {
					 //Upload the file
					 $upload_dir = 'files/';
					 $filename = strtotime(date('Y-m-d H:i:s')).'.csv';
					 if(move_uploaded_file($this->request->data['SpecialCode']['file']['tmp_name'], $upload_dir.$filename))
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
									//Fetch area code
									$code = $this->AreaCode->find('first',array('conditions'=>array('AreaCode.code'=>trim($data[0]))));
									$area_code = $code['AreaCode']['id'];
									
									//Fetch type code
									$code = $this->TypeCode->find('first',array('conditions'=>array('TypeCode.code'=>trim($data[1]))));
									$type_code = $code['TypeCode']['id'];
									
									//Fetch severity code
									$code = $this->SeverityCode->find('first',array('conditions'=>array('SeverityCode.code'=>trim($data[2]))));
									$severity_code = $code['SeverityCode']['id'];
									
									//Check if code exist
									$code_exist = $this->SpecialCode->find('first',array('conditions'=>array('SpecialCode.area_code'=>$area_code,'SpecialCode.type_code'=>$type_code,'SpecialCode.severity_code'=>$severity_code)));
									
									if ( !$code_exist )
									{
										$result['SpecialCode'][$j]['area_code'] 	= $area_code;
										$result['SpecialCode'][$j]['type_code'] 	= $type_code;
										$result['SpecialCode'][$j]['severity_code'] = $severity_code;
										$result['SpecialCode'][$j]['description'] 	= trim($data[3]);
										
										$j++;
									}
								}
								$i++;
							}
							
							if (isset($result['SpecialCode']))
							{
								$this->SpecialCode->create();
								$this->SpecialCode->saveAll($result['SpecialCode']);
							}
									
							
							fclose($handle);
						}
						if ( unlink($upload_dir.$filename) )
						{
							$this->Session->setFlash(__('Special codes saved successfully'),'default',array(),'success');
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
	* Method Name : admin_edit	 
	* Author Name : Santosh Gupta
	* Inputs : $id
	* Output : void
	* Date : 30-October-2013
	* Description : Edit Special code
	*/
	public function admin_edit($id = null)
	{
		$this->SpecialCode->id = $id;
		if (!$this->SpecialCode->exists())
		{
			$this->Session->setFlash(__('Invalid Special code'),'default',array(),'error');
			$this->redirect(array ('action' => 'index'));
		}
		
		if (!empty($this->request->data))
		{
			if ($this->SpecialCode->save($this->request->data))
			{
				$this->Session->setFlash(__('The special code has been updated successfully'),'default',array(),'success');
				$this->redirect(array ('action' => 'index'));
			}
			else
			{
				$errors = $this->SpecialCode->validationErrors;
				$this->set('invalidfields', $errors);
				$this->Session->setFlash(__('The special code could not be saved. Please, try again.'),'default',array(),'error');
			}
		}
		else
		{
			$this->request->data = $this->SpecialCode->read(null, $id);
			$this->loadModel('AreaCode');	
			$this->loadModel('TypeCode');
			$this->loadModel('SeverityCode');
			
			//Fetch area codes
			$areacodes = $this->AreaCode->find('list',array('conditions'=>array('AreaCode.status'=>STATUS_ACTIVE,'AreaCode.parent_id !='=>0),'fields'=>array('AreaCode.id','AreaCode.description')));
			$typecodes = $this->TypeCode->find('list',array('conditions'=>array('TypeCode.status'=>STATUS_ACTIVE),'fields'=>array('TypeCode.id','TypeCode.description')));
			$severitycodes = $this->SeverityCode->find('list',array('conditions'=>array('SeverityCode.status'=>STATUS_ACTIVE),'fields'=>array('SeverityCode.id','SeverityCode.description')));
			
			$this->set(compact('areacodes', 'typecodes', 'severitycodes'));
		}
	}
	
  /**
	* Method Name : admin_delete	 
	* Author Name : Santosh Gupta
	* Inputs : $id
	* Output : void
	* Date : 30-October-2013
	* Description : Delete special code
	*/
	public function admin_delete($id = null)
	{
		$this->SpecialCode->id = $id;
		if (!$this->SpecialCode->exists())
		{
			$this->Session->setFlash(__('Invalid special code'),'default',array(),'error');
			$this->redirect(array ('action' => 'index', 'admin' => true));
		}
		if ($this->SpecialCode->delete($id,true))
		{
			$this->Session->setFlash(__('Special code deleted successfully'),'default',array(),'success');
			$this->redirect(array ('action' => 'index', 'admin' => true));
		}
		$this->Session->setFlash(__('Special code was not deleted'),'default',array(),'error');
		$this->redirect(array ('action' => 'index', 'admin' => true));
	}


}
