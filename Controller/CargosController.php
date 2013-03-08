<?php
App::uses('AppController', 'Controller');
/**
 * Cargos Controller
 *
 */
class CargosController extends AppController {

	public function variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Cargo');
		$this->set('controller', 'cargos');
		$this->set('del_info', array('Cargo'=>'nome'));
		
		$forms = $this->Cargo->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function save(){
		if ($this->Cargo->save($this->data)):
			$this->Session->setFlash(__('Cargo gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Cargo não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Cargo->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['Cargo.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->Cargo->find('all', array('conditions'=>$conditions)));
		$this->variables('Cargos');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/cargos');
			}
			$this->save();
		endif;
		$this->variables('Adiciona Cargo');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/cargos');
			}
			$this->save();
		else:
			$this->data = $this->Cargo->read(null, $id);
			$this->variables('Edita Cargo');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Cargo->delete($this->data['Cargo']['id'])) {
				$this->Session->setFlash(__('Cargo excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Cargo não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
