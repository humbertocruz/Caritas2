<?php
App::uses('NiveisAcesso', 'Model');

/**
 * NiveisAcesso Test Case
 *
 */
class NiveisAcessoTestCase extends CakeTestCase {
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
		$this->NiveisAcesso = ClassRegistry::init('NiveisAcesso');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->NiveisAcesso);

		parent::tearDown();
	}

}
