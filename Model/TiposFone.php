<?php
App::uses('AppModel', 'Model');

class TiposFone extends AppModel {

	public $useTable = 'tipos_fone';

	public $displayField = 'nome';
	
	public $formFields = array('TiposFone'=>array(
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
}
