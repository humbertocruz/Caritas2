<?php
App::uses('AppModel', 'Model');
/**
 * FonesContato Model
 *
 * @property TipoFone $TipoFone
 * @property Contato $Contato
 */
class FonesContato extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'fones_contato';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'fone';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'tipo_fone_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'contato_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'TiposFone' => array(
			'className' => 'TiposFone',
			'foreignKey' => 'tipo_fone_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Contato' => array(
			'className' => 'Contato',
			'foreignKey' => 'contato_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
