<?php
App::uses('AppModel', 'Model');

class ContatosInstituicao extends AppModel {

	public $displayField = 'instituicao_id';

	public $useTable = 'contatos_instituicoes';
	
	public $formFields = array('ContatosInstituicao'=>array(
		'template'=>'default',
		'fields'=>array(
			array(
				'field'=>'cargo_id',
				'name'=>'Cargo',
				'type'=>'belongsTo',
				'model'=>'Cargo',
				'url'=>'cargos',
				'index'=>false
			),
			array(
				'field'=>'nome',
				'name'=>'Contato',
				'type'=>'source_none',
				'model'=>'Contato',
				'index'=>true
			),
			array(
				'field'=>'razao_social',
				'name'=>'Instituição',
				'type'=>'source_none',
				'model'=>'Instituicao',
				'index'=>true
			),
			array(
				'field'=>'nome',
				'name'=>'Cargo',
				'type'=>'none',
				'model'=>'Cargo',
				'index'=>true
			),
			array(
				'field'=>'nome',
				'name'=>'Situação do Contato',
				'type'=>'none',
				'model'=>'SituacoesContato',
				'index'=>true
			),
			array(
				'field'=>'data_inicio',
				'name'=>'Data Início',
				'type'=>'date',
				'index'=>false
			),
			array(
				'field'=>'data_fim',
				'name'=>'Data Fim',
				'type'=>'date',
				'index'=>false
			),
			array(
				'field'=>'situacao_contato_id',
				'name'=>'Situação do Contato',
				'type'=>'belongsTo',
				'model'=>'SituacoesContato',
				'url'=>'situacoes_contatos',
				'index'=>false
			),
			array(
				'field'=>'contato_id',
				'name'=>'Contato',
				'type'=>'belongsTo',
				'model'=>'Contato',
				'source_id'=>'id',
				'url'=>'contatos',
				'search'=>true,
				'index'=>false
			),
			array(
				'field'=>'instituicao_id',
				'name'=>'Instituicao',
				'type'=>'belongsTo',
				'model'=>'Instituicao',
				'source_id'=>'id',
				'url'=>'instituicoes',
				'search'=>true,
				'index'=>false
			)
		))
	);

	public $belongsTo = array(
		'Instituicao' => array(
			'className' => 'Instituicao',
			'foreignKey' => 'instituicao_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Contato' => array(
			'className' => 'Contato',
			'foreignKey' => 'contato_id',
		),
		'Cargo' => array(
			'className' => 'Cargo',
			'foreignKey' => 'cargo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SituacoesContato' => array(
			'className' => 'SituacoesContato',
			'foreignKey' => 'situacao_contato_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $hasMany = array(
		'InstituicoesEmail' => array(
			'foreignKey' => 'instituicao_id'
		),
		'InstituicoesFone' => array(
			'foreignKey' => 'instituicao_id'
		)
	);
	
	public function beforeSave() {
		if (!empty( $this->data['ContatosInstituicao']['data_inicio'] ) ) {
			$data = split('/', $this->data['ContatosInstituicao']['data_inicio']);
			$this->data['ContatosInstituicao']['data_inicio'] = $data[2].'-'.$data[1].'-'.$data[0];
		}
		if (!empty( $this->data['ContatosInstituicao']['data_fim'] ) ) {
			$data = split('/', $this->data['ContatosInstituicao']['data_fim']);
			$this->data['ContatosInstituicao']['data_fim'] = $data[2].'-'.$data[1].'-'.$data[0];
		}
	}
}
