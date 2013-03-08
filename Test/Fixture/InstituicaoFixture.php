<?php
/**
 * InstituicaoFixture
 *
 */
class InstituicaoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'razao_social' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 80, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'nome_fantasia' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 80, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'inscricao_estadual' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 80, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cnpj' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 14, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'data_cadastro' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'tipo_instituicao_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'estados_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 2, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_instituicoes_tipos_instituicao1' => array('column' => 'tipo_instituicao_id', 'unique' => 0), 'fk_instituicoes_estados1' => array('column' => 'estados_id', 'unique' => 0)),
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
			'razao_social' => 'Lorem ipsum dolor sit amet',
			'nome_fantasia' => 'Lorem ipsum dolor sit amet',
			'inscricao_estadual' => 'Lorem ipsum dolor sit amet',
			'cnpj' => 'Lorem ipsum ',
			'data_cadastro' => '2012-03-07',
			'tipo_instituicao_id' => 1,
			'estados_id' => ''
		),
	);
}
