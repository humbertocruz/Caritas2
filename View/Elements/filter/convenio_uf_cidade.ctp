<?php

if (isset($this->data['filter']['estado_id'])) $filter_estado_id = $this->data['filter']['estado_id']; else $filter_estado_id = 0;
if (isset($this->data['filter']['cidade_id'])) $filter_cidade_id = $this->data['filter']['cidade_id']; else $filter_cidade_id = 0;
         
?>
<select class="span1" id="filter_estado" name="data[filter][estado_id]">
    <option value="0">Todos</option>
    <?php foreach ($estados as $estado) { ?>
    <option <?php if($filter_estado_id === $estado['Estado']['id']) echo 'selected="selected"'; ?> value="<?php echo $estado['Estado']['id'];?>"><?php echo $estado['Estado']['id']; ?></option>
    <?php } ?>
</select>
<select class="span3" id="filter_cidade" name="data[filter][cidade_id]">
    <option value="0">Todas</option>
    <?php foreach ($cidades as $key=>$value) { ?>
    <option <?php if($filter_cidade_id == $key) echo 'selected="selected"'; ?> value="<?php echo $key;?>"><?php echo $value; ?></option>
    <?php } ?>
</select>
<script>
    $(document).ready(function(){
        $('#filter_estado').change(function() {
            $.ajax({
                url: '/systems/cidade/'+$(this).val(),
                success: function(data) {
                    $('#filter_cidade').html(data);
                }
            })
        });
    });
</script>