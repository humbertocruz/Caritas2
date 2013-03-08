<?php
App::uses('TiposInstituicao', 'Model');

/**
 * TiposInstituicao Test Case
 *
 */
class TiposInstituicaoTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.tipos_instituicao');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TiposInstituicao = ClassRegistry::init('TiposInstituicao');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TiposInstituicao);

		parent::tearDown();
	}

}
