<?php
App::uses('AppModel', 'Model');
class AtaPreco extends AppModel {

	public $displayField = 'nome';

	public $useTable = 'ata_precos';
	
	public $formFields = array('AtaPreco'=>array(
		'template'=>'generic',
		'fields'=>array(
			array(
				'field'=>'nome',
				'name'=>'Nome',
				'type'=>'text',
				'index'=>true
			),
			array(
				'field'=>'data',
				'name'=>'Data',
				'type'=>'date',
				'index'=>true
			),
			array(
				'field'=>'edital_id',
				'name'=>'Edital',
				'type'=>'belongsTo',
				'model'=>'Edital',
				'url'=>'editais',
				'index'=>false
			),
			array(
				'field'=>'numero',
				'name'=>'Edital',
				'type'=>'none',
				'model'=>'Edital',
				'index'=>true
			)
		)
	));

	public $belongsTo = array(
		'Edital' => array(
			'className' => 'Edital',
			'foreignKey' => 'edital_id',
		)
	);

	public function beforeSave() {
		if (!empty($this->data['AtaPreco']['data'])) {
			$data = split('/', $this->data['AtaPreco']['data']);
			$this->data['AtaPreco']['data'] = $data[2].'-'.$data[1].'-'.$data[0];
		}
	}
}
