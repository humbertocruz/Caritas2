<?php
App::uses('AppController', 'Controller');
/**
 * Prioridades Controller
 *
 */
class PrioridadesController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Prioridade');
		$this->set('controller', 'prioridades');
		$this->set('del_info', array('Prioridade'=>'nome'));
		
		$forms = $this->Prioridade->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Prioridade->save($this->data)):
			$this->Session->setFlash(__('Prioridade gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Prioridade não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Prioridade->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['Prioridade.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->Prioridade->find('all', array('conditions'=>$conditions)));
		$this->_variables('Prioridades');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/prioridades');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Prioridade');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/prioridades');
			}
			$this->_save();
		else:
			$this->data = $this->Prioridade->read(null, $id);
			$this->_variables('Edita Prioridade');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Prioridade->delete($this->data['Prioridade']['id'])) {
				$this->Session->setFlash(__('Prioridade excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Prioridade não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
