<?php
App::uses('AppController', 'Controller');
/**
 * Editais Controller
 *
 */
class EditaisController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Edital');
		$this->set('controller', 'Editais');
		$this->set('del_info', array('Edital'=>'numero'));
		
		$forms = $this->Edital->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Edital->save($this->data)):
			$this->Session->setFlash(__('Edital gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Editao não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Edital->invalidFields());
		endif;
	}

	public function index() {
		$condEnd = array();
		$sess_models = $this->_sess_models();
		if ($sess_models['Projetos']['id']!=0) {
			$condEnd['Edital.projeto_id'] = $sess_models['Projetos']['id'];
		}
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$condEnd['Edital.numero like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->Edital->find('all', array('conditions'=>$condEnd)));
		$this->_variables('Editais');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/Editais');
			}
			$this->_save();
		endif;
		$orgaos = $this->Edital->Orgao->find('list', array('fields'=>array('id','nome')));
		
		$belongsTo = array('Orgao'=>$orgaos);
		
		$this->set('belongsTo',$belongsTo);		
		$this->_variables('Adiciona Edital');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/Editais');
			}
			$this->_save();
		else:
			$this->data = $this->Edital->read(null, $id);
			$orgaos = $this->Edital->Orgao->find('list', array('fields'=>array('id','nome')));
		
			$belongsTo = array('Orgao'=>$orgaos);
		
			$this->set('belongsTo',$belongsTo);		
			$this->_variables('Edita Edital');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Edital->delete($this->data['Edital']['id'])) {
				$this->Session->setFlash(__('Edital excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Edital não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
