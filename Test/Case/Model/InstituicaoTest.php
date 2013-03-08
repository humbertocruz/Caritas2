<?php
App::uses('Instituicao', 'Model');

/**
 * Instituicao Test Case
 *
 */
class InstituicaoTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.instituicao', 'app.tipo_instituicao', 'app.estados', 'app.endereco', 'app.pedido', 'app.projeto', 'app.chamada', 'app.usuario', 'app.niveis_acesso', 'app.chamadas_procedimento', 'app.tipos_chamada', 'app.contato', 'app.sexo', 'app.emails_contato', 'app.tipos_email', 'app.fones_contato', 'app.tipos_fone', 'app.contato_instituicao', 'app.prioridade', 'app.assunto', 'app.status', 'app.procedimento', 'app.dn', 'app.ata_preco', 'app.convenio', 'app.edital', 'app.orgao', 'app.tipo_pagamento', 'app.etapa', 'app.pedidos_etapa', 'app.situaco', 'app.pedidos_situaco', 'app.veiculo', 'app.pedidos_veiculo', 'app.veiculos_processo', 'app.pedidos_veiculos_processo');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Instituicao = ClassRegistry::init('Instituicao');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Instituicao);

		parent::tearDown();
	}

}
