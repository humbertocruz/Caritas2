<?php
App::uses('AppModel', 'Model');

class Cargo extends AppModel {

	public $displayField = 'nome';
	
	public $useTable = 'cargos';

	public $formFields = array('Cargo'=>array(
		'template'=>'generic',
		'fields'=>array(
			array(
				'field'=>'nome',
				'name'=>'Nome',
				'type'=>'text'
			)
		)
	));

}
