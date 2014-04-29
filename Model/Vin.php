<?php
/**
	 * Vin Model
	 *
	 * Purpose : Manage Vin activity
	 * @project Auto Tran
	 * @since 18-October-2013
	 * @author : Santosh Gupta
	 */
class Vin extends Model {
	
	public $validate = array(
		'vin_number' => array(
			'rule' => 'isUnique',
			'message' => 'Vin number should be unique'
		)
	);
	
	var $belongsTo = array(
		'Dealer' => array(
			'className' => 'Dealer',
			'foreignKey' => 'dealer_id'
		),
		'Load' => array(
			'className' => 'Load',
			'foreignKey' => 'load_id'
		),
		'Position' => array(
			'className' => 'Position',
			'foreignKey' => 'position_id'
		)
    );
}
