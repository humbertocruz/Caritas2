<?php
App::uses('Editai', 'Model');

/**
 * Editai Test Case
 *
 */
class EditaiTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.editai', 'app.orgao');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Editai = ClassRegistry::init('Editai');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Editai);

		parent::tearDown();
	}

}
