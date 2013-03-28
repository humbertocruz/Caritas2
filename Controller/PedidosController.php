<?php
App::uses('AppController', 'Controller');
/**
 * Pedidos Controller
 *
 */
class PedidosController extends AppController {

	var $helpers = array('Bootstrap');
	var $uses = array('Pedido','PedidosItem','PedidosItensEtapasAtividade', 'Documento');
	
	public function _variables($header = null) {
	
		$this->set('header',$header);
		$this->set('model','Pedido');
		$this->set('controller', 'pedidos');
		$this->set('del_info', array('Pedido'=>'data_inicio'));
		
		$this->set('fix_projeto_id', 2);
		
		$forms = $this->Pedido->formFields;
		
		$this->set('forms',$forms);
	}
	
	public function _save(){		
		if ($this->Pedido->save($this->data)):
			$this->Session->setFlash(__('Pedido gravada com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			if ($this->data['continue'] == 0) {
				$this->redirect('index');
			} else {
				$this->redirect('edit/'.$this->Pedido->id);
			}
		else:
			$this->Session->setFlash(__('Pedido não pode ser gravada!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Pedido->invalidFields());
		endif;
	}
	
	public function index() {
		$this->Pedido->Behaviors->attach('Containable');
		$this->Pedido->contain(array(
			'Instituicao.InstituicoesEndereco.Cidade.estado_id',
			'TiposPagamento.nome',
			'Convenio',
			'Distribuidor.nome',
			'PedidosItem.id',
			'PedidosItem.Item',
			'Chamada.id',
			'Edital'
		));
		// Dados de relacionamentos
		$this->set('status', $this->Pedido->Status->find('list', array('fields'=>array('id','nome'))));
		$this->set('tipos_pagamento', $this->Pedido->TiposPagamento->find('list', array('fields'=>array('id','nome'))));
		$this->set('estados', $this->Pedido->Instituicao->InstituicoesEndereco->Cidade->Estado->find('list', array('fields'=>array('id','id'))));
		if (isset($this->data['ped_filter']['estado_id'])) {
		$this->set('cidades', $this->Pedido->Instituicao->InstituicoesEndereco->Cidade->find('list',
			array('fields'=>array('id','nome'), 'conditions'=>array('Cidade.estado_id'=>$this->data['ped_filter']['estado_id']))));
		} else {
			$this->set('cidades', array());
		}
		// Filtros de busca
		$filters = array(
			'status_id'=>0,
			'estado_id'=>0,
			'cidade_id'=>0,
			'tipos_pagamento_id'=>0,
			'data_inicio'=>null,
			'data_fim'=>null,
			'instnome'=>null
		);
		
		// Condicoes de pesquisa com os filtros
		$conditions = array();
		if (isset($this->data['ped_filter'])) {
			if ($this->data['ped_filter']['clear_filter'] == 0) {
				if (!empty($this->data['ped_filter']['status_id'])) {	
					$conditions['Pedido.status_id'] =$this->data['ped_filter']['status_id'];
					$filters['status_id'] = $this->data['ped_filter']['status_id'];
				}
				if (!empty($this->data['ped_filter']['tipos_pagamento_id'])) {	
					$conditions['TiposPagamento.id'] =$this->data['ped_filter']['tipos_pagamento_id'];
					$filters['tipos_pagamento_id'] = $this->data['ped_filter']['tipos_pagamento_id'];
				}
				if (!empty($this->data['ped_filter']['estado_id'])) {	
					$filters['estado_id'] = $this->data['ped_filter']['estado_id'];
				}
				if ($this->data['ped_filter']['cidade_id'] != 0) {
					$instituicoesEndereco = $this->Pedido->Instituicao->InstituicoesEndereco->find('list',array(
						'conditions'=>array('InstituicoesEndereco.cidade_id'=>$this->data['ped_filter']['cidade_id']),
						'fields'=>array('instituicao_id')
					));
					$instituicoes = $this->Pedido->Instituicao->find('list',array(
						'conditions'=>array('Instituicao.id'=>$instituicoesEndereco),
						'fields'=>array('id')
					));
					$conditions['Pedido.instituicao_id'] = $instituicoes;
					$filters['cidade_id'] = $this->data['ped_filter']['cidade_id'];
				}
				if (!empty($this->data['ped_filter']['tipos_pagamento_id'])) {	
					$filters['tipos_pagamento_id'] = $this->data['ped_filter']['tipos_pagamento_id'];
				}
				if (!empty($this->data['ped_filter']['data_inicio'])) {	
					$conditions['Pedido.data_inicio >='] =$this->data['ped_filter']['data_inicio'];
					$filters['data_inicio'] = $this->data['ped_filter']['data_inicio'];
				}
				if (!empty($this->data['ped_filter']['data_fim'])) {	
					$conditions['Pedido.data_fim >='] =$this->data['ped_filter']['data_fim'];
					$filters['data_fim'] = $this->data['ped_filter']['data_fim'];
				}
				if (!empty($this->data['ped_filter']['instnome'])) {	
					$conditions['Instituicao.razao_social like'] = '%'.$this->data['ped_filter']['instnome'].'%';
					$filters['instnome'] = $this->data['ped_filter']['instnome'];
				}
			}
		}

		$sess_models = $this->_sess_models();
		if ($sess_models['Projetos']['id']!=0) {
			$conditions['Pedido.projeto_id'] = $sess_models['Projetos']['id'];
		}
		
		$this->set('filters', $filters);
				
		$this->set('data_index', $this->Paginate('Pedido', $conditions));
		$this->_variables('Pedidos');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/Pedidos');
			}
			if ($this->data['Pedido']['instituicao_id'] == 0) {
				$this->Session->setFlash(__('Selecione a Instituição!', true), 'bootstrap_flash', array('class'=>'alert'));
			} else {
				$this->_save();		
			}
		endif;
		$sess_models = AppController::_sess_models();
		if ($sess_models['Projetos']['id'] == 0) {
				$this->Session->setFlash(__('Necessário selecionar o Projeto!', true), 'bootstrap_flash', array('class'=>'alert-error'));
				$this->redirect('/Pedidos');			
		}
		
		$this->set('sess_controls', array('Projeto' => array('id'=>$sess_models['Projetos']['id'],'texto'=>$sess_models['Projetos']['texto'])));
		
		
		$status = $this->Pedido->Status->find('list', array('fields'=>array('id','nome')));
		$projetos = $this->Pedido->Projeto->find('list', array('fields'=>array('id','nome')));
		$editais = $this->Pedido->Edital->find('list', array('fields'=>array('id','numero')));
		$estados = $this->Pedido->Instituicao->InstituicoesEndereco->Cidade->Estado->find('list', array('fields'=>array('id','id')));
		$distribuidores = $this->Pedido->Distribuidor->find('list', array('fields'=>array('id','nome')));
		$atasprecos = $this->Pedido->AtaPreco->find('list', array('fields'=>array('id','nome')));
		$tipospagamentos = $this->Pedido->TiposPagamento->find('list', array('fields'=>array('id','nome')));
		$estados = $this->Pedido->Instituicao->InstituicoesEndereco->Cidade->Estado->find('list', array('fields'=>array('id','id')));
		$cidades = array();
		$instituicoes_endereco = array();
		$instituicoes = array();

		$belongsTo = array('Status'=>$status, 'Projeto'=>$projetos, 'Estado'=>$estados,
			'Distribuidor'=>$distribuidores ,'AtaPreco'=>$atasprecos,
			'TiposPagamento'=>$tipospagamentos, 'Cidade'=>$cidades, 'Instituicao'=>$instituicoes, 'Edital'=>$editais);
		$this->set('belongsTo',$belongsTo);

		$this->_variables('Adiciona Pedido');
	}
	
	public function view($id = null){
		$this->layout = false;
		$this->helpers = array('Session','Html','Form','Bootstrap','Caritas');
		$this->Pedido->Behaviors->attach('Containable');
		$this->Pedido->contain(
			array(
				'Instituicao',
				'Instituicao.InstituicoesEndereco',
				'Instituicao.InstituicoesEndereco.Cidade',
				'PedidosItem',
				'PedidosItem.Item',
				'PedidosItem.Item.EtapasAtividadesItem',
				'PedidosItem.Item.EtapasAtividadesItem.Atividade',
				'PedidosItem.Item.EtapasAtividadesItem.Etapa',
				'PedidosItem.Item.EtapasAtividadesItem.PedidosItensEtapasAtividade.pedido_id = '.$id,
				'Chamada',
				'Chamada.Assunto',
				'Chamada.ChamadasFilha',
				'Chamada.ChamadasProcedimento',
				'Documento',
				'Documento.TiposDocumento'
			)
		);
		$this->data = $this->Pedido->read(null, $id);
	}
	
	public function edit($id = null) {
		$this->helpers = array('Session','Html','Form','Bootstrap','Caritas');

		//$status = $this->Pedido->Chamada->Status->find('list', array('fields'=>array('id','nome')));
		//$belongsToArray = array('Status'=>$status);
		//$this->set('belongsToArray',$belongsToArray);
		
		if ($this->request->isPost() && isset($this->data['System']) ) {
			if (isset($this->data['System']) && $this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/Pedidos');
			}
			if (isset($this->data['System']) ) { $this->_save(); }
		} else {
			$this->Pedido->Behaviors->attach('Containable');
			$this->Pedido->contain(
				array(
					'Instituicao',
					'Instituicao.InstituicoesEndereco',
					'Instituicao.InstituicoesEndereco.Cidade',
					'PedidosItem',
					'PedidosItem.Item',
					'PedidosItem.Item.EtapasAtividadesItem',
					'PedidosItem.Item.EtapasAtividadesItem.Atividade',
					'PedidosItem.Item.EtapasAtividadesItem.Etapa',
					'PedidosItem.Item.EtapasAtividadesItem.PedidosItensEtapasAtividade.pedido_id = '.$id,
					'Chamada',
					'Chamada.Assunto',
					'Chamada.ChamadasFilha',
					'Chamada.ChamadasProcedimento',
					'Documento',
					'Documento.TiposDocumento'
				)
			);
			$this->data = $this->Pedido->read(null, $id);
			$status = $this->Pedido->Status->find('list', array('fields'=>array('id','nome')));
			$editais = $this->Pedido->Edital->find('list', array('fields'=>array('id','numero')));
			$projetos = $this->Pedido->Projeto->find('list', array('fields'=>array('id','nome')));
			$distribuidores = $this->Pedido->Distribuidor->find('list', array('fields'=>array('id','nome')));
			$atasprecos = $this->Pedido->AtaPreco->find('list', array('fields'=>array('id','nome')));
			$convenios = $this->Pedido->Convenio->find(
				'list',
				array('fields'=>array('id','num_convenio'),'conditions'=>array('Convenio.instituicao_id'=>$this->data['Pedido']['instituicao_id']))
			);
			$tipospagamentos = $this->Pedido->TiposPagamento->find('list', array('fields'=>array('id','nome')));
			$estados = $this->Pedido->Instituicao->InstituicoesEndereco->Cidade->Estado->find('list', array('fields'=>array('id','id')));
			$cidades = $this->Pedido->Instituicao->InstituicoesEndereco->Cidade->find(
				'list',
				array(
				      'fields'=>array('id','nome'),
				      'conditions'=>array('Cidade.estado_id'=>$this->data['Instituicao']['InstituicoesEndereco'][0]['Cidade']['estado_id'])
				)
			);
			$instituicoes_endereco = $this->Pedido->Instituicao->InstituicoesEndereco->find('list',
				array('fields'=>array('instituicao_id'), 'conditions'=>array('InstituicoesEndereco.cidade_id'=>$this->data['Instituicao']['InstituicoesEndereco'][0]['cidade_id']))
			);

			$instituicoes = $this->Pedido->Instituicao->find('list',
				array(
					'fields'=>array('id','razao_social'),
					'conditions'=>array('Instituicao.id'=>$instituicoes_endereco))
			);
			
			$sess_models = $this->_sess_models();
			if ($sess_models['Projetos']['id']!=0) {
				$conditions['Pedido.projeto_id'] = $sess_models['Projetos']['id'];
			}
			$this->set('sess_controls', array('Projeto' => array('id'=>$sess_models['Projetos']['id'],'texto'=>$sess_models['Projetos']['texto'])));
			$belongsTo = array('Status'=>$status, 'Projeto'=>$projetos, 'Distribuidor'=>$distribuidores,
				'AtaPreco'=>$atasprecos, 'Convenio'=>$convenios, 'TiposPagamento'=>$tipospagamentos,
				'Estado'=>$estados, 'Cidade'=>$cidades, 'Instituicao'=>$instituicoes, 'Edital'=>$editais);
			$this->set('belongsTo',$belongsTo);

			$this->_variables('Edita Pedido');
		}
	}
	
	public function addDocumento($pedido_id = null) {
		if ($this->request->isPost()) {
			$data = $this->data;
			
			$data['Documento']['nome_arquivo'] = $data['Documento']['nome_arquivo']['name'];
			$this->Documento->save($data);

			$pedidos_dir = WWW_ROOT.DS.'documentos'.DS.'pedidos';
			
			if (!is_dir($pedidos_dir.DS.$pedido_id)) mkdir($pedidos_dir.DS.$pedido_id);
			$pedidos_dir = $pedidos_dir.DS.$pedido_id;
			move_uploaded_file($this->data['Documento']['nome_arquivo']['tmp_name'], $pedidos_dir.DS.$this->Documento->id.'_'.$this->data['Documento']['nome_arquivo']['name']);
			$this->Session->setFlash(__('Documento gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('/pedidos/edit/'.$pedido_id.'#tabDocumento');
		}
	
		$this->set('pedido_id', $pedido_id);
		$this->set('tipos_documentos', $this->Documento->TiposDocumento->find('list', array('id','nome')));
	}

	public function editDocumento($id = null) {
		if ($this->request->isPost()) {
			$data = $this->data;
			
			$data['Documento']['nome_arquivo'] = $data['Documento']['nome_arquivo']['name'];
			$this->Documento->save($data);

			$pedidos_dir = WWW_ROOT.DS.'documentos'.DS.'pedidos';
			
			if (!is_dir($pedidos_dir.DS.$pedido_id)) mkdir($pedidos_dir.DS.$pedido_id);
			$pedidos_dir = $pedidos_dir.DS.$pedido_id;
			move_uploaded_file($this->data['Documento']['nome_arquivo']['tmp_name'], $pedidos_dir.DS.$this->Documento->id.'_'.$this->data['Documento']['nome_arquivo']['name']);
			$this->Session->setFlash(__('Documento gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('/pedidos/edit/'.$pedido_id.'#tabDocumento');
		}

		$this->data = $this->Documento->read(null, $id);
	
		$this->set('tipos_documentos', $this->Documento->TiposDocumento->find('list', array('id','nome')));
	}
	
	public function delDocumento($pedido_id = null) {
		if ($this->request->isPost()) {
			$data = $this->data;
			$id = $data['Documento']['id'];
			$this->Documento->delete($id);
			$this->Session->setFlash(__('Documento excluido com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('/pedidos/edit/'.$pedido_id.'#tabDocumento');
		}
	}
	
	public function calendario($pedido_item_id = null) {
		$this->PedidosItem->Behaviors->attach('Containable');
		$this->PedidosItem->contain(
			array(
				'Item',
				'Pedido',
				'Pedido.Instituicao',
				'PedidosItensEtapasAtividade',
				'PedidosItensEtapasAtividade.EtapasAtividadesItem',
				'PedidosItensEtapasAtividade.EtapasAtividadesItem.Atividade',
				'PedidosItensEtapasAtividade.EtapasAtividadesItem.Etapa'
			)
		);
		$calendario = $this->PedidosItem->read(null, $pedido_item_id);
		$this->set('calendario', $calendario);
	}
	
	public function prazos($prazo_id = null) {
		if ($this->request->isPost()) {
			$this->PedidosItem->PedidosItensEtapasAtividade->save($this->data);
			$this->Session->setFlash(__('Data dos Prazos atualizado com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('/pedidos/calendario/'.$this->data['pedido_item_id']);
		}
		$this->data = $this->PedidosItem->PedidosItensEtapasAtividade->read(null, $prazo_id);
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			if ($this->Pedido->delete($this->data['Pedido']['id'])) {
				$this->Session->setFlash(__('Pedido excluída com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Pedido não pôde ser excluída!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
	
	public function calcula_prazos($data = null) {
		$pedidosItem_etapasAtividade = array();
		$data_inicio = DateTime::createFromFormat('d/m/Y', $data['PedidosItem']['data_inicial']);
		$data_fim = DateTime::createFromFormat('d/m/Y', $data['PedidosItem']['data_inicial']);

		$itens = $this->PedidosItem->Item->read(null, $data['PedidosItem']['item_id']);

		foreach($itens['EtapasAtividadesItem'] as $item) {
			$dtinterval = new DateInterval('P'.($item['prazo']-1).'D');
			$data_fim->add($dtinterval);
			$campos = array(
			'PedidosItensEtapasAtividade'=>array(
				'pedido_id' => $data['PedidosItem']['pedido_id'],
				'etapa_atividade_id' => $item['id'],
				'pedido_item_id' => $data['PedidosItem']['id'],
				'data_inicio_prevista' => $data_inicio->format('Y-m-d'),
				'data_fim_prevista' => $data_fim->format('Y-m-d')
			)
			);
			$data_inicio->add($dtinterval);
			$data_inicio->add(new DateInterval('P1D'));
			$data_fim->add(new DateInterval('P1D'));
			$this->PedidosItensEtapasAtividade->create(false);
			$this->PedidosItensEtapasAtividade->save($campos);
		}
	}
	
	public function add_item($pedido_id = null) {
		if ($this->request->isPost()) {
			$this->Pedido->PedidosItem->save($this->data);
			$data = $this->data;
			$data['PedidosItem']['id'] = $this->PedidosItem->id;
			$this->calcula_prazos($data);
			
			$this->Session->setFlash(__('Item do Pedido gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert'));
			$this->redirect('/pedidos/edit/'.$this->data['PedidosItem']['pedido_id'].'#tabItems');
		}
		
		$this->Pedido->Behaviors->attach('Containable');
		$this->Pedido->contain('Edital','Edital.AtaPreco.id');
		
		$pedido = $this->Pedido->read(null, $pedido_id);
		$ata_preco_id = array();
		
		foreach($pedido['Edital']['AtaPreco'] as $atapreco) array_push($ata_preco_id, intval( $atapreco['id'] ));
		
		$conditions = array(
			'Item.ata_preco_id' => $ata_preco_id
		);

		$items = $this->Pedido->PedidosItem->Item->find(
			'list',
			array(
				'fields' => array('id', 'nome'),
				'conditions' => $conditions
			)
		);
		
		$this->set('items', $items);
		$this->set('pedido_id', $pedido_id);
	}
	public function edit_item($item_id = null, $pedido_id = 0) {
		if ($this->request->isPost()) {
			$data = $this->data;
			if ($data['PedidosItem']['item_id'] == 0) unset($data['PedidosItem']['item_id']);
			$this->Pedido->PedidosItem->save($data);
			$this->Session->setFlash(__('Item do Pedido gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert'));
			$this->redirect('/pedidos/edit/'.$data['PedidosItem']['pedido_id'].'#tabItems');
		}
		$PedidoItem = $this->Pedido->PedidosItem->read(null, $item_id);
		$this->Pedido->Behaviors->attach('Containable');
		$this->Pedido->contain();
		$pedido = $this->Pedido->read(null, $pedido_id);
		$ata_preco_id = $pedido['Pedido']['ata_preco_id'];
		$conditions = array(
			'Item.ata_preco_id' => $ata_preco_id
		);
		$items = am(array('0'=>'Nenhum Item'), $this->Pedido->PedidosItem->Item->find(
			'list',
			array(
				'fields' => array('id', 'nome'),
				'conditions' => $conditions
			))
		);
		$this->set('items', $items);
		$this->set('pedido_id', $PedidoItem['PedidosItem']['pedido_id']);
		$this->set('item', $PedidoItem);
	}
	
	public function delItem() {
		if ($this->request->isPost()) {
			$this->layout = null;
			$this->PedidosItem->delete($this->data['PedidoItem']['id']);
			$this->Session->setFlash(__('Item excluido com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('/pedidos/edit/'.$pedido_id.'#tabItem');
		}
	}
	
	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->Pedido->find('list',array('fields'=>array('id','nome'))));
	}
}
