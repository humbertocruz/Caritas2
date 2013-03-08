<?php
App::uses('ProjetosController', 'Controller');

/**
 * TestProjetosController *
 */
class TestProjetosController extends ProjetosController {
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
 * ProjetosController Test Case
 *
 */
class ProjetosControllerTestCase extends CakeTestCase {
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
		$this->Projetos = new TestProjetosController();
		$this->Projetos->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Projetos);

		parent::tearDown();
	}

}
