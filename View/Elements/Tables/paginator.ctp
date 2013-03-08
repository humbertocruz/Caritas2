<?php
$atual = $params['paging'][$model]['page'];
$antes = ($atual-5 >= 1) ? ($atual-5) : 1;
$depois = ($atual+5 <= $params['paging'][$model]['pageCount'])?($atual+5):($params['paging'][$model]['pageCount']);
$url = '/'.$params['controller'].'/'.$params['action'];
$sort = (isset($params['named']['sort']))?('/sort:'.$params['named']['sort']):'';
$direction = (isset($params['named']['direction']))?('/direction:'.$params['named']['direction']):'';;

?>
<div class="pagination">
	<ul>
		<li class="<?php echo ($atual==1)?('disabled'):('');?>"><a href="<?php echo $url.'/page:1'.$sort.$direction;?>">&laquo;&laquo;</a></li>
		<li class="disabled"><a href="#">::</a></li>
		<?php for($pa=$antes;$pa<$atual;$pa++) { ?>
		<li class=""><a href="<?php echo $url.'/page:'.$pa.$sort.$direction; ?>"><?php echo $pa; ?></a></li>
		<?php } ?>
		<li class="active"><a href="#"><?php echo $atual; ?></a></li>
		<?php for($pd=$atual+1;$pd<=$depois;$pd++) { ?>
		<li class=""><a href="<?php echo $url.'/page:'.$pd.$sort.$direction; ?>"><?php echo $pd; ?></a></li>
		<?php } ?>
		<li class="disabled"><a href="#">::</a></li>
		<li class="<?php echo ($atual==$params['paging'][$model]['pageCount'])?('disabled'):('');?>"><a href="<?php echo $url.'/page:'.$params['paging'][$model]['pageCount'].$sort.$direction;?>">&raquo;&raquo;</a></li>
	</ul>
</div>
<div class="alert"><?php echo $params['paging'][$model]['count']; ?> registros em <?php echo $params['paging'][$model]['pageCount']; ?> páginas.</div>
