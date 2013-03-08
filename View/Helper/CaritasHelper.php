<?php
App::uses('AppHelper', 'View/Helper');

class CaritasHelper extends AppHelper {

	public function calcEtapaAtividade( $data ) {
		$agora = strtotime('2000-01-01');
		$lastEA = array(
			'atividade' => '',
			'prevista' => null,
			'efetiva' => $agora
		);
		foreach($data as $EtapaAtividade) {
			
			$testDate = strtotime( $EtapaAtividade['PedidosItensEtapasAtividade'][0]['data_inicio_efetiva'] );
			
			if ( $testDate ) {
				$lastEA = array(
					'atividade' => $EtapaAtividade['Atividade']['nome'],
					'prevista' => date('d/m/Y', strtotime ( $EtapaAtividade['PedidosItensEtapasAtividade'][0]['data_inicio_prevista'] ) ),
					'efetiva' => date('d/m/Y', strtotime ( $EtapaAtividade['PedidosItensEtapasAtividade'][0]['data_inicio_efetiva'] ) )
				);
			}
		}
		if ($lastEA['efetiva'] == $agora) {
			$lastEA = array(
				'atividade' => 'Não iniciou',
				'prevista' => '---',
				'efetiva' => '---'
			);
		}
		return( $lastEA );
	}
}