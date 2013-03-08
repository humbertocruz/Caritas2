<?php
App::uses('AppController', 'Controller');
/**
 * Orgaos Controller
 *
 */
class OrgaosController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Orgao');
		$this->set('controller', 'orgaos');
		$this->set('del_info', array('Orgao'=>'nome'));
		
		$forms = $this->Orgao->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Orgao->save($this->data)):
			$this->Session->setFlash(__('Orgão gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Orgão não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Orgao->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['Orgao.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->Orgao->find('all', array('conditions'=>$conditions)));
		$this->_variables('Orgãos');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/orgaos');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Orgão');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/orgaos');
			}
			$this->_save();
		else:
			$this->data = $this->Orgao->read(null, $id);
			$this->_variables('Edita Orgão');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Orgao->delete($this->data['Orgao']['id'])) {
				$this->Session->setFlash(__('Orgão excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Orgao não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
