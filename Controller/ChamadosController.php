<?php
class ChamadosController extends AppController {
	
	public function index() {
		$this->Chamado->Behaviors->attach('Containable');

		$this->paginate = array(
			'order'=>array('Chamado.data_inicio'=>'DESC')
		);

		$this->Chamado->contain(array(
			'Instituicao',
			'Instituicao.InstituicoesEndereco.Cidade',
			'Fornecedor',
			'Fornecedor.FornecedoresEndereco.Cidade',
			'Contato',
			'Assunto',
			'ChamadasFilha',
			'ChamadasProcedimento'
		));
		$this->data = $this->paginate();
	}
	
	public function view($chamado_id = null) {
		$this->set('page_header_title', 'Ver Chamado');
		$this->render('implement');
	}
	
	public function add($chamado_id = null, $pedido_id = null) {
		if ( $this->request->isPost() ) {
			$this->_post();
		}
		$this->set('page_header_title', 'Adicionar Chamado');
		$this->_relations();
		$this->_sessions();
		$this->set('pedido_id', $pedido_id);
		$this->render('form');
	}

	public function edit($chamado_id = null, $pedido_id = null) {
		if ( $this->request->isPost() ) {
			$this->_post();
		}
		$this->set('page_header_title', 'Editar Chamado');
		$this->_relations();
		$this->_sessions();
		$this->set('pedido_id', $pedido_id);
		$this->data = $this->Chamado->read(null, $chamado_id);
                pr ($this->data['Chamado']);
		//pr($this->data);
		$this->render('form');
	}
	
	private function _post() {
		$data = $this->data;
		if ( $data['Chamado']['id'] == 0 ) unset($data['Chamado']['id']);
		if ( $data['Chamado']['chamada_id'] == 0 ) unset($data['Chamado']['chamada_id']);
		
		if (isset($data['instituicao_id'])) {
			$data['Chamado']['instituicao_id'] =  $data['instituicao_id'];
			unset($data['instituicao_id']);
		}
		if (isset($data['fornecedor_id'])) {
			$data['Chamado']['fornecedor_id'] =  $data['fornecedor_id'];
			unset($data['fornecedor_id']);
		}
		
		if ( $data['Chamado']['pedido_id'] == 0 ) unset($data['Chamado']['pedido_id']);
		
		//pr($data);
		
		$this->Chamado->save($data);
		
		$this->Session->setFlash(__('Chamado Gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));	
		$this->redirect('/chamados');
                //exit();
	}
	
	private function _relations() {
		
		$this->set('ufs', $this->ufs);
		$this->set('projetos', $this->Chamado->Projeto->find('list',array('fields'=>array('id','nome'))));
		$this->set('tipos_chamada', $this->Chamado->TiposChamada->find('list',array('fields'=>array('id','nome'))));
		$this->set('assuntos', $this->Chamado->Assunto->find('list',array('fields'=>array('id','nome'))));
		$this->set('prioridades', $this->Chamado->Prioridade->find('list',array('fields'=>array('id','nome'))));
		$this->set('status', $this->Chamado->Status->find('list',array('fields'=>array('id','nome'))));

		$pedidos = $this->Chamado->Pedido->find('list',array('fields'=>array('id','data_inicio')));
		$pedidos = array_merge( array( '0'=>'Nenhum Pedido' ), $pedidos );
		$this->set('pedidos', $pedidos );
		
		$estados = $this->Chamada->Instituicao->InstituicoesEndereco->Cidade->Estado->find('list',array('fields'=>array('id')));
		$estados = array_merge( array('0'=>'Escolha o Estado'), $estados );
		$this->set('estados', $estados );
	}
	
	private function _sessions() {
		$sess_models = $this->_sess_models();
		$this->set( 'projeto_id', $sess_models['Projetos']['id'] );
		$this->set( 'atendente_id', $this->Session->read('Auth.User') );
		
		$this->set('sr_forms_ready', $this->Session->read('sr_forms') );
	}
	
	public function loadCidades() {
		$this->uses = array('Chamado','Cidade','Projeto');
		$this->layout = null;

		$this->Cidade->Behaviors->attach('Containable');
		$this->Cidade->contain();
		$conditions = array(
			'Cidade.estado_id'=>$this->data['estado_id']
		);
		$cidades = $this->Cidade->find( 'all', 
			array(
				'conditions'=>array(
					$conditions
				)
			)
		);
		$this->set('cidades',$cidades);
	}
	
	public function loadInstituicoes() {
		$this->uses = array('Chamado','InstituicoesEndereco','Projeto');
		$this->layout = null;

		$this->InstituicoesEndereco->Behaviors->attach('Containable');
		$this->InstituicoesEndereco->contain('Instituicao');
		$conditions = array(
			'InstituicoesEndereco.cidade_id'=>$this->data['cidade_id']
		);
		$instituicoes = $this->InstituicoesEndereco->find( 'all', 
			array(
				'conditions'=>array(
					$conditions
				)
			)
		);
		$this->set('instituicoes',$instituicoes);
	}
	
	public function loadContatos() {
		$this->uses = array('Chamado','ContatosInstituicao','Projeto');
		$this->layout = null;

		$this->ContatosInstituicao->Behaviors->attach('Containable');
		$this->ContatosInstituicao->contain('Contato');
		$conditions = array(
			'ContatosInstituicao.instituicao_id'=>$this->data['instituicao_id']
		);
		$contatos = $this->ContatosInstituicao->find( 'all', 
			array(
				'conditions'=>array(
					$conditions
				)
			)
		);
		$this->set('contatos',$contatos);
	}
	
	public function loadContatosDetalhes() {
		$this->uses = array('Chamado','ContatosInstituicao','Projeto');
		$this->layout = null;

		$this->ContatosInstituicao->Behaviors->attach('Containable');
		$this->ContatosInstituicao->contain('Contato','Cargo','Contato.ContatosEmail','Contato.ContatosFone');
		$conditions = array(
			'ContatosInstituicao.instituicao_id'=>$this->data['instituicao_id']
		);
		$contatos = $this->ContatosInstituicao->find( 'all', 
			array(
				'conditions'=>array(
					$conditions
				)
			)
		);
		$this->set('contatos',$contatos);
	}
	
	public function loadHistoricos() {
		$this->uses = array('Chamado','Projeto');
		$this->layout = null;

		$this->Chamado->Behaviors->attach('Containable');
		$this->Chamado->contain('Contato','Atendente');
		$conditions = array(
			'Chamado.instituicao_id'=>$this->data['instituicao_id']
		);
		$historicos = $this->Chamado->find( 'all', 
			array(
				'conditions'=>array(
					$conditions
				)
			)
		);
		$this->set('historicos',$historicos);
	}
	
	public function del($chamado_id = null) {
		$this->set('page_header_title', 'Excluir Chamado');
		$this->render('implement');

	}
	
	public function addContato($chamado_id = null) {
		$this->set('page_header_title', 'Ver Chamado');
		$this->render('implement');
		
	}
	
	public function editContato($contato_id = null, $chamado_id = null) {
		$this->set('page_header_title', 'Ver Chamado');
		$this->render('implement');
		
	}
	
	public function delContato($contato_id = null, $chamado_id = null) {
		$this->set('page_header_title', 'Ver Chamado');
		$this->render('implement');
		
	}
	
	public function addEmailContato($contato_id = null, $chamado_id = null) {
		$this->set('page_header_title', 'Ver Chamado');
		$this->render('implement');
		
	}
	
	public function editEmailContato($email_id = null, $contato_id = null, $chamado_id = null) {
		$this->set('page_header_title', 'Ver Chamado');
		$this->render('implement');
		
	}

	public function delEmailContato($email_id = null, $contato_id = null, $chamado_id = null) {
		$this->set('page_header_title', 'Ver Chamado');
		$this->render('implement');
		
	}
	
	public function addTelefoneContato($contato_id = null, $chamado_id = null) {
		$this->set('page_header_title', 'Ver Chamado');
		$this->render('implement');
		
	}

	public function editTelefoneContato($telefone_id = null, $contato_id = null, $chamado_id = null) {
		$this->set('page_header_title', 'Ver Chamado');
		$this->render('implement');
		
	}
	
	public function delTelefoneContato($telefone_id = null, $contato_id = null, $chamado_id = null) {
		$this->set('page_header_title', 'Ver Chamado');
		$this->render('implement');
		
	}

	public function histChamados($municipio_id = null, $chamado_id = null) {
		$this->set('page_header_title', 'Ver Chamado');
		$this->render('implement');
		
	}
	
}