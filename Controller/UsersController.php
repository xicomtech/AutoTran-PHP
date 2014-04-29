<?php
App::uses('AppController', 'Controller');
   /**
	 * User Controller
	 *
	 * Purpose : Manage user activity
	 * @project Auto Tran
	 * @since 16-October-2013
	 * @author : Santosh Gupta
	 */

class UsersController extends AppController
{
	public $components = array('Uploader');
	
	public function beforeFilter(){
		parent::beforeFilter();
		if ($this->params['prefix'] == 'admin'){
			$this->Auth->allow( array('admin_login','admin_logout') );
		}else{
			$this->Auth->allow();
		}		
	}
	
  /**
	* Method Name : admin_index	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 16-October-2013
	* Description : Shoe the theme layout
	*/
	public function admin_index()
	{
		$this->theme = 'Admin';
	}
	
  /**
	* Method Name : admin_manage	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 16-October-2013
	* Description : Manage admin users
	*/
	public function admin_manage()
	{
		$conditions	 = 	array();
		$joins		 = 	array();
	
		// If search through email id
		if ( !empty($this->request->query['email']) )
		{
			$email_keyword = strtolower(trim($this->request->query['email']));
			$email_keyword = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $email_keyword);
			$sql = "LOWER(CONCAT_WS(' ', User.first_name, User.last_name)) LIKE '%" . $email_keyword . "%'  OR User.email LIKE '%" . $email_keyword . "%'";
			$conditions = array($sql);
		}
	
		$this->paginate = array(
				'joins' => $joins,
				'conditions' => $conditions,
				'order' => 'User.created desc',
				'recursive' => 1,
				'limit' => ADMIN_PAGE_LIMIT,
		);
		$users = $this->paginate('User');
		$this->set( compact('users') );
	}
	
  /**
	* Method Name : admin_login	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 16-October-2013
	* Description : Admin login
	*/
	public function admin_login()
	{
		if ( !empty($this->request->data) )
		{
			if ($this->Auth->login())
			{
				if($this->Auth->user('id') == '1')
				{
					if ( !empty($this->request->data['remember']) )
					{
						$this->Cookie->write('user_rem', $this->request->data, false);
					}
					else
					{
						$this->Cookie->delete('user_rem');
					}				
					$this->redirect(array('controller' => 'users','action' => 'index', 'admin' => true));
				}
				else
				{
					$this->Session->destroy();
					$this->Session->setFlash(__('Password and / or Username do not match'));
					$this->redirect($this->Auth->logout());	
				}
			} 
			else
			{
				$this->Session->setFlash(__('Password and / or Username do not match'));
				//$this->redirect(array('controller' => 'users', 'action' => 'login','admin' => true));
			}
		}
		$remember = $this->Cookie->read('user_rem');
	
		if ( $remember && is_array($remember) )
		{
			$this->request->data = $remember;
			$this->request->data['remember'] = '1';
			
		}
		$this->set('title_for_layout', 'Administrator Login');
	}
	
  /**
	* Method Name : admin_view	 
	* Author Name : Santosh Gupta
	* Inputs : $id
	* Output : void
	* Date : 16-October-2013
	* Description : Show user detail
	*/
	public function admin_view($id = null)
	{
		$this->User->id = $id;
		if (!$this->User->exists())
		{
			throw new NotFoundException(__('Invalid user'));
		}

		$user = $this->User->find('first', array('fields' => '*','conditions' => array('id' => $id)));
		$this->set(compact('user'));
	}
	
  /**
	* Method Name : admin_edit	 
	* Author Name : Santosh Gupta
	* Inputs : $id
	* Output : void
	* Date : 16-October-2013
	* Description : Edit User
	*/
	public function admin_edit($id = null)
	{
		$this->User->id = $id;
		if (!$this->User->exists())
		{
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put'))
		{
			if ($this->User->save($this->request->data))
			{
				$this->Session->setFlash(__('The user has been updated successfully'));
				$this->redirect(array ('action' => 'manage'));
			}
			else
			{
				$errors = $this->User->validationErrors;
				$this->set('invalidfields', $errors);
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->User->read(null, $id);
		}
	}
	
  /**
	* Method Name : admin_delete	 
	* Author Name : Santosh Gupta
	* Inputs : $id
	* Output : void
	* Date : 16-October-2013
	* Description : Delete user
	*/
	public function admin_delete($id = null)
	{
		$this->User->id = $id;
		if (!$this->User->exists())
		{
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete())
		{
			$this->Session->setFlash(__('User deleted successfully'));
			$this->redirect(array ('action' => 'manage', 'admin' => true));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array ('action' => 'manage', 'admin' => true));
	}
	
  /**
	* Method Name : admin_change_password	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 16-October-2013
	* Description : Change admin password
	*/
	public function admin_change_password()
	{
		if ( $user = $this->Auth->user() )
		{
			if ($this->request->is('post'))
			{
				$data = $this->request->data;
				if (!empty($data['User']['password']) && $this->Auth->user('id') == 1)
				{
					$data['User']['password'] = AuthComponent::password($data['User']['password']);;
					if ($this->User->save($data))
					{
						if (!empty($data['User']['password']))
						{
							unset($this->request->data['User']['password']);
							unset($this->request->data['User']['confirm_password']);
							$this->Session->setFlash(__('Your password has been changed.'));
						}
						else
						{
							$this->Session->setFlash(__('Information updated.'));
						}
					}
				}
			}
			else
			{
				$data = $user;
				if (!array_key_exists('User', $user))
				{
					$data = array ('User' => $user);
				}
				if (isset($data['User']['password']))
				{
					unset($data['User']['password']);
				}
				$this->set('user', $data);
				$this->request->data = null;
				$this->request->data = $data;
			}
		}
		else
		{
			$this->Auth->logout($this->Auth->redirect());
		}
	}
	
  /**
	* Method Name : admin_logout	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 16-October-2013
	* Description : Admin logout
	*/
	public function admin_logout()
	{
		$this->Session->destroy();
		$this->redirect($this->Auth->logout());		
	}
	
	/**
	* Method Name : admin_add	 
	* Author Name : Santosh Gupta
	* Inputs : None
	* Output : void
	* Date : 16-October-2013
	* Description : Edit User
	*/
	public function admin_add()
	{
		if ($this->request->is('post'))
		{
			$this->request->data['User']['role']='user';
			$this->User->create();
			if ($this->User->save($this->request->data))
			{
				$this->Session->setFlash(__('The user has been added successfully'));
				$this->redirect(array ('action' => 'manage'));
			}
			else
			{
				$errors = $this->User->validationErrors;
				$this->set('invalidfields', $errors);
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}
	
	public function check()
	{
	}
}
