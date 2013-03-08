<?php
App::uses('NiveisAcessosController', 'Controller');

/**
 * TestNiveisAcessosController *
 */
class TestNiveisAcessosController extends NiveisAcessosController {
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
 * NiveisAcessosController Test Case
 *
 */
class NiveisAcessosControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.niveis_acesso');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->NiveisAcessos = new TestNiveisAcessosController();
		$this->NiveisAcessos->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->NiveisAcessos);

		parent::tearDown();
	}

}
