<?php
/**
 * ContatoFixture
 *
 */
class ContatoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'nome' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 80, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'data_nascimento' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'sexo_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'cpf' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 11, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_contatos_sexo1' => array('column' => 'sexo_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'nome' => 'Lorem ipsum dolor sit amet',
			'data_nascimento' => '2012-03-07',
			'sexo_id' => 1,
			'cpf' => 'Lorem ips'
		),
	);
}
