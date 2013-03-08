<div id="modal-excluir" class="modal hide fade">
    <div class="modal-header">
        <span class="close bt-modal-cancelar">x</span>
        <h3>Excluir</h3>
    </div>
    <div class="modal-body">
        <p>Tem certeza que deseja excluir o registro <span class="text-modal-name"></span></p>
    </div>
    <div class="modal-footer">
        <a class="bt-modal-cancelar btn" href="#">Cancelar</a>
        <a class="bt-modal-excluir btn btn-danger" href="#">Excluir</a>
    </div>
</div>
<script>
    $(document).ready(function(){
        var exc_url = '';
        var exc_id = 0;
        $('.bt-del').click(function() {
            exc_url = $(this).data('del-url');
            exc_id = $(this).data('del-id');
            $('.text-modal-name').html($(this).data('del-text'));
            $('#modal-excluir').modal('show');
        });
        $('.bt-modal-cancelar').click(function(){
            $('#modal-excluir').modal('hide');
        });
        $('.bt-modal-excluir').click(function(){
           $.ajax({
            url: exc_url,
            type: 'POST',
            data: {id: exc_id},
            success: function(data) {
                window.location.reload();
            }
           });
        });
    });
</script>