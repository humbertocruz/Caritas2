<?php
App::uses('AppController', 'Controller');
/**
 * Chamadas Controller
 *
 */
class ChamadasController extends AppController {
	
	var $helpers = array('Bootstrap');
	// Garante o correto carregamento da Model
	var $uses = array( 'Chamada','ContatosInstituicao','ContatosFornecedor','Contato','Pedido');
	
	public function beforeFilter() {
		$this->Auth->allow('contatos_from','carrega_chamadas','contatos_fones','contatos_emails');
	}


	public function _variables($header = null, $parent_id = 0) {
		$this->set('header',$header);
		$this->set('model','Chamada');
		$this->set('controller', 'chamadas');
		$this->set('del_info', array('Chamada'=>'data_inicio'));

		$subs = array(
			'ChamadasFilha' => $this->Chamada->formFields['Chamada']
		);
		$this->set('sess_models', AppController::_sess_models() );
		$this->set('source_model', 'Chamada');
		$this->set('subs', $subs);
	}
	
	public function carrega_chamadas($deonde = 'instituicao', $instituicao_id = null, $first = 'follow') {
		if ($first == 'follow') $this->layout = false;
		$this->recursive = 1;
		$conditions = array(
			'Chamada.instituicao_id' => $instituicao_id,
			'Chamada.chamada_id' => null 
		);
		$order = array(
			'Chamada.data_inicio' => 'DESC'
		);
		$chamadas = $this->Chamada->find('all', array('conditions'=>$conditions, 'order'=>$order, 'limit'=>10, 'fields'=>array('Chamada.id','Chamada.data_inicio','Chamada.solicitacao','Chamada.contato_id','Contato.nome','Atendente.nome')));
		$this->set('chamadas',$chamadas);
	}
	
	public function _save(){
		$dados_chamada = $this->data;
		if ($dados_chamada['System']['finalizando'] == 1) {
			$dados_chamada['Chamada']['data_fim'] = date_format( date_create() ,'Y-m-d');
		}
		if ($dados_chamada['Chamada']['chamada_id'] == 0) {
			unset($dados_chamada['Chamada']['chamada_id']);
		}
		if ($this->Chamada->save($dados_chamada)):
			$this->Session->setFlash(__('Chamada gravada com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			if (!isset($this->data['continue']) || $this->data['continue'] == 0) {
				$this->redirect('index'); 
			} else {
				$this->redirect('edit/'.$this->Chamada->id); 
			}
		else:
			$this->Session->setFlash(__('Chamada não pode ser gravada!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Chamada->invalidFields());
		endif;
	}
	
	public function index() {

		// Controle dos Filtros de Pesquisa
		if ( isset( $this->data['filter'] ) ) {
			$dFilter = $this->data['filter'];
			if ( !isset( $dFilter['clear'] ) ) $dFilter['clear'] = 0;
			if ( $dFilter['clear'] == '1' ) {
				$this->Session->delete('filter');
			} else {
				$this->Session->write('filter', $dFilter);
				$this->set('filter', $dFilter);
			}
		} else if ( $this->Session->check('filter') ) {
			$this->set('filter', $this->Session->read('filter'));
		}

		$authuser = $this->Auth->user('Atendente');
		
		$sess_models = AppController::_sess_models();
		$condEnd = array();
		$condEnd['Chamada.chamada_id'] = null;
		
		// Filtros de busca
		$filters = array(
			'status'=>$this->Chamada->Status->find('all'),
			'atendentes'=>$this->Chamada->Atendente->find('all')
		);
		
		if ( $this->Session->check('filter') ) {
			$filter_sess = $this->Session->read('filter');
			$this->set('filters_sess',$filter_sess);

			if (isset($filter_sess['status_id']) && $filter_sess['status_id'] != '0') {
				$condEnd['Chamada.data_fim'] = null;
			}
			if (isset($filter_sess['atendente_id']) && $filter_sess['atendente_id'] != '0') {
				$condEnd['Chamada.atendente_id'] = $filter_sess['atendente_id'];
			}
			if (isset($filter_sess['search']) && $filter_sess['search'] != '') {
				$condEnd['OR'] = array(
					'Contato.nome like' => '%'.$filter_sess['search'].'%',
					'Instituicao.nome_fantasia like' => '%'.$filter_sess['search'].'%',
					'Fornecedor.nome_fantasia like' => '%'.$filter_sess['search'].'%',
					'Chamada.solicitacao like' => '%'.$filter_sess['search'].'%'
				);
			}
		}
		if ($sess_models['Projetos']['id']!=0) {
			$condEnd['Chamada.projeto_id'] = $sess_models['Projetos']['id'];
		}
		
		$this->Chamada->Behaviors->attach('Containable');

		$this->paginate = array(
			'conditions'=>$condEnd,
			'order'=>array('Chamada.data_inicio'=>'DESC')
		);

		$this->Chamada->contain(array(
			'Instituicao',
			'Instituicao.InstituicoesEndereco.Cidade',
			'Fornecedor',
			'Fornecedor.FornecedoresEndereco.Cidade',
			'Contato',
			'Assunto',
			'ChamadasFilha',
			'ChamadasProcedimento'
		));
		
		$this->set('filters', $filters);
		
		$this->set('data_index', $this->paginate());
		
		$status = $this->Chamada->Status->find('list', array('fields'=>array('id','nome')));
		$belongsToArray = array('Status'=>$status);
		$this->set('belongsToArray',$belongsToArray);
		
		$this->_variables('Chamadas');
		
	}
	
	public function relacionadas($id = null) {
		$sess_models = AppController::_sess_models();
		$conditions = array(
			'Chamada.projeto_id' => $sess_models['Projetos']['id'],
			'Chamada.chamada_id' => $id,
			'Chamada.data_fim' => null
		);
		if ( isset( $this->data['search'] ) ) {
			if ($this->data['situacao'] == 'todas') unset($conditions['Chamada.data_fim']);
		}
		$this->set('search', $this->data);
		$this->_variables('Chamadas');
		$this->set('data_index', $this->Chamada->find('all', array('conditions'=>$conditions)));
		
	}
	
	public function finalizar($pedido_id = 0) {
		$this->layout = null;

		if (!empty($this->data['Chamada']['data_fim'])) {
			$data_text = $this->data['Chamada']['data_fim'];
			$data = DateTime::createFromFormat('d/m/Y H:i:s', $data_text);
			$data_formated = $data->format('Y-m-d H:i:s');
		}
		
		$this->Chamada->id = $this->data['Chamada']['id'];
		$this->Chamada->saveField('status_id', $this->data['Chamada']['status_id']);
		$this->Chamada->saveField('data_fim', $data_formated);
		
		if ($pedido_id == 0) {
			$redirect_url = 'index';
		} else {
			$redirect_url = '/pedidos/edit/'.$pedido_id.'#tabChamada';
		}

		if (!isset($this->data['continue']) || $this->data['continue'] == 0): $this->redirect($redirect_url); else: $this->redirect('edit/'.$this->Chamada->id); endif;
	}
	
	public function view($id = null, $pedido_id = 0) {
		$this->set('data_view', $this->Chamada->read(null, $id));
		$this->set('pedido_id', $pedido_id);
	}
	
	public function contatos_from($deonde, $id, $contato_id = 0, $chamada_id = 0) {
		$this->layout = null;
		$this->ContatosInstituicao->Behaviors->attach('Containable');

		$this->ContatosInstituicao->contain(
			array(
				'Contato',
				'Cargo',
				'Instituicao',
				'Contato.ContatosEmail',
				'Contato.ContatosFone'
		) );
		if ($deonde == 'instituicao') {
			$this->set('contatos', $this->ContatosInstituicao->find('all', array('conditions'=>array('ContatosInstituicao.instituicao_id'=>$id))) );
		} else {
			$this->set('contatos', $this->ContatosFornecedor->find('all', array('conditions'=>array('ContatosFornecedor.fornecedor_id'=>$id))) );
		}
		$this->set('contato_id', $contato_id);
		$this->set('chamada_id', $chamada_id);
	}
	public function contatos_fones($contato_id = 0) {
		$this->layout = 'ajax';
		$this->set('fones', json_encode( $this->Chamada->Contato->ContatosFone->find('all', array('conditions'=>array('Contato.id'=>$contato_id)))));
	}
	public function contatos_emails($contato_id = 0) {
		$this->layout = 'ajax';
		$this->set('emails', json_encode( $this->Chamada->Contato->ContatosEmail->find('all', array('conditions'=>array('Contato.id'=>$contato_id)))));
	}
	
	public function add($chamada_id = 0, $pedido_id = 0) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				if ($this->data['System']['pedido_id'] == 0) {
					$this->redirect('/Chamadas');
				} else {
					$this->redirect('/pedidos/edit/'.$this->data['System']['pedido_id'].'#tabChamadas');
				}
			}
			$this->_save();
		endif;
		
		
		$sess_models = AppController::_sess_models();
		if ($sess_models['Projetos']['id'] == 0) {
				$this->Session->setFlash(__('Necessário selecionar o Projeto!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->redirect('/chamadas');			
		}
		
		$this->set('sess_controls', array('Projeto' => array('id'=>$sess_models['Projetos']['id'],'texto'=>$sess_models['Projetos']['texto'])));

		$this->set('pedido_id', $pedido_id);
		$this->set('addContatoSexo', $this->Chamada->Contato->Sexo->find('all'));
		$this->set('addContatoCargo', $this->ContatosInstituicao->Cargo->find('all'));
		$this->set('addContatoSituacao', $this->ContatosInstituicao->SituacoesContato->find('all'));

		$this->set('addContatoTiposFone', $this->Contato->ContatosFone->TiposFone->find('all'));
		$this->set('addContatoTiposEmail', $this->Contato->ContatosEmail->TiposEmail->find('all'));

		if ($chamada_id != 0) {
			$this->Chamada->Behaviors->attach('Containable');
			$this->Chamada->contain('Instituicao','Instituicao.InstituicoesEndereco','ChamadasProcedimento');
			$chamada_filha = $this->Chamada->read(null, $chamada_id);
			
			$this->set('sessCidade', $this->Chamada->Instituicao->InstituicoesEndereco->Cidade->read(null, $chamada_filha['Instituicao']['InstituicoesEndereco'][0]['cidade_id']));
			$texto = date('d/m/Y', strtotime( $chamada_filha['Chamada']['data_inicio'] ));
			
			unset( $chamada_filha['Chamada']['id'] );
			unset( $chamada_filha['Chamada']['data_inicio'] );
			unset( $chamada_filha['Chamada']['data_fim'] );
			unset( $chamada_filha['Chamada']['solicitacao']);
			unset( $chamada_filha['Chamada']['status_id']);
			
			$chamada_filha['Chamada']['chamada_id'] = $chamada_id;
			
			$this->data = $chamada_filha;
			
			
			AppController::_sess_models_write('Chamadas', $chamada_id, $texto);
		} else if ( $pedido_id != 0 ) {
			$this->Pedido->Behaviors->attach('Containable');
			$this->Pedido->contain('Instituicao','Instituicao.InstituicoesEndereco','Instituicao.InstituicoesEndereco.Cidade');
			$pedido_filho = $this->Pedido->read(null, $pedido_id);
			$instituicao = $pedido_filho['Instituicao'];
						
			$this->set('sessCidade', $this->Pedido->Instituicao->InstituicoesEndereco->Cidade->read(null, $pedido_filho['Instituicao']['InstituicoesEndereco'][0]['cidade_id']));
			
			$chamada_filha = array(
				'Instituicao' => $instituicao
			);
						
			$this->data = $chamada_filha;
 			$this->set('instituicao_pedido',$instituicao['nome_fantasia'].' / '.$instituicao['InstituicoesEndereco'][0]['Cidade']['estado_id']);
			
			//AppController::_sess_models_write('Chamadas', $chamada_id, $texto);
			
			$this->recursive = 1;
			$conditions_cf = array(
				'Chamada.instituicao_id' => $instituicao['id'],
				'Chamada.chamada_id' => null 
				);
			$order_cf = array(
				'Chamada.data_inicio' => 'DESC'
				);
			$chamadas_cf = $this->Chamada->find('all', array('conditions'=>$conditions_cf, 'order'=>$order_cf, 'limit'=>10, 'fields'=>array('Chamada.id','Chamada.data_inicio','Chamada.solicitacao','Chamada.contato_id','Contato.nome','Atendente.nome')));
			$this->set('chamadas_hist',$chamadas_cf);
		
		} else {
			AppController::_sess_models_write('Chamadas', 0, 'Nenhuma');
		}

		$chamadas = $this->Chamada->find('list', array('fields'=>array('id','data_inicio')));
		$chamadas[0] = 'Nenhuma';
		$assuntos = $this->Chamada->Assunto->find('list', array('fields'=>array('id','nome')));
		$tiposchamada = $this->Chamada->TiposChamada->find('list', array('fields'=>array('id','nome')));
		$projetos = $this->Chamada->Projeto->find('list', array('fields'=>array('id','nome')));
		$atendentes = $this->Chamada->Atendente->find('list', array('fields'=>array('id','nome')));
		$contatos = $this->Chamada->Contato->find('list', array('fields'=>array('id','nome')));
		$instituicoes = $this->Chamada->Instituicao->find('list', array('fields'=>array('id','nome_fantasia')));
		$pedidos = $this->Chamada->Pedido->find('list', array('fields'=>array('id','data_inicio')));
		$status = $this->Chamada->Status->find('list', array('fields'=>array('id','nome')));
		$prioridades = $this->Chamada->Prioridade->find('list', array('fields'=>array('id','nome')));
		
		$belongsTo = array('Assunto'=>$assuntos, 'TiposChamada'=>$tiposchamada,'Projeto'=>$projetos, 'Atendente'=>$atendentes, 'ChamadaFilha'=>$chamadas,'Status'=>$status,'Pedido'=>$pedidos,'Prioridade'=>$prioridades);
		$this->set('belongsTo',$belongsTo);
		$filter_data = array(
			'Estado'=>$this->Chamada->Instituicao->InstituicoesEndereco->Cidade->Estado->find('all'),
			'Cidade'=>array('Cidade'=>array())
		);
		$this->set('filter_data', $filter_data);

		$this->_variables('Adiciona Chamada');
		
	}
	
	public function edit($id = null, $pedido_id = 0) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				if ($this->data['System']['pedido_id'] == 0) {
					$this->redirect('/Chamadas');
				} else {
					$this->redirect('/pedidos/edit/'.$this->data['System']['pedido_id'].'#tabChamadas');
				}
			}
			$this->_save();
		else:
		
			
		$sess_models = AppController::_sess_models();
		if ($sess_models['Projetos']['id'] == 0) {
				$this->Session->setFlash(__('Necessário selecionar o Projeto!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->redirect('/chamadas');			
		}
		
		$this->set('sess_controls', array('Projeto' => array('id'=>$sess_models['Projetos']['id'],'texto'=>$sess_models['Projetos']['texto'])));
		
			$this->set('pedido_id', $pedido_id);
			$this->set('addContatoSexo', $this->Chamada->Contato->Sexo->find('all'));
			$this->set('addContatoCargo', $this->ContatosInstituicao->Cargo->find('all'));
			$this->set('addContatoSituacao', $this->ContatosInstituicao->SituacoesContato->find('all'));
			$this->set('addContatoTiposFone', $this->Contato->ContatosFone->TiposFone->find('all'));
			$this->set('addContatoTiposEmail', $this->Contato->ContatosEmail->TiposEmail->find('all'));
			
			$this->set('addChamadaProcedimentos', $this->Chamada->ChamadasProcedimento->Procedimento->find('all'));

			$this->Chamada->Behaviors->attach('Containable');
			$this->Chamada->contain('Instituicao','Instituicao.InstituicoesEndereco','ChamadasProcedimento');
			$this->data = $this->Chamada->read(null, $id);
			
			$this->set('sessCidade', $this->Chamada->Instituicao->InstituicoesEndereco->Cidade->read(null, $this->data['Instituicao']['InstituicoesEndereco'][0]['cidade_id']));
			$chamadas = $this->Chamada->find('list', array('fields'=>array('id','tipo_chamada_id')));
			$chamadas[0] = 'Nenhuma';
			
			
			$assuntos = $this->Chamada->Assunto->find('list', array('fields'=>array('id','nome')));
			$tiposchamada = $this->Chamada->TiposChamada->find('list', array('fields'=>array('id','nome')));
			$projetos = $this->Chamada->Projeto->find('list', array('fields'=>array('id','nome')));
			$atendentes = $this->Chamada->Atendente->find('list', array('fields'=>array('id','nome')));
			$pedidos = $this->Chamada->Pedido->find('list', array('fields'=>array('id','data_inicio')));
			$status = $this->Chamada->Status->find('list', array('fields'=>array('id','nome')));
			$prioridades = $this->Chamada->Prioridade->find('list', array('fields'=>array('id','nome')));
			$belongsTo = array('Assunto'=>$assuntos, 'TiposChamada'=>$tiposchamada,'Projeto'=>$projetos, 'Atendente'=>$atendentes, 'ChamadaFilha'=>$chamadas,'Status'=>$status,'Pedido'=>$pedidos,'Prioridade'=>$prioridades);
			$this->set('belongsTo',$belongsTo);
			
			$procedimentos = $this->Chamada->ChamadasProcedimento->find('all', array('conditions'=>array('ChamadasProcedimento.chamada_id'=>$id),'order'=>array('ChamadasProcedimento.data'=>'asc')));
			$filhas = $this->Chamada->ChamadasFilha->find('all', array('conditions'=>array('ChamadasFilha.chamada_id'=>$id)));
			
			$hasMany = array('ChamadasProcedimento'=>$procedimentos, 'ChamadasFilha'=>$filhas);
			$this->set('hasMany', $hasMany);
			
			$filter_data = array(
				'Estado'=>$this->Chamada->Instituicao->InstituicoesEndereco->Cidade->Estado->find( 'all' ),
				'Cidade'=>array( 'Cidade'=>array() )
			);
			$this->set('filter_data', $filter_data);
			$this->_variables('Edita Chamada');
			$this->carrega_chamadas( 'instituicao', $this->data['Chamada']['instituicao_id'], 'first' );
			
			$this->ContatosInstituicao->Behaviors->attach('Containable');

			$this->ContatosInstituicao->contain(
			array(
				'Contato',
				'Cargo',
				'Instituicao',
				'Contato.ContatosEmail',
				'Contato.ContatosFone'
			) );

			$contatos = $this->ContatosInstituicao->find( 'all', array( 'conditions'=>array( 'ContatosInstituicao.instituicao_id'=>$this->data['Chamada']['instituicao_id'] ) ) );
			
			$this->set( 'contatos', $contatos );

			$this->render( 'form' );
			
		endif;
	}
	
	public function del($id = null, $pedido_id = 0) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Chamada->delete($this->data['Chamada']['id'])) {
				$this->Session->setFlash(__('Chamada excluída com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Chamada não pôde ser excluída!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			if ($pedido_id == 0) {
				$redirect_url = 'index';
			} else {
				$redirect_url = '/pedidos/edit/'.$pedido_id.'#tabChamada';
			}
			$this->redirect($redirect_url);
		endif;
	}
	
	public function addContatoChamada() {
		$this->layout = null;
		if ( $this->request->isPost() ) {
			$this->Contato->save($this->data['Contato']);
			$ContatoInstituicao = $this->data['ContatosInstituicao'];
			$ContatoInstituicao['contato_id'] = $this->Contato->id;
			$ContatoInstituicao['data_inicio'] = date('Y-m-d',time());
			$this->ContatosInstituicao->save($ContatoInstituicao);
			$endereco = array (
				'tipo_endereco_id'=>'7',
				'cidade_id'=>$this->data['Cidade']['id'],
				'contato_id'=>$this->Contato->id
			);
			$this->Contato->ContatosEndereco->save($endereco);
		}
	}

	public function addContatoFone() {
		$this->layout = null;
		if ( $this->request->isPost() ) {
			$this->Contato->ContatosFone->save($this->data['ContatosFone']);
		}
	}

	public function addContatoEmail() {
		$this->layout = null;
		if ( $this->request->isPost() ) {
			$this->Contato->ContatosEmail->save($this->data['ContatosEmail']);
		}
	}

	public function edit_chamadas_procedimento() {
		$this->layout = null;
		
		if ($this->request->isPost()):
			$dados = $this->data;
			if ($dados['ChamadasProcedimento']['id'] == 0) unset($dados['ChamadasProcedimento']['id']);
			$this->Chamada->ChamadasProcedimento->save($dados);

			$this->set('success', 'Procedimento da Chamada gravado com sucesso!');
		endif;
	}

	public function del_chamadas_procedimento() {
		$this->layout = null;
		if ($this->request->isPost()) {
			$this->Chamada->ChamadasProcedimento->delete($this->data['ChamadasProcedimento']['id']);
			$this->set('success', 'Procedimento da Chamada excluído com sucesso!');
		}
	}
	
	public function reload_chamadas_procedimento($chamada_id) {
		$this->layout = null;
		$this->set('chamadas_procedimentos', $this->Chamada->ChamadasProcedimento->find('all', array('conditions'=>array('ChamadasProcedimento.chamada_id'=>$chamada_id),'order'=>array('ChamadasProcedimento.data'=>'asc'))));
	}
	
	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->Chamada->find('list',array('fields'=>array('id','nome'))));
	}
}
