<?php
App::uses('ContatosController', 'Controller');

/**
 * TestContatosController *
 */
class TestContatosController extends ContatosController {
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
 * ContatosController Test Case
 *
 */
class ContatosControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.contato', 'app.sexo', 'app.chamada', 'app.projeto', 'app.pedido', 'app.instituicao', 'app.tipos_instituicao', 'app.estados', 'app.contatos_instituico', 'app.dn', 'app.ata_preco', 'app.convenio', 'app.edital', 'app.orgao', 'app.tipo_pagamento', 'app.status', 'app.etapa', 'app.pedidos_etapa', 'app.situaco', 'app.pedidos_situaco', 'app.veiculo', 'app.pedidos_veiculo', 'app.veiculos_processo', 'app.pedidos_veiculos_processo', 'app.usuario', 'app.nivel_acesso', 'app.chamadas_procedimento', 'app.tipos_chamada', 'app.prioridade', 'app.assunto', 'app.procedimento', 'app.emails_contato', 'app.fones_contato');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Contatos = new TestContatosController();
		$this->Contatos->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Contatos);

		parent::tearDown();
	}

}
