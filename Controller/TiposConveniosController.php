<?php
App::uses('AppController', 'Controller');
/**
 * TiposConvenios Controller
 *
 */
class TiposConveniosController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','TiposConvenio');
		$this->set('controller', 'tipos_convenios');
		$this->set('del_info', array('TiposConvenio'=>'nome'));
		
		$forms = $this->TiposConvenio->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->TiposConvenio->save($this->data)):
			$this->Session->setFlash(__('Tipo de Convenio gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Tipo de Convenio não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->TiposConvenio->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['TiposConvenio.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->TiposConvenio->find('all', array('conditions'=>$conditions)));
		$this->_variables('TiposConvenios');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_convenios');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona TiposConvenio');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_convenios');
			}
			$this->_save();
		else:
			$this->data = $this->TiposConvenio->read(null, $id);
			$this->_variables('Edita TiposConvenio');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->TiposConvenio->delete($this->data['TiposConvenio']['id'])) {
				$this->Session->setFlash(__('TiposConvenio excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('TiposConvenio não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
