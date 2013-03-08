<?php
App::uses('AppModel', 'Model');

class PedidosItensEtapasAtividade extends AppModel {
	
	public $useTable = 'pedidos_itens_etapas_atividade';
	
	public $belongsTo = array(
		'EtapasAtividadesItem' => array(
			'className' => 'EtapasAtividadesItem',
			'foreignKey' => 'etapa_atividade_id'
		)
	);
	
	public function beforeSave() {
		if (!empty($this->data['PedidosItensEtapasAtividade']['data_inicio_efetiva'])) {
			$data_text = $this->data['PedidosItensEtapasAtividade']['data_inicio_efetiva'];
			$data = DateTime::createFromFormat('d/m/Y', $data_text);
			$this->data['PedidosItensEtapasAtividade']['data_inicio_efetiva'] = $data->format('Y-m-d');
		}
		if (!empty($this->data['PedidosItensEtapasAtividade']['data_fim_efetiva'])) {
			$data_text = $this->data['PedidosItensEtapasAtividade']['data_fim_efetiva'];
			$data = DateTime::createFromFormat('d/m/Y', $data_text);
			$this->data['PedidosItensEtapasAtividade']['data_fim_efetiva'] = $data->format('Y-m-d');
		}
	}
	
}