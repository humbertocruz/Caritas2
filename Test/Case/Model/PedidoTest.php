<?php
App::uses('Pedido', 'Model');

/**
 * Pedido Test Case
 *
 */
class PedidoTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.pedido', 'app.instituicao', 'app.projeto', 'app.chamada', 'app.usuario', 'app.tipos_chamada', 'app.contato', 'app.prioridade', 'app.assunto', 'app.status', 'app.procedimento', 'app.chamadas_procedimento', 'app.dn', 'app.ata_preco', 'app.convenio', 'app.edital', 'app.tipo_pagamento', 'app.etapa', 'app.pedidos_etapa', 'app.situaco', 'app.pedidos_situaco', 'app.veiculo', 'app.pedidos_veiculo', 'app.veiculos_processo', 'app.pedidos_veiculos_processo');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Pedido = ClassRegistry::init('Pedido');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Pedido);

		parent::tearDown();
	}

}
