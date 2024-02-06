<hr>
<?php

$resultado_ok = $this->session->flashdata('resultado_ok');
$resultado_error = $this->session->flashdata('resultado_error');
$mensagem = $this->session->flashdata('mensagem');

if (@count($resultado_error)!= ''){?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Problemas!</h4>
        <?php echo $resultado_error ?>
    </div>
<?php } ?>
<?php /*if (count($resultado_ok)!= ''){?>
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-info"></i> Informação!</h4>
    </div>
<?php }*/ ?>
<?php if (@count($mensagem)!= ''){?>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-warning"></i> Atenção!</h4>
        <ul>
        <?php foreach ($mensagem as $msg) {?>
              <li><?php echo $msg ?></li>
        <?php } ?>
        </ul>
    </div>
<?php } ?>
<?php if (@count($resultado_ok)!= ''){?> 
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
        <?php echo $resultado_ok ?>
    </div>
<?php } ?>
