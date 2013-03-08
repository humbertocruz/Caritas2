<?php
class ContatosFornecedoresController extends AppController {

	public function _variables($header = null, $model = 'Fornecedor') {
		$this->set('header',$header);
		$this->set('model',$model);
		$this->set('controller', 'contatos_fornecedores');
		$this->set('del_info', array('Fornecedor'=>'nome_fantasia'));
		
		$forms = array_merge(
			$this->ContatosFornecedor->formFields,
			$this->ContatosFornecedor->Contato->formFields
		);
				
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Fornecedor->save($this->data)):
			$this->Session->setFlash(__('Fornecedor gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			if ($this->data['continue'] == 0): $this->redirect('index'); else: $this->redirect('edit/'.$this->Fornecedor->id); endif;
		else:
			$this->Session->setFlash(__('Fornecedor não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Fornecedor->invalidFields());
		endif;
	}
	
	public function index() {
	}
	
	public function add() {
		/*
		if ($this->request->isPost()):
			
			if ($this->ContatosFornecedor->save($this->data)):
				$this->Session->setFlash(__('Fornecedor do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosFornecedor']['contato_id'].'#contato');
			else:
				$this->Session->setFlash(__('Fornecedor do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->ContatosFornecedor->invalidFields());
			endif;
					
		endif;
		*/
		$cargos = $this->ContatosFornecedor->Cargo->find('list', array('fields'=>array('id','nome')));
		$situacoes = $this->ContatosFornecedor->SituacoesContato->find('list', array('fields'=>array('id','nome')));
		$contatos = $this->ContatosFornecedor->Contato->find('list', array('fields'=>array('id','nome')));
		
		$belongsTo = array('Cargo'=>$cargos, 'SituacoesContato'=>$situacoes, 'Contato'=>$contatos);
		$this->set('belongsTo',$belongsTo);
		
		$this->_variables('Adiciona Contato de Fornecedor', 'ContatosFornecedor');
		
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			
			if ($this->ContatosFornecedor->save($this->data)):
				$this->Session->setFlash(__('Fornecedor do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosFornecedor']['contato_id'].'#fornecedor');
			else:
				$this->Session->setFlash(__('Fornecedor do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Fornecedor->ContatosFornecedor->read(null, $id);
		$cargos = $this->Fornecedor->ContatosFornecedor->Cargo->find('list', array('fields'=>array('id','nome')));
		$situacoes = $this->Fornecedor->ContatosFornecedor->SituacoesContato->find('list', array('fields'=>array('id','nome')));
		$contatos = $this->Fornecedor->ContatosFornecedor->Contato->find('list', array('fields'=>array('id','nome')));
		
		$belongsTo = array('Cargo'=>$cargos, 'SituacoesContato'=>$situacoes, 'Contato'=>$contatos);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Edita Fornecedor','ContatosFornecedor');
	}
	
}