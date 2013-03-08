<?php
App::uses('TiposEmail', 'Model');

/**
 * TiposEmail Test Case
 *
 */
class TiposEmailTestCase extends CakeTestCase {
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
		$this->TiposEmail = ClassRegistry::init('TiposEmail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TiposEmail);

		parent::tearDown();
	}

}
