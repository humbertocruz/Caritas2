<?php
App::uses('AppModel', 'Model');
class Procedimento extends AppModel {

	public $displayField = 'nome';

	public $useTable = 'procedimentos';
	
	public $formFields = array(
		'Procedimento'=>array(
			'template'=>'generic',
			'fields'=>array(
				array(
					'field'=>'nome',
					'name'=>'Nome',
					'type'=>'text'
				),
				array(
					'field'=>'descricao',
					'name'=>'Descrição',
					'type'=>'textarea'
				)
			)
		)
	);

	public $validate = array(
		'descricao' => array(
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
		'ChamadasProcedimento' => array(
			'className' => 'ChamadasProcedimento',
			'foreignKey' => 'procedimento_id',
			'dependent' => false,
		)
	);

}
