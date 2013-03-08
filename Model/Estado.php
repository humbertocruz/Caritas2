<?php
App::uses('AppModel', 'Model');

class Estado extends AppModel {

	public $displayField = 'nome';
	public $recursive = 2;
	
	public $useTable = 'estados';
	
	public $formFields = array('Estado'=>array(
		'template'=>'generic',
		'fields'=>array(
			array(
				'field'=>'id',
				'name'=>'Sigla',
				'model'=>'Estado',
				'type'=>'text',
				'index'=>true
			),
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
				'message' => 'O campo "Nome" não pode ficar vazio!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $hasMay = array(
		'Cidade' => array(
			'className' => 'Cidade',
			'foreignKey' => 'estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
