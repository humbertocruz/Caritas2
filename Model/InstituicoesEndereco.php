<?php
App::uses('AppModel', 'Model');

class InstituicoesEndereco extends AppModel {

	public $useTable = 'instituicoes_enderecos';

	public $displayField = 'endereco';
	
	public $formFields = array('InstituicoesEndereco'=>array(
		'template'=>'default',
		'fields'=>array(
			array(
				'field'=>'tipo_endereco_id',
				'name'=>'Tipo de Endereço',
				'type'=>'belongsTo',
				'model'=>'TiposEndereco',
				'url'=>'tipos_enderecos',
				'index'=>false
			),
			array(
				'field'=>'endereco',
				'name'=>'Endereço',
				'type'=>'text',
				'index'=>true
			),
			array(
				'field'=>'bairro',
				'name'=>'Bairro',
				'type'=>'text',
				'index'=>true
			),
			array(
				'field'=>'cep',
				'name'=>'CEP',
				'type'=>'text',
				'index'=>false
			),
			array(
				'field'=>'complemento',
				'name'=>'Complemento',
				'type'=>'text',
				'index'=>false
			),
			array(
				'field'=>'cidade_id',
				'name'=>'Cidade',
				'type'=>'ufCidade',
				'model'=>'Cidade',
				'url'=>'cidades',
				'index'=>false
			),
			array(
				'field'=>'nome',
				'name'=>'Cidade',
				'type'=>'none',
				'model'=>'Cidade',
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
		'TiposEndereco' => array(
			'className' => 'TiposEndereco',
			'foreignKey' => 'tipo_endereco_id'
		),
		'Cidade'=>array(
			'className' => 'Cidade',
			'foreignKey' => 'cidade_id'
		),
		'Instituicao' => array(
			'className' => 'Instituicao',
			'foreignKey' => 'instituicao_id'
		)
	);
}
