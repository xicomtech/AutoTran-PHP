<?php
/**
	 * SpecialCode Model
	 *
	 * Purpose : Manage Special code activity
	 * @project Auto Tran
	 * @since 29-October-2013
	 * @author : Santosh Gupta
	 */
class SpecialCode extends Model {
	
	public $validate = array(
		'code' => array(
			'rule' => 'isUnique',
			'message' => 'Code should be unique'
		)
	);
	
    var $belongsTo = array(
		'areaCode' => array(
			'className' => 'areaCode',
			'foreignKey' => 'area_code',
			'conditions' => array('areaCode.status'=>STATUS_ACTIVE)
		),
		'typeCode' => array(
			'className' => 'typeCode',
			'foreignKey' => 'type_code',
			'conditions' => array('typeCode.status'=>STATUS_ACTIVE)
		),
		'severityCode' => array(
			'className' => 'severityCode',
			'foreignKey' => 'severity_code',
			'conditions' => array('severityCode.status'=>STATUS_ACTIVE)
		)
    );

    
}
