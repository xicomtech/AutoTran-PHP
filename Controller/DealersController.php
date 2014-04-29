<?php
App::uses('AppController', 'Controller');
   /**
	 * Dealers Controller
	 *
	 * Purpose : Manage dealers activity
	 * @project Auto Tran
	 * @since 31-October-2013
	 * @author : Santosh Gupta
	 */

class DealersController extends AppController
{
	var $components = array('Export');
	
	public function beforeFilter(){
		parent::beforeFilter();
		$auth_allow = array('csv_download' , 'front_csv_upload');
		$this->define_access($auth_allow);				
	}

  /**
	* Method Name : admin_index
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 29-October-2013
	* Description : Manage dealers
	*/
	public function admin_index()
	{
		$conditions	 = 	array();
		$joins		 = 	array();
		
		// If search through description
		if ( !empty($this->request->query['keyword']) )
		{
			$keyword = trim($this->request->query['keyword']);
			$sql = "Dealer.shptocust LIKE '%" . $keyword . "%'";
			$conditions[] = array($sql);
		}
		
		$this->paginate = array(
				'joins' => $joins,
				'conditions' => $conditions,
				'order' => 'Dealer.created desc',
				'recursive' => 1,
				'limit' => ADMIN_PAGE_LIMIT
		);
		$data = $this->paginate('Dealer');
		$this->set( compact('data') );
	}
	
	/**
	* Method Name : admin_csv_upload
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 29-October-2013
	* Description : Add admin dealer using csv file
	*/
	public function admin_csv_upload()
	{
		$this->loadModel('CsvFile');
		if ($this->request->is('post'))
		{
			if (!empty($this->request->data))
			{			
				 $path_parts = pathinfo($this->request->data['Dealer']['file']['name']);
				 //~ pr($this->request->data);
				 //~ die;
				 if ($path_parts['extension'] == 'csv')
				 {
					 //Upload the file
					 $upload_dir = UPLOAD_DIR;
					 $filename = strtotime(date('Y-m-d H:i:s')).'.csv';
					 if(move_uploaded_file($this->request->data['Dealer']['file']['tmp_name'], $upload_dir.$filename))
					 {
						$this->Session->setFlash(__('Data saved successfully'),'default',array(),'success');
						
						//Read csv
						$i = 0;$result = array();$j=0;
						if (($handle = fopen($upload_dir.$filename, "r")) !== FALSE) 
						{
							while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
							{
								//~ pr($data);
								if ($i != 0)
								{
									//Check if code exist
									$exists = $this->Dealer->find('first',array('conditions'=>array('Dealer.shptocust'=>trim($data[2]))));
									
									if ( !$exists )
									{
										$result['Dealer'][$j]['ldnbr'] 			= trim($data[0]);
										$result['Dealer'][$j]['mfg'] 			= trim($data[1]);
										$result['Dealer'][$j]['shptocust'] 		= trim($data[2]);
										$result['Dealer'][$j]['customer_name'] 	= trim($data[3]);
										$result['Dealer'][$j]['city'] 			= trim($data[4]);
										$result['Dealer'][$j]['state'] 			= trim($data[5]);
										$result['Dealer'][$j]['address'] 		= trim($data[6]);
										$result['Dealer'][$j]['zip'] 			= trim($data[7]);
										$result['Dealer'][$j]['monam'] 			= trim($data[8]);
										$result['Dealer'][$j]['tueam'] 			= trim($data[9]);
										$result['Dealer'][$j]['wedam'] 			= trim($data[10]);
										$result['Dealer'][$j]['thuam'] 			= trim($data[11]);
										$result['Dealer'][$j]['friam'] 			= trim($data[12]);
										$result['Dealer'][$j]['satam'] 			= trim($data[13]);
										$result['Dealer'][$j]['sunam'] 			= trim($data[14]);
										$result['Dealer'][$j]['monpm'] 			= trim($data[15]);
										$result['Dealer'][$j]['tuepm'] 			= trim($data[16]);
										$result['Dealer'][$j]['wedpm'] 			= trim($data[17]);
										$result['Dealer'][$j]['thupm'] 			= trim($data[18]);
										$result['Dealer'][$j]['fripm'] 			= trim($data[19]);
										$result['Dealer'][$j]['satpm'] 			= trim($data[20]);
										$result['Dealer'][$j]['sunpm'] 			= trim($data[21]);
										$result['Dealer'][$j]['afthr'] 			= trim($data[22]);
										$result['Dealer'][$j]['comments'] 		= trim($data[23]);
										
										$j++;
									}
								}
								$i++;
							}
							$csvfilename['CsvFile']['name']		=	$this->request->data['Dealer']['file']['name'];
							$csvfilename['CsvFile']['type']		=	'dealer';
							$csvfilename['CsvFile']['count']	=	$j;
							$csvfilename['CsvFile']['created']		=	date('Y-m-d H:i:s');
							
							if (isset($result['Dealer']))
							{
								$this->Dealer->create();
								$this->Dealer->saveAll($result['Dealer']);
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
	
	
	public function admin_add()
	{
		if (!empty($this->request->data))
		{
			if ($this->Dealer->save($this->request->data))
			{
				$this->Session->setFlash(__('The dealer has been created successfully'),'default',array(),'success');
				$this->redirect(array ('action' => 'index'));
			}
			else
			{
				$errors = $this->Dealer->validationErrors;
				$this->set('invalidfields', $errors);
				$this->Session->setFlash(__('The dealer could not be saved. Please, try again.'),'default',array(),'error');
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
		$this->Dealer->id = $id;
		if (!$this->Dealer->exists())
		{
			$this->Session->setFlash(__('Invalid Dealer'),'default',array(),'error');
			$this->redirect(array ('action' => 'index'));
		}
		
		if (!empty($this->request->data))
		{
			if ($this->Dealer->save($this->request->data))
			{
				$this->Session->setFlash(__('The dealer has been updated successfully'),'default',array(),'success');
				$this->redirect(array ('action' => 'index'));
			}
			else
			{
				$errors = $this->Dealer->validationErrors;
				$this->set('invalidfields', $errors);
				$this->Session->setFlash(__('The dealer could not be saved. Please, try again.'),'default',array(),'error');
			}
		}
		else
		{
			$this->request->data = $this->Dealer->read(null, $id);
		}
	}
	
  /**
	* Method Name : admin_delete	 
	* Author Name : Santosh Gupta
	* Inputs : $id
	* Output : void
	* Date : 30-October-2013
	* Description : Delete dealer
	*/
	public function admin_delete($id = null)
	{
		$this->Dealer->id = $id;
		if (!$this->Dealer->exists())
		{
			$this->Session->setFlash(__('Invalid Dealer'),'default',array(),'error');
			$this->redirect(array ('action' => 'index', 'admin' => true));
		}
		if ($this->Dealer->delete($id,true))
		{
			$this->Session->setFlash(__('Dealer deleted successfully'),'default',array(),'success');
			$this->redirect(array ('action' => 'index', 'admin' => true));
		}
		$this->Session->setFlash(__('Dealer was not deleted'),'default',array(),'error');
		$this->redirect(array ('action' => 'index', 'admin' => true));
	}
	
	public function csv_download()
	{
		$this->autoRender	=	false;
		$this->Dealer->recursive	=	-1;
		$data = $this->Dealer->find('all');
		
		$this->Export->exportCsv($data);
	}
	
	public function front_csv_upload()
	{
		$this->autoLayout	=	false;
		$this->loadModel('CsvFile');		
		
		$this->paginate = array(
				'conditions'	=>	array('type'	=>	'dealer'),
				'order' => 'id desc',
				'limit' => ADMIN_PAGE_LIMIT,
		);
		$csvfiles = $this->paginate('CsvFile');	
		
		$this->set(compact('csvfiles'));
		if ($this->request->is('post'))
		{
			if (!empty($this->request->data))
			{			
				 $path_parts = pathinfo($this->request->data['Dealer']['file']['name']);
				 //~ pr($this->request->data);
				 //~ die;
				 if ($path_parts['extension'] == 'csv')
				 {
					 //Upload the file
					 $upload_dir = UPLOAD_DIR;
					 $filename = strtotime(date('Y-m-d H:i:s')).'.csv';
					 if(move_uploaded_file($this->request->data['Dealer']['file']['tmp_name'], $upload_dir.$filename))
					 {
						$this->Session->setFlash(__('Data saved successfully'),'default',array(),'success');
						
						//Read csv
						$i = 0;$result = array();$j=0;
						if (($handle = fopen($upload_dir.$filename, "r")) !== FALSE) 
						{
							while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
							{
								//~ pr($data);
								if ($i != 0)
								{
									//Check if code exist
									$exists = $this->Dealer->find('first',array('conditions'=>array('Dealer.shptocust'=>trim($data[2]))));
									
									if ( !$exists )
									{
										$result['Dealer'][$j]['ldnbr'] 			= trim($data[0]);
										$result['Dealer'][$j]['mfg'] 			= trim($data[1]);
										$result['Dealer'][$j]['shptocust'] 		= trim($data[2]);
										$result['Dealer'][$j]['customer_name'] 	= trim($data[3]);
										$result['Dealer'][$j]['city'] 			= trim($data[4]);
										$result['Dealer'][$j]['state'] 			= trim($data[5]);
										$result['Dealer'][$j]['address'] 		= trim($data[6]);
										$result['Dealer'][$j]['zip'] 			= trim($data[7]);
										$result['Dealer'][$j]['monam'] 			= trim($data[8]);
										$result['Dealer'][$j]['tueam'] 			= trim($data[9]);
										$result['Dealer'][$j]['wedam'] 			= trim($data[10]);
										$result['Dealer'][$j]['thuam'] 			= trim($data[11]);
										$result['Dealer'][$j]['friam'] 			= trim($data[12]);
										$result['Dealer'][$j]['satam'] 			= trim($data[13]);
										$result['Dealer'][$j]['sunam'] 			= trim($data[14]);
										$result['Dealer'][$j]['monpm'] 			= trim($data[15]);
										$result['Dealer'][$j]['tuepm'] 			= trim($data[16]);
										$result['Dealer'][$j]['wedpm'] 			= trim($data[17]);
										$result['Dealer'][$j]['thupm'] 			= trim($data[18]);
										$result['Dealer'][$j]['fripm'] 			= trim($data[19]);
										$result['Dealer'][$j]['satpm'] 			= trim($data[20]);
										$result['Dealer'][$j]['sunpm'] 			= trim($data[21]);
										$result['Dealer'][$j]['afthr'] 			= trim($data[22]);
										$result['Dealer'][$j]['comments'] 		= trim($data[23]);
										
										$j++;
									}
								}
								$i++;
							}
							$csvfilename['CsvFile']['name']		=	$this->request->data['Dealer']['file']['name'];
							$csvfilename['CsvFile']['type']		=	'dealer';
							$csvfilename['CsvFile']['count']	=	$j;
							$csvfilename['CsvFile']['created']		=	date('Y-m-d H:i:s');
							$this->CsvFile->save($csvfilename['CsvFile']);
							if (isset($result['Dealer']))
							{
								$this->Dealer->create();
								$this->Dealer->saveAll($result['Dealer']);
							}
							
							fclose($handle);
						}
						if ( unlink($upload_dir.$filename) )
						{
							$this->Session->setFlash(__('Type codes saved successfully'),'default',array(),'success');
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
