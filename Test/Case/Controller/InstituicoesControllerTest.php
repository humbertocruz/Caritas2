<?php
App::uses('InstituicoesController', 'Controller');

/**
 * TestInstituicoesController *
 */
class TestInstituicoesController extends InstituicoesController {
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
 * InstituicoesController Test Case
 *
 */
class InstituicoesControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.instituico');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Instituicoes = new TestInstituicoesController();
		$this->Instituicoes->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Instituicoes);

		parent::tearDown();
	}

}
