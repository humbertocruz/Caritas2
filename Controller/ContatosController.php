<?php
App::uses('AppController', 'Controller');
/**
 * Contatos Controller
 *
 */
class ContatosController extends AppController {

	public $uses = array('Contato','ContatosEmail','ContatosFone','ContatosEndereco','ContatosLotacao','ContatosFornecedor');

	public function _variables($header = null, $model = 'Contato') {
		$this->set('header',$header);
		$this->set('model',$model);
		$this->set('controller', 'contatos');
		$this->set('del_info', array(
			'Contato'=>'nome',
			'ContatosEmail'=>'email',
			'ContatosFone'=>'fone',
			'ContatosEndereco'=>'endereco',
			'Fornecedor'=>'nome_fantasia',
			'Instituicao'=>'nome_fantasia'
		));

		$this->set('source_model', 'Contato');

		$forms = array_merge(
			$this->Contato->formFields,
			$this->Contato->ContatosEmail->formFields,
			$this->Contato->ContatosFone->formFields,
			$this->Contato->ContatosEndereco->formFields,
			$this->Contato->ContatosFornecedor->formFields,
			$this->Contato->ContatosInstituicao->formFields
		);

		$this->set('forms', $forms);
	}
	
	public function _save(){
		if ($this->Contato->save($this->data)):
			$this->Session->setFlash(__('Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		else:
			$this->Session->setFlash(__('Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Contato->invalidFields());
		endif;
	}

	public function index() {
		$this->Session->delete('hasMany_source');
		$condEnd = array();
		$cond = array();
		if ( $this->Session->check('filter') ) {
			$filter_sess = $this->Session->read('filter');
			if (isset($filter_sess['uf']) && $filter_sess['uf'] != '0') {
				$condEnd['Cidade.estado_id'] = $filter_sess['uf'];
			}
			if (isset($filter_sess['cidade']) && $filter_sess['cidade'] != '0') {
				$condEnd['Cidade.id'] = $filter_sess['cidade'];
			}
			if (isset($filter_sess['search']) && $filter_sess['search'] != '') {
				$cond['OR'] = array(
					'Contato.nome like' => '%'.$filter_sess['search'].'%',
					'Contato.cpf like' => '%'.$filter_sess['search'].'%',
				);
			}
		}
		if (count($condEnd) > 0) {
			$enderecos = $this->Contato->ContatosEndereco->find('all', array('conditions'=>$condEnd, 'fields'=>array('Contato.id')));
			$list_contat = array();
			foreach($enderecos as $contat) {
				array_push($list_contat, $contat['Contato']['id']);
			}
			$cond['Contato.id'] = $list_contat;
		}
		
		$this->paginate = array(
			'conditions'=>$cond,
			'order'=>array('Contato.nome'=>'ASC')
		);
		$this->set('data_index', $this->paginate());
		
		$this->set('filter_form', array('filter/uf_cidade'));
		$filter_data = array(
			'Estado'=>$this->Contato->ContatosEndereco->Cidade->Estado->find('all'),
			'Cidade'=>array('Cidade'=>array())
		);
		$this->set('filter_data', $filter_data);
		$this->_variables('Contatos');

	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/contatos');
			}
			$this->_save();
		endif;
		$sexo = $this->Contato->Sexo->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('Sexo'=>$sexo);
		$this->set('belongsTo',$belongsTo);
			
		$this->_variables('Adiciona Contato');
	}
	
	public function edit($id = null, $id_chamada = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				if ($this->data['System']['chamada_id'] == 0) {
					$this->redirect('/contatos');
				} else {
					$this->redirect('/chamadas/edit/'.$this->data['System']['chamada']);
				}
			}
			$this->_save();
			if ($this->data['System']['chamada_id'] == 0) {
				$this->redirect('/contatos');
			} else {
				$this->redirect('/chamadas/edit/'.$this->data['System']['chamada_id']);
			}
		else:
			
			// Edita Contato de Chamada
			if ($id_chamada != null) {
				if ($this->Session->check('sess_belongsTo')) {
					$sess_belongsTo = $this->Session->read('sess_belongsTo');
				} else {
					$sess_belongsTo = array();
				}
				array_push($sess_belongsTo, $this->data);
				if (count($sess_belongsTo) > 0) {
					$this->Session->write('sess_belongsTo', $sess_belongsTo);
				} else {
					$this->Session->delete('sess_belongsTo');
				}
				$this->Session->write('do_belongsTo', true);
			}
			
			$this->data = $this->Contato->read(null, $id);
			$sexos = $this->Contato->Sexo->find('list', array('fields'=>array('id','nome')));
			
			$belongsTo = array('Sexo'=>$sexos);
			
			$this->set('belongsTo',$belongsTo);
			$this->set('id_chamada', $id_chamada);
						
			$this->Session->write('hasMany_source',array('contato_id'=>$id));
			$this->_variables('Edita Contato');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Contato->delete($this->data['Contato']['id'])) {
				$this->Session->setFlash(__('Contato excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Contato não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
	
	public function addContatosEmail($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['ContatosEmail']['contato_id'].'#email');
			}			
			if ($this->ContatosEmail->save($this->data)):
				$this->Session->setFlash(__('Email do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosEmail']['contato_id'].'#email');
			else:
				$this->Session->setFlash(__('Email do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Contato->read(null, $id);
		$source = array('ContatosEmail'=>$this->Contato->ContatosEmail->formFields);	
		$this->set('source', $source);
		$tipos_email = $this->Contato->ContatosEmail->TiposEmail->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('TiposEmail'=>$tipos_email);
		$this->set('belongsTo',$belongsTo);
			
		$this->_variables('Adiciona Email','ContatosEmail');
	}
	
	public function editContatosEmail($id) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['ContatosEmail']['contato_id'].'#email');
			}			
			
			if ($this->ContatosEmail->save($this->data)):
				$this->Session->setFlash(__('Email do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosEmail']['contato_id'].'#email');
			else:
				$this->Session->setFlash(__('Email do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->ContatosEmail->read(null, $id);
		$source = array('ContatosEmail'=>$this->Contato->ContatosEmail->formFields);	
		$this->set('source', $source);
		$tipos_email = $this->Contato->ContatosEmail->TiposEmail->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('TiposEmail'=>$tipos_email);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Edita Email');
	}

	public function delContatosEmail($id = null) {
		$this->layout = null;
		$this->Contato->ContatosEmail->delete($this->data['ContatosEmail']['id']);
		$this->Session->setFlash(__('Email do Contato excluído com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->redirect('edit/'.$this->data['Contato']['id'].'#email');	
	}
	
	public function addContatosFone($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['ContatosFone']['contato_id'].'#fone');
			}			
			
			if ($this->ContatosFone->save($this->data)):
				$this->Session->setFlash(__('Telefone do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosFone']['contato_id'].'#fone');
			else:
				$this->Session->setFlash(__('Telefone do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Contato->read(null, $id);
		$source = array('ContatosFone'=>$this->Contato->ContatosFone->formFields);	
		$this->set('source', $source);
		$tipos_fone = $this->Contato->ContatosFone->TiposFone->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('TiposFone'=>$tipos_fone);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Adiciona Telefone');
	}
	
	public function editContatosFone($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['ContatosFone']['contato_id'].'#fone');
			}			
			
			if ($this->ContatosFone->save($this->data)):
				$this->Session->setFlash(__('Telefone do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosFone']['contato_id'].'#fone');
			else:
				$this->Session->setFlash(__('Telefone do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->ContatosFone->read(null, $id);
		$source = array('ContatosFone'=>$this->Contato->ContatosFone->formFields);	
		$this->set('source', $source);
		$tipos_fone = $this->Contato->ContatosFone->TiposFone->find('list', array('fields'=>array('id','nome')));
		$belongsTo = array('TiposFone'=>$tipos_fone);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Edita Telefone');
	}
	
	public function delContatosFone($id = null) {
		$this->layout = null;
		$this->Contato->ContatosFone->delete($this->data['ContatosFone']['id']);
		$this->Session->setFlash(__('Telefone do Contato excluído com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->redirect('edit/'.$this->data['Contato']['id'].'#fone');	
	}

	public function addContatosEndereco($id = null) {
		if ($this->request->isPost()):
			if (isset($this->data['ContatosEndereco']['estado_id'])) {
				$this->Session->write('ContatosEndereco.estado_id', $this->data['ContatosEndereco']['estado_id']);
			}
			if (isset($this->data['ContatosEndereco']['cidade_id'])) {
				$this->Session->write('ContatosEndereco.cidade_id', $this->data['ContatosEndereco']['cidade_id']);
			}
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['ContatosEndereco']['contato_id'].'#endereco');
			}
			if ($this->ContatosEndereco->save($this->data)):
				$this->Session->setFlash(__('Endereço do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosEndereco']['contato_id'].'#endereco');
			else:
				$this->Session->setFlash(__('Endereço do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Contato->read(null, $id);
		$source = array('ContatosEndereco'=>$this->Contato->ContatosEndereco->formFields);	
		$this->set('source', $source);
		$tipos_endereco = $this->Contato->ContatosEndereco->TiposEndereco->find('list', array('fields'=>array('id','nome')));
		
		$estados = $this->Contato->ContatosEndereco->Cidade->Estado->find('list', array('fields'=>array('id','nome')));
		$cidades = $this->Contato->ContatosEndereco->Cidade->find('list', array('fields'=>array('id','nome'),'conditions'=>array('estado_id'=>'AC')));
		
		$belongsTo = array('TiposEndereco'=>$tipos_endereco,'Estado'=>$estados,'Cidade'=>$cidades);
		
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Adiciona Endereço');
	}
	
	public function editContatosEndereco($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['ContatosEndereco']['contato_id'].'#endereco');
			}			
			
			if ($this->ContatosEndereco->save($this->data)):
				$this->Session->setFlash(__('Endereço do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosEndereco']['contato_id'].'#endereco');
			else:
				$this->Session->setFlash(__('Endereço do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->ContatosEndereco->read(null, $id);
		$source = array('ContatosEndereco'=>$this->Contato->ContatosEndereco->formFields);	
		$this->set('source', $source);
		$tipos_endereco = $this->Contato->ContatosEndereco->TiposEndereco->find('list', array('fields'=>array('id','nome')));
		
		$estados = $this->Contato->ContatosEndereco->Cidade->Estado->find('list', array('fields'=>array('id','nome')));
		$cidades = $this->Contato->ContatosEndereco->Cidade->find('list', array('fields'=>array('id','nome'),'conditions'=>array('estado_id'=>'AC')));
		
		$belongsTo = array('TiposEndereco'=>$tipos_endereco,'Estado'=>$estados,'Cidade'=>$cidades);		
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Edita Endereço');
	}

	public function delContatosEndereco($id = null) {
		$this->layout = null;
		$this->Contato->ContatosEndereco->delete($this->data['ContatosEndereco']['id']);
		$this->Session->setFlash(__('Endereço do Contato excluído com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->redirect('edit/'.$this->data['Contato']['id'].'#endereco');	
	}
	
	public function addContatosFornecedor($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['ContatosFornecedor']['contato_id'].'#fornecedor');
			}
			
			if ($this->Contato->ContatosFornecedor->save($this->data)):
				$this->Session->setFlash(__('Fornecedor do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosFornecedor']['contato_id'].'#fornecedor');
			else:
				$this->Session->setFlash(__('Fornecedor do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Contato->read(null, $id);
		$cargos = $this->Contato->ContatosFornecedor->Cargo->find('list', array('fields'=>array('id','nome')));
		$situacoes = $this->Contato->ContatosFornecedor->SituacoesContato->find('list', array('fields'=>array('id','nome')));
		$fornecedores = $this->Contato->ContatosFornecedor->Fornecedor->find('list', array('fields'=>array('id','razao_social')));
		
		$belongsTo = array('Cargo'=>$cargos, 'SituacoesContato'=>$situacoes, 'Fornecedor'=>$fornecedores);
		$this->set('belongsTo',$belongsTo);
		$this->set('source_model','Contato');
		$this->_variables('Adiciona Contato de Fornecedor', 'ContatosFornecedor');
	}
	
	public function editContatosFornecedor($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['ContatosFornecedor']['contato_id'].'#fornecedor');
			}
			
			if ($this->Contato->ContatosFornecedor->save($this->data)):
				$this->Session->setFlash(__('Fornecedor do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosFornecedor']['contato_id'].'#fornecedor');
			else:
				$this->Session->setFlash(__('Fornecedor do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Contato->ContatosFornecedor->read(null, $id);
		$cargos = $this->Contato->ContatosFornecedor->Cargo->find('list', array('fields'=>array('id','nome')));
		$situacoes = $this->Contato->ContatosFornecedor->SituacoesContato->find('list', array('fields'=>array('id','nome')));
		$fornecedores = $this->Contato->ContatosFornecedor->Fornecedor->find('list', array('fields'=>array('id','razao_social')));
		
		$belongsTo = array('Cargo'=>$cargos, 'SituacoesContato'=>$situacoes, 'Fornecedor'=>$fornecedores);
		$this->set('belongsTo',$belongsTo);
		$this->set('source_model','Contato');
		$this->_variables('Adiciona Contato de Fornecedor', 'ContatosFornecedor');
	}

	public function delContatosFornecedor($id = null) {
		$this->layout = null;
		$this->Contato->ContatosFornecedor->delete($this->data['ContatosFornecedor']['id']);
		$this->Session->setFlash(__('Fornecedor do Contato excluído com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->redirect('edit/'.$this->data['Contato']['id'].'#fornecedor');	
	}

	public function addContatosInstituicao($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['ContatosInstituicao']['contato_id'].'#instituicao');
			}
			if ($this->Contato->ContatosInstituicao->save($this->data)):
				$this->Session->setFlash(__('Instituição do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				$this->redirect('edit/'.$this->data['ContatosInstituicao']['contato_id'].'#instituicao');
			else:
				$this->Session->setFlash(__('Instituição do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Contato->read(null, $id);
		$cargos = $this->Contato->ContatosInstituicao->Cargo->find('list', array('fields'=>array('id','nome')));
		$situacoes = $this->Contato->ContatosInstituicao->SituacoesContato->find('list', array('fields'=>array('id','nome')));
		$instituicoes = $this->Contato->ContatosInstituicao->Instituicao->find('list', array('fields'=>array('id','razao_social')));
		
		$belongsTo = array('Cargo'=>$cargos, 'SituacoesContato'=>$situacoes, 'Instituicao'=>$instituicoes);
		$this->set('belongsTo',$belongsTo);
		$this->_variables('Adiciona Instituição do Contato', 'ContatosInstituicao');
	}

	public function editContatosInstituicao($id = null, $id_chamada = 0) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('edit/'.$this->data['ContatosInstituicao']['contato_id'].'#instituicao');
			}
			
			if ($this->Contato->ContatosInstituicao->save($this->data)):
				$this->Session->setFlash(__('Instituição do Contato gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
				if ($this->data['System']['id_chamada'] == 0) {
					$this->redirect('edit/'.$this->data['ContatosInstituicao']['contato_id'].'#instituicao');
				} else {
					$this->redirect('/chamadas/edit/'.$this->data['System']['id_chamada']);
				}
			else:
				$this->Session->setFlash(__('Instituição do Contato não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->set('invalidFields', $this->Contato->invalidFields());
			endif;
					
		endif;
		$this->data = $this->Contato->ContatosInstituicao->read(null, $id);
		$cargos = $this->Contato->ContatosInstituicao->Cargo->find('list', array('fields'=>array('id','nome')));
		$situacoes = $this->Contato->ContatosInstituicao->SituacoesContato->find('list', array('fields'=>array('id','nome')));
		$instituicoes = $this->Contato->ContatosInstituicao->Instituicao->find('list', array('fields'=>array('id','razao_social')));
		
		$belongsTo = array('Cargo'=>$cargos, 'SituacoesContato'=>$situacoes, 'Instituicao'=>$instituicoes);
		$this->set('belongsTo',$belongsTo);
		$this->set('id_chamada', $id_chamada);
		$this->_variables('Adiciona Instituição do Contato', 'ContatosInstituicao');
	}
	
	public function delContatosInstituicao($id = null) {
		$this->layout = null;
		$this->Contato->ContatosInstituicao->delete($this->data['ContatosInstituicao']['id']);
		$this->Session->setFlash(__('Instituição do Contato excluído com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->redirect('edit/'.$this->data['Contato']['id'].'#instituicao');	
	}

}
