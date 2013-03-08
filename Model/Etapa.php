<?php
App::uses('AppModel', 'Model');

class Etapa extends AppModel {

	public $displayField = 'nome';

	public $useTable = 'etapas';
	
	public $formFields = array('Etapa'=>array(
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

