<?php
App::uses('AppModel', 'Model');
/**
 * EmailsContato Model
 *
 * @property TipoEmail $TipoEmail
 * @property Contato $Contato
 */
class ContatosFone extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'contatos_fones';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'fone';
	public $order = array('ContatosFone.updated'=>'desc');
	
	public $formFields = array('ContatosFone'=>array(
		'template'=>'generic',
		'fields'=>array(
		array(
			'field'=>'fone',
			'name'=>'Telefoone',
			'type'=>'text',
			'index'=>true
		),
		array(
			'field'=>'nome',
			'name'=>'Tipo de Telefone',
			'type'=>'none',
			'model'=>'TiposFone',
			'index'=>true
		),
		array(
			'field'=>'tipo_fone_id',
			'name'=>'Tipo de Telefone',
			'type'=>'belongsTo',
			'model'=>'TiposFone',
			'index'=>false
		),
		array(
			'field'=>'contato_id',
			'name'=>'Contato',
			'type'=>'belongsTo',
			'model'=>'Contato',
			'url'=>'contatos',
			'index'=>false
		)
		))
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
		'Contato' => array(
			'className' => 'Contato',
			'foreignKey' => 'contato_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
