<?php
App::uses('AppController', 'Controller');
/**
 * Cidades Controller
 *
 */
class CidadesController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Cidade');
		$this->set('controller', 'cidades');
		$this->set('del_info', array('Cidade'=>'nome'));
		
		$forms = $this->Cidade->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Cidade->save($this->data)):
			$this->Session->setFlash(__('Cidade gravada com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Cidade não pode ser gravada!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Cidade->invalidFields());
		endif;
	}
	
	public function findByUf($uf = 'AC') {
		$this->layout = null;
		$cidades = $this->Cidade->find('list', array('fields'=>array('id','nome'), 'conditions'=>array('estado_id'=>$uf)));
		$this->set('cidades', $cidades);
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['Cidade.nome like'] = '%'.$filter_search.'%';
		}
		$this->paginate = array(
			'conditions'=>$conditions
		);
		$this->set('data_index', $this->paginate());
		$this->_variables('Cidades');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/cidades');
			}
			$this->_save();
		endif;
		$estados = $this->Cidade->Estado->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('Estado'=>$estados);
		$this->set('belongsTo',$belongsTo);

		$this->_variables('Adiciona Cidade');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/cidades');
			}
			$this->_save();
		else:
			$this->data = $this->Cidade->read(null, $id);
			$estados = $this->Cidade->Estado->find('list', array('fields'=>array('id','nome')));
			$belongsTo = array('Estado'=>$estados);
			$this->set('belongsTo',$belongsTo);
			$this->_variables('Edita Cidade');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Cidade->delete($this->data['Cidade']['id'])) {
				$this->Session->setFlash(__('Cidade excluída com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Cidade não pôde ser excluída!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
	
	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->Cidade->find('list',array('fields'=>array('id','nome'))));
	}
}
