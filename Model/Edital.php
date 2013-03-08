<?php
App::uses('AppModel', 'Model');
class Edital extends AppModel {

	public $displayField = 'nome';

	public $useTable = 'editais';
	
	public $formFields = array(
	'Edital'=>array(
		'template'=>'generic',
		'fields'=>array(
			array(
				'field'=>'numero',
				'name'=>'N&uacute;mero',
				'type'=>'text'
			),
			array(
				'field'=>'ano',
				'name'=>'Ano',
				'type'=>'text'
			),
			array(
				'field'=>'orgao_id',
				'name'=>'&Oacute;rg&atilde;o',
				'type'=>'belongsTo',
				'model'=>'Orgao',
				'url'=>'orgaos',
				'index'=>false
			),
			array(
				'field'=>'projeto_id',
				'name'=>'Projeto',
				'type'=>'session',
				'model'=>'Projeto',
				'session'=>'Projetos',
				'index'=>false
			)
		)
	));
	public $belongsTo = array(
		'Orgao' => array(
			'className' => 'Orgao',
			'foreignKey' => 'orgao_id'
		),
		'Projeto' => array(
			'className' => 'Projeto',
			'foreignKey' => 'projeto_id'
		)
	);
	
	public $hasMany = array(
		'AtaPreco' => array(
			'className' => 'AtaPreco',
			'foreignKey' => 'edital_id'
		)
	);

}
