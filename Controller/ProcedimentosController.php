<?php
App::uses('AppController', 'Controller');
/**
 * Procedimentos Controller
 *
 */
class ProcedimentosController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Procedimento');
		$this->set('controller', 'Procedimentos');
		$this->set('del_info', array('Procedimento'=>'nome'));
		
		$forms = $this->Procedimento->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Procedimento->save($this->data)):
			$this->Session->setFlash(__('Procedimento gravada com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Procedimento não pode ser gravada!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Procedimento->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['Procedimento.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->Procedimento->find('all', array('conditions'=>$conditions)));
		$this->_variables('Procedimentos');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/Procedimentos');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Procedimento');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/Procedimentos');
			}
			$this->_save();
		else:
			$this->data = $this->Procedimento->read(null, $id);
			$this->_variables('Edita Procedimento');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Procedimento->delete($this->data['Procedimento']['id'])) {
				$this->Session->setFlash(__('Procedimento excluída com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Procedimento não pôde ser excluída!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
	
	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->Procedimento->find('list',array('fields'=>array('id','nome'))));
	}
}
