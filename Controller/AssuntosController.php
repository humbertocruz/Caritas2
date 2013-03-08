<?php
App::uses('AppController', 'Controller');

class AssuntosController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Assunto');
		$this->set('controller', 'assuntos');
		$this->set('del_info', array('Assunto'=>'nome'));
		
		$forms = $this->Assunto->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Assunto->save($this->data)):
			$this->Session->setFlash(__('Assunto gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Assunto não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Assunto->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['Assunto.nome like'] = '%'.$filter_search.'%';
		}

		$this->set('data_index', $this->Assunto->find('all', array('conditions'=>$conditions)));
		$this->_variables('Assuntos');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/assuntos');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Assunto');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/assuntos');
			}
			$this->_save();
		else:
			$this->data = $this->Assunto->read(null, $id);
			$this->_variables('Edita Assunto');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Assunto->delete($this->data['Assunto']['id'])) {
				$this->Session->setFlash(__('Assunto excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Assunto não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
