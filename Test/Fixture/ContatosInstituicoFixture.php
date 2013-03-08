<?php
/**
 * ContatosInstituicoFixture
 *
 */
class ContatosInstituicoFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'contatos_instituicoes';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'contatos_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'instituicoes_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'cargo_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'data_inicio' => array('type' => 'date', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'data_fim' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'situacoes_do_contato_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => array('id', 'contatos_id', 'instituicoes_id', 'cargo_id', 'data_inicio'), 'unique' => 1), 'fk_contatos_has_instituicoes_instituicoes1' => array('column' => 'instituicoes_id', 'unique' => 0), 'fk_contatos_has_instituicoes_contatos1' => array('column' => 'contatos_id', 'unique' => 0), 'fk_contatos_instituicoes_cargos1' => array('column' => 'cargo_id', 'unique' => 0), 'fk_contatos_instituicoes_contatos_situacoes1' => array('column' => 'situacoes_do_contato_id', 'unique' => 0)),
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
			'contatos_id' => 1,
			'instituicoes_id' => 1,
			'cargo_id' => 1,
			'data_inicio' => '2012-03-07',
			'data_fim' => '2012-03-07',
			'situacoes_do_contato_id' => 1
		),
	);
}
