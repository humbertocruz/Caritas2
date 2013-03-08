<?php
App::uses('AppController', 'Controller');
/**
 * TiposEnderecos Controller
 *
 */
class TiposEnderecosController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','TiposEndereco');
		$this->set('controller', 'tipos_enderecos');
		$this->set('del_info', array('TiposEndereco'=>'nome'));
		
		$forms = $this->TiposEndereco->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->TiposEndereco->save($this->data)):
			$this->Session->setFlash(__('Tipo de Endereco gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Tipo de Endereco não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->TiposEndereco->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['TiposEndereco.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->TiposEndereco->find('all', array('conditions'=>$conditions)));
		$this->_variables('TiposEnderecos');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_enderecos');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona TiposEndereco');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_enderecos');
			}
			$this->_save();
		else:
			$this->data = $this->TiposEndereco->read(null, $id);
			$this->_variables('Edita TiposEndereco');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->TiposEndereco->delete($this->data['TiposEndereco']['id'])) {
				$this->Session->setFlash(__('TiposEndereco excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('TiposEndereco não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
	
	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->TiposEndereco->find('list',array('fields'=>array('id','nome'))));
	}
}
