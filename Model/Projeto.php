<?php
App::uses('AppModel', 'Model');

class Projeto extends AppModel {

	public $useTable = 'projetos';

	public $displayField = 'nome';
	
	public $formFields = array('Projeto'=>array(
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
