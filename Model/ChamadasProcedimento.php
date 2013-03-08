<?php
App::uses('AppModel', 'Model');

class ChamadasProcedimento extends AppModel {

	public $useTable = 'chamadas_procedimentos';

	public $displayField = 'nome';
	
	public $formFields = array('ChamadasProcedimento'=>array(
		'template'=>'default',
		'fields'=>array(
			array(
				'field'=>'procedimento_id',
				'name'=>'Procedimento',
				'type'=>'belongsTo',
				'model'=>'Procedimento',
				'url'=>'procedimentos',
				'index'=>false
			),
			array(
				'field'=>'data',
				'name'=>'Data',
				'type'=>'datetime',
				'index'=>true
			),
			array(
				'field'=>'atendente_id',
				'name'=>'Atendente',
				'type'=>'session',
				'session'=>'Atendentes',
				'model'=>'Atendente',
				'index'=>false
			),
			array(
				'field'=>'chamada_id',
				'name'=>'Chamada',
				'type'=>'belongsTo',
				'model'=>'Chamada',
				'url'=>'chamadas',
				'index'=>false
			),
			array(
				'field'=>'procedimento',
				'name'=>'Procedimento',
				'type'=>'textarea',
				'index'=>true
			)
		))
	);

	public $belongsTo = array(
		'Procedimento' => array(
			'className' => 'Procedimento',
			'foreignKey' => 'procedimento_id',
		)
	);
	
	public function beforeSave() {
		if (!empty($this->data['ChamadasProcedimento']['data'])) {
			$data = split('/', $this->data['ChamadasProcedimento']['data']);
			$this->data['ChamadasProcedimento']['data'] = $data[2].'-'.$data[1].'-'.$data[0];
		}
		
	}

}
