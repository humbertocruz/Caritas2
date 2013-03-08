<?php
App::uses('Assunto', 'Model');

/**
 * Assunto Test Case
 *
 */
class AssuntoTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.assunto', 'app.chamada', 'app.projeto', 'app.pedido', 'app.instituicao', 'app.tipos_instituicao', 'app.estados', 'app.contato', 'app.contatos_instituico', 'app.dn', 'app.ata_preco', 'app.convenio', 'app.edital', 'app.orgao', 'app.tipo_pagamento', 'app.status', 'app.etapa', 'app.pedidos_etapa', 'app.situaco', 'app.pedidos_situaco', 'app.veiculo', 'app.pedidos_veiculo', 'app.veiculos_processo', 'app.pedidos_veiculos_processo', 'app.usuario', 'app.nivel_acesso', 'app.chamadas_procedimento', 'app.tipos_chamada', 'app.prioridade', 'app.procedimento');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Assunto = ClassRegistry::init('Assunto');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Assunto);

		parent::tearDown();
	}

}
