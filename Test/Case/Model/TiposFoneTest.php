<?php
App::uses('TiposFone', 'Model');

/**
 * TiposFone Test Case
 *
 */
class TiposFoneTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.tipos_fone');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TiposFone = ClassRegistry::init('TiposFone');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TiposFone);

		parent::tearDown();
	}

}
