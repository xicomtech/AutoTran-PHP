<?php
/**
	 * User Model
	 *
	 * Purpose : Manage user activity
	 * @project Auto Tran
	 * @since 16-October-2013
	 * @author : Santosh Gupta
	 */
class User extends Model {
	
	Public $hasMany = array('Load');
	
	public $virtualFields = array(
	'full_name' => 'CONCAT(User.first_name, " ", User.last_name)'
	);
	
	public $validate = array(
		'user_id' => array(
			'rule' => 'isUnique',
			'message' => 'User id should be unique'
		),
		'email' => array(
			'email' => array(
				'rule' => 'email',
				'message' => 'Email id Should be a valid email address'
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Email id  Should be unique'
			)
		)
	);
}
