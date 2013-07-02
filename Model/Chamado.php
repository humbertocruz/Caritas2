<?php
class Chamado extends AppModel {
	
	public $useTable = 'chamadas';
	
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
		'ChamadasProcedimento' => array(
			'className' => 'ChamadasProcedimento',
			'foreignKey' => 'chamada_id'
		),
		'ChamadasFilha' => array(
			'className' => 'Chamado',
			'foreignKey' => 'chamada_id'
		)
	);
	
}