<?php
App::uses('AppController', 'Controller');
/**
 * Convenios Controller
 *
 */
class ConveniosController extends AppController {
	public $uses = array('Convenio','Instituicao','Estado','Cidade');
	
	public function _variables($header = null) {
		$this->set('header',$header);
		$this->set('model','Convenio');
		$this->set('controller', 'convenios');
		$this->set('del_info', array('Convenio'=>'num_convenio'));
		
		$forms = $this->Convenio->formFields;
		
		$this->set('forms',$forms);
		
		$filter_form = array(
			'filter/convenio_uf_cidade'	
		);
		$this->set('filter_form', $filter_form);
		$this->set('estados', $this->Estado->find('all'));
		if (isset($this->data['filter']['estado_id'])) {
			$this->set('cidades', $this->Cidade->find('list', array('fields'=>array('id','nome'),'conditions'=>array('Cidade.estado_id'=>$this->data['filter']['estado_id']))));
		} else {
			$this->set('cidades', array());	
		}
	}
	
	public function _save(){
		if ($this->Convenio->save($this->data)):
			$this->Session->setFlash(__('Convênio gravado com sucesso!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			$this->redirect('index');
		else:
			$this->Session->setFlash(__('Convênio não pode ser gravado!', true), 'bootstrap_flash', array('class'=>'alert-error'));
			$this->set('invalidFields', $this->Convenio->invalidFields());
		endif;
	}

	public function index() {
		$conditions = array();
		if (isset($this->data['filter'])) {
			if($this->data['filter']['cidade_id'] == 0 and isset($this->data['filter']['estado_id'])) {
				$cidades = $this->Instituicao->InstituicoesEndereco->Cidade->find(
					'list',
					array(
						'fields'=>array('Cidade.id'),
						'conditions'=>array('Cidade.estado_id'=>$this->data['filter']['estado_id'])
					)
				);
				$instituicoes = $this->Instituicao->InstituicoesEndereco->find(
					'list',
					array(
					      'fields'=>array('InstituicoesEndereco.instituicao_id'),
					      'conditions'=>array('InstituicoesEndereco.cidade_id'=>$cidades)
					)
				);
			} elseif (isset($this->data['filter']['cidade_id'])) {
				$instituicoes = $this->Instituicao->InstituicoesEndereco->find(
					'list',
					array(
					      'fields'=>array('InstituicoesEndereco.instituicao_id'),
					      'conditions'=>array('InstituicoesEndereco.cidade_id'=>$this->data['filter']['cidade_id'])
					)
				);
			}
			$conditions['Convenio.instituicao_id'] = $instituicoes;
		}
		$this->set('data_index', $this->Convenio->find('all', array('conditions'=>$conditions)));
		$this->_variables('Convênios');
	}
	
	public function add() {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Inclusão Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/Convenios');
			}
			$this->_save();
		endif;
		$tiposconvenios = $this->Convenio->TiposConvenio->find('list', array('fields'=>array('id','nome')));
		$orgaos = $this->Convenio->Orgao->find('list', array('fields'=>array('id','nome')));
		$editais = $this->Convenio->Edital->find('list', array('fields'=>array('id','numero')));

		$belongsTo = array('TiposConvenio'=>$tiposconvenios, 'Orgao'=>$orgaos, 'Edital'=>$editais);
		
		$this->set('belongsTo',$belongsTo);
		
		$this->_variables('Adiciona Convênio');
	}
	
	public function edit($id = null) {
		if ($this->request->isPost()):
			if ($this->data['System']['cancel'] == 1) {
				$this->Session->setFlash(__('Edição Cancelada!', true), 'bootstrap_flash', array('class'=>'alert'));
				$this->redirect('/Convenios');
			}
			$this->_save();
		else:
			$this->data = $this->Convenio->read(null, $id);
			$tiposconvenios = $this->Convenio->TiposConvenio->find('list', array('fields'=>array('id','nome')));
			$orgaos = $this->Convenio->Orgao->find('list', array('fields'=>array('id','nome')));
			$editais = $this->Convenio->Edital->find('list', array('fields'=>array('id','numero')));

			$belongsTo = array('TiposConvenio'=>$tiposconvenios, 'Orgao'=>$orgaos, 'Edital'=>$editais);
		
			$this->set('belongsTo',$belongsTo);
			$this->_variables('Edita Convênio');
		endif;
	}
	
	public function del($id = null) {
		if ($this->request->isPost()):
			$this->layout = null;
			
			if ($this->Convenio->delete($this->data['Convenio']['id'])) {
				$this->Session->setFlash(__('Convênio excluído com sucesso!',true), 'bootstrap_flash', array('class'=>'alert-success'));
			} else {
				$this->Session->setFlash(__('Convenio não pôde ser excluído!',true), 'bootstrap_flash', array('class'=>'alert-error'));
			}
			$this->redirect('index');
		endif;
	}
}
