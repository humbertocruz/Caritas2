<?php
App::uses('AppModel', 'Model');
/**
 * Usuario Model
 *
 * @property NivelAcesso $NivelAcesso
 * @property Chamada $Chamada
 * @property ChamadasProcedimento $ChamadasProcedimento
 */
class Atendente extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nome';
	public $actAs = array('Acl'=>array('type'=>'both'));
	public $useTable = 'atendentes';
	
	public $formFields = array('Atendente'=>array(
		'template'=>'generic',
		'fields'=>array(
			array(
				'field'=>'nome',
				'name'=>'Nome',
				'type'=>'text'
			)
		)
	));
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'nome' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'O campo "Nome" não pode ficar vazio!',
				//'allowEmpty' => false,
				//'required' => false,
				'last' => true, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Email inválido!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'unico'=>array(
				'rule' => 'validateUnique',
				'field'=> 'email',
				'message' => 'Já existe um Atendente cadastrado com este Email!',
			)
		),
		'cpf' => array(
			'unico'=>array(
				'rule'=>'validateUnique',
				'field'=>'cpf',
				'message'=>'Já existe um Atendente com este CPF !',
				'last'=>true
			),
			'cpf' => array(
				'rule' => 'validateCPF',
				'message' => 'CPF inválido!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'nivel_acesso_id' => array(
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
		'NiveisAcesso' => array(
			'className' => 'NiveisAcesso',
			'foreignKey' => 'nivel_acesso_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Sexo' => array(
			'className' => 'sexo',
			'foreignKey' => 'sexo_id',
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
		'Chamada' => array(
			'className' => 'Chamada',
			'foreignKey' => 'atendente_id',
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
		'ChamadasProcedimento' => array(
			'className' => 'ChamadasProcedimento',
			'foreignKey' => 'atendente_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	public function beforeSave($options = array()) {
		if(isset($this->ata['Atendente']['senha'])) {
        	$this->data['Atendente']['senha'] = AuthComponent::password($this->data['Atendente']['senha']);
        }
        return true;
    }

}
