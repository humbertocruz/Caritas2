<?php
App::uses('AppController', 'Controller');
/**
 * Permissoes Controller
 *
 */
class PermissoesController extends AppController {

	public function index() {
		$niveis = $this->Permissao->NiveisAcesso->find('all', array('conditions'=>array('NiveisAcesso.nome <>' => 'Administrador')));

		if (isset($this->request->query)) {
			$req = $this->request->query;
			if (isset($req['nivel_acesso_id'])) $nivel_acesso_id = $req['nivel_acesso_id'];
			else $nivel_acesso_id = $niveis[0]['NiveisAcesso']['id'];
		}
		$conditions = array(
		);
		if ($nivel_acesso_id != 0) $conditions['Permissao.nivel_acesso_id'] = $nivel_acesso_id;

		$permissoes = $this->Permissao->find('all', array('conditions'=>$conditions));
		
		$this->set('permissoes', $permissoes);
		$this->set('niveis', $niveis);
		$this->set('nivel_acesso_id', $nivel_acesso_id);
		
	}
	
	public function add($nivel_acesso_id = 0) {
		if ($this->request->isPost()){
			$this->Permissao->save($this->data);
			$this->Session->setFlash(__('Permissão gravada com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('/permissoes');
		}
		$this->set('nivel_acesso_id', $nivel_acesso_id);
	}
	
	public function del($permissao_id = null) {
		$this->layout = null;
			
		if ($this->Permissao->delete($permissao_id)) {
			$this->Session->setFlash(__('Permissão excluída com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
		} else {
			$this->Session->setFlash(__('Permissão não pôde ser excluída!',true), 'bootstrap_flash', array('class'=>'alert-error'));
		}
		$this->redirect('index');
	}
}