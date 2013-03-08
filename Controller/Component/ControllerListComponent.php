<?php
class ControllerListComponent extends Component {
    public function get() {
        $controllerClasses = App::objects('controller');
        $controllers = array();
        foreach($controllerClasses as $controller) { 
            if ($controller != 'AppController') { 
                if(App::import('Controller', str_replace('Controller','', $controller))) {
	                $actions = get_class_methods($controller);
	                $valid_actions = array();
	                foreach($actions as $k => $v) {
	                	if($v{0} == '_') continue;
	                	if($v == 'beforeFilter') {
	                		break;
	                	}
	                	array_push($valid_actions, $v);
	                }
    	            $controllers[$controller] = $valid_actions;
                } else {
                    $controllers[$controller] = array();
                }
            }
        }
		     
        return $controllers;  
    }
}