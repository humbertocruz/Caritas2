<?php
class SystemsController extends AppController {
	
	var $uses = array('Cidade','Instituicao','Fornecedor','Convenio','Projeto');
	
	public function beforeFilter() {
		//$this->Auth->allow('cidade','instituicao','convenio','fornecedor','back','changeProjeto','belongsTo','debugMode');
		$this->Auth->allow('*');
	}

	
	public function debugMode() {
		// Liga e desliga o modo de Debug
		if ($this->Session->check('sess_debugMode')) {
			$sess_debugMode = $this->Session->read('sess_debugMode');
		} else $sess_debugMode = false;
		
		if ($sess_debugMode) {
			$debugMode = false;
			$texto = 'Modo debug desativado!';
		} else {
			$debugMode = true;
			$texto = 'Modo debug ativado!';
		}
		$this->Session->write('sess_debugMode', $debugMode);
		$this->Session->setFlash(__($texto, true), 'bootstrap_flash', array('class'=>'alert-success'));
		$this->redirect($this->referer());
	}

	public function belongsto($url = null) {
		if ($this->Session->check('sess_belongsTo')) {
			$sess_belongsTo = $this->Session->read('sess_belongsTo');
		} else {
			$sess_belongsTo = array();
		}
		
		array_push($sess_belongsTo, $this->data);
		
		if (isset( $this->data['form_data'] ) ) {
			$url = $this->data['form_data'];
		}
		
		if (count($sess_belongsTo) > 0) {
			$this->Session->write('sess_belongsTo', $sess_belongsTo);
		} else {
			$this->Session->delete('sess_belongsTo');
		}
		$this->Session->write('do_belongsTo', true);

		$this->redirect('/'.$url);
	}
	
	public function changeProjeto() {
		if ( $this->request->isPost() ) {
			$projeto = $this->Projeto->read(null, $this->data['projeto_id']);
			$sess_models = $this->_sess_models();
			$sess_models['Projetos']['id'] = $projeto['Projeto']['id'];
			$sess_models['Projetos']['texto'] = $projeto['Projeto']['nome'];
			$this->Session->write( 'sess_models', $sess_models );
			
			$this->Session->setFlash(__('Projeto Alterado!', true), 'bootstrap_flash', array('class'=>'alert-success'));
			if ($this->data['action'] == 'index') {
				$this->redirect($this->data['here']);
			} else {
				if ($this->data['name'] != 'Pages') {
					$this->redirect('/'.$this->data['name']);
				} else {
					$this->redirect('/');
				}
			}
		}
	}

	public function back($id = null) {
		if ($this->Session->check('sess_belongsTo')) {
			$sess_belongsTo = $this->Session->read('sess_belongsTo');
			$load = array_pop($sess_belongsTo);
			if (empty($load)) $load = array_pop($sess_belongsTo);
			$load['System']['return_id'] = $id;
			$this->Session->write('load_belongsTo',$load);

			if (count($sess_belongsTo) > 0) {
				$this->Session->write('sess_belongsTo', $sess_belongsTo);
			} else {
				$this->Session->delete('sess_belongsTo');
				$this->Session->delete('do_belongsTo');
			}
			$this->redirect($load['System']['here']);
		} else {
			$this->redirect('/');
		}
	}
	
	public function cidade($estado = 'XX', $cidade = 0) {
		$this->Session->write('sessLoadEstado',$estado);
		$this->layout = null;
		$cidades = $this->Cidade->find('all', array('conditions'=>array('Cidade.estado_id'=>$estado),'order'=>array('Cidade.nome'=>'ASC')));
		$this->set('cidades',$cidades);
		$this->set('search_cidade',$cidade);
	}
	
	public function instituicao($cidade = 0) {
		$this->Session->write('sessLoadCidade',$cidade);
		$this->layout = null;
		$enderecos = $this->Instituicao->InstituicoesEndereco->find('list', array('fields'=>array('instituicao_id'), 'conditions'=>array('InstituicoesEndereco.cidade_id'=>$cidade)));
		$instituicoes = $this->Instituicao->find('all', array('conditions'=>array('Instituicao.id'=>$enderecos)));
		$this->set('instituicoes',$instituicoes);
		$this->set('search_cidade',$cidade);
	}
	
	public function convenio($instituicao = 0) {
		$this->Session->write('sessLoadInstituicao',$instituicao);
		$this->layout = null;
		$convenios = $this->Convenio->find('all', array('conditions'=>array('Convenio.instituicao_id'=>$instituicao)));
		$this->set('convenios',$convenios);
		$this->set('search_instituicao',$instituicao);
	}

	public function fornecedor($cidade = 0) {
		$this->Session->write('sessLoadCidade',$cidade);
		$this->layout = null;
		$enderecos = $this->Fornecedor->FornecedoresEndereco->find('list', array('fields'=>array('fornecedor_id'), 'conditions'=>array('FornecedoresEndereco.cidade_id'=>$cidade)));
		$fornecedores = $this->Fornecedor->find('all', array('conditions'=>array('Fornecedor.id'=>$enderecos)));
		$this->set('fornecedores',$fornecedores);
		$this->set('search_cidade',$cidade);
	}
	
	public function guardaForm($form_id = null) {
		$this->layout = null;
		$json = $this->request->data['json'];
		$this->Session->write('sr_forms.form_'.$form_id, array('key'=>$form_id,'url'=>$this->request->referer(),'json'=>$json));
	}
	
	public function restauraForm($form_id = null) {
		$this->layout = null;
		$form = $this->Session->read('sr_forms.form_'.$form_id);
		echo $form['json'];
		$this->render(null);
	}
	
	public function excluiForm($form_id = null) {
		$this->layout = null;
		$this->Session->delete( 'sr_forms.form_'.$form_id );
	}
	
}