<?php
App::uses('AppModel', 'Model');
class SituacoesContato extends AppModel {

	public $displayField = 'nome';

	public $useTable = 'situacoes_contatos';
	
	public $formFields = array('SituacoesContato'=>array(
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
