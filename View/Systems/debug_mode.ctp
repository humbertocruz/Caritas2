<?php
if ($this->Session->read('sess_debugMode')) { ?>
<div class="alert alert-success">
<h3>Modo debug ativado!</h3>
</div>
<?php } else { ?>
<div class="alert alert-success">
<h3>Modo debug desativado!</h3>
</div>
<?php } ?>