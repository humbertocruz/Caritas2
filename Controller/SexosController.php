<?php
App::uses('AppController', 'Controller');

class SexosController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Sexo');
		$this->set('controller', 'sexos');
		$this->set('del_info', array('Sexo'=>'nome'));
		
		$forms = $this->Sexo->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Sexo->save($this->data)):
			$this->Session->setFlash(__('Sexo gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Sexo não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Sexo->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['Sexo.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->Sexo->find('all', array('conditions'=>$conditions)));
		$this->_variables('Sexos');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/sexos');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Sexo');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/sexos');
			}
			$this->_save();
		else:
			$this->data = $this->Sexo->read(null, $id);
			$this->_variables('Edita Sexo');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Sexo->delete($this->data['Sexo']['id'])) {
				$this->Session->setFlash(__('Sexo excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Sexo não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
	
	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->Sexo->find('list',array('fields'=>array('id','nome'))));
	}
}
