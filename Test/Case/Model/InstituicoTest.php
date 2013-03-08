<?php
App::uses('Instituico', 'Model');

/**
 * Instituico Test Case
 *
 */
class InstituicoTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.instituico', 'app.tipo_instituicao', 'app.estados', 'app.contato', 'app.contatos_instituico');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Instituico = ClassRegistry::init('Instituico');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Instituico);

		parent::tearDown();
	}

}
