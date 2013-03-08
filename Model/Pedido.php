<?php
App::uses('AppModel', 'Model');

class Pedido extends AppModel {

	public $displayField = 'data_inicio';
	
	public $useTable = 'pedidos';
	
	public $hasMany = array(
		'Chamada'=>array(
			'className'=>'Chamada',
			'foreignKey'=>'pedido_id'	
		),
		'PedidosItem'=>array(
			'className'=>'PedidosItem',
			'foreignKey'=>'pedido_id'	
		),
		'Documento' => array(
			'className'=>'Documento',
			'foreignKey'=>'pedido_id'
		)
	);

	public $belongsTo = array(
		'Projeto' => array(
			'className' => 'Projeto',
			'foreignKey' => 'projeto_id'
		),
		'Instituicao' => array(
			'className' => 'Instituicao',
			'foreignKey' => 'instituicao_id'
		),
		'Status' => array(
			'className' => 'Status',
			'foreignKey' => 'status_id'
		),
		'Distribuidor' => array(
			'className' => 'Distribuidor',
			'foreignKey' => 'distribuidor_id'
		),
		'Convenio' => array(
			'className' => 'Convenio',
			'foreignKey' => 'convenio_id'
		),
		'AtaPreco' => array(
			'className' => 'AtaPreco',
			'foreignKey' => 'ata_preco_id'
		),
		'Edital' => array(
			'className' => 'Edital',
			'foreignKey' => 'edital_id'
		),
		'TiposPagamento' => array(
			'className' => 'TiposPagamento',
			'foreignKey' => 'tipo_pagamento_id'
		)
	);
	
	public function beforeSave($options = array()) {
    	if ( !empty( $this->data['Pedido']['data_inicio_date'] ) ) {
        	$this->data['Pedido']['data_inicio'] = $this->dateFormatBeforeSave($this->data['Pedido']['data_inicio_date']).' '.$this->data['Pedido']['data_inicio_time'];
        }
        if ( $this->data['System']['finalize'] == 1 ) {
        	$this->data['Pedido']['data_fim'] = date( 'Y-m-d H:i', time());
        }
	    return true;
    }

    public function dateFormatBeforeSave($dateString) {
    	return date_format( date_create_from_format( 'd/m/Y', $dateString ), 'Y-m-d' );
    }
	
}

