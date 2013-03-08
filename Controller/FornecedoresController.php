<?php
App::uses('AppController', 'Controller');
/**
 * Fornecedores Controller
 *
 */
class FornecedoresController extends AppController {

	public function _variables($header = null, $model = 'Fornecedor') {
		$this->set('header',$header);
		$this->set('model',$model);
		$this->set('controller', 'fornecedores');
		$this->set('del_info', array(
			'Fornecedor'=>'nome_fantasia',
			'FornecedoresEmail'=>'email',
			'FornecedoresFone'=>'fone',
			'FornecedoresEndereco'=>'endereco',
			'Contato'=>'nome'
		));
		$this->set('source_model', 'Fornecedor');

		
		$forms = array_merge(
			$this->Fornecedor->formFields, 
			$this->Fornecedor->FornecedoresEmail->formFields, 
			$this->Fornecedor->FornecedoresFone->formFields, 
			$this->Fornecedor->FornecedoresEndereco->formFields,
			$this->Fornecedor->ContatosFornecedor->formFields,
			$this->Fornecedor->ContatosFornecedor->Contato->formFields
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
		$this->Session->delete('hasMany_source');
		$cond = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$cond['OR'] = array();
			$cond['OR']['Fornecedor.razao_social like'] = '%'.$filter_search.'%';
			$cond['OR']['Fornecedor.cnpj like'] = '%'.$filter_search.'%';
			$cond['OR']['Fornecedor.nome_fantasia like'] = '%'.$filter_search.'%';
			$cond['OR']['Fornecedor.inscricao_estadual like'] = '%'.$filter_search.'%';
		}

		$this->paginate = array(
			'conditions'=>$cond
		);
		$this->set('data_index', $this->paginate());
		$this->_variables('Fornecedores','Fornecedor');
	}
	
	public function add() {
		if ($this->request->isPost()):
			// Verifica se foi pressionado o botao Cancelar
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Adição Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/fornecedores');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Fornecedor','Fornecedor');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			// Verifica se foi pressionado o botao Cancelar
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/fornecedores');
			}
			$this->_save();
		else:
			$this->data = $this->Fornecedor->read(null, $id);
			$this->_variables('Edita Fornecedor', 'Fornecedor');
		endif;
	}
	
	public function del() {
		if ($this->request->isPost()):
			$this->layout = null;
			$fornecedor = $this->Fornecedor->read(null, $this->data['Fornecedor']['id']);
						
			if ($this->Fornecedor->delete($this->data['Fornecedor']['id'])) {
				$this->Session->setFlash(__('Fornecedor excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Fornecedor não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
	
	public function addContatosFornecedor($id = null) {
		if ($this->request->isPost()):
			// Verifica se foi pressionado o botao Cancelar
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Alterações Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['ContatosFornecedor']['fornecedor_id'].'#contato');
			}
			
			if ($this->Fornecedor->ContatosFornecedor->save($this->data)):
				$this->Session->setFlash(__('Fornecedor do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosFornecedor']['fornecedor_id'].'#contato');
			else:
				$this->Session->setFlash(__('Fornecedor do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Fornecedor->read(null, $id);
		$cargos = $this->Fornecedor->ContatosFornecedor->Cargo->find('list', array('fields'=>array('id','nome')));
		$situacoes = $this->Fornecedor->ContatosFornecedor->SituacoesContato->find('list', array('fields'=>array('id','nome')));
		$contatos = $this->Fornecedor->ContatosFornecedor->Contato->find('list', array('fields'=>array('id','nome'),'conditions'=>array('Contato.id'=>0)));
		$this->set('source_model','Fornecedor');
		
		$belongsTo = array('Cargo'=>$cargos, 'SituacoesContato'=>$situacoes, 'Contato'=>$contatos);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Adiciona Contato de Fornecedor', 'ContatosFornecedor');
	}
	
	public function editContatosFornecedor($id = null) {
		// Carrega ID do campo pesquisado
		if ($this->request->isPost()):
			// Verifica se foi pressionado o botao Cancelar
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Alterações Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['ContatosFornecedor']['fornecedor_id'].'#contato');
			}
			
			if ($this->Fornecedor->ContatosFornecedor->save($this->data)):
				$this->Session->setFlash(__('Fornecedor do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosFornecedor']['fornecedor_id'].'#contato');
			else:
				$this->Session->setFlash(__('Fornecedor do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Fornecedor->ContatosFornecedor->read(null, $id);
		$cargos = $this->Fornecedor->ContatosFornecedor->Cargo->find('list', array('fields'=>array('id','nome')));
		$situacoes = $this->Fornecedor->ContatosFornecedor->SituacoesContato->find('list', array('fields'=>array('id','nome')));
		$contatos = $this->Fornecedor->ContatosFornecedor->Contato->find('list', array('fields'=>array('id','nome'),'conditions'=>array('Contato.id'=>$this->data['Contato']['id'])));
		
		$this->set('source_model','Fornecedor');
		
		$belongsTo = array('Cargo'=>$cargos, 'SituacoesContato'=>$situacoes, 'Contato'=>$contatos);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Edita Contato de Fornecedor','ContatosFornecedor');
	}
	
	public function delContatosFornecedor($id = null) {
		$this->layout = null;
		$this->Fornecedor->ContatosFornecedor->delete($this->data['ContatosFornecedor']['id']);
		$this->Session->setFlash(__('Contato do Fornecedor excluído com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->redirect('edit/'.$this->data['Fornecedor']['id'].'#contato');	
	}
	
	public function addFornecedoresEmail($id = null) {
		if ($this->request->isPost()):
			// Verifica se foi pressionado o botao Cancelar
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Alterações Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['FornecedoresEmail']['fornecedor_id'].'#email');
			}
			if ($this->Fornecedor->FornecedoresEmail->save($this->data)):
				$this->Session->setFlash(__('Email do Fornecedor gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['FornecedoresEmail']['fornecedor_id'].'#email');
			else:
				$this->Session->setFlash(__('Email do Fornecedor não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Fornecedor->FornecedoresEmail->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Fornecedor->read(null, $id);
		$source = array('FornecedoresEmail'=>$this->Fornecedor->FornecedoresEmail->formFields);	
		$this->set('source', $source);
		$tipos_email = $this->Fornecedor->FornecedoresEmail->TiposEmail->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('TiposEmail'=>$tipos_email);
		$this->set('belongsTo',$belongsTo);
			
		$this->_variables('Adiciona Email do Fornecedor', 'FornecedoresEmail');
	}
	
	public function editFornecedoresEmail($id) {
		if ($this->request->isPost()):			
			// Verifica se foi pressionado o botao Cancelar
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Alterações Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['FornecedoresEmail']['fornecedor_id'].'#email');
			}
			if ($this->Fornecedor->FornecedoresEmail->save($this->data)):
				$this->Session->setFlash(__('Email do Fornecedor gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['FornecedoresEmail']['fornecedor_id'].'#email');
			else:
				$this->Session->setFlash(__('Email do Fornecedor não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Fornecedor->FornecedoresEmail->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Fornecedor->FornecedoresEmail->read(null, $id);
		$source = array('FornecedoresEmail'=>$this->Fornecedor->FornecedoresEmail->formFields);	
		$this->set('source', $source);
		$tipos_email = $this->Fornecedor->FornecedoresEmail->TiposEmail->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('TiposEmail'=>$tipos_email);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Edita Email do Fornecedor','FornecedoresEmail');
	}
	
	public function delFornecedoresEmail($id = null) {
		$this->layout = null;
		$this->Fornecedor->FornecedoresEmail->delete($this->data['FornecedoresEmail']['id']);
		$this->Session->setFlash(__('Email do Fornecedor excluído com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->redirect('edit/'.$this->data['Fornecedor']['id'].'#email');	
	}


	public function addFornecedoresFone($id = null) {
		if ($this->request->isPost()):
			// Verifica se foi pressionado o botao Cancelar
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Alterações Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['FornecedoresFone']['fornecedor_id'].'#fone');
			}
			if ($this->Fornecedor->FornecedoresFone->save($this->data)):
				$this->Session->setFlash(__('Telefone do Fornecedor gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['FornecedoresFone']['fornecedor_id'].'#fone');
			else:
				$this->Session->setFlash(__('Telefone do Fornecedor não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Fornecedor->FornecedoresFone->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Fornecedor->read(null, $id);
		$source = array('FornecedoresEmail'=>$this->Fornecedor->FornecedoresFone->formFields);	
		$this->set('source', $source);
		$tipos_fone = $this->Fornecedor->FornecedoresFone->TiposFone->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('TiposFone'=>$tipos_fone);
		$this->set('belongsTo',$belongsTo);
			
		$this->_variables('Adiciona Telefone do Fornecedor','FornecedoresFone');
	}
	
	public function editFornecedoresFone($id) {
		if ($this->request->isPost()):
			// Verifica se foi pressionado o botao Cancelar
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Alterações Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['FornecedoresFone']['fornecedor_id'].'#fone');
			}

			if ($this->Fornecedor->FornecedoresFone->save($this->data)):
				$this->Session->setFlash(__('Telefone do Fornecedor gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['FornecedoresFone']['fornecedor_id'].'#fone');
			else:
				$this->Session->setFlash(__('Email do Fornecedor não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Fornecedor->FornecedoresFone->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Fornecedor->FornecedoresFone->read(null, $id);
		$source = array('FornecedoresFone'=>$this->Fornecedor->FornecedoresFone->formFields);	
		$this->set('source', $source);
		$tipos_fone = $this->Fornecedor->FornecedoresFone->TiposFone->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('TiposFone'=>$tipos_fone);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Edita Telefone do Fornecedor','FornecedoresFone');
	}
	
	public function delFornecedoresFone($id = null) {
		$this->layout = null;
		$this->Fornecedor->FornecedoresFone->delete($this->data['FornecedoresFone']['id']);
		$this->Session->setFlash(__('Telefoe do Fornecedor excluído com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->redirect('edit/'.$this->data['Fornecedor']['id'].'#fone');	
	}


	public function addFornecedoresEndereco($id = null) {
		if ($this->request->isPost()):
			// Verifica se foi pressionado o botao Cancelar
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Alterações Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['FornecedoresEndereco']['fornecedor_id'].'#endereco');
			}
			if ($this->Fornecedor->FornecedoresEndereco->save($this->data)):
				$this->Session->setFlash(__('Endereço do Fornecedor gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['FornecedoresEndereco']['fornecedor_id'].'#endereco');
			else:
				$this->Session->setFlash(__('Endereço do Fornecedor não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Fornecedor->FornecedoresEndereco->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Fornecedor->read(null, $id);
		$source = array('FornecedoresEmail'=>$this->Fornecedor->FornecedoresEndereco->formFields);	
		$this->set('source', $source);

		$tipos_endereco = $this->Fornecedor->FornecedoresEndereco->TiposEndereco->find('list', array('fields'=>array('id','nome')));
		$estados = $this->Fornecedor->FornecedoresEndereco->Cidade->Estado->find('list', array('fields'=>array('id','nome')));
		$cidades = $this->Fornecedor->FornecedoresEndereco->Cidade->find('list', array('fields'=>array('id','nome'),'conditions'=>array('estado_id'=>'AC')));
		
		$belongsTo = array('TiposEndereco'=>$tipos_endereco,'Estado'=>$estados,'Cidade'=>$cidades);
		
		$this->set('belongsTo',$belongsTo);
			
		$this->_variables('Adiciona Endereço do Fornecedor','FornecedoresEndereco');
	}
	
	public function editFornecedoresEndereco($id) {
		if ($this->request->isPost()):
			// Verifica se foi pressionado o botao Cancelar
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Alterações Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['FornecedoresEndereco']['fornecedor_id'].'#endereco');
			}
			
			if ($this->Fornecedor->FornecedoresEndereco->save($this->data)):
				$this->Session->setFlash(__('Endereço do Fornecedor gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['FornecedoresEndereco']['fornecedor_id'].'#endereco');
			else:
				$this->Session->setFlash(__('Endereço do Fornecedor não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Fornecedor->FornecedoresEndereco->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Fornecedor->FornecedoresEndereco->read(null, $id);
		$source = array('FornecedoresEndereco'=>$this->Fornecedor->FornecedoresEndereco->formFields);	
		$this->set('source', $source);
		
		$tipos_endereco = $this->Fornecedor->FornecedoresEndereco->TiposEndereco->find('list', array('fields'=>array('id','nome')));
		$estados = $this->Fornecedor->FornecedoresEndereco->Cidade->Estado->find('list', array('fields'=>array('id','nome')));
		$cidades = $this->Fornecedor->FornecedoresEndereco->Cidade->find('list', array('fields'=>array('id','nome'),'conditions'=>array('estado_id'=>$this->data['Cidade']['estado_id'])));
		
		$belongsTo = array('TiposEndereco'=>$tipos_endereco,'Estado'=>$estados,'Cidade'=>$cidades);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Endereço do Fornecedor','FornecedoresEndereco');
	}
	
	public function delFornecedoresEndereco($id = null) {
		$this->layout = null;
		$this->Fornecedor->FornecedoresEndereco->delete($this->data['FornecedoresEndereco']['id']);
		$this->Session->setFlash(__('Endereço do Fornecedor excluído com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->redirect('edit/'.$this->data['Fornecedor']['id'].'#endereco');	
	}

}
