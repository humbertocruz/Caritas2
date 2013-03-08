<?php
App::uses('AppController', 'Controller');
/**
 * Etapas Controller
 *
 */
class EtapasController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Etapa');
		$this->set('controller', 'etapas');
		$this->set('del_info', array('Etapa'=>'nome'));
		
		$forms = $this->Etapa->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Etapa->save($this->data)):
			$this->Session->setFlash(__('Etapa gravada com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Etapa não pode ser gravada!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Etapa->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['Etapa.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->Etapa->find('all', array('conditions'=>$conditions)));
		$this->_variables('Etapas');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/etapas');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Etapa');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/etapas');
			}
			$this->_save();
		else:
			$this->data = $this->Etapa->read(null, $id);
			$this->_variables('Edita Etapa');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Etapa->delete($this->data['Etapa']['id'])) {
				$this->Session->setFlash(__('Etapa excluída com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Etapa não pôde ser excluída!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
