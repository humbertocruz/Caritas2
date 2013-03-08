<?php
App::uses('TiposEmailsController', 'Controller');

/**
 * TestTiposEmailsController *
 */
class TestTiposEmailsController extends TiposEmailsController {
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
 * TiposEmailsController Test Case
 *
 */
class TiposEmailsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.tipos_email');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TiposEmails = new TestTiposEmailsController();
		$this->TiposEmails->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TiposEmails);

		parent::tearDown();
	}

}
