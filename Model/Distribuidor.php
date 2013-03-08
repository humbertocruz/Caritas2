<?php
App::uses('AppModel', 'Model');
class Distribuidor extends AppModel {

	public $displayField = 'nome';

	public $useTable = 'distribuidores';
	
	public $formFields = array(
		'Distribuidor'=>array(
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
