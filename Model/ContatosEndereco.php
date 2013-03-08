<?php
App::uses('AppModel', 'Model');
/**
 * EmailsContato Model
 *
 * @property TipoEmail $TipoEmail
 * @property Contato $Contato
 */
class ContatosEndereco extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'contatos_enderecos';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'endereco';
	
	public $formFields = array('ContatosEndereco'=>array(
		'template'=>'generic',
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
							'field'=>'nome',
							'name'=>'Tipo de Endereço',
							'type'=>'none',
							'model'=>'TiposEndereco',
							'index'=>true
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
						'field'=>'contato_id',
						'name'=>'Contato',
						'type'=>'belongsTo',
						'model'=>'Contato',
						'index'=>false
					)
				)
			)
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
			'foreignKey' => 'tipo_endereco_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Contato' => array(
			'className' => 'Contato',
			'foreignKey' => 'contato_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Cidade' => array(
			'className' => 'Cidade',
			'foreignKey' => 'cidade_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
