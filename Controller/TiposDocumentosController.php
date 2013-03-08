<?php
App::uses('AppController', 'Controller');
/**
 * TiposDocumentos Controller
 *
 */
class TiposDocumentosController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','TiposDocumento');
		$this->set('controller', 'tipos_documentos');
		$this->set('del_info', array('TiposDocumento'=>'nome'));
		
		$forms = $this->TiposDocumento->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->TiposDocumento->save($this->data)):
			$this->Session->setFlash(__('Tipo de Documento gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Tipo de Documento não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->TiposDocumento->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['TiposDocumento.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->TiposDocumento->find('all', array('conditions'=>$conditions)));
		$this->_variables('TiposDocumentos');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_documentos');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona TiposDocumento');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/tipos_documentos');
			}
			$this->_save();
		else:
			$this->data = $this->TiposDocumento->read(null, $id);
			$this->_variables('Edita TiposDocumento');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->TiposDocumento->delete($this->data['TiposDocumento']['id'])) {
				$this->Session->setFlash(__('TiposDocumento excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('TiposDocumento não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
