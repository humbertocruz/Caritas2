<?php
App::uses('AppController', 'Controller');

class SituacoesContatosController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','SituacoesContato');
		$this->set('controller', 'situacoes_contatos');
		$this->set('del_info', array('SituacoesContato'=>'nome'));
		
		$forms = $this->SituacoesContato->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->SituacoesContato->save($this->data)):
			$this->Session->setFlash(__('Situações de Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Situações de Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->SituacoesContato->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['SituacoesContato.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->SituacoesContato->find('all', array('conditions'=>$conditions)));
		$this->_variables('SituacoesContatos');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/situacoes_contatos');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Situação de Contato');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/situacoes_contatos');
			}
			$this->_save();
		else:
			$this->data = $this->SituacoesContato->read(null, $id);
			$this->_variables('Edita Situação de Contato');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->SituacoesContato->delete($this->data['SituacoesContato']['id'])) {
				$this->Session->setFlash(__('SituacoesContato excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('SituacoesContato não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
	
	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->SituacoesContato->find('list',array('fields'=>array('id','nome'))));
	}
}
