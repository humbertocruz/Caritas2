<?php
App::uses('AppController', 'Controller');
/**
 * AtaPrecos Controller
 *
 */
class AtaPrecosController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','AtaPreco');
		$this->set('controller', 'ata_precos');
		$this->set('del_info', array('AtaPreco'=>'nome'));
		
		$forms = $this->AtaPreco->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->AtaPreco->save($this->data)):
			$this->Session->setFlash(__('AtaPreco gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('AtaPreco não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->AtaPreco->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['AtaPreco.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->AtaPreco->find('all',array('conditions'=>$conditions)));
		$this->_variables('AtaPrecos');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/ata_precos');
			}
			$this->_save();
		endif;
		$editais = $this->AtaPreco->Edital->find('list', array('fields'=>array('id','numero')));
		$belongsTo = array('Edital'=>$editais);
		$this->set('belongsTo',$belongsTo);		

		$this->_variables('Adiciona Ata de Preço');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/ata_precos');
			}
			$this->_save();
		else:
			$this->data = $this->AtaPreco->read(null, $id);
			$editais = $this->AtaPreco->Edital->find('list', array('fields'=>array('id','numero')));
			$belongsTo = array('Edital'=>$editais);
			$this->set('belongsTo',$belongsTo);		
			$this->_variables('Edita AtaPreco');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->AtaPreco->delete($this->data['AtaPreco']['id'])) {
				$this->Session->setFlash(__('AtaPreco excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('AtaPreco não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
