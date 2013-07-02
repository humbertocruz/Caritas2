<div id="list-contatos">
<label>Contato</label>
<select name="data[Chamado][contato_id]" id="contato_id" class="span6" disabled="disabled">
</select>
	<div id="contatos-detalhes">
	</div>
</div>

<div class="modal hide fade" id="modal-add-email">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3>Modal header</h3>
  </div>
  <div class="modal-body">
	<p>One fine body…</p>
  </div>
  <div class="modal-footer">
	<a href="#" class="btn">Close</a>
	<a href="#" class="btn btn-primary">Save changes</a>
  </div>
</div>

<script>
	$(document).ready(function(){
		$('#btn-add-email').live(
			'click',
			function(){
				$('#modal-add-email').modal('show');
			}
		);
	});
</script>

