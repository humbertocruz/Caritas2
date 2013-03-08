<?php
App::uses('AppModel', 'Model');
/**
 * EmailsContato Model
 *
 * @property TipoEmail $TipoEmail
 * @property Contato $Contato
 */
class FornecedoresEmail extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'fornecedores_emails';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'email';
	
	public $formFields = array('FornecedoresEmail'=>array(
		'template'=>'default',
		'fields'=>array(
			array(
				'field'=>'email',
				'name'=>'Email',
				'type'=>'email',
				'del_info'=>true,
				'index'=>true
			),
			array(
				'field'=>'tipo_email_id',
				'name'=>'Tipo de Email',
				'type'=>'belongsTo',
				'model'=>'TiposEmail',
				'url'=>'tipos_emails',
				'index'=>false
			),
			array(
				'field'=>'nome',
				'name'=>'Tipo de Email',
				'type'=>'none',
				'model'=>'TiposEmail',
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
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'tipo_email_id' => array(
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
		'TiposEmail' => array(
			'className' => 'TiposEmail',
			'foreignKey' => 'tipo_email_id',
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
