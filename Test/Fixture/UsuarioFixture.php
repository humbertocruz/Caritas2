<?php
/**
 * UsuarioFixture
 *
 */
class UsuarioFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'nome' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 80, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 80, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ramal' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 15, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'senha' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 16, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'nivel_acesso_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'email_UNIQUE' => array('column' => 'email', 'unique' => 1), 'fk_usuarios_niveis_acesso' => array('column' => 'nivel_acesso_id', 'unique' => 0)),
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
			'email' => 'Lorem ipsum dolor sit amet',
			'ramal' => 'Lorem ipsum d',
			'senha' => 'Lorem ipsum do',
			'nivel_acesso_id' => 1
		),
	);
}
