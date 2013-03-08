<?php
App::uses('AppModel', 'Model');
class Prazo extends AppModel {

	public $useTable = 'pedidos_itens_etapas_atividade';
	
	public $belongsTo = array(
		'Pedido' => array(
			'className' => 'Pedido',
			'foreignKey' => 'pedido_id',
		),
		'Atividade' => array(
			'className' => 'Atividade',
			'foreignKey' => 'pedido_atividade_id',
		),
		'Item' => array(
			'className' => 'Item',
			'foreignKey' => 'pedido_item_id',
		),
	);

}
