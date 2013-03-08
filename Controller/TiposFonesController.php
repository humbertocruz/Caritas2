<?php
App::uses('AppController', 'Controller');
/**
 * TiposFones Controller
 *
 */
class TiposFonesController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','TiposFone');
		$this->set('controller', 'tipos_fones');
		$this->set('del_info', array('TiposFone'=>'nome'));
		
		$forms = $this->TiposFone->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->TiposFone->save($this->data)):
			$this->Session->setFlash(__('Tipo de Fone gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Tipo de Fone não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->TiposFone->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['TiposFone.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->TiposFone->find('all', array('conditions'=>$conditions)));
		$this->_variables('Tipo de Telefone');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_fones');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Tipo de Telefone');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_fones');
			}
			$this->_save();
		else:
			$this->data = $this->TiposFone->read(null, $id);
			$this->_variables('Edita Tipo de Telefone');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->TiposFone->delete($this->data['TiposFone']['id'])) {
				$this->Session->setFlash(__('TiposFone excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('TiposFone não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}

	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->TiposFone->find('list',array('fields'=>array('id','nome'))));
	}

}
