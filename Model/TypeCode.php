<?php
/**
	 * Type Code Model
	 *
	 * Purpose : Manage type code activity
	 * @project Auto Tran
	 * @since 30-October-2013
	 * @author : Santosh Gupta
	 */
class TypeCode extends Model {
	
	public $validate = array(
		'code' => array(
			'rule' => 'isUnique',
			'message' => 'Code should be unique'
		)
	);
	
	
}
