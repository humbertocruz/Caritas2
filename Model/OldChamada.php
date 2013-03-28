<?php
App::uses('AppModel', 'Model');

class Chamada extends AppModel {

	public $displayField = 'tipo_chamada_id';
	
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
			'className' => 'Chamada',
			'foreignKey' => 'chamada_id'
		)
	);
	
	public function beforeSave() {
		if (!empty($this->data['Chamada']['data_inicio'])) {
			$data_text = $this->data['Chamada']['data_inicio'].' '.$this->data['Chamada']['data_inicio_time'];
			$data = DateTime::createFromFormat('d/m/Y H:i:s', $data_text);
			$this->data['Chamada']['data_inicio'] = $data->format('Y-m-d H:i:s');
		}
		if (isset($this->data['Chamada']['data_fim'])) {
			//unset($this->data['Chamada']['data_fim']);
		}
		if (!isset( $this->data['Chamada']['instituicao_id'] )) {
			$this->data['Chamada']['instituicao_id'] = null;
		} else {
			if ($this->data['Chamada']['instituicao_id'] == 0) {
				$this->data['Chamada']['instituicao_id'] = null;
			}
		}
		if (!isset( $this->data['Chamada']['pedido_id'] )) {
			$this->data['Chamada']['pedido_id'] = null;
		} else {
			if ($this->data['Chamada']['pedido_id'] == 0) {
				$this->data['Chamada']['pedido_id'] = null;
			}
		}
		
		if (!isset( $this->data['Chamada']['fornecedor_id'] )) {
			$this->data['Chamada']['fornecedor_id'] = null;
		} else {
			if ($this->data['Chamada']['fornecedor_id'] == 0) {
				$this->data['Chamada']['fornecedor_id'] = null;
			}
		}
	}	
}

