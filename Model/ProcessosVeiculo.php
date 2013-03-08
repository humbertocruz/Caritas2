<?php
App::uses('AppModel', 'Model');
/**
 * TiposEmail Model
 *
 */
class ProcessosVeiculo extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'processos_veiculos';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'veiculo_id';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'nome' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
