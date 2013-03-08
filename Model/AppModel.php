<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
	function validateUnique($value, $params = array()) {
		$conditions = array($params['field'] => $value);
		if (!empty($this->id)) {
			$conditions = Set::merge($conditions, array($this->name.'.'.$this->primaryKey => '!= '.$this->id));
		}
		return !$this->hasAny($conditions);
	}
	
	function validateCPF($value) {
		$cpf = str_pad(ereg_replace('[^0-9]', '', $value['cpf']), 11, '0', STR_PAD_LEFT);
		if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
		{
			return false;
    	} else {
    		for ($t=9; $t<11; $t++) {
    			for ($d=0,$c=0; $c < $t; $c++) {
    				$d += $cpf{$c} * (($t + 1) - $c);
    			}
    			$d = ((10 * $d) % 11) % 10;
    			
    			if ($cpf{$c} != $d ) {
    				return false;
    			}
    		}
    	}
		return true;
	}
	
}
