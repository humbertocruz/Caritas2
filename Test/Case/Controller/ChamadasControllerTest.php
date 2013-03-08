<?php
App::uses('ChamadasController', 'Controller');

/**
 * TestChamadasController *
 */
class TestChamadasController extends ChamadasController {
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
 * ChamadasController Test Case
 *
 */
class ChamadasControllerTestCase extends CakeTestCase {
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
		$this->Chamadas = new TestChamadasController();
		$this->Chamadas->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Chamadas);

		parent::tearDown();
	}

}
