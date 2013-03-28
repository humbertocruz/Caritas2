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
	public function beforeSave() {
		if (!empty($this->data['Documento']['data_documento'])) {
			$data_text = $this->data['Documento']['data_documento'];
			$data = DateTime::createFromFormat('d/m/Y', $data_text);
			$this->data['Documento']['data_documento'] = date_format($data, ('Y-m-d'));
		}
		if (!empty($this->data['Documento']['data_cadastro'])) {
			$data_text = $this->data['Documento']['data_cadastro'];
			$data = DateTime::createFromFormat('d/m/Y', $data_text);
			$this->data['Documento']['data_cadastro'] = date_format($data, ('Y-m-d'));
		}
	}
}
