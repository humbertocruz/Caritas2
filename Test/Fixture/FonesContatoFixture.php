<?php
/**
 * FonesContatoFixture
 *
 */
class FonesContatoFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'fones_contato';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'fone' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tipo_fone_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'contato_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_fontes_contato_tipos_fone1' => array('column' => 'tipo_fone_id', 'unique' => 0), 'fk_fontes_contato_contatos1' => array('column' => 'contato_id', 'unique' => 0), 'fk_fone_contato_tipo_fone1' => array('column' => 'tipo_fone_id', 'unique' => 0), 'fk_fone_contato_contato' => array('column' => 'contato_id', 'unique' => 0)),
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
			'fone' => 'Lorem ipsum dolor sit amet',
			'tipo_fone_id' => 1,
			'contato_id' => 1
		),
	);
}
