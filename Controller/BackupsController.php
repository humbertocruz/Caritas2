<?php
class BackupsController extends AppController {
	public function index() {
		$bkps = array();
		if ($handle = opendir(WWW_ROOT.'/backups_dir')) {
			/* This is the correct way to loop over the directory. */
			while (false !== ($entry = readdir($handle))) {
				array_push($bkps, array('arquivo'=>$entry,'tam'=>0));
			}
			closedir($handle);
		}
		$this->set('backups', $bkps);
	}
	
	public function gerar_arq() {
		exec('tar cf '.WWW_ROOT.'/backups_dir/arq_'.date('Y_m_d_H_i_s').'.tar.gz '.ROOT, $saida);
		$this->redirect('/backups');
	}
	
	public function gerar_db() {
		App::uses('ConnectionManager', 'Model');
		$dataSource = ConnectionManager::getDataSource('default');
		$username = $dataSource->config['login'];
		$passw = $dataSource->config['password'];
		$host = $dataSource->config['host'];
		$database = $dataSource->config['database'];
		//echo 'mysqldump -h '.$host.' -u '.$username.' -p'.$passw.' '.$database.' > '.WWW_ROOT.'/backups_dir/db_'.date('Y_m_d_H_i_s').'.tar.gz ';
		exec('mysqldump -h '.$host.' -u '.$username.' -p'.$passw.' '.$database.' > '.WWW_ROOT.'/backups_dir/db_'.date('Y_m_d_H_i_s').'.tar.gz ', $saida, $status);
		pr($status);
		//$this->redirect('/backups');
	}
}