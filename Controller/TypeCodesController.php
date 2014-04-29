<?php
App::uses('AppController', 'Controller');
   /**
	 * Type Codes Controller
	 *
	 * Purpose : Manage type code activity
	 * @project Auto Tran
	 * @since 30-October-2013
	 * @author : Santosh Gupta
	 */

class TypeCodesController extends AppController
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
			$sql = "TypeCode.description LIKE '%" . $keyword . "%'";
			$conditions[] = array($sql);
		}
		
		$this->paginate = array(
				'joins' => $joins,
				'conditions' => $conditions,
				'order' => 'TypeCode.created desc',
				'recursive' => 1,
				'limit' => ADMIN_PAGE_LIMIT
		);
		$data = $this->paginate('TypeCode');
		$this->set( compact('data') );
	}
	
	/**
	* Method Name : admin_add
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 29-October-2013
	* Description : Add admin type code using csv file
	*/
	public function admin_csv_upload()
	{
		if ($this->request->is('post'))
		{
			if (!empty($this->request->data))
			{			
				 $path_parts = pathinfo($this->request->data['TypeCode']['file']['name']);
				 if ($path_parts['extension'] == 'csv')
				 {
					 //Upload the file
					 $upload_dir = 'files/';
					 $filename = strtotime(date('Y-m-d H:i:s')).'.csv';
					 if(move_uploaded_file($this->request->data['TypeCode']['file']['tmp_name'], $upload_dir.$filename))
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
									$code_exist = $this->TypeCode->find('first',array('conditions'=>array('TypeCode.code'=>trim($data[1]))));
									if ( !$code_exist )
									{
										$result['TypeCode'][$j]['code'] = trim($data[0]);
										$result['TypeCode'][$j]['description'] = trim($data[1]);
										
										$j++;
									}
								}
								$i++;
							}
							if (isset($result['TypeCode']))
							{
								$this->TypeCode->create();
								$this->TypeCode->saveAll($result['TypeCode']);
							}
										
							fclose($handle);
						}
						if ( unlink($upload_dir.$filename) )
						{
							$this->Session->setFlash(__('Type codes saved successfully'),'default',array(),'success');
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
		$this->TypeCode->id = $id;
		if (!$this->TypeCode->exists())
		{
			$this->Session->setFlash(__('Invalid Type code'),'default',array(),'error');
			$this->redirect(array ('action' => 'index'));
		}
		
		if (!empty($this->request->data))
		{
			if ($this->TypeCode->save($this->request->data))
			{
				$this->Session->setFlash(__('The type code has been updated successfully'),'default',array(),'success');
				$this->redirect(array ('action' => 'index'));
			}
			else
			{
				$errors = $this->TypeCode->validationErrors;
				$this->set('invalidfields', $errors);
				$this->Session->setFlash(__('The vin could not be saved. Please, try again.'),'default',array(),'error');
			}
		}
		else
		{
			$this->request->data = $this->TypeCode->read(null, $id);
		}
	}
	
  /**
	* Method Name : admin_delete	 
	* Author Name : Santosh Gupta
	* Inputs : $id
	* Output : void
	* Date : 30-October-2013
	* Description : Delete type code
	*/
	public function admin_delete($id = null)
	{
		$this->TypeCode->id = $id;
		if (!$this->TypeCode->exists())
		{
			$this->Session->setFlash(__('Invalid Type code'),'default',array(),'error');
			$this->redirect(array ('action' => 'index', 'admin' => true));
		}
		if ($this->TypeCode->delete($id,true))
		{
			$this->Session->setFlash(__('Type code deleted successfully'),'default',array(),'success');
			$this->redirect(array ('action' => 'index', 'admin' => true));
		}
		$this->Session->setFlash(__('Type code was not deleted'),'default',array(),'error');
		$this->redirect(array ('action' => 'index', 'admin' => true));
	}


}
