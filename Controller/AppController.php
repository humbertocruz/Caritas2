<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
		'Session',
		'Auth' => array(
			'loginAction' => array(
				'controller' => 'atendentes',
				'action' => 'login'
			),
			'flash' => array(
				'element' => 'bootstrap_flash',
				'key' => 'auth',
				'params' => array()
			),
			'authError' => 'Voc&ecirc; n&atilde;o tem permiss&atilde;o para acessar este m&oacute;dulo!',
			'authenticate' => array(
				'Form' => array(
					'fields' => array('username'=>'email','password'=>'senha')
				)
			),
			'loginRedirect' => '/pedidos',
			'logoutRedirect' => '/',
			'autoRedirect' => false
		),
		'ControllerList',
		//'DebugKit.Toolbar'
	);
	
	public $menus = array(
		'sis_modulos' => array(
			'name' => 'Módulos',
			'data' => array(
				'Chamadas' => array('Chamadas', '/chamadas'),
				'Projetos' => array('Projetos', '/projetos'),
				'Contatos' => array('Contatos', '/contatos'),
				'Convenios' => array('Convênios', '/convenios'),
				'Fornecedores'=>array('Fornecedores','/fornecedores'),
				'Instituicoes' => array('Instituições', '/instituicoes'),
				'Pedidos' => array('Pedidos', '/pedidos')
			)
		),
		'sis_tabelas' => array(
			'name' => 'Tabelas',
			'data' => array(
				'Assuntos'=>array('Assuntos','/assuntos'),
				'AtaPrecos'=>array('Ata de Preços','/ata_precos'),
				'Atividades'=>array('Atividades','/atividades'),
				'Cargos'=>array('Cargos','/cargos'),
				'Cidades'=>array('Cidades','/cidades'),
				'Editais'=>array('Editais','/editais'),
				'Estados'=>array('Estados','/estados'),
				'Etapas'=>array('Etapas','/etapas'),
				'Orgaos'=>array('Órgãos','/orgaos'),
				'Itens'=>array('Itens','/itens'),
				'Prioridades'=>array('Prioridades','/prioridades'),
				'Procedimentos'=>array('Procedimentos', '/procedimentos'),
				//'Projetos'=>array('Projetos', '/projetos'),
				'Sexos'=>array('Sexos','/sexos'),
				'SituacoesContatos'=>array('Situações de Contatos','/situacoes_contatos'),
				'Status'=>array('Status','/status'),
				'divider'=>'Tipos',
				'TiposChamadas' => array('de Chamadas','/tipos_chamadas'),
				'TiposConvenios' => array('de Convênios','/tipos_convenios'),
				'TiposDocumentos' => array('de Documentos','/tipos_documentos'),
				'TiposEmails' => array('de Emails','/tipos_emails'),
				'TiposEnderecos' => array('de Endereços','/tipos_enderecos'),
				'TiposFones' => array('de Fones','/tipos_fones'),
				'TiposInstituicoes' => array('de Instituições','/tipos_instituicoes'),
				'TiposPagamentos' => array('de Pagamentos','/tipos_pagamentos')
			)
		)
	);
	
	public $uses = array('Projeto','Chamada');
	
	public $helper = array('Bootstrap','Caritas');
	
	public function _sub_children($itens, $vars) {
		$contador = 0;
		foreach ($itens as $item) {
			if ($item[$vars['model']][$vars['field']] == $vars['id']) $contador++;
		}
		return ($contador);
	}
	
	public function _sess_models() {		
		if ($this->Session->check('sess_models')) {
			$sess_models = array(
				'Projetos' => array(
					'id' => $this->Session->read('sess_models.Projetos.id'),

					'texto' => $this->Session->read('sess_models.Projetos.texto'),
					'flag' => TRUE
				),
				'Atendentes' => array(
					'id' => $this->Session->read('sess_models.Atendentes.id'),
					'texto' => $this->Session->read('sess_models.Atendentes.texto')
				),
				'Chamadas' => array(
					'id' => $this->Session->read('sess_models.Chamadas.id'),
					'texto' => $this->Session->read('sess_models.Chamadas.texto')
				)
			);
		} else {
			$sess_models = array(
				'Projetos' => array(
					'id' => 0,
					'texto' => '',
					'flag' => TRUE
				),
				'Atendentes' => array(
					'id' => null,
					'texto' => ''
				),
				'Chamadas' => array(
					'id' => null,
					'texto' => ''
				)
			);			
		}
		return ( $sess_models );
	}
	
	public function _sess_models_write($model, $id, $texto) {
		$this->Session->write('sess_models.'.$model.'.id', $id);
		$this->Session->write('sess_models.'.$model.'.texto', $texto);
	}
	
	public function _isAdmin() {
		$AuthUser = $this->Session->read('Auth.User');
		if($AuthUser['NiveisAcesso']['nome'] == 'Administrador') return true;
		else return false;
	}
	
	public function _menuPermission($chk_menus = null) {
		$AuthUser = $this->Session->read('Auth.User');
		if (!$AuthUser) return false;

		if($AuthUser['NiveisAcesso']['nome'] == 'Administrador') return $chk_menus;

		$AuthPermTemp = $AuthUser['NiveisAcesso']['Permissao'];
		$AuthPerm = array();
		foreach($AuthPermTemp as $perm) {
			$menuPermList = explode('::',$perm['action']);
			array_push($AuthPerm, str_replace('Controller','',$menuPermList[0]));
		}
		$user_menu = array();
		$separator = 0;
		foreach($chk_menus as $key=>$value) {
			if ($key == 'divider' and $separator == 0) $separator = 1;
			foreach ($AuthPerm as $perm) {
				if ($perm == $key) {
					if ($separator == 1) $user_menu['divider']='Tipos';
					$user_menu[$key] = $value;
					$separator = 2;
				}
			}
		}
		return ($user_menu);
	}
	
	public function _hasPermission($menuPerm = null) {
		$AuthUser = $this->Session->read('Auth.User');
		if (!$AuthUser) return false;

		if($AuthUser['NiveisAcesso']['nome'] == 'Administrador') return true;

		$AuthPermTemp = $AuthUser['NiveisAcesso']['Permissao'];
		$AuthPerm = array();
		foreach($AuthPermTemp as $perm) {
			$menuPermList = explode('::',$perm['action']);
			array_push($AuthPerm, str_replace('Controller','',$menuPermList[0]));
		}
		$thisPerm = $menuPerm;
		//pr($thisPerm, $AuthPerm);
		if (in_array($thisPerm, $AuthPerm)) {
			return true;
		}
		else return false;
	}
	
	public function _checkRel($row = null, $fkey = 'id') {
		//pr($row);
		$rel = true;
		foreach ($row as $column) {
			if (is_array($column)) {
				if (count($column) > 0) {
					if (isset($column[0][$fkey])) {
						$rel = false;
					}
				}
			}
		}
		return $rel;
	}
	
	public function _checkPermission() {
		$AuthUser = $this->Session->read('Auth.User');
		
		if (empty($AuthUser)) return false; // Usuario não logado
		
		if($AuthUser['NiveisAcesso']['nome'] == 'Administrador') return true; // Usuario eh administrador ( todas as permissoes )
		
		$AuthPermTemp = $AuthUser['NiveisAcesso']['Permissao']; // Todas as permissoes do nivel de acesso do usuário
		
		$AuthPerm = array();
		foreach($AuthPermTemp as $perm) {
			array_push($AuthPerm, $perm['action']);
		}
		$thisPerm = $this->name.'Controller::'.$this->view;
		
		if (!in_array($thisPerm, $AuthPerm)) {
			$this->Session->setFlash(__('Você não tem permissão de acesso a essa área !'), 'bootstrap_flash', array('class'=>'alert-error'));
			return $this->redirect($this->referer());
		}
		else return true;
	}
	
	public function _indexFormat($field, $type) {
		if ($type == 'date') {
			if ($field > 0) {
				return(date('d/m/Y', strtotime($field)));
			} else {
				return('--xx--');
			}
		} else if ($type == 'cpf') {
			if ($field == '' or strlen($field) < 11) return('');
			$mascara = '###.###.###-##';
			$indice = -1;
			for($i=0;$i<strlen($mascara);$i++) {
				if ($mascara[$i]=="#") $mascara[$i] = $field[++$indice];
			}
			return ($mascara);
		} else if ($type == 'cnpj') {
			if ($field == '') return('');
			if (strlen($field) < 14) return($field);
			$mascara = '##.###.###/####-##';
			$indice = -1;
			for($i=0;$i<strlen($mascara);$i++) {
				if ($mascara[$i]=="#") $mascara[$i] = $field[++$indice];
			}
			return ($mascara);
		}

		else return($field);
	}
	public function afterFilter() {
		//pr($this->_checkPermission());
	}
	
	public function beforeFilter() {
		// Controle de Autenticacao
		$this->Auth->userModel = 'Atendente';
		$this->_checkPermission();
		
		/*
		session_destroy();
		/*
		$this->Session->delete('sess_belongsTo');
		$this->Session->delete('do_belongsTo');
		$this->Session->delete('load_belongsTo');
		*/

		// Controle de Acessos BelongsTo
		
		if ( $this->Session->check('do_belongsTo') ) {
			$sess_belongsTo = $this->Session->read('sess_belongsTo');
			if (count($sess_belongsTo) == 0) {
				$this->Session->write('do_belongsTo',false);
			}
		}
		
		// Busca e Filtros
		$conditions = array();
		if ($this->request->isPost()) {
			if (isset($this->data['filter'])) {
				if ($this->data['filter']['clear'] == 1) {
					$this->Session->delete('filter');
				} else {
					/*
					if ($this->data['filter']['search'] != '') {
						$this->Session->write('filter.search', $this->data['filter']['search']);
					}
					if (isset($this->data['filter']['uf']) && $this->data['filter']['uf'] != '0') {
						$this->Session->write('filter.uf', $this->data['filter']['uf']);
					}
					if (isset($this->data['filter']['cidade']) && $this->data['filter']['cidade'] != '0') {
						$this->Session->write('filter.cidade', $this->data['filter']['cidade']);
					}
					*/
					$this->Session->write('filter', $this->data['filter']);
				}
			}		
		}
		
	}
	
	public function beforeRender() {
		
		// Projetos
		$app_projetos = $this->Projeto->find('all', array('fields'=>array('id','nome')));
		$this->set('app_projetos', $app_projetos);
		
		//Enviar lista de Menus para a view
		$user_menu = array();
		foreach($this->menus as $menu) {
			$tmp_user_menu = $this->_menuPermission($menu['data']);

			if (is_array($tmp_user_menu) && count($tmp_user_menu) > 0) array_push($user_menu, array('name'=>$menu['name'], 'data'=>$tmp_user_menu));
		}
		
		$this->set('menu_control', $user_menu);
		
		if ($this->Session->check('load_belongsTo')) {
			$load = $this->Session->read('load_belongsTo');
			$this->data = array_merge($this->data, $load);
			$this->Session->delete('load_belongsTo');

			if (isset($this->data['System']['return_id'])) {
				$ret_belongsTo = split('\|',$this->data['System']['return_id']);
				$this->set('ret_belongsTo', array($ret_belongsTo[0]=>$ret_belongsTo));
			}
		}
		$conditions = array(
			'Chamada.data_fim'=>'0000-00-00',
			'Chamada.atendente_id'=>$this->Session->read('Auth.User.Atendente.id')
		);
		$chamadas_aberto = $this->Chamada->find('count', array('conditions'=>$conditions));
		
		$this->set('chamadas_aberto', $chamadas_aberto);
	}
		
}

