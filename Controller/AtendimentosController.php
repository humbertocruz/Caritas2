<?php
App::uses('AppController', 'Controller');
/**
 * Atendentes Controller
 *
 */
class AtendimentosController extends AppController {
	
	var $uses = array('Contato','Instituicao','ContatosInstituicao','Chamada','ChamadasInstituicao');

	public function index() {
		if ($this->request->isPost()) {
			//pr($this->data);
			if(!isset($this->data['search']['contato_id'])) {
				$conditions = array(
					'Contato.nome like' => '%'.$this->data['search']['text'].'%' 
				);
			} else {
				$conditions = array(
					'Contato.id' => $this->data['search']['contato_id'] 
				);
			}
			$contatos = $this->Contato->find('all', array('conditions'=>$conditions));
			$this->set('contatos',$contatos);
			
			if(!isset($this->data['search']['contato_id'])) {
				$conditions = array(
					'Instituicao.nome_fantasia like' => '%'.$this->data['search']['text'].'%' 
				);
				$instituicoes = $this->Instituicao->find('all', array('conditions'=>$conditions));
				$this->set('instituicoes',$instituicoes);
			} else {
				$conditions = array(
					'ContatosInstituicao.contato_id' => $this->data['search']['contato_id'] 
				);
				$instituicoesContato = $this->ContatosInstituicao->find('list', array('conditions'=>$conditions, 'fields'=>'ContatosInstituicao.instituicao_id'));
				$instituicoes = $this->Instituicao->find('all', array('conditions'=>array('Instituicao.id'=>$instituicoesContato)));
				$this->set('instituicoes',$instituicoes);
			}
			if(isset($this->data['search']['instituicao_id'])) {
				$conditions = array(
					'Chamada.instituicao_id' => $this->data['search']['instituicao_id'] 
				);
				$chamadas = $this->Chamada->find('all', array('conditions'=>$conditions));
				$this->set('chamadas',$chamadas);
			}
		}
	}

}