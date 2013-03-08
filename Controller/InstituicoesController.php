<?php
App::uses('AppController', 'Controller');
/**
 * Instituicoes Controller
 *
 */
class InstituicoesController extends AppController {

	public function _variables($header = null, $model = 'Instituicao') {
		$this->set('header',$header);
		$this->set('model',$model);
		$this->set('del_info', array(
			'Instituicao'=>'nome_fantasia',
			'InstituicoesEmail'=>'email',
			'InstituicoesFone'=>'fone',
			'InstituicoesEndereco'=>'endereco',
			'Contato'=>'nome'
		));
		
		$this->set('controller', 'instituicoes');
		$this->set('source_model', 'Instituicao');

		
		$forms = array_merge(
			$this->Instituicao->formFields, 
			$this->Instituicao->InstituicoesEmail->formFields, 
			$this->Instituicao->InstituicoesFone->formFields, 
			$this->Instituicao->InstituicoesEndereco->formFields,
			$this->Instituicao->ContatosInstituicao->formFields,
			$this->Instituicao->ContatosInstituicao->Contato->formFields
		);
				
		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Instituicao->save($this->data)):
			$this->Session->setFlash(__('Instituição gravada com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			if ($this->data['continue'] == 0): $this->redirect('index'); else: $this->redirect('edit/'.$this->Instituicao->id); endif;
		else:
			$this->Session->setFlash(__('Instituição não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Instituicao->invalidFields());
		endif;
	}

	public function index() {
		$this->Session->delete('hasMany_source');
		$condEnd = array();		
		$cond = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$cond['OR'] = array();
			$cond['OR']['Instituicao.razao_social like'] = '%'.$filter_search.'%';
			$cond['OR']['Instituicao.cnpj like'] = '%'.$filter_search.'%';
			$cond['OR']['Instituicao.nome_fantasia like'] = '%'.$filter_search.'%';
			$cond['OR']['Instituicao.inscricao_estadual like'] = '%'.$filter_search.'%';
		}

		if (count($condEnd) > 0) {
			$enderecos = $this->Instituicao->InstituicoesEndereco->find('all', array('conditions'=>$condEnd, 'fields'=>array('Instituicao.id')));
			$list_inst = array();
			foreach($enderecos as $inst) {
				array_push($list_inst, $inst['Instituicao']['id']);
			}
			$cond['Instituicao.id'] = $list_inst;
		}
		if ( $this->Session->check('filter') ) {
			$filter_sess = $this->Session->read('filter');
			
			$this->set('filters_sess',$filter_sess);

			if (isset($filter_sess['cidade']) && $filter_sess['cidade'] != '0') {
				$condEnd['InstituicoesEndereco.cidade_id'] = $filter_sess['cidade'];
			}
			if (isset($filter_sess['tipo_instituicao']) && $filter_sess['tipo_instituicao'] != '0') {
				$cond['Instituicao.tipo_instituicao_id'] = $filter_sess['tipo_instituicao'];
			}
			/*
			if (isset($filter_sess['search']) && $filter_sess['search'] != '') {
				$condEnd['OR'] = array(
					'Contato.nome like' => '%'.$filter_sess['search'].'%',
					'Instituicao.nome_fantasia like' => '%'.$filter_sess['search'].'%',
					'Fornecedor.nome_fantasia like' => '%'.$filter_sess['search'].'%',
					'Chamada.solicitacao like' => '%'.$filter_sess['search'].'%'
				);
			}
			*/
		}
		if (count($condEnd) != 0) {
			$instituicao_id = $this->Instituicao->InstituicoesEndereco->find('list', array('conditions'=>$condEnd, 'fields'=>array('InstituicoesEndereco.instituicao_id')));
			$cond['Instituicao.id'] = $instituicao_id;
		}
		
		$this->set('filter_form', array('filter/uf_cidade','filter/tipo_instituicao'));
		$filter_data = array(
			'Estado'=>$this->Instituicao->InstituicoesEndereco->Cidade->Estado->find('all'),
			'Cidade'=>array('Cidade'=>array()),
			'TiposInstituicao' => $this->Instituicao->TiposInstituicao->find('all')
		);
		$this->set('filter_data', $filter_data);
		$this->paginate = array(
			'conditions'=>$cond
		);
		$this->set('data_index', $this->paginate());
		$this->_variables('Instituições','Instituicao');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Adição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/instituicoes');
			}
			$this->_save();
		endif;
		$tipos_instituicao = $this->Instituicao->TiposInstituicao->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('TiposInstituicao'=>$tipos_instituicao);
		$this->set('belongsTo',$belongsTo);
		
		$this->_variables('Adiciona Instituição','Instituicao');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/instituicoes');
			}
			$this->_save();
		else:
			$this->data = $this->Instituicao->read(null, $id);
			$tipos_instituicao = $this->Instituicao->TiposInstituicao->find('list', array('fields'=>array('id','nome')));
			$belongsTo = array('TiposInstituicao'=>$tipos_instituicao);
			$this->set('belongsTo',$belongsTo);
			$this->_variables('Edita Instituição', 'Instituicao');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Instituicao->delete($this->data['Instituicao']['id'])) {
				$this->Session->setFlash(__('Instituicao excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Instituicao não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
	
	public function addContatosInstituicao($id = null) {
		// Se vier dados via POST
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Adição Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['ContatosInstituicao']['instituicao_id'].'#contato');
			}			
			if ($this->Instituicao->ContatosInstituicao->save($this->data)):
				$this->Session->setFlash(__('Instituicao do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosInstituicao']['instituicao_id'].'#contato');
			else:
				$this->Session->setFlash(__('Instituicao do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Instituicao->read(null, $id);
		$cargos = $this->Instituicao->ContatosInstituicao->Cargo->find('list', array('fields'=>array('id','nome')));
		$situacoes = $this->Instituicao->ContatosInstituicao->SituacoesContato->find('list', array('fields'=>array('id','nome')));
		$contatos = $this->Instituicao->ContatosInstituicao->Contato->find('list', array('fields'=>array('id','nome'),'conditions'=>array('Contato.id'=>0)));
		$this->set('source_model','Instituicao');
		
		$belongsTo = array('Cargo'=>$cargos, 'SituacoesContato'=>$situacoes, 'Contato'=>$contatos);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Adiciona Contato de Instituicao', 'ContatosInstituicao');
	}
	public function editContatosInstituicao($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['ContatosInstituicao']['instituicao_id'].'#contato');
			}			
			
			if ($this->Instituicao->ContatosInstituicao->save($this->data)):
				$this->Session->setFlash(__('Instituicao do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosInstituicao']['instituicao_id'].'#contato');
			else:
				$this->Session->setFlash(__('Instituicao do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Instituicao->ContatosInstituicao->read(null, $id);
		$cargos = $this->Instituicao->ContatosInstituicao->Cargo->find('list', array('fields'=>array('id','nome')));
		$situacoes = $this->Instituicao->ContatosInstituicao->SituacoesContato->find('list', array('fields'=>array('id','nome')));
		$contatos = $this->Instituicao->ContatosInstituicao->Contato->find('list', array('fields'=>array('id','nome'),'conditions'=>array('Contato.id'=>$this->data['Contato']['id'])));

		$this->set('source_model','Instituicao');

		$belongsTo = array('Cargo'=>$cargos, 'SituacoesContato'=>$situacoes, 'Contato'=>$contatos);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Edita Instituicao', 'ContatosInstituicao');
	}
	
	public function delContatosInstituicao($id = null) {
		$this->layout = null;
		$this->Instituicao->ContatosInstituicao->delete($this->data['ContatosInstituicao']['id']);
		$this->Session->setFlash(__('Contato da Instituição excluído com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->redirect('edit/'.$this->data['Instituicao']['id'].'#contato');	
	}
	
	public function addInstituicoesEmail($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Adição Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['InstituicoesEmail']['instituicao_id'].'#email');
			}			

			if ($this->Instituicao->InstituicoesEmail->save($this->data)):
				$this->Session->setFlash(__('Email do Instituicao gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['InstituicoesEmail']['instituicao_id'].'#email');
			else:
				$this->Session->setFlash(__('Email do Instituicao não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Instituicao->InstituicoesEmail->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Instituicao->read(null, $id);
		$source = array('InstituicoesEmail'=>$this->Instituicao->InstituicoesEmail->formFields);	
		$this->set('source', $source);
		$tipos_email = $this->Instituicao->InstituicoesEmail->TiposEmail->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('TiposEmail'=>$tipos_email);
		$this->set('belongsTo',$belongsTo);
			
		$this->_variables('Adiciona Email do Instituicao', 'InstituicoesEmail');
	}
	
	public function editInstituicoesEmail($id) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['InstituicoesEmail']['instituicao_id'].'#email');
			}			
			if ($this->Instituicao->InstituicoesEmail->save($this->data)):
				$this->Session->setFlash(__('Email do Instituicao gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['InstituicoesEmail']['instituicao_id'].'#email');
			else:
				$this->Session->setFlash(__('Email do Instituicao não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Instituicao->InstituicoesEmail->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Instituicao->InstituicoesEmail->read(null, $id);
		$source = array('InstituicoesEmail'=>$this->Instituicao->InstituicoesEmail->formFields);	
		$this->set('source', $source);
		$tipos_email = $this->Instituicao->InstituicoesEmail->TiposEmail->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('TiposEmail'=>$tipos_email);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Edita Email do Instituicao','InstituicoesEmail');
	}

	public function delInstituicoesEmail($id = null) {
		$this->layout = null;
		$this->Instituicao->InstituicoesEmail->delete($this->data['InstituicoesEmail']['id']);
		$this->Session->setFlash(__('Email da Instituição excluído com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->redirect('edit/'.$this->data['Instituicao']['id'].'#email');	
	}

	public function addInstituicoesFone($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Adição Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['InstituicoesFone']['instituicao_id'].'#fone');
			}			
			if ($this->Instituicao->InstituicoesFone->save($this->data)):
				$this->Session->setFlash(__('Telefone do Instituicao gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['InstituicoesFone']['instituicao_id'].'#fone');
			else:
				$this->Session->setFlash(__('Telefone do Instituicao não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Instituicao->InstituicoesFone->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Instituicao->read(null, $id);
		$source = array('InstituicoesEmail'=>$this->Instituicao->InstituicoesFone->formFields);	
		$this->set('source', $source);
		$tipos_fone = $this->Instituicao->InstituicoesFone->TiposFone->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('TiposFone'=>$tipos_fone);
		$this->set('belongsTo',$belongsTo);
			
		$this->_variables('Adiciona Telefone do Instituicao','InstituicoesFone');
	}
	
	public function editInstituicoesFone($id) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['InstituicoesFone']['instituicao_id'].'#fone');
			}			

			if ($this->Instituicao->InstituicoesFone->save($this->data)):
				$this->Session->setFlash(__('Telefone do Instituicao gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['InstituicoesFone']['instituicao_id'].'#fone');
			else:
				$this->Session->setFlash(__('Email do Instituicao não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Instituicao->InstituicoesFone->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Instituicao->InstituicoesFone->read(null, $id);
		$source = array('InstituicoesFone'=>$this->Instituicao->InstituicoesFone->formFields);	
		$this->set('source', $source);
		$tipos_fone = $this->Instituicao->InstituicoesFone->TiposFone->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('TiposFone'=>$tipos_fone);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Edita Telefone do Instituicao','InstituicoesFone');
	}

	public function delInstituicoesFone($id = null) {
		$this->layout = null;
		$this->Instituicao->InstituicoesFone->delete($this->data['InstituicoesFone']['id']);
		$this->Session->setFlash(__('Telefone da Instituição excluído com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->redirect('edit/'.$this->data['Instituicao']['id'].'#fone');	
	}
	

	public function addInstituicoesEndereco($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Adição Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['InstituicoesEndereco']['instituicao_id'].'#endereco');
			}			
			if ($this->Instituicao->InstituicoesEndereco->save($this->data)):
				$this->Session->setFlash(__('Endereço do Instituicao gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['InstituicoesEndereco']['instituicao_id'].'#endereco');
			else:
				$this->Session->setFlash(__('Endereço do Instituicao não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Instituicao->InstituicoesEndereco->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Instituicao->read(null, $id);
		$source = array('InstituicoesEmail'=>$this->Instituicao->InstituicoesEndereco->formFields);	
		$this->set('source', $source);

		$tipos_endereco = $this->Instituicao->InstituicoesEndereco->TiposEndereco->find('list', array('fields'=>array('id','nome')));
		$estados = $this->Instituicao->InstituicoesEndereco->Cidade->Estado->find('list', array('fields'=>array('id','nome')));
		$cidades = $this->Instituicao->InstituicoesEndereco->Cidade->find('list', array('fields'=>array('id','nome'),'conditions'=>array('estado_id'=>'AC')));
		
		$belongsTo = array('TiposEndereco'=>$tipos_endereco,'Estado'=>$estados,'Cidade'=>$cidades);
		
		$this->set('belongsTo',$belongsTo);
			
		$this->_variables('Adiciona Endereço do Instituicao','InstituicoesEndereco');
	}
	
	public function editInstituicoesEndereco($id) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Canceladas!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['InstituicoesEndereco']['instituicao_id'].'#endereco');
			}			
			
			if ($this->Instituicao->InstituicoesEndereco->save($this->data)):
				$this->Session->setFlash(__('Endereço do Instituicao gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['InstituicoesEndereco']['instituicao_id'].'#endereco');
			else:
				$this->Session->setFlash(__('Endereço do Instituicao não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Instituicao->InstituicoesEndereco->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Instituicao->InstituicoesEndereco->read(null, $id);
		$source = array('InstituicoesEndereco'=>$this->Instituicao->InstituicoesEndereco->formFields);	
		$this->set('source', $source);
		
		$tipos_endereco = $this->Instituicao->InstituicoesEndereco->TiposEndereco->find('list', array('fields'=>array('id','nome')));
		$estados = $this->Instituicao->InstituicoesEndereco->Cidade->Estado->find('list', array('fields'=>array('id','nome')));
		$cidades = $this->Instituicao->InstituicoesEndereco->Cidade->find('list', array('fields'=>array('id','nome'),'conditions'=>array('estado_id'=>$this->data['Cidade']['estado_id'])));
		
		$belongsTo = array('TiposEndereco'=>$tipos_endereco,'Estado'=>$estados,'Cidade'=>$cidades);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Endereço do Instituicao','InstituicoesEndereco');
	}

	public function delInstituicoesEndereco($id = null) {
		$this->layout = null;
		$this->Instituicao->InstituicoesEndereco->delete($this->data['InstituicoesEndereco']['id']);
		$this->Session->setFlash(__('Endereço da Instituição excluído com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->redirect('edit/'.$this->data['Instituicao']['id'].'#endereco');	
	}
	
}
