<?php
App::uses('Projeto', 'Model');

/**
 * Projeto Test Case
 *
 */
class ProjetoTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.projeto', 'app.chamada', 'app.usuario', 'app.tipos_chamada', 'app.contato', 'app.prioridade', 'app.assunto', 'app.status', 'app.pedido', 'app.procedimento', 'app.chamadas_procedimento');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Projeto = ClassRegistry::init('Projeto');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Projeto);

		parent::tearDown();
	}

}
