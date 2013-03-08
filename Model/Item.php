<?php
App::uses('AppModel', 'Model');

class Item extends AppModel {
	
	public $useTable = 'itens';
	
	public $displayField = 'nome';
	
	public $hasMany = array (
		'EtapasAtividadesItem' => array(
			'order'=>array('ordem_exibicao'=>'ASC')
		)
		);
	
	public $formFields = array(
		'Item'=>array(
		'template'=>'tabs',
		'fields'=>array(
			array(
				'field'=>'nome',
				'name'=>'Nome',
				'type'=>'text',
				'model'=>'Item',
				'index'=>true
			),
			array(
				'field'=>'valor',
				'name'=>'Valor',
				'type'=>'text',
				'model'=>'Item',
				'index'=>true
			),
			array(
				'field'=>'ata_preco_id',
				'name'=>'Ata de Preço',
				'type'=>'belongsTo',
				'url'=>'ata_precos',
				'model'=>'AtaPreco',
				'search' => false,
				'index'=>false
			),
			array(
				'field'=>'fornecedor_id',
				'name'=>'Fornecedor',
				'type'=>'belongsTo',
				'url'=>'fornecedores',
				'model'=>'Fornecedor',
				'search'=>false,
				'index'=>false
			)
		),
		'hasMany'=>array(
			array(
				'field'=>'etapasatividadesitem',
				'name'=>'EtapasAtivdadesItem',
				'type'=>'hasMany',
				'model'=>'EtapasAtividadesItem',
				'controller'=>'etaspasatividadesitens',
				'del_info'=>'prazo',
				'index'=>false
			)
		)
		)
	);
	
}