<?php
App::uses('AppModel', 'Model');

class EtapasAtividadesItem extends AppModel {

	public $displayField = 'atividades_id';

	public $useTable = 'etapas_atividades_itens';
	
	public $formFields = array('EtapasAtividadesItem'=>array(
		'template'=>'generic',
		'fields'=>array(
			array(
				'field'=>'projeto_id',
				'name'=>'Projeto',
				'type'=>'hidden'
			),
			array(
				'field'=>'etapas_id',
				'name'=>'Etapa',
				'model'=>'Etapa',
				'type'=>'belongsTo'
			),
			array(
				'field'=>'atividades_id',
				'name'=>'Atividade',
				'model'=>'Atividade',
				'type'=>'belongsTo'
			),
			array(
				'field'=>'itens_id',
				'name'=>'Item',
				'model'=>'Item',
				'type'=>'belongsTo'
			),
			array(
				'field'=>'prazo',
				'name'=>'Prazo',
				'type'=>'text'
			),
			array(
				'field'=>'ordem_exibicao',
				'name'=>'Órdem de Exibição',
				'type'=>'text'
			),
			array(
				'field'=>'global',
				'name'=>'Global',
				'type'=>'bool'
			)
		)
	));

	public $hasMany = array(
		'PedidosItensEtapasAtividade' => array(
			'className' => 'PedidosItensEtapasAtividade',
			'foreignKey' => 'etapa_atividade_id',
			'order' => array('data_inicio_prevista'=>'ASC')
		)
	);
	
		public $belongsTo = array(
			'Atividade' => array(
				'className'=>'Atividade',
				'foreignKey'=>'atividades_id'
			),
			'Projeto',
			'Etapa' => array(
				'className'=>'Etapa',
				'foreignKey'=>'etapas_id'
			),
			'Item'
		);

}
