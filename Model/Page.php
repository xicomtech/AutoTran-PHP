<?php

App::uses('AppModel', 'Model');

/**
 * Page Model
 *
 * @property Page $Page
 * @property Page $Page
 */
class Page extends AppModel
{

    /**
     * Validation rules
     *
     * @var array
     */
    //var $actsAs = array ("Tree");
    public $validate = array (
	'title' => array (
	    'notempty' => array (
		'rule' => array ('notempty')
	    )
	),
	'slug' => array (
	    'notempty' => array (
			'rule' => array ('notempty'),
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Slug is required'
			),
			'unique' => array (
				'rule' => 'isUnique',
				'message' => 'This slug has already been taken.'
			),
			'reg' => array (
				'rule' => array ('custom', '/^[A-Za-z0-9_-]+$/'),
				'required' => true,
				'allowEmpty' => true,
				'message' => 'Only letters, numbers, underscores and hyphens are allowed'
			)
	),
    );


/**
 * footer_link : to get the footer link
 * @param :  
 * @return array()
 */
	function footer_link()
	{
		$footer_link = $this->find('all', array(
								'fields' => array('Page.slug', 'Page.title'),
								'conditions' => array('Page.active' => StatusTypes::Active)
								)
							);
		return $footer_link;
	}
}
