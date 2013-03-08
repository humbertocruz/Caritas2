<?php
App::uses('AppModel', 'Model');

class Atividade extends AppModel {

	public $displayField = 'nome';

	public $useTable = 'atividades';
	
	public $formFields = array('Atividade'=>array(
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
