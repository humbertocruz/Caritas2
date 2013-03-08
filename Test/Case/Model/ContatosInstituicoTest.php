<?php
App::uses('ContatosInstituico', 'Model');

/**
 * ContatosInstituico Test Case
 *
 */
class ContatosInstituicoTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.contatos_instituico', 'app.contatos', 'app.instituicoes', 'app.cargo', 'app.situacoes_do_contato');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ContatosInstituico = ClassRegistry::init('ContatosInstituico');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ContatosInstituico);

		parent::tearDown();
	}

}
