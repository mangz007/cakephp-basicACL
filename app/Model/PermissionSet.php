<?php
App::uses('AppModel', 'Model');
/**
 * PermissionSet Model
 *
 * @property PermissionGroup $PermissionGroup
 */
class PermissionSet extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'permission_group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'action' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'PermissionGroup' => array(
			'className' => 'PermissionGroup',
			'foreignKey' => 'permission_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
