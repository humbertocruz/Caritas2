<?php
App::uses('AppModel', 'Model');
/**
 * NivelAcesso Model
 *
 */
class Permissao extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'permissoes';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'action';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'action' => array(
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
	
	public $belongsTo = array(
		'NiveisAcesso' => array(
			'className' => 'NiveisAcesso',
			'foreignKey' => 'nivel_acesso_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
