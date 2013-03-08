<?php
App::uses('AppHelper', 'View/Helper');

class BootstrapHelper extends AppHelper {

	public function br($data) {
		$date = date_create_from_format('Y-m-d H:i:s', $data);
		return $date->format('d/m/Y H:i:s');
	}
	
	public function delPost($params = array()) {
		if (!is_array($params)) $params = array();
		$defaults = array(
			'model' => null,
			'value' => null,
			'url' => null,
		);
		$params = array_merge($defaults, $params);
		$helper =
		'<form style="display: inline;" method="post" action="'.$params['url'].'">'
		.'<input type="hidden" name="data['.$params['model'].'][id]" value="'.$params['value'].'">'
		.'<button style="border: 0; background-color: transparent;" type="submit"><i class="icon icon-trash"></i></button>'
		.'</form>';
		return ($helper);
	}

	public function date($model = null, $label = null, $name = null, $value_date = '') {
		if (isset($this->data[$model][$name])) {
			$value_date = date('d/m/Y', strtotime($this->data[$model][$name]));
		}
		$helper = 
		'<div class="control-group">'
		.'<label class="control-label">'.$label.'</label>'
		.'<div class="controls">'
		.'<div class="input-append date" data-date="'.$value_date.'" data-date-format="dd/mm/yyyy" id="ctrl_date_'.$name.'">'
		.'<input type="text" value="'.$value_date.'" name="data['.$model.']['.$name.']" class="date span3"><span class="add-on"><i class="icon-calendar"></i></span>'
		.'</div>'
		.'</div>'
		.'</div>'
		;
		return ($helper);
	}
	public function date_time($params = array()) {
		if (!is_array($params)) $params = array();
		$defaults = array(
			'model' => null,
			'label' => null,
			'name' => null,
			'now' => false,
			'readonly' => false
		);
		$params = array_merge($defaults, $params);
		$value_date = '';
		$value_time = '';
		if (isset($this->data[$params['model']][$params['name']])) {
			$value_date = date('d/m/Y', strtotime($this->data[$params['model']][$params['name']]));
			$value_time = date('H:i:s', strtotime($this->data[$params['model']][$params['name']]));
		} else if ($params['now'] == true) {
			$value_date = date('d/m/Y');
			$value_time = date('H:i:s');
		}
		
		if ($params['readonly']) $readonly = 'readonly="readonly"'; else $readonly = '';
		$helper = 
		 '<div class="control-group">'
			.'<label class="control-label">'.$params['label'].'</label>'
			.'<div class="controls">'
				.'<div class="input-append date" data-date="'.$value_date.'" data-date-format="dd/mm/yyyy" id="ctrl_date_'.$params['name'].'">'
					.'<input '.$readonly.' type="text" value="'.$value_date.'" name="data['.$params['model'].']['.$params['name'].'_date]" placeholder="Data" class="date-time span3">'
					.'<span class="add-on"><i class="icon-calendar"></i></span>'
				.'</div>'
				.'<input '.$readonly.' type="text" value="'.$value_time.'" name="data['.$params['model'].']['.$params['name'].'_time]" placeholder="Hora" class="date-time span2">'
			.'</div>'
		.'</div>';
		if (!$readonly) {
		$helper .= '<script>'
		.'$("#ctrl_date_'.$params['name'].'").datepicker();'
		.'</script>';
		}
		return ($helper);
	}
	
	public function input_file($params) {
		if (!is_array($params)) $params = array();
		$defaults = array(
			'model' => null,
			'label' => null,
			'name' => null
		);
		$params = array_merge($defaults, $params);
		$helper = 
		'<div class="control-group">'
		.'<label class="control-label">'.$params['label'].'</label>'
		.'<div class="controls">'
		.'<input type="file" name="data['.$params['model'].']['.$params['name'].']" class="text span3">'
		.'</div>'
		.'</div>'
		;
		return ($helper);
	}
	
	public function text($params) {
		if (!is_array($params)) $params = array();
		$defaults = array(
			'model' => null,
			'label' => null,
			'name' => null,
			'value' => null
		);
		$params = array_merge($defaults, $params);
		if (isset($this->data[$params['model']][$params['name']])) {
			$value = $this->data[$params['model']][$params['name']];
		}
		$helper = 
		'<div class="control-group">'
		.'<label class="control-label">'.$params['label'].'</label>'
		.'<div class="controls">'
		.'<input type="text" value="'.$params['value'].'" name="data['.$params['model'].']['.$params['name'].']" class="text span3">'
		.'</div>'
		.'</div>'
		;
		return ($helper);
	}
	public function textarea($model = null, $label = null, $name = null) {
		$value = '';
		if (isset($this->data[$model][$name])) {
			$value = $this->data[$model][$name];
		}
		$helper = 
		'<div class="control-group">'
		.'<label class="control-label">'.$label.'</label>'
		.'<div class="controls">'
		.'<textarea name="data['.$model.']['.$name.']" class="text span3">'.$value.'</textarea>'
		.'</div>'
		.'</div>'
		;
		return ($helper);
	}
	public function select($params = array()) {
		if (!is_array($params)) $params = array();
		
		$defaults = array(
			'model' => null,
			'label' => null,
			'name' => null,
			'data' => array(),
			'controller' => null,
			'value' => null
		);
		$params = array_merge($defaults, $params);
		

		$helper = 
		'<div class="control-group">'
		.'<label class="control-label">'.$params['label'].'</label>'
		.'<div class="controls">'
		.'<select id="fld_'.$params['name'].'" name="data['.$params['model'].']['.$params['name'].']" class="belongsTo span3">';
		foreach($params['data'] as $key=>$val) {
			if ($params['value'] == $key) $selected = 'selected="selected"'; else $selected = '';
			$helper.='<option '.$selected.' value="'.$key.'">'.$val.'</option>';
		}
		$helper.='</select>';
		if ($params['controller']) {
			$helper.='<a href="#" class="btn bt-model" data-controller="'.$params['controller'].'" id="btn_access_"'.$params['model'].'><b class="icon-plus-sign"></b></a>';
		}
		$helper.='</div>'
		.'</div>'
		;
		return ($helper);
	}
	
	public function session( $model = null, $label = null, $name = null, $data = array(), $controller = null, $value = null, $value_txt = '') {
		$helper = 
		'<div class="control-group">'
		.'<label class="control-label">'.$label.'</label>'
		.'<div class="controls">'
		.'<input type="hidden" value="'.$value.'" data-value="'.$value.'" id="fld_'.$name.'" name="data['.$model.']['.$name.']">'
		.'<input type="text" value="'.$value_txt.'" readonly="readonly" class="span3">';
		$helper.='</div>'
		.'</div>'
		;
		return ($helper);
	}
	
	public function belongsTo($model = null, $label = null, $name = null, $data = array(), $controller = null, $fixed = false, $value = null) {
		if (isset($this->data[$model][$name])) {
			$value = $this->data[$model][$name];
		}
		if ($fixed != false) {
			$fixo = 'readonly="readonly"';
			$fixo_class = 'readonly';
		} else { 
			$fixo = '';
			$fixo_class = '';
		}
		$helper = 
		'<div class="control-group">'
		.'<label class="control-label">'.$label.'</label>'
		.'<div class="controls">'
		.'<select '.$fixo.' data-value="'.$value.'" id="fld_'.$name.'" name="data['.$model.']['.$name.']" class="belongsTo span3 '.$fixo_class.'">';
		foreach($data as $key=>$val) {
			if ($key == $value) $selected = 'selected="selected"'; else $selected = '';
			$helper.='<option '.$selected.' value="'.$key.'">'.$val.'</option>';
		}
		$helper.='</select>';
		if ($controller) {
			$helper.='<a href="#" class="btn bt-model" data-controller="'.$controller.'" id="btn_access_"'.$model.'><b class="icon-plus-sign"></b></a>';
		}
		$helper.='</div>'
		.'</div>'
		;
		return ($helper);
	}
	public function instituicao($model = null, $label = null, $name = null, $data = array('Estado'=>array(),'Cidade'=>array(),'Instituicao'=>array())) {
		$value = '';
		if (isset($this->data[$model][$name])) {
			$value = $this->data[$model][$name];
		}
		if ( isset( $this->data['Pedido']['instituicao_id'] ) ) {
			$instituicao_id_val = $this->data['Pedido']['instituicao_id'];
			$cidade_id_val = $this->data['Instituicao']['InstituicoesEndereco'][0]['cidade_id'];
			$estado_id_val = $this->data['Instituicao']['InstituicoesEndereco'][0]['Cidade']['estado_id'];
		} else {
			$estado_id_val = 0;
			$cidade_id_val = 0;
			$instituicao_id_val = 0;
		}
		$helper = '<div class="control-group">'
		.'<label class="control-label">'.$label.'</label>'
		.'<div class="controls">'
		.'<select id="fld_'.$name.'_estado" name="data['.$model.']['.$name.'][estado]" class="span1">'
		.'<option value="0">Selecione o Estado</option>';
		foreach($data['Estado'] as $key=>$val) {
			if ($estado_id_val === $key) $selected = 'selected="selected"'; else $selected = '';
			$helper.='<option '.$selected.' value="'.$key.'">'.$val.'</option>';
		}
		$helper.='</select>&nbsp;'
		.'<select id="fld_'.$name.'_cidade" name="data['.$model.']['.$name.'][cidade]" class="span3">'
		.'<option value="0">Selecione o Município</option>';
		foreach($data['Cidade'] as $key=>$val) {
			if ($cidade_id_val == $key) $selected = 'selected="selected"'; else $selected = '';
			$helper.='<option '.$selected.' value="'.$key.'">'.$val.'</option>';
		}
		$helper.='</select>&nbsp;'
		.'<select id="fld_'.$name.'" name="data['.$model.']['.$name.']" class="belongsTo span3">'
		.'<option value="0">Selecione a Instituição</option>';
		foreach($data['Instituicao'] as $key=>$val) {
			if ($instituicao_id_val == $key) $selected = 'selected="selected"'; else $selected = '';
			$helper.='<option '.$selected.' value="'.$key.'">'.$val.'</option>';
		}
		$helper.='</select>'
		.'</div>'
		.'</div>'
		;
		return ($helper);
	}
}