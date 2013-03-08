<?php
App::uses('AppController', 'Controller');
/**
 * Distribuidores Controller
 *
 */
class DistribuidoresController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Distribuidor');
		$this->set('controller', 'Distribuidores');
		$this->set('del_info', array('Distribuidor'=>'nome'));
		
		$forms = $this->Distribuidor->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Distribuidor->save($this->data)):
			$this->Session->setFlash(__('Distribuidor gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Distribuidor não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Distribuidor->invalidFields());
		endif;
	}

	public function index() {
		$this->set('data_index', $this->Distribuidor->find('all'));
		$this->_variables('Distribuidors');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/Distribuidores');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Distribuidor');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/Distribuidores');
			}
			$this->_save();
		else:
			$this->data = $this->Distribuidor->read(null, $id);
			$this->_variables('Edita Distribuidor');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Distribuidor->delete($this->data['Distribuidor']['id'])) {
				$this->Session->setFlash(__('Distribuidor excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Distribuidor não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
