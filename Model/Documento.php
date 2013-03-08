<?php
App::uses('AppModel', 'Model');
class Documento extends AppModel {

	public $displayField = 'observacao';

	public $useTable = 'pedidos_documentos';
	
	public $belongsTo = array(
		'TiposDocumento' => array(
			'className' => 'TiposDocumento',
			'foreignKey' => 'tipo_documento_id'
		)
	);
}
