<?php
App::uses('AppController', 'Controller');
/**
 * Níveis de Acesso Controller
 *
 */
class NiveisAcessoController extends AppController {

	public function variables() {
		$forms = array();
		$forms['fields'] = array(
			array(
				'name'=>'Nome',
				'type'=>'text',
				'field'=>'nome',
			),
		);
		$this->set('model', 'NiveisAcesso');
		$this->set('controller', 'niveis_acesso');
		$this->set('forms', $forms);
	}
	
	public function index() {
		$this->set('niveis_acessos', $this->NiveisAcesso->find('all', array('conditions'=>array('NiveisAcesso.nome <>'=>'Administrador'))));
	}	
	
	public function dup($id = null) {
		$nivel = $this->NiveisAcesso->read(null, $id);
		//pr($nivel);
		$novo_nivel = array(
			'NiveisAcesso' => array('nome'=>$nivel['NiveisAcesso']['nome'].' Duplicado'),
			'Permissao' => array()
		);
		$this->NiveisAcesso->create();
		$this->NiveisAcesso->save($novo_nivel);
		$nova_perm = array();
		
		foreach($nivel['Permissao'] as $permissao) {
			$nova_perm['Permissao'] = array(
				'action'=>$permissao['action'],
				'nivel_acesso_id'=>$this->NiveisAcesso->id
			);
			$this->NiveisAcesso->Permissao->create();
			$this->NiveisAcesso->Permissao->save($nova_perm);
		}		
	}
	
	public function add() {
		if ($this->request->isPost()):
			$this->NiveisAcesso->save($this->data);
			$this->Session->setFlash(__('Nível de Acesso gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		endif;
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			$data = $this->data;
			if ($data['NiveisAcesso']['nome'] == 'Administrador') {
				$this->Session->setFlash(__('O nome Administrador não pode ser usado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			} else {
			if ($this->NiveisAcesso->save($data)):
				$this->Session->setFlash(__('Nível de Acesso gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			else:
				$this->Session->setFlash(__('Nível de Acesso gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			endif;
			$this->redirect('index');
			}
		endif;
		$this->variables();
		$this->data = $this->NiveisAcesso->read(null, $id);
	}
	
	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->NiveisAcesso->find('list',array('fields'=>array('id','nome'))));
	}
}
