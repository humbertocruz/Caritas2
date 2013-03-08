<?php
App::uses('AppController', 'Controller');
/**
 * TiposEmails Controller
 *
 */
class TiposEmailsController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','TiposEmail');
		$this->set('controller', 'tipos_emails');
		$this->set('del_info', array('TiposEmail'=>'nome'));
		
		$forms = $this->TiposEmail->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->TiposEmail->save($this->data)):
			$this->Session->setFlash(__('Tipo de Email gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Tipo de Email não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->TiposEmail->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['TiposEmail.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->TiposEmail->find('all', array('conditions'=>$conditions)));
		$this->_variables('TiposEmails');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_emails');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona TiposEmail');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_emails');
			}
			$this->_save();
		else:
			$this->data = $this->TiposEmail->read(null, $id);
			$this->_variables('Edita TiposEmail');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->TiposEmail->delete($this->data['TiposEmail']['id'])) {
				$this->Session->setFlash(__('TiposEmail excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('TiposEmail não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
	
	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->TiposEmail->find('list',array('fields'=>array('id','nome'))));
	}

}
