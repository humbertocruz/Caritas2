<?php
App::uses('PedidosController', 'Controller');

/**
 * TestPedidosController *
 */
class TestPedidosController extends PedidosController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * PedidosController Test Case
 *
 */
class PedidosControllerTestCase extends CakeTestCase {
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
		$this->Pedidos = new TestPedidosController();
		$this->Pedidos->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Pedidos);

		parent::tearDown();
	}

}
