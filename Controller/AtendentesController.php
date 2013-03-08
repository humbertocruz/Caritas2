<?php
App::uses('AppController', 'Controller');
/**
 * Atendentes Controller
 *
 */
class AtendentesController extends AppController {

	var $components = array('Email');

	public function beforeFilter() {
		$this->Auth->allow('login','recupera');
	}

	
	function _variables() {

		$belongsTo = array();
		$belongsTo['Sexo'] = $this->Atendente->Sexo->find('list',array('fields'=>array('id','nome')));
		$belongsTo['NiveisAcesso'] = $this->Atendente->NiveisAcesso->find('list',array('fields'=>array('id','nome')));
		$this->set('belongsTo', $belongsTo);
		
		$forms = array();
		$forms['fields'] = array(
			array(
				'fieldset'=>'Dados',
				'name'=>'Nome',
				'type'=>'text',
				'field'=>'nome',
			),
			array(
				'name'=>'Email',
				'type'=>'text',
				'field'=>'email',
			),
			array(
				'name'=>'CPF',
				'type'=>'cpf',
				'field'=>'cpf',
			),
			array(
				'name'=>'Nível de Acesso',
				'type'=>'belongsTo',
				'model'=>'NiveisAcesso',
				'field'=>'nivel_acesso_id',
				'url'=>'niveis_acesso'
			),
			array(
				'name'=>'Sexo',
				'type'=>'belongsTo',
				'field'=>'sexo_id',
				'model'=>'Sexo',
				'url' => 'sexos'
			)
		);
		$this->set('forms', $forms);

	}
	
	public function index() {
		$this->set('atendentes', $this->Atendente->find('all'));
	}	
	public function add() {
		if ($this->request->isPost()):
			if ($this->Atendente->save($this->data)):
				$this->Session->setFlash(__('Atendente gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('index');
			else:
				$this->Session->setFlash(__('Atendente não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Atendente->invalidFields());
				$this->data = $this->data;
			endif;
		endif;
		$this->_variables();
	}
	
	public function recupera() {

		$this->Atendente->Behaviors->attach('Containable');
		$this->Atendente->contain();
		$atendente = $this->Atendente->findByEmail($this->data['Atendente']['email']);
		if ($atendente) {
		
			$nova_senha = '';
			$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
			for($s=1;$s<=6;$s++) {
				$nova_senha = $nova_senha.substr($chars, rand(0, strlen($chars)-1), 1 );
			}
			$atendente['Atendente']['senha'] = $this->Auth->password($nova_senha);
			$this->Atendente->save($atendente);
			
			/*
			$this->Email->reset();

			$this->Email->from    = 'humberto.cruz@phpapp.com.br';
			$this->Email->to      = $atendente['Atendente']['email'];
			$this->Email->subject = 'Nova senha para o sistema!';
			$this->Email->send('Sua nova senha é [ '.$nova_senha.' ] !');
			pr($this->Email);
			*/
			App::uses('CakeEmail', 'Network/Email');
			$email = new CakeEmail();
			$email->from(array('humberto.cruz@phpapp.com.br'=>'Caritas'));
			$email->to($atendente['Atendente']['email']);
			$email->subject('Nova senha para o sistema!');
			$email->send('Sua nova senha é [ '.$nova_senha.' ] !');
			
			$this->set('nova_senha', $nova_senha );
			$this->set('resultado', true);
			
		} else {
			$this->set('emailrec', $this->data['Atendente']['email']);
			$this->set('resultado', false);
		}
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->Atendente->save($this->data)):
				$this->Session->setFlash(__('Atendente alterado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('index');
			else:
				$this->Session->setFlash(__('Atendente não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Atendente->invalidFields());
				$this->data = $this->data;
			endif;
		endif;
		$this->data = $this->Atendente->read(null, $id);
		$this->_variables();
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Atividade->delete($this->data['Atividade']['id'])) {
				$this->Session->setFlash(__('Atividade excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Atividade não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
	
	public function login() {
		if($this->request->isPost()):
			
			$conditions = $this->data['Atendente'];
			$conditions['senha'] = AuthComponent::password($this->data['Atendente']['senha']);
			$atendente = $this->Atendente->find('first', array('conditions'=>$conditions, 'recursive'=>2));
			if($atendente) {
				AppController::_sess_models_write('Atendentes', $atendente['Atendente']['id'], $atendente['Atendente']['nome']);
				$this->Auth->login($atendente);
				$NAUser_id = $this->Session->read('Auth.User');
				$NAUser_id = $NAUser_id['NiveisAcesso']['id'];
				$permissoes = $this->Atendente->NiveisAcesso->Permissao->find('all',array('conditions'=>$NAUser_id));
				$atendente = array_merge($atendente, $permissoes);
				$this->Session->setFlash(__('Você fez o login com sucesso !'), 'bootstrap_flash', array('class'=>'alert-success'));
				return $this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Email ou Senha incorretos!'), 'bootstrap_flash', array('class'=>'alert-error'));
			}
		endif;
	}
	
	public function change_pass() {
		$this->layout = null;
		if($this->request->isPost()) {
			$conditions = array(
				'Atendente.id'=>$this->Session->read('Auth.User.Atendente.id'),
				'Atendente.senha'=>AuthComponent::password($this->data['Atendente']['password'])
			);
			$atendente = $this->Atendente->find('all', array('conditions'=>$conditions));
			if ($atendente) {
				if ($this->data['Atendente']['new-password'] == $this->data['Atendente']['conf-password']) {
					$this->Atendente->read(null, $this->Session->read('Auth.User.Atendente.id'));
					$this->Atendente->set('senha',AuthComponent::password($this->data['Atendente']['new-password']));
					$this->Atendente->save();
					echo 'Senha alterada com sucesso!';
				} else {
					echo 'As novas senhas não conferem!';
				}
			} else {
				echo 'Senha atual inválida!';
			}
		}
	}
	
	public function logout() {
		$this->Session->setFlash(__('Você saiu do Sistema !'), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->Session->delete('sess_models');
		$this->redirect($this->Auth->logout());
	}
	
}
