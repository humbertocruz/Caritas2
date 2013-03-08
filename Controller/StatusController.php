<?php
App::uses('AppController', 'Controller');
/**
 * Status Controller
 *
 */
class StatusController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Status');
		$this->set('controller', 'Status');
		$this->set('del_info', array('Status'=>'nome'));
		
		$forms = $this->Status->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Status->save($this->data)):
			$this->Session->setFlash(__('Status gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Status não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Status->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['Status.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->Status->find('all', array('conditions'=>$conditions)));
		$this->_variables('Status');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/Status');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Status');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/Status');
			}
			$this->_save();
		else:
			$this->data = $this->Status->read(null, $id);
			$this->_variables('Edita Status');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Status->delete($this->data['Status']['id'])) {
				$this->Session->setFlash(__('Status excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Status não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
