<?php
App::uses('AppController', 'Controller');
/**
 * ChamadasProcedimento Controller
 *
 */
class ChamadasProcedimentosController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','ChamadasProcedimento');
		$this->set('controller', 'chamadas_procedimentos');
		$this->set('del_info', array('ChamadasProcedimento'=>'procedimento'));
		
		$forms = $this->ChamadasProcedimento->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->ChamadasProcedimento->save($this->data)):
			$this->Session->setFlash(__('ChamadasProcedimento gravada com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('ChamadasProcedimento n‹o pode ser gravada!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->ChamadasProcedimento->invalidFields());
		endif;
	}

	public function index() {
		$this->set('data_index', $this->ChamadasProcedimento->find('all'));
		$this->_variables('ChamadasProcedimento');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclus‹o Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/chamadas_procedimentos');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona ChamadasProcedimento');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edi‹o Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/chamadas_procedimentos');
			}
			$this->_save();
		else:
			$this->data = $this->ChamadasProcedimento->read(null, $id);
			$this->_variables('Edita ChamadasProcedimento');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->ChamadasProcedimento->delete($this->data['ChamadasProcedimento']['id'])) {
				$this->Session->setFlash(__('ChamadasProcedimento exclu’da com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('ChamadasProcedimento n‹o p™de ser exclu’da!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
