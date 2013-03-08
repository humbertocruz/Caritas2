<?php
App::uses('AppModel', 'Model');
/**
 * EmailsContato Model
 *
 * @property TipoEmail $TipoEmail
 * @property Contato $Contato
 */
class InstituicoesEmail extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'instituicoes_emails';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'email';
	
	public $formFields = array('InstituicoesEmail'=>array(
		'template'=>'generic',
		'fields'=>array(
		array(
			'field'=>'email',
			'name'=>'Email',
			'type'=>'email',
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
			'model'=>'TiposEmail',
			'type'=>'none',
			'index'=>true
		),
		array(
			'field'=>'instituicao_id',
			'name'=>'Instituição',
			'type'=>'belongsTo',
			'model'=>'Instituicao',
			'source_id'=>'id',
			'url'=>'instituicoes',
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
		'Instituicao' => array(
			'className' => 'Instituicao',
			'foreignKey' => 'instituicao_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
