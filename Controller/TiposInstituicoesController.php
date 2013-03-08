<?php
App::uses('AppController', 'Controller');
/**
 * TiposInstituicoes Controller
 *
 */
class TiposInstituicoesController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','TiposInstituicao');
		$this->set('controller', 'tipos_instituicoes');
		$this->set('del_info', array('TiposInstituicao'=>'nome'));
		
		$forms = $this->TiposInstituicao->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->TiposInstituicao->save($this->data)):
			$this->Session->setFlash(__('Tipo de Instituicao gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Tipo de Instituicao não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->TiposInstituicao->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['TiposInstituicao.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->TiposInstituicao->find('all', array('conditions'=>$conditions)));
		$this->_variables('Tipo de Instituição');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_instituicoes');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Tipo de Instituição');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_instituicoes');
			}
			$this->_save();
		else:
			$this->data = $this->TiposInstituicao->read(null, $id);
			$this->_variables('Edita TiposInstituicao');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->TiposInstituicao->delete($this->data['TiposInstituicao']['id'])) {
				$this->Session->setFlash(__('Tipo de Instituição excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Tipo de Instituição não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
	
	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->TiposInstituicao->find('list',array('fields'=>array('id','nome'))));
	}
}
