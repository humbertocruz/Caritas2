<?php
App::uses('AppModel', 'Model');
/**
 * EmailsContato Model
 *
 * @property TipoEmail $TipoEmail
 * @property Contato $Contato
 */
class FornecedoresFone extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'fornecedores_fones';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'fone';
	
	public $formFields = array('FornecedoresFone'=>array(
		'template'=>'default',
		'fields'=>array(
			array(
				'field'=>'fone',
				'name'=>'Fone',
				'type'=>'text',
				'index'=>true
			),
			array(
				'field'=>'tipo_fone_id',
				'name'=>'Tipo de Telefone',
				'type'=>'belongsTo',
				'model'=>'TiposFone',
				'url'=>'tipos_fones',
				'index'=>false
			),
			array(
				'field'=>'nome',
				'name'=>'Tipo de Telefone',
				'model'=>'TiposFone',
				'type'=>'none',
				'index'=>true
			),
			array(
				'field'=>'fornecedor_id',
				'name'=>'Fornecedor',
				'type'=>'belongsTo',
				'model'=>'Fornecedor',
				'source_id'=>'id',
				'url'=>'fornecedores',
				'search'=>true,
				'index'=>false
			)
		))
	);
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
		'Fornecedor' => array(
			'className' => 'Fornecedor',
			'foreignKey' => 'fornecedor_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
