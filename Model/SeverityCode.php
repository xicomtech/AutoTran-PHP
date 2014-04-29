<?php
/**
	 * Severity Code Model
	 *
	 * Purpose : Manage Severity code activity
	 * @project Auto Tran
	 * @since 30-October-2013
	 * @author : Santosh Gupta
	 */
class SeverityCode extends Model {
	
	public $validate = array(
		'code' => array(
			'rule' => 'isUnique',
			'message' => 'Code should be unique'
		)
	);
	
	
}
