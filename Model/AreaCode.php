<?php
/**
	 * Area Code Model
	 *
	 * Purpose : Manage Area code activity
	 * @project Auto Tran
	 * @since 29-October-2013
	 * @author : Santosh Gupta
	 */
class AreaCode extends Model {
	
	public $validate = array(
		'code' => array(
			'rule' => 'isUnique',
			'message' => 'Area code should be unique'
		)
	);
	
	var $hasMany = array(
    'child' =>
            array('className' => 'AreaCode',
          'foreignKey' => 'parent_id',
          'dependent' => true
	  ),
    ); 
}
