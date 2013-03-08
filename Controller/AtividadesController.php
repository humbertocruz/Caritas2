<?php
App::uses('AppController', 'Controller');
/**
 * Atividades Controller
 *
 */
class AtividadesController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Atividade');
		$this->set('controller', 'atividades');
		$this->set('del_info', array('Atividade'=>'nome'));
		
		$forms = $this->Atividade->formFields;
		
		$this->set('forms',$forms);
		
	}
	
	public function _save(){
		if ($this->Atividade->save($this->data)):
			$this->Session->setFlash(__('Atividade gravada com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Atividade não pode ser gravada!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Atividade->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['Atividade.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->Atividade->find('all',array('conditions'=>$conditions)));
		$this->_variables('Atividades');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/atividades');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Atividade');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/atividades');
			}
			$this->_save();
		else:
			$this->data = $this->Atividade->read(null, $id);
			$this->_variables('Edita Atividade');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Atividade->delete($this->data['Atividade']['id'])) {
				$this->Session->setFlash(__('Atividade excluída com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Atividade não pôde ser excluída!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
