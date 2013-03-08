<?php
App::uses('Status', 'Model');

/**
 * Status Test Case
 *
 */
class StatusTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.status', 'app.chamada', 'app.projeto', 'app.usuario', 'app.tipos_chamada', 'app.contato', 'app.prioridade', 'app.assunto', 'app.procedimento', 'app.chamadas_procedimento', 'app.pedido');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Status = ClassRegistry::init('Status');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Status);

		parent::tearDown();
	}

}
