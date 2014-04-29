<?php
App::uses('AppController', 'Controller');
   /**
	 * Area Codes Controller
	 *
	 * Purpose : Manage area code activity
	 * @project Auto Tran
	 * @since 29-October-2013
	 * @author : Santosh Gupta
	 */

class AreaCodesController extends AppController
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
	* Description : Manage area codes
	*/
	public function admin_index()
	{
		$conditions	 = 	array();
		$joins		 = 	array();
		
		// If search through parent area name
		if ( !empty($this->request->query['keyword']) )
		{
			$keyword = trim($this->request->query['keyword']);
			$sql = "AreaCode.group LIKE '%" . $keyword . "%'";
			$conditions[] = array($sql);
		}
		$conditions[] = array('AreaCode.parent_id'=>0);
		
		$this->paginate = array(
				'joins' => $joins,
				'conditions' => $conditions,
				'order' => 'AreaCode.created desc',
				'recursive' => 1,
				'limit' => ADMIN_PAGE_LIMIT
		);
		$data = $this->paginate('AreaCode');
		$this->set( compact('data') );
	}
	
	/**
	* Method Name : admin_add
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 29-October-2013
	* Description : Add admin area code using csv file
	*/
	public function admin_csv_upload()
	{
		if ($this->request->is('post'))
		{
			if (!empty($this->request->data))
			{
				 $path_parts = pathinfo($this->request->data['AreaCode']['file']['name']);
				 if ($path_parts['extension'] == 'csv')
				 {
					 //Upload the file
					 $upload_dir = 'files/';
					 $filename = strtotime(date('Y-m-d H:i:s')).'.csv';
					 if(move_uploaded_file($this->request->data['AreaCode']['file']['tmp_name'], $upload_dir.$filename))
					 {
						$this->Session->setFlash(__('Data saved successfully'),'default',array(),'success');
						
						//Read csv
						$i = 0;
						if (($handle = fopen($upload_dir.$filename, "r")) !== FALSE) 
						{
							while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
							{
								if ($i != 0)
								{
									//Check if top exist
									$top_exist = $this->AreaCode->find('first',array('conditions'=>array('AreaCode.group'=>trim($data[0]))));
									
									if ( !$top_exist )
									{
										//Save Top level codes
										$top_data['AreaCode']['group'] = trim($data[0]);
										
										$this->AreaCode->create();
										$this->AreaCode->save($top_data);
										$top_id = $this->AreaCode->getLastInsertId();
									}
									else
									{
										//Fetch top id
										$top_id = $top_exist['AreaCode']['id']."<br>";
									}
									
									//Check if child code exist
									$child_code_exist = $this->AreaCode->find('first',array('conditions'=>array('AreaCode.code'=>trim($data[1]))));
									if ( !$child_code_exist )
									{
										$child_data['AreaCode']['parent_id'] 	= $top_id;
										$child_data['AreaCode']['code'] 		= trim($data[1]);
										$child_data['AreaCode']['description'] 	= trim($data[2]);
										
										$this->AreaCode->create();
										$this->AreaCode->save($child_data);
									}
								}
								$i++;
							}
							
							fclose($handle);
						}
						if ( unlink($upload_dir.$filename) )
						{
							$this->Session->setFlash(__('Area codes saved successfully'),'default',array(),'success');
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
	* Description : Edit area code
	*/
	public function admin_edit($id = null)
	{
		$this->AreaCode->id = $id;
		if (!$this->AreaCode->exists())
		{
			$this->Session->setFlash(__('Invalid Area code'),'default',array(),'error');
			$this->redirect(array ('action' => 'index'));
		}
		
		if (!empty($this->request->data))
		{
			if ($this->AreaCode->save($this->request->data))
			{
				$this->Session->setFlash(__('The area code has been updated successfully'));
				$this->redirect(array ('action' => 'index'));
			}
			else
			{
				//Fetch all top level category
				$this->AreaCode->unbindModel(array('hasMany' => array('child')));
				
				$top_level = $this->AreaCode->find('list',array('conditions'=>array('parent_id'=>0),'fields'=>array('id','group')));
				$this->set('top_level',$top_level);
				
				$errors = $this->AreaCode->validationErrors;
				$this->set('invalidfields', $errors);
				$this->Session->setFlash(__('The vin could not be saved. Please, try again.'));
			}
		}
		else
		{
			$data = $this->AreaCode->read(null, $id);
			
			if ($data['AreaCode']['parent_id'] != 0)
			{
				//Fetch all top level category
				$this->AreaCode->unbindModel(array('hasMany' => array('child')));
				
				$top_level = $this->AreaCode->find('list',array('conditions'=>array('parent_id'=>0),'fields'=>array('id','group')));
				$this->set('top_level',$top_level);
				$this->request->data = $data;
			}
			else
			{
				$this->request->data = $data;
			}
		}
	}
	
  /**
	* Method Name : admin_delete	 
	* Author Name : Santosh Gupta
	* Inputs : $id
	* Output : void
	* Date : 30-October-2013
	* Description : Delete area code
	*/
	public function admin_delete($id = null)
	{
		$this->AreaCode->id = $id;
		if (!$this->AreaCode->exists())
		{
			$this->Session->setFlash(__('Invalid Area code'),'default',array(),'error');
			$this->redirect(array ('action' => 'index', 'admin' => true));
		}
		if ($this->AreaCode->delete($id,true))
		{
			$this->Session->setFlash(__('Area code deleted successfully'),'default',array(),'success');
			$this->redirect(array ('action' => 'index', 'admin' => true));
		}
		$this->Session->setFlash(__('Area code was not deleted'),'default',array(),'error');
		$this->redirect(array ('action' => 'index', 'admin' => true));
	}


}
