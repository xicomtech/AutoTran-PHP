<?php
App::uses('AppController', 'Controller');
   /**
	 * VinMessage Codes Controller
	 *
	 * Purpose : Manage Vin Message activity
	 * @project Auto Tran
	 * @since 30-October-2013
	 * @author : Santosh Gupta
	 */

class VinMessagesController extends AppController
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
	* Description : Manage Vin Message
	*/
	public function admin_index()
	{
		$conditions	 = 	array();
		$joins		 = 	array();
		
		// If search through Vin Message
		if ( !empty($this->request->query['keyword']) )
		{
			$keyword = trim($this->request->query['keyword']);
			$sql = "VinMessage.name LIKE '%" . $keyword . "%'";
			$conditions[] = array($sql);
		}
		
		$this->paginate = array(
				'joins' => $joins,
				'conditions' => $conditions,
				'order' => 'VinMessage.created desc',
				'recursive' => 1,
				'limit' => ADMIN_PAGE_LIMIT
		);
		$data = $this->paginate('VinMessage');
		$this->set( compact('data') );
	}
	
	/**
	* Method Name : admin_add
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 29-October-2013
	* Description : Add admin vin message using csv file
	*/
	public function admin_csv_upload()
	{
		if ($this->request->is('post'))
		{
			if (!empty($this->request->data))
			{			
				 $path_parts = pathinfo($this->request->data['VinMessage']['file']['name']);
				 if ($path_parts['extension'] == 'csv')
				 {
					 //Upload the file
					 $upload_dir = 'files/';
					 $filename = strtotime(date('Y-m-d H:i:s')).'.csv';
					 if(move_uploaded_file($this->request->data['VinMessage']['file']['tmp_name'], $upload_dir.$filename))
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
									//Check if code exist
									$code_exist = $this->VinMessage->find('first',array('conditions'=>array('VinMessage.message'=>trim($data[0]))));
									if ( !$code_exist )
									{
										$result['VinMessage'][$j]['message'] = trim($data[0]);
										$j++;
									}
								}
								$i++;
							}
							if (isset($result['VinMessage']))
							{
								$this->VinMessage->create();
								$this->VinMessage->saveAll($result['VinMessage']);
							}
														
							fclose($handle);
						}
						if ( unlink($upload_dir.$filename) )
						{
							$this->Session->setFlash(__('Vin Message saved successfully'),'default',array(),'success');
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
		$this->VinMessage->id = $id;
		if (!$this->VinMessage->exists())
		{
			$this->Session->setFlash(__('Invalid Vin Message'),'default',array(),'error');
			$this->redirect(array ('action' => 'index'));
		}
		
		if (!empty($this->request->data))
		{
			if ($this->VinMessage->save($this->request->data))
			{
				$this->Session->setFlash(__('The Vin Message has been updated successfully'),'default',array(),'success');
				$this->redirect(array ('action' => 'index'));
			}
			else
			{
				$errors = $this->VinMessage->validationErrors;
				$this->set('invalidfields', $errors);
				$this->Session->setFlash(__('The vin could not be saved. Please, try again.'),'default',array(),'error');
			}
		}
		else
		{
			$this->request->data = $this->VinMessage->read(null, $id);
		}
	}
	
  /**
	* Method Name : admin_delete	 
	* Author Name : Santosh Gupta
	* Inputs : $id
	* Output : void
	* Date : 30-October-2013
	* Description : Delete Vin Message
	*/
	public function admin_delete($id = null)
	{
		$this->VinMessage->id = $id;
		if (!$this->VinMessage->exists())
		{
			$this->Session->setFlash(__('Invalid Vin Message'),'default',array(),'error');
			$this->redirect(array ('action' => 'index', 'admin' => true));
		}
		if ($this->VinMessage->delete($id,true))
		{
			$this->Session->setFlash(__('Vin Message deleted successfully'),'default',array(),'success');
			$this->redirect(array ('action' => 'index', 'admin' => true));
		}
		$this->Session->setFlash(__('Vin Message was not deleted'),'default',array(),'error');
		$this->redirect(array ('action' => 'index', 'admin' => true));
	}


}
