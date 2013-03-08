<?php
App::uses('AppController', 'Controller');
/**
 * Etapas Controller
 *
 */
class EtapasAtividadesController extends AppController {

	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','EtapasAtividade');
		$this->set('controller', 'etapas_atividades');
		$this->set('del_info', array('EtapasAtividade'=>'atividades_id'));
		$this->set('del_info_value', 0);
		
		$forms = $this->EtapasAtividade->formFields;
		$sess_models = $this->_sess_models();
		$belongsTo = array(
				'Projeto'=>$sess_models['Projetos']['id'],
				'Atividade'=>$this->EtapasAtividade->Atividade->find('list', array('fields'=>array('id','nome'))),
				'Etapa'=>$this->EtapasAtividade->Etapa->find('list', array('fields'=>array('id','nome')))
		);

		$this->set('forms',$forms);
		$this->set('belongsTo', $belongsTo);
	}

	public function _save(){
		$sess_models = AppController::_sess_models();
		$data = $this->data;
		$data['EtapasAtividade']['projeto_id'] = $sess_models['Projetos']['id'];
		if ($this->EtapasAtividade->save($data)):
			$this->Session->setFlash(__('Etapa x Atividade gravadas com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Etapa x Atividae não podem ser gravadas!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Etapa->invalidFields());
		endif;
	}

	public function index() {
		$this->set('data_index', $this->EtapasAtividade->find('all'));
		$this->_variables('Etapas x Atividades');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/etapas_atividades');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Etapa x Atividade');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/etapas_atividades');
			}
			$this->_save();
		else:
			$this->data = $this->Etapa->read(null, $id);
			$this->_variables('Edita Etapa x Atividade');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->EtapasAtividade->delete($this->data['EtapasAtividade']['id'])) {
				$this->Session->setFlash(__('Etapa x Atividade excluída com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Etapa x Atividade não pôde ser excluída!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
