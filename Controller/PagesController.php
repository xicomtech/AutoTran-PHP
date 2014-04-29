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
class PagesController extends AppController {
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow();	
	}
	public function display()
	{
		
	}
	
	public function admin_test()
	{
	}
}
