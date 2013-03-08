<?php
App::uses('AppModel', 'Model');
class Convenio extends AppModel {

	public $displayField = 'num_convenio';

	public $useTable = 'convenios';
	
	public $formFields = array(
		'Convenio'=>array(
		'template'=>'generic',
		'fields'=>array(
			array(
				'field'=>'tipo_convenio_id',
				'name'=>'Tipo de Conv&ecirc;nio',
				'type'=>'belongsTo',
				'url'=>'tipos_convenios',
				'model'=>'TiposConvenio',
				'search'=>false,
				'index'=>false
			),
			array(
				'field'=>'num_convenio',
				'name'=>'N&uacute;mero',
				'type'=>'text'
			),
			array(
				'field' => 'data_publicacao',
				'name' => 'Data de Publica&ccedil;&atilde;o',
				'type' => 'date'
			),
			array(
				'field' => 'valor_total',
				'name' => 'Valor Total',
				'type' => 'text'
			),
			array(
				'field' => 'contrapartida',
				'name' => 'Contrapartida',
				'type' => 'text'
			),
			array(
				'field' => 'encargo_fnde',
				'name' => 'Encargo FNDE',
				'type' => 'text',
				'index'=>false
			),
			array(
				'field' => 'pagina',
				'name' => 'P&aacute;gina',
				'type' => 'text',
				'index'=>false
			),
			array(
				'field' => 'secao',
				'name' => 'Se&ccedil;&atilde;o',
				'type' => 'text',
				'index'=>false
			),
			array(
				'field'=>'edital_id',
				'name'=>'Edital',
				'type'=>'belongsTo',
				'url'=>'editais',
				'model'=>'Edital',
				'search'=>false,
				'index'=>false
			),
			array(
				'field'=>'orgao_id',
				'name'=>'&Oacute;rg;&atilde;o',
				'type'=>'belongsTo',
				'url'=>'orgaos',
				'model'=>'Orgao',
				'search'=>false,
				'index'=>false
			),
			array(
				'field'=>'instituicao_id',
				'name'=>'Institui&ccedil;&atilde;o',
				'type'=>'belongsTo',
				'url'=>'instituicoes',
				'model'=>'Instituicao',
				'search'=>true,
				'index'=>false
			)
		)
	));
	public $belongsTo = array(
		'TiposConvenio' => array(
			'className' => 'TiposConvenio',
			'foreignKey' => 'tipo_convenio_id'
		),
		'Orgao' => array(
			'className' => 'Orgao',
			'foreignKey' => 'orgao_id'
		),
		'Edital' => array(
			'className' => 'Edital',
			'foreignKey' => 'edital_id'
		),
	);
	public function beforeSave() {
		if (!empty($this->data['Convenio']['data_publicacao'])) {
			$data = split('/', $this->data['Convenio']['data_publicacao']);
			$this->data['Convenio']['data_publicacao'] = $data[2].'-'.$data[1].'-'.$data[0];
		}
	}
}
