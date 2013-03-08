<?php
App::uses('AppModel', 'Model');

class TiposEmail extends AppModel {

	public $useTable = 'tipos_email';

	public $displayField = 'nome';
	
	public $formFields = array('TiposEmail'=>array(
		'template'=>'default',
		'fields'=>array(
			array(
				'field'=>'nome',
				'name'=>'Nome',
				'type'=>'text',
				'index'=>true
			)
		)
	));

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
	);

	public $hasMany = array(
		'FornecedoresEmail' => array(
			'className' => 'FornecedoresEmail',
			'foreignKey' => 'fornecedor_id'
		)
	);
}
