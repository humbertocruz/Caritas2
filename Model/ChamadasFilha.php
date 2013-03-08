<?php
App::uses('AppModel', 'Model');

class ChamadasFilha extends AppModel {

	public $displayField = 'tipo_chamada_id';
	
	public $useTable = 'chamadas';
	
	public $recursive = 2;

	public $formFields = array(
		'Chamada'=>array(
			'template'=>'tabs',
			'fields'=>array(
				array(
					'field'=>'nome_fantasia',
					'name'=>'Institui&ccedil;&atilde;o',
					'type'=>'none',
					'model'=>'Instituicao',
					'index'=>true
				),array(
					'field'=>'nome',
					'name'=>'Contato',
					'type'=>'none',
					'model'=>'Contato',
					'index'=>true
				),array(
					'field'=>'data_inicio',
					'name'=>'Data In&iacute;cio',
					'type'=>'datetime',
					'index'=>true
				),array(
					'field'=>'data_fim',
					'name'=>'Data Fim',
					'type'=>'datetime',
					'index'=>true
				),array(
					'field'=>'assunto_id',
					'name'=>'Assunto',
					'type'=>'belongsTo',
					'url'=>'assuntos',
					'model'=>'Assunto',
					'search'=>false,
					'index'=>false
				),array(
					'field'=>'chamada_id',
					'name'=>'Chamada Filha',
					'type'=>'session',
					'session'=>'Chamadas',
					'model'=>'ChamadaFilha',
					'index'=>false
				),array(
					'field'=>'solicitacao',
					'name'=>'Solicita&ccedil;&atilde;o',
					'type'=>'textarea',
					'index'=>true
				),array(
					'field'=>'prioridade_id',
					'name'=>'Prioridade',
					'type'=>'belongsTo',
					'url'=>'prioridades',
					'model'=>'Prioridade',
					'search'=>false,
					'index'=>false
				),array(
					'field'=>'tipo_chamada_id',
					'name'=>'Tipo de Chamada',
					'type'=>'belongsTo',
					'url'=>'tipos_chamadas',
					'model'=>'TiposChamada',
					'search'=>false,
					'index'=>false
				),
				array(
					'field'=>'projeto_id',
					'name'=>'Projeto',
					'type'=>'session',
					'session'=>'Projetos',
					'model'=>'Projeto',
					'index'=>false
				),
				array(
					'field'=>'pedido_id',
					'name'=>'Pedido',
					'type'=>'belongsTo',
					'url'=>'pedidos',
					'model'=>'Pedido',
					'search'=>false,
					'index'=>false
				),
				array(
					'field'=>'status_id',
					'name'=>'Status',
					'type'=>'belongsTo',
					'url'=>'status',
					'model'=>'Status',
					'search'=>false,
					'index'=>false
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
					'field'=>'contato_id',
					'name'=>'Contato',
					'type'=>'belongsTo',
					'url'=>'contatos',
					'model'=>'Contato',
					'search'=>true,
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
				),
				array(
					'field'=>'fornecedor_id',
					'name'=>'Fornecedor',
					'type'=>'belongsTo',
					'url'=>'fornecedores',
					'model'=>'Fornecedor',
					'search'=>true,
					'index'=>false
				)
			),
			'hasMany'=>array(
				array(
					'field'=>'procedimentos',
					'name'=>'Procedimentos',
					'type'=>'hasMany',
					'model'=>'ChamadasProcedimento',
					'controller'=>'chamadas_procedimentos',
					'del_info'=>'nome',
					'index'=>false
				),
				array(
					'field'=>'chamadas',
					'name' => 'Chamadas Relacionadas',
					'type' => 'hasMany',
					'model' => 'ChamadasFilha',
					'controller' => 'chamadas',
					'del_info' => 'data_inicio',
					'index' => false
				)
			)
		)
	);


	public $belongsTo = array(
		'Projeto' => array(
			'className' => 'Projeto',
			'foreignKey' => 'projeto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Atendente' => array(
			'className' => 'atendente',
			'foreignKey' => 'atendente_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TiposChamada' => array(
			'className' => 'TiposChamada',
			'foreignKey' => 'tipo_chamada_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Contato' => array(
			'className' => 'Contato',
			'foreignKey' => 'contato_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Fornecedor' => array(
			'className' => 'Fornecedor',
			'foreignKey' => 'fornecedor_id'
		),
		'Instituicao' => array(
			'className' => 'Instituicao',
			'foreignKey' => 'instituicao_id'
		),
		'Prioridade' => array(
			'className' => 'Prioridade',
			'foreignKey' => 'prioridade_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Assunto' => array(
			'className' => 'Assunto',
			'foreignKey' => 'assunto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ChamadaPai' => array(
			'className' => 'Chamada',
			'foreignKey' => 'chamada_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Status' => array(
			'className' => 'Status',
			'foreignKey' => 'status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Pedido' => array(
			'className' => 'Pedido',
			'foreignKey' => 'pedido_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $hasMany = array(
		'ChamadasFilha' => array(
			'className' => 'Chamadas',
			'foreignKey' => 'chamada_id'
		),
		'ChamadasProcedimento' => array(
			'className' => 'ChamadasProcedimento',
			'foreignKey' => 'chamada_id'
		)
	);
	
	public function beforeSave() {
		if (!empty($this->data['Chamada']['data_inicio'])) {
			$data = split('/', $this->data['Chamada']['data_inicio']);
			$this->data['Chamada']['data_inicio'] = $data[2].'-'.$data[1].'-'.$data[0].' '.$this->data['Chamada']['data_inicio_time'];
		}
		if (!empty($this->data['Chamada']['data_fim'])) {
			$data = split('/', $this->data['Chamada']['data_fim']);
			$this->data['Chamada']['data_fim'] = $data[2].'-'.$data[1].'-'.$data[0].' '.$this->data['Chamada']['data_fim_time'];
		}
	}	
}

