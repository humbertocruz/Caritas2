<?php
class ContatosInstituicoesController extends AppController {

	public function index() {

		$this->set('contos_inst', $this->ContatosInstituico->find('all'));
	
	}
}
