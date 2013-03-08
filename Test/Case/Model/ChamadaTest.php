<?php
App::uses('Chamada', 'Model');

/**
 * Chamada Test Case
 *
 */
class ChamadaTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.chamada', 'app.projeto', 'app.usuario', 'app.tipo_chamada', 'app.contato', 'app.prioridade', 'app.assunto', 'app.status', 'app.procedimento', 'app.chamadas_procedimento');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Chamada = ClassRegistry::init('Chamada');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Chamada);

		parent::tearDown();
	}

}
