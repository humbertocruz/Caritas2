<?php
App::uses('AppController', 'Controller');
/**
 * TiposChamadas Controller
 *
 */
class TiposChamadasController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','TiposChamada');
		$this->set('controller', 'tipos_chamadas');
		$this->set('del_info', array('TiposChamada'=>'nome'));
		
		$forms = $this->TiposChamada->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->TiposChamada->save($this->data)):
			$this->Session->setFlash(__('Tipo de Chamada gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Tipo de Chamada não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->TiposChamada->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['TiposChamada.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->TiposChamada->find('all', array('conditions'=>$conditions)));
		$this->_variables('TiposChamadas');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_chamadas');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Tipo de Chamada');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_chamadas');
			}
			$this->_save();
		else:
			$this->data = $this->TiposChamada->read(null, $id);
			$this->_variables('Edita Tipo de Chamada');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->TiposChamada->delete($this->data['TiposChamada']['id'])) {
				$this->Session->setFlash(__('TiposChamada excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('TiposChamada não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
