<?php
App::uses('TiposChamada', 'Model');

/**
 * TiposChamada Test Case
 *
 */
class TiposChamadaTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.tipos_chamada');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TiposChamada = ClassRegistry::init('TiposChamada');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TiposChamada);

		parent::tearDown();
	}

}
