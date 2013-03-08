<?php
App::uses('AppModel', 'Model');
/**
 * ContatosInstituico Model
 *
 * @property Contatos $Contatos
 * @property Instituicoes $Instituicoes
 * @property Cargo $Cargo
 * @property SituacoesDoContato $SituacoesDoContato
 */
class ContatosLotacao extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'contatos_lotacao';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'data_inicio';
	
	public $formFields = array(
		array(
			'field'=>'fornecedor_id',
			'name'=>'Fornecedor',
			'type'=>'belongsTo',
			'index'=>true
		),
		array(
			'field'=>'cargo_id',
			'name'=>'Cargo',
			'type'=>'belongsTo',
			'index'=>true
		),
		array(
			'field'=>'data_inicio',
			'name'=>'Data Início',
			'type'=>'date',
			'index'=>true
		),
		array(
			'field'=>'data_fim',
			'name'=>'Data Fim',
			'type'=>'date',
			'index'=>true
		),
		array(
			'field'=>'situacao_contato_id',
			'name'=>'Situação do Contato',
			'type'=>'belongsTo',
			'index'=>true
		),
		array(
			'field'=>'contato_id',
			'name'=>'Contato',
			'type'=>'source',
			'source_model'=>'Contato',
			'source_key'=>'contato_id',
			'value'=>false,
			'index'=>false
		)
	);
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'contatos_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'instituicoes_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'cargo_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'data_inicio' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'situacoes_contato_id' => array(
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
		'Contatos' => array(
			'className' => 'Contatos',
			'foreignKey' => 'contato_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Instituicoes' => array(
			'className' => 'Instituicoes',
			'foreignKey' => 'instituicao_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Cargo' => array(
			'className' => 'Cargo',
			'foreignKey' => 'cargo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SituacoesContato' => array(
			'className' => 'SituacoesContato',
			'foreignKey' => 'situacao_contato_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
