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
				
	}
	
	public function edit($chamada_id =  null) {
		$this->Chamada->Behaviors->attach('Containable');
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
		
		$chamada = $this->Chamada->read(null, $chamada_id);
		$this->data = $chamada;
		
		$this->recursive = 1;
		$conditions = array(
			'Chamada.instituicao_id' => $this->data['Instituicao']['id'],
			'Chamada.chamada_id' => null 
		);
		$order = array(
			'Chamada.data_inicio' => 'DESC'
		);
		$historico = $this->Chamada->find('all', array('conditions'=>$conditions, 'order'=>$order, 'limit'=>10, 'fields'=>array('Chamada.id','Chamada.data_inicio','Chamada.solicitacao','Chamada.contato_id','Contato.nome','Atendente.nome')));
		$this->set('historico',$historico);
		
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
				'Estado'=>$this->Chamada->Instituicao->InstituicoesEndereco->Cidade->Estado->find('all'),
				'Cidade'=>array('Cidade'=>array())
			);
			$this->set('filter_data', $filter_data);

		$this->render('form');
	}
	
	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->Chamada->find('list',array('fields'=>array('id','nome'))));
	}
}
