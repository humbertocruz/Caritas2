<?php
/**
 * ChamadaFixture
 *
 */
class ChamadaFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'hora' => array('type' => 'time', 'null' => false, 'default' => NULL),
		'data_inicio' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'data_fim' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'solicitacao' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'projeto_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'usuario_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'tipo_chamada_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'contato_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'prioridade_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'assunto_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'chamada_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'status_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_chamadas_projetos1' => array('column' => 'projeto_id', 'unique' => 0), 'fk_chamadas_usuarios1' => array('column' => 'usuario_id', 'unique' => 0), 'fk_chamadas_tipos_chamada1' => array('column' => 'tipo_chamada_id', 'unique' => 0), 'fk_chamadas_contatos1' => array('column' => 'contato_id', 'unique' => 0), 'fk_chamadas_prioridades1' => array('column' => 'prioridade_id', 'unique' => 0), 'fk_chamadas_assuntos1' => array('column' => 'assunto_id', 'unique' => 0), 'fk_chamadas_chamadas_id' => array('column' => 'chamada_id', 'unique' => 0), 'fk_chamadas_status1' => array('column' => 'status_id', 'unique' => 0)),
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
			'hora' => '18:46:39',
			'data_inicio' => '2012-03-06',
			'data_fim' => '2012-03-06',
			'solicitacao' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'projeto_id' => 1,
			'usuario_id' => 1,
			'tipo_chamada_id' => 1,
			'contato_id' => 1,
			'prioridade_id' => 1,
			'assunto_id' => 1,
			'chamada_id' => 1,
			'status_id' => 1
		),
	);
}
