<?php
App::uses('AppModel', 'Model');

class ContatosFornecedor extends AppModel {

	public $useTable = 'contatos_fornecedores';

	public $displayField = 'nome';
	
	public $formFields = array('ContatosFornecedor'=>array(
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
				'del_info'=>true,
				'index'=>true
			),
			array(
				'field'=>'razao_social',
				'name'=>'Fornecedor',
				'type'=>'source_none',
				'model'=>'Fornecedor',
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
				'field'=>'data_inicio',
				'name'=>'Data Início',
				'type'=>'date',
				'index'=>true
			),
			array(
				'field'=>'data_fim',
				'name'=>'Data Fim',
				'type'=>'date',
				'index'=>true
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
				'field'=>'fornecedor_id',
				'name'=>'Fornecedor',
				'type'=>'belongsTo',
				'model'=>'Fornecedor',
				'source_id'=>'id',
				'url'=>'fornecedores',
				'search'=>true,
				'index'=>false
			)
		))
	);

	public $belongsTo = array(
		'Fornecedor' => array(
			'className' => 'Fornecedor',
			'foreignKey' => 'fornecedor_id',
		),
		'Contato' => array(
			'className' => 'Contato',
			'foreignKey' => 'contato_id',
		),
		'Cargo' => array(
			'className' => 'Cargo',
			'foreignKey' => 'cargo_id',
		),
		'SituacoesContato' => array(
			'className' => 'SituacoesContato',
			'foreignKey' => 'situacao_contato_id',
		)
	);
	
	public function beforeSave() {
		if (!empty($this->data['ContatosFornecedor']['data_inicio'])) {
			$data = split('/', $this->data['ContatosFornecedor']['data_inicio']);
			$this->data['ContatosFornecedor']['data_inicio'] = $data[2].'-'.$data[1].'-'.$data[0];
		}
		if (!empty($this->data['ContatosFornecedor']['data_fim'])) {
			$data = split('/', $this->data['ContatosFornecedor']['data_fim']);
			$this->data['ContatosFornecedor']['data_fim'] = $data[2].'-'.$data[1].'-'.$data[0];
		}
	}

}
