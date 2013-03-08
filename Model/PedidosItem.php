<?php
App::uses('AppModel', 'Model');

class PedidosItem extends AppModel {
	
	public $useTable = 'pedidos_itens';
	
	public $belongsTo = array(
		'Item' => array(
			'className' => 'Item',
			'foreignKey' => 'item_id'
		),
		'Pedido' => array(
			'className' => 'Pedido',
			'foreignKey' => 'pedido_id'
		)
	);

	public $hasMany = array(
		'PedidosItensEtapasAtividade' => array(
			'className' => 'PedidosItensEtapasAtividade',
			'foreignKey' => 'pedido_item_id',
			'order' => array('data_inicio_prevista'=>'ASC')
		)
	);
	
	public function beforeSave() {
		if (!empty($this->data['PedidosItem']['data_inicial'])) {
			$data_text = $this->data['PedidosItem']['data_inicial'];
			$data = DateTime::createFromFormat('d/m/Y', $data_text);
			$this->data['PedidosItem']['data_inicial'] = $data->format('Y-m-d H:i:s');
		}
	}
	
}