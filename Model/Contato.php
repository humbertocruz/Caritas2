<?php
App::uses('AppModel', 'Model');

class Contato extends AppModel {

	public $displayField = 'nome';
	
	public $useTable = 'contatos';
	
	public $recursive = 2;

	public $formFields = array('Contato'=>array(
		'template'=>'tabs',
		'fields'=>array(
			array(
				'field'=>'nome',
				'name'=>'Nome',
				'type'=>'text',
				'model'=>'Contato',
				'index'=>true,
			),
			array(
				'field'=>'cpf',
				'name'=>'CPF',
				'type'=>'cpf',
				'model'=>'Contato',
				'index'=>true
			),
			array(
				'field'=>'data_nascimento',
				'name'=>'Data de Nascimento',
				'type'=>'date',
				'model'=>'Contato',
				'index'=>true
			),
			array(
				'field'=>'nome',
				'name'=>'Sexo',
				'type'=>'none',
				'model'=>'Sexo',
				'index'=>true
			),
			array(
				'field'=>'sexo_id',
				'name'=>'Sexo',
				'type'=>'belongsTo',
				'url'=>'sexos',
				'model'=>'Sexo',
				'search'=>false,
				'index'=>false
			),
			array(
				'type'=>'habtm',
				'field'=>'fone',
				'name'=>'Telefone',
				'model'=>'ContatosFone',
				'index'=>true
			),
			array(
				'type'=>'habtm',
				'field'=>'email',
				'name'=>'Email',
				'model'=>'ContatosEmail',
				'index'=>true
			)
			
		),
		'hasMany'=>array(
			array(
				'field'=>'email',
				'name'=>'Emails',
				'type'=>'hasMany',
				'model'=>'ContatosEmail',
				'controller'=>'contatos_emails',
				'del_info'=>'email',
				'index'=>false
			),
			array(
				'field'=>'fone',
				'name'=>'Telefones',
				'type'=>'hasMany',
				'model'=>'ContatosFone',
				'controller'=>'contatos_fones',
				'index'=>false
			),
			array(
				'field'=>'endereco',
				'name'=>'Endereços',
				'type'=>'hasMany',
				'model'=>'ContatosEndereco',
				'controller'=>'contatos_enderecos',
				'index'=>false
			),
			array(
				'field'=>'fornecedor',
				'name'=>'Fornecedores',
				'type'=>'hasMany',
				'model'=>'ContatosFornecedor',
				'del_info'=>'razao_social',
				'index'=>false,
				'manyModel'=>'Fornecedor',
				'manyController'=>'fornecedores'
			),
			array(
				'field'=>'instituicao',
				'name'=>'Instituições',
				'type'=>'hasMany',
				'model'=>'ContatosInstituicao',
				'del_info'=>'razao_social',
				'index'=>false,
				'manyModel'=>'Instituicao',
				'manyController'=>'instituicoes'
			)
		))
	);

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
		'sexo_id' => array(
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


	public $belongsTo = array(
		'Sexo' => array(
			'className' => 'Sexo',
			'foreignKey' => 'sexo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	public $hasMany = array(
		'Chamada' => array(
			'className' => 'Chamada',
			'foreignKey' => 'contato_id',
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
		'ContatosEmail' => array(
			'className' => 'ContatosEmail',
			'foreignKey' => 'contato_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => array('ContatosEmail.updated'=>'desc'),
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ContatosFone' => array(
			'className' => 'ContatosFone',
			'foreignKey' => 'contato_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => array('ContatosFone.updated'=>'desc'),
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ContatosEndereco' => array(
			'className' => 'ContatosEndereco',
			'foreignKey' => 'contato_id',
			'order' => array('id'=>'desc')
		),
		'ContatosFornecedor' => array(
			'className' => 'ContatosFornecedor',
			'foreignKey' => 'contato_id'
		),
		'ContatosInstituicao' => array(
			'className' => 'ContatosInstituicao',
			'foreignKey' => 'contato_id'
		)
	);
	
	public function beforeSave() {
		//$data = split('/', $this->data['Contato']['data_nascimento']);
		//$this->data['Contato']['data_nascimento'] = $data[2].'-'.$data[1].'-'.$data[0];
		if (trim($this->data['Contato']['data_nascimento']) == '') $this->data['Contato']['data_nascimento'] = null; else {
			$date = DateTime::createFromFormat('d/m/Y', trim($this->data['Contato']['data_nascimento']));
			$this->data['Contato']['data_nascimento'] = $date->format('Y-m-d');
		}
	}

}
