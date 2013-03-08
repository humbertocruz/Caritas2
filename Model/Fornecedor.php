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
class Fornecedor extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'razao_social';
	public $recursive = 2;
	
	public $formFields = array('Fornecedor'=>array(
		'template'=>'tabs',
		'fields'=>array(
			array(
				'field'=>'nome_fantasia',
				'name'=>'Nome Fantasia',
				'model'=>'Fornecedor',
				'type'=>'text',
				'index'=>true
			),
			array(
				'field'=>'razao_social',
				'name'=>'Razão Social',
				'model'=>'Fornecedor',
				'type'=>'text',
				'index'=>true
			),
			array(
				'field'=>'inscricao_estadual',
				'name'=>'Inscrição Estadual',
				'model'=>'Fornecedor',
				'type'=>'text',
				'index'=>true
			),
			array(
				'field'=>'cnpj',
				'name'=>'CNPJ',
				'model'=>'Fornecedor',
				'type'=>'text',
				'index'=>true
			),
		),
		'hasMany'=>array(
			array(
				'field'=>'email',
				'name'=>'Emails',
				'type'=>'hasMany',
				'model'=>'FornecedoresEmail',
				'controller'=>'fornecedores_emails',
				'del_info'=>'email',
				'index'=>false
			),
			array(
				'field'=>'fone',
				'name'=>'Telefones',
				'type'=>'hasMany',
				'model'=>'FornecedoresFone',
				'controller'=>'fornecedores_fones',
				'del_info'=>'fone',
				'index'=>false
			),
			array(
				'field'=>'endereco',
				'name'=>'Endereços',
				'type'=>'hasMany',
				'model'=>'FornecedoresEndereco',
				'controller'=>'fornecedores_enderecos',
				'del_info'=>'endereco',
				'index'=>false
			),
			array(
				'field'=>'contato',
				'name'=>'Contatos',
				'type'=>'hasMany',
				'model'=>'ContatosFornecedor',
				'controller'=>'contatos_fornecedores',
				'del_info'=>'nome',
				'index'=>false,
				'manyModel'=>'Contato',
				'manyController'=>'contatos'
			)
		))
	);


/**
 * belongsTo associations
 *
 * @var array
 */
	

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'FornecedoresEmail' => array(
			'className' => 'FornecedoresEmail',
			'foreignKey' => 'fornecedor_id'
		),
		'FornecedoresFone' => array(
			'className' => 'FornecedoresFone',
			'foreignKey' => 'fornecedor_id'
		),
		'FornecedoresEndereco' => array(
			'className' => 'FornecedoresEndereco',
			'foreignKey' => 'fornecedor_id'
		),
		'ContatosFornecedor'=>array(
			'className'=>'ContatosFornecedor',
			'foreignKey'=>'fornecedor_id'
		)

	);

}
