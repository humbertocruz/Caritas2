<?php
						foreach($historicos as $chamado) { ?>
						<tr>
							<td class="span2"><?php echo date('d/m/Y H:i', strtotime( $chamado['Chamado']['data_inicio'] ) );?></td>
							<td><?php echo $chamado['Contato']['nome'];?></td>
							<td><?php echo $chamado['Chamado']['solicitacao'];?></td>
							<td><?php echo $chamado['Atendente']['nome'];?>a</td>
						</tr>
					<?php } ?>