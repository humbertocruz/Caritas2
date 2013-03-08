<?php
App::uses('AppController', 'Controller');
/**
 * ContatosEmails Controller
 *
 */
class ContatosEmailsController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','ContatosEmail');
		$this->set('controller', 'contatos_emails');
		$this->set('del_info', 'email');
				
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->ContatosEmail->save($this->data)):
			$this->Session->setFlash(__('ContatosEmail gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('ContatosEmail não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->ContatosEmail->invalidFields());
		endif;
	}

	public function index() {
		$this->set('data_index', $this->ContatosEmail->find('all'));
		$this->_variables('ContatosEmails');
	}
	
	public function add() {
		if ($this->request->isPost()):
			$this->_save();
		endif;
		$this->_variables('Adiciona ContatosEmail');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			$this->_save();
		else:
			$this->data = $this->ContatosEmail->read(null, $id);
			$this->_variables('Edita ContatosEmail');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->ContatosEmail->delete($this->data['ContatosEmail']['id'])) {
				$this->Session->setFlash(__('ContatosEmail excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('ContatosEmail não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
