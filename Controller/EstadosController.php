<?php
App::uses('AppController', 'Controller');
/**
 * Estados Controller
 *
 */
class EstadosController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Estado');
		$this->set('controller', 'estados');
		$this->set('del_info', array('Estado'=>'nome'));
		
		$forms = $this->Estado->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Estado->save($this->data)):
			$this->Session->setFlash(__('Estado gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Estado não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Estado->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['OR'] = array();
			$conditions['OR']['Estado.nome like'] = '%'.$filter_search.'%';
			$conditions['OR']['Estado.id like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->Estado->find('all', array('conditions'=>$conditions)));
		$this->_variables('Estados');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/estados');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Estado');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/estados');
			}
			$this->_save();
		else:
			$this->data = $this->Estado->read(null, $id);
			$this->_variables('Edita Estado');
		endif;
	}
	
	public function del() {
		if ($this->request->isPost()):
			$this->layout = null;		
			$estado = $this->Estado->read(null, $this->data['Estado']['id']);
			$estado['Estado']['lixeira'] = 1;
			$this->Estado->save($estado);
			
			$this->Session->setFlash(__('Estado excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			
			$this->redirect('index');
		endif;
	}
	
	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->Estado->find('list',array('fields'=>array('id','nome'))));
	}
}
