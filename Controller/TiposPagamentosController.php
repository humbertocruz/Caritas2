<?php
App::uses('AppController', 'Controller');
/**
 * TiposPagamentos Controller
 *
 */
class TiposPagamentosController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','TiposPagamento');
		$this->set('controller', 'tipos_pagamentos');
		$this->set('del_info', array('TiposPagamento'=>'nome'));
		
		$forms = $this->TiposPagamento->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->TiposPagamento->save($this->data)):
			$this->Session->setFlash(__('Tipo de Pagamento gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Tipo de Pagamento não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->TiposPagamento->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['TiposPagamento.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->TiposPagamento->find('all', array('conditions'=>$conditions)));
		$this->_variables('Tipo de Pagamento');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_pagamentos');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Tipo de Pagamento');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_pagamentos');
			}
			$this->_save();
		else:
			$this->data = $this->TiposPagamento->read(null, $id);
			$this->_variables('Edita Tipo de Pagamento');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->TiposPagamento->delete($this->data['TiposPagamento']['id'])) {
				$this->Session->setFlash(__('TiposPagamento excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('TiposPagamento não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
