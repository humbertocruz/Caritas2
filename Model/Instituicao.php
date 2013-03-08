<?php
App::uses('AppModel', 'Model');
/**
 * Instituicao Model
 *
 * @property TipoInstituicao $TipoInstituicao
 * @property Estados $Estados
 * @property Endereco $Endereco
 * @property Pedido $Pedido
 */
class Instituicao extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'razao_social';
	
	public $useTable = 'instituicoes';
	public $recursive = 2;
	
	public $formFields = array(
		'Instituicao'=>array(
			'template'=>'tabs',
			'fields'=>array(
				array(
					'field'=>'razao_social',
					'name'=>'Razão Social',
					'model'=>'Instituicao',
					'type'=>'text',
					'index'=>false
				),
		array(
			'field'=>'nome_fantasia',
			'name'=>'Nome Fantasia',
			'model'=>'Instituicao',
			'type'=>'text',
			'index'=>true
		),
		array(
			'field'=>'inscricao_estadual',
			'name'=>'Inscrição Estadual',
			'model'=>'Instituicao',
			'type'=>'text',
			'index'=>true
		),
		array(
			'field'=>'cnpj',
			'name'=>'CNPJ',
			'model'=>'Instituicao',
			'type'=>'cnpj',
			'index'=>true
		),
		array(
			'field'=>'tipo_instituicao_id',
			'name'=>'Tipo de Instituição',
			'type'=>'belongsTo',
			'model'=>'TiposInstituicao',
			'url'=>'tipos_instituicoes',
			'search'=>false,
			'index'=>false
		),
		array(
			'field'=>'nome',
			'name'=>'Tipo de Instituição',
			'type'=>'none',
			'model'=>'TiposInstituicao',
			'index'=>true
		),
			array(
				'type'=>'habtm',
				'field'=>'fone',
				'name'=>'Telefone',
				'model'=>'InstituicoesFone',
				'index'=>true
			),
			array(
				'type'=>'habtm',
				'field'=>'email',
				'name'=>'Email',
				'model'=>'InstituicoesEmail',
				'index'=>true
			)
	),
	'hasMany'=>array(
		array(
			'field'=>'email',
			'name'=>'Emails',
			'type'=>'hasMany',
			'model'=>'InstituicoesEmail',
			'controller'=>'instituicoes_emails',
			'index'=>false
		),
		array(
			'field'=>'fone',
			'name'=>'Telefones',
			'type'=>'hasMany',
			'model'=>'InstituicoesFone',
			'controller'=>'instituicoes_fones',
			'index'=>false
		),
		array(
			'field'=>'endereco',
			'name'=>'Endereços',
			'type'=>'hasMany',
			'model'=>'InstituicoesEndereco',
			'controller'=>'instituicoes_enderecos',
			'index'=>false
		),
		array(
			'field'=>'contato',
			'name'=>'Contatos',
			'type'=>'hasMany',
			'model'=>'ContatosInstituicao',
			'controller'=>'contatos_instituicoes',
			'index'=>false,
			'manyModel'=>'Contato',
			'manyController'=>'contatos'
		)
		)
	)
	);


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'tipo_instituicao_id' => array(
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
		'TiposInstituicao' => array(
			'className' => 'TiposInstituicao',
			'foreignKey' => 'tipo_instituicao_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'InstituicoesEmail' => array(
			'className' => 'InstituicoesEmail',
			'foreignKey' => 'instituicao_id',
		),
		'InstituicoesFone' => array(
			'className' => 'InstituicoesFone',
			'foreignKey' => 'instituicao_id',
		),
		'InstituicoesEndereco' => array(
			'className' => 'InstituicoesEndereco',
			'foreignKey' => 'instituicao_id'
		),
		'ContatosInstituicao' => array(
			'className' => 'ContatosInstituicao',
			'foreignKey' => 'instituicao_id'
		),

	);

}
