<?php
App::uses('AppController', 'Controller');
   /**
	 * Load Controller
	 *
	 * Purpose : Manage load activity
	 * @project Auto Tran
	 * @since 23-October-2013
	 * @author : Santosh Gupta
	 */

class LoadsController extends AppController
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
	* Date : 23-October-2013
	* Description : Manage vin
	*/
	public function admin_index()
	{
		$conditions	 = 	array();
		$joins		 = 	array();
	
		// If search through load #
		if ( !empty($this->request->query['keyword']) )
		{
			$keyword = trim($this->request->query['keyword']);
			$sql = "Load.load LIKE '%" . $keyword . "%'";
			$conditions = array($sql);
		}
	
		$this->paginate = array(
				'joins' => $joins,
				'conditions' => $conditions,
				'order' => 'Load.created desc',
				'recursive' => 1,
				'limit' => ADMIN_PAGE_LIMIT,
		);
		$loads = $this->paginate('Load');
		$this->set( compact('loads') );
	}
	
  /**
	* Method Name : admin_create	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 23-October-2013
	* Description : Create and assign the vins to a load
	*/
	public function admin_create()
	{
		if ($this->request->is('post'))
		{
			//Create a load
			$this->loadModel('User');
			$this->User->id = $this->request->data['Load']['user_id'];
			$load_number = $this->User->field('user_id').'-'.$this->request->data['Load']['truck_number'];
			$load_data['Load']['load'] 				= $load_number;
			$load_data['Load']['user_id'] 			= $this->request->data['Load']['user_id'];
			$load_data['Load']['ship_address']		= $this->request->data['Load']['ship_address'];
			$load_data['Load']['ship_date'] 		= $this->request->data['Load']['ship_date'];
			$load_data['Load']['truck_number'] 		= $this->request->data['Load']['truck_number'];
			
			$this->Load->create();
			if ($this->Load->saveAll($load_data['Load']))
			{
				$load_id = $this->Load->getLastInsertId();
				
				//Update vin table
				$this->loadModel('Vin');
				$i = 0;
				if ( !empty($this->request->data['Load']['vin_list']) && !empty($this->request->data['Load']['user_id']))
				{
					foreach ($this->request->data['Load']['vin_list'] as $data)
					{
						$vin_data['Vin'][$i]['id'] = $data;
						$vin_data['Vin'][$i]['load_id'] = $load_id;
						$i++;
					}
					
					if ($this->Vin->saveAll($vin_data['Vin']))
					{
						$this->Session->setFlash(__('The load has been created and vins has been assigned successfully'));
						$this->redirect(array ('action' => 'index'));
					}
					else
					{
						$errors = $this->Vin->validationErrors;
						
						$this->set('invalidfields', $errors);
						$this->Session->setFlash(__('The vin could not be assigned. Please, try again.'));
					}
				}
			}
			else
			{
				$errors = $this->Load->validationErrors;
				$this->set('invalidfields', $errors);
				$this->Session->setFlash(__('The load could not be created. Please, try again.'));
				
			}
		}
		//Get the list of vins
		$this->loadModel('Vin');
		$vins = $this->Vin->find('list',array('conditions' => array('load_id' => 0, 'status' => 0),'fields' => array('id','vin_number'),'order' => 'id'));
		$this->set(compact('vins'));
		
		//Get the list of drivers
		$this->loadModel('User');
		$users = $this->User->find('list',array('conditions'=>array('user_type'=>'driver','role'=>'user','status'=>1),'fields'=>array('id','full_name'),'order'=>'full_name'));
		$this->set(compact('users'));
	}
	
  /**
	* Method Name : admin_view	 
	* Author Name : Santosh Gupta
	* Inputs : $id
	* Output : void
	* Date : 23-October-2013
	* Description : Show vin detail
	*/
	public function admin_view($id = null)
	{
		$this->Load->id = $id;
		if (!$this->Load->exists())
		{
			throw new NotFoundException(__('Invalid Vin'));
		}

		$data = $this->Load->find('first', array('fields' => array('Load.*','Dealer.customer_name','User.first_name','User.last_name'),'conditions' => array('Load.id' => $id)));		
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
		$this->Load->id = $id;
		if (!$this->Load->exists())
		{
			throw new NotFoundException(__('Invalid Load'));
		}
		
		if (!empty($this->request->data))
		{
			//Fetch the user id(Driver id)
			$this->loadModel('User');
			$driver = $this->User->find('first',array('conditions'=>array('User.role'=>'user','User.user_type'=>'driver','User.id'=>$this->request->data['Load']['user_id'])));
			$driver_original_id = $driver['User']['user_id'];
			
			//update a load
			$load_data['Load']['load'] 			= $driver_original_id.'-'.$this->request->data['Load']['truck_number'];
			$load_data['Load']['user_id'] 		= $this->request->data['Load']['user_id'];
			$load_data['Load']['truck_number']	= $this->request->data['Load']['truck_number'];
			$load_data['Load']['dealer_id'] 	= $this->request->data['Load']['dealer_id'];
			$load_data['Load']['ship_date'] 	= $this->request->data['Load']['ship_date'];
			$load_data['Load']['estdeliverdate']= $this->request->data['Load']['estdeliverdate'];
			$load_data['Load']['status'] 		= $this->request->data['Load']['status'];
			
			if ($this->Load->save($load_data))
			{
				//Reset all vins with load id
				$this->loadModel('Vin');
				$this->Vin->updateAll(array('Vin.load_id' =>0), array('AND'=>array('OR'=>array(array('Vin.load_id'=>0),array('Vin.load_id'=>$id)))));
								
				//Update vin table
				$i = 0;
				if ( !empty($this->request->data['Load']['vin_list']) && !empty($this->request->data['Load']['user_id']))
				{
					foreach ($this->request->data['Load']['vin_list'] as $data)
					{
						$vin_data['Vin'][$i]['id'] = $data;
						$vin_data['Vin'][$i]['load_id'] = $this->request->data['Load']['id'];
						$i++;
					}
					
					if ($this->Vin->saveAll($vin_data['Vin']))
					{
						$this->Session->setFlash(__('The load has been updated and vins has been assigned successfully'));
						$this->redirect(array ('action' => 'index'));
					}
					else
					{
						$errors = $this->Vin->validationErrors;
						
						$this->set('invalidfields', $errors);
						$this->Session->setFlash(__('The vin could not be assigned. Please, try again.'));
					}
				}
				
				$this->Session->setFlash(__('The vin has been updated successfully'));
				$this->redirect(array ('action' => 'index'));
			}
			else
			{
				pr($this->Load->validationErrors);
			}
		}
		
		$this->request->data = $this->Load->read(null, $id);
		
		//Vin list
		$vin_ids = array();
		foreach ($this->request->data['Vin'] as $data1)
		{
			$vin_ids[] = $data1['id'];
		}
		$this->set('vin_ids',$vin_ids);
		
		//Get the list of vins
		$this->loadModel('Vin');
		$vins = $this->Vin->find('list',array('conditions'=>array(
		'AND'=>array('OR'=>array(array('Vin.load_id'=>0),array('Vin.load_id'=>$id)))),'fields'=>array('Vin.id','Vin.vin_number'),'order'=>'Vin.id'));
		
		//Get the list of drivers
		$this->loadModel('User');
		$users = $this->User->find('list',array('conditions'=>array('user_type'=>'driver','role'=>'user','status'=>1),'fields'=>array('id','full_name'),'order'=>'full_name'));
		
		//Get the list of dealers
		$this->loadModel('Dealer');
		$dealers = $this->Dealer->find('list',array('conditions'=>array('Dealer.status'=>1),'fields'=>array('Dealer.id','Dealer.customer_name'),'order'=>'Dealer.id'));
		
		$this->set(compact('users','vins','dealers'));
		
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
}
