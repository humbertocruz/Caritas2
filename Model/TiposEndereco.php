<?php
App::uses('AppModel', 'Model');

class TiposEndereco extends AppModel {

 	public $displayField = 'nome';

	public $useTable = 'tipos_endereco';
	
	public $formFields = array('TiposEndereco'=>array(
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
