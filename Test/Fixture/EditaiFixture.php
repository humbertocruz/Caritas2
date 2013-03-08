<?php
/**
 * EditaiFixture
 *
 */
class EditaiFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'numero' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'ano' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'orgao_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'id_UNIQUE' => array('column' => 'id', 'unique' => 1), 'fk_editais_orgaos1' => array('column' => 'orgao_id', 'unique' => 0)),
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
			'numero' => 1,
			'ano' => 1,
			'orgao_id' => 1
		),
	);
}
