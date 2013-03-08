<?php
App::uses('AppModel', 'Model');

class Cidade extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nome';
	
	public $formFields = array('Cidade'=>array(
		'template'=>'default',
		'fields'=>array(
			array(
				'field'=>'nome',
				'name'=>'Nome',
				'type'=>'text',
				'model'=>'Cidade',
				'index'=>true
			),
			array(
				'field'=>'id',
				'name'=>'Estado',
				'type'=>'none',
				'model'=>'Estado',
				'index'=>true
			),
			array(
				'field'=>'estado_id',
				'name'=>'Estado',
				'type'=>'belongsTo',
				'url'=>'estados',
				'model'=>'Estado',
				'index'=>false
			)
		)
		));

/**
 * Validation rules
 *
 * @var array
 */
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

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Estado' => array(
			'className' => 'Estado',
			'foreignKey' => 'estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
