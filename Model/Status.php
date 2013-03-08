<?php
App::uses('AppModel', 'Model');
class Status extends AppModel {

	public $displayField = 'nome';

	public $useTable = 'status';
	
	public $formFields = array(
		'Status'=>array(
			'template'=>'generic',
			'fields'=>array(
				array(
					'field'=>'nome',
					'name'=>'Nome',
					'type'=>'text'
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

}
