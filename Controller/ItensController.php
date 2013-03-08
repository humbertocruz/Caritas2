<?php
App::uses('AppController', 'Controller');
/**
 * Estados Controller
 *
 */
class ItensController extends AppController {

	public $uses = array('Item', 'AtaPreco', 'Fornecedor', 'Atividade', 'Etapa');

	public function _variables($header = null, $model = 'Item') {
		$this->set('header',$header);
		$this->set('model',$model);
		$this->set('controller', 'itens');
		$this->set('del_info', array('Item'=>'nome'));

		$atasprecos = $this->AtaPreco->find('list');
		$forneceores = $this->Fornecedor->find('list');
		$atividades = $this->Atividade->find('list');
		$etapas = $this->Etapa->find('list');
		

		$belongsTo = array('AtaPreco'=>$atasprecos, 'Fornecedor'=>$forneceores, 'Atividade'=>$atividades, 'Etapa'=>$etapas );

		$this->set('belongsTo', $belongsTo);

		$forms = array_merge(
			$this->Item->formFields
		);

		$this->set('forms',$forms);
	}
	
	public function _save(){
		if ($this->Item->save($this->data)):
			$this->Session->setFlash(__('Item gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			if (!isset($this->data['continue']) || $this->data['continue'] == 0): $this->redirect('index'); else: $this->redirect('edit/'.$this->Item->id); endif;
		else:
			$this->Session->setFlash(__('Item não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Item->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if ($this->Session->check('filter.search')) {
			$filter_search = $this->Session->read('filter.search');
			$conditions['Item.nome like'] = '%'.$filter_search.'%';
		}
		$this->set('data_index', $this->Item->find('all', array('conditions'=>$conditions)));
		$this->_variables('Itens');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/itens');
			}
			$this->_save();
		endif;
		$this->_variables('Adiciona Item');
	}
	
	public function addPrazo($item_id = 0) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/itens');
			}
			$data = $this->data;
			$this->Item->EtapasAtividadesItem->save($data);
			$this->Session->setFlash(__('Item gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('edit/'.$data['EtapasAtividadesItem']['item_id']);
		endif;
		$this->set('data', $this->Item->EtapasAtividadesItem->read(null));
		$this->set('etapas', $this->Item->EtapasAtividadesItem->Etapa->find('list'));
		$this->set('atividades', $this->Item->EtapasAtividadesItem->Atividade->find('list'));
		$this->set('foreignKey', $item_id);
		
		$this->_variables('Adiciona Item');
	}
	
	public function editaPrazo($item_id = 0, $prazo_id = 0) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/itens');
			}
			$data = $this->data;
			$this->Item->EtapasAtividadesItem->save($data);
			$this->Session->setFlash(__('Item gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('edit/'.$data['EtapasAtividadesItem']['item_id']);
		endif;
		$this->set('data', $this->Item->EtapasAtividadesItem->read(null));
		$this->set('etapas', $this->Item->EtapasAtividadesItem->Etapa->find('list'));
		$this->set('atividades', $this->Item->EtapasAtividadesItem->Atividade->find('list'));
		$this->set('foreignKey', $item_id);
		
		$this->_variables('Edita Item');
	}
	
	public function edit($id = null) {
		$this->Item->Behaviors->attach('Containable');
		$this->Item->contain(array(
			'EtapasAtividadesItem',
			'EtapasAtividadesItem.Etapa',
			'EtapasAtividadesItem.Atividade'
		));
		
		if ($this->request->isPost()):
			$this->_save();
		else:
			$this->set('ataprecos', $this->AtaPreco->find('list'));
			$this->set('fornecedores', $this->Fornecedor->find('list'));
			$this->set('data', $this->Item->read(null, $id));
		endif;
	}
	
	public function del() {
		if ($this->request->isPost()):
			$this->layout = null;		
			$estado = $this->Estado->read(null, $this->data['Estado']['id']);
			$estado['Estado']['lixeira'] = 1;
			$this->Estado->save($estado);
			
			$this->Session->setFlash(__('Estado excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			
			$this->redirect('index');
		endif;
	}
	
	public function loading() {
		$this->layout = null;
		$this->set('loading', $this->Estado->find('list',array('fields'=>array('id','nome'))));
	}
}