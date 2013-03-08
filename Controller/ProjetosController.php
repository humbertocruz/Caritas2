<?php
App::uses('AppController', 'Controller');
/**
 * Projetos Controller
 *
 */
class ProjetosController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Projeto');
		$this->set('controller', 'projetos');
		$this->set('del_info', array('Projeto'=>'nome'));
		
		$forms = $this->Projeto->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Projeto->save($this->data)):
			$this->Session->setFlash(__('Projeto gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Projeto não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Projeto->invalidFields());
		endif;
	}

	public function index() {
		// Busca e Filtros
		$conditions = array();
		if ($this->Session->check('filter.search')) {
		$conditions['Projeto.nome like'] = '%'.$this->Session->read('filter.search').'%';
		}
		
		$this->set('data_index', $this->Projeto->find('all', array('conditions'=>$conditions)));
		$this->_variables('Projeto');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/projetos');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Projeto');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/projetos');
			}
			$this->_save();
		else:
			$this->data = $this->Projeto->read(null, $id);
			$this->_variables('Edita Projeto');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Projeto->delete($this->data['Projeto']['id'])) {
				$this->Session->setFlash(__('Projeto excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Projeto não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
	
	public function seleciona($id = null) {
		
		
		if ($id != null) {
			$projeto = $this->Projeto->read(null, $id);
			$texto = $projeto['Projeto']['nome'];
			AppController::_sess_models_write('Projetos', $id, $texto);
			$this->Session->setFlash(__('Projeto Selecionado!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		}
		$this->redirect('/projetos');
	}

	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->Projeto->find('list',array('fields'=>array('id','nome'))));
	}

}
