<?php
/**
 * EmailsContatoFixture
 *
 */
class EmailsContatoFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'emails_contato';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tipo_email_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'contato_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_emails_contato_tipos_email1' => array('column' => 'tipo_email_id', 'unique' => 0), 'fk_emails_contato_contatos1' => array('column' => 'contato_id', 'unique' => 0)),
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
			'email' => 'Lorem ipsum dolor sit amet',
			'tipo_email_id' => 1,
			'contato_id' => 1
		),
	);
}
