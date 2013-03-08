<?php
/**
 * PedidoFixture
 *
 */
class PedidoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'data_inicio' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'data_fim' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'observacao' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'data_anuencia' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'instituicao_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'projeto_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'dn_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'ata_preco_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'convenio_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'edital_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'tipo_pagamento_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'status_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_pedidos_instituicoes1' => array('column' => 'instituicao_id', 'unique' => 0), 'fk_pedidos_projetos1' => array('column' => 'projeto_id', 'unique' => 0), 'fk_pedidos_dn1' => array('column' => 'dn_id', 'unique' => 0), 'fk_pedidos_ata_precos1' => array('column' => 'ata_preco_id', 'unique' => 0), 'fk_pedidos_convenios1' => array('column' => 'convenio_id', 'unique' => 0), 'fk_pedidos_tipos_pagamento1' => array('column' => 'tipo_pagamento_id', 'unique' => 0), 'fk_pedidos_editais1' => array('column' => 'edital_id', 'unique' => 0), 'fk_pedidos_status1' => array('column' => 'status_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'data_inicio' => '2012-03-06',
			'data_fim' => '2012-03-06',
			'observacao' => 'Lorem ipsum dolor sit amet',
			'data_anuencia' => '2012-03-06',
			'instituicao_id' => 1,
			'projeto_id' => 1,
			'dn_id' => 1,
			'ata_preco_id' => 1,
			'convenio_id' => 1,
			'edital_id' => 1,
			'tipo_pagamento_id' => 1,
			'status_id' => 1
		),
	);
}
