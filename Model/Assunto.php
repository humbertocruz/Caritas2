<?php
App::uses('AppModel', 'Model');

class Assunto extends AppModel {

	public $displayField = 'descricao';

	public $useTable = 'assuntos';
	
	public $formFields = array('Assunto'=>array(
		'template'=>'generic',
		'fields'=>array(
			array(
				'field'=>'nome',
				'name'=>'Nome',
				'type'=>'text'
			)
		)
	));

	public $hasMany = array(
		'Chamada' => array(
			'className' => 'Chamada',
			'foreignKey' => 'assunto_id',
		)
	);

}
