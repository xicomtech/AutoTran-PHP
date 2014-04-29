<?php
/**
	 * Load Model
	 *
	 * Purpose : Manage load activity
	 * @project Auto Tran
	 * @since 23-October-2013
	 * @author : Santosh Gupta
	 */
class Load extends Model {
	
	public $thumb_sizes = array('65x65', '330x330', '30x30', '100x100');
	
	Public $hasMany = array('Vin');
	
	public $belongsTo = array(
		'Dealer' => array(
			'className' => 'Dealer',
			'foreignKey' => 'dealer_id'
		),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
	
	public $validate = array(
		'load_number' => array(
			'rule' => 'isUnique',
			'message' => 'Load number should be unique'
		),
		'ship_address' => array(
			'rule'    => 'notEmpty',
			'message' => 'Shipping address is required',
		),
		'ship_date' => array(
			'rule'    => 'notEmpty',
			'message' => 'Shipping date is required',
		),
		'vin_list' => array(
			'rule'    => 'notEmpty',
			'message' => 'Vin is required',
		),
		'user_id' => array(
			'rule'    => 'notEmpty',
			'message' => 'Driver is required',
		)
	);
}
