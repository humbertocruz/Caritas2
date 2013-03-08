<?php
App::uses('AppModel', 'Model');
/**
 * NivelAcesso Model
 *
 */
class NiveisAcesso extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'niveis_acesso';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nome';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'nome' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	public $hasMany = array(
		'Permissao' => array(
			'className' => 'Permissao',
			'foreignKey' => 'nivel_acesso_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);
}
