<?php
/**
	 * Dealers Model
	 *
	 * Purpose : Manage dealer activity
	 * @project Auto Tran
	 * @since 31-October-2013
	 * @author : Santosh Gupta
	 */
class Dealer extends Model {
	
	public $validate = array(
		'shptocust' => array(
			'rule' => 'isUnique',
			'message' => 'Cistomer id should be unique'
		)
	);
	
	
}
