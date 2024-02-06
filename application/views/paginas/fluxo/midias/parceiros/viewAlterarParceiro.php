<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Mídias
        <small>Alterar  Parceiros</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('MidiasParceirosController/viewAreaParceiros') ?>">Sistema de Mídias</a></li>
        <li class="active">Alterar Parceiros</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
       <form action="<?php echo base_url('MidiasParceirosController/alterarParceiro') ?>" method="POST">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações Parceiros</h3>

          <?php $this->load->view('include/alertsMsg') ?>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
            <div class="col-md-6">

              <input type="hidden" name="idParceiro" value="<?php echo $parceiro[0]->idParceiros ?>">

              <div class="form-group">
                  <label for="nome">Nome :</label>
                  <input name="nome" type="text" class="form-control" id="nome" placeholder="Informe o nome" value="<?php echo $parceiro[0]->nomeParceiro ?>">
              </div>

              <div class="form-group">
                  <label for="descricao">Descrição :</label>
                  <textarea name="descricao" class="form-control" rows="4" placeholder="Descrição ..."><?php echo $parceiro[0]->descricaoParceiro ?></textarea>
              </div>

            </div>
            <!-- /.col -->
            <div class="col-md-6">

                <div class="form-group">
                  <label>Mostrar Site novo</label>
                  <select name="site_novo" class="form-control" style="width: 100%;">
                    <option value="S" <?php echo ($parceiro[0]->site == 'S')? 'selected="selected"': '' ?>>SIM</option>
                    <option value="N" <?php echo ($parceiro[0]->site == 'N')? 'selected="selected"': '' ?>>Não</option>
                  </select>
                </div>
                               
                <div class="form-group">
                  <label>Situação</label>
                  <select name="situacao" class="form-control" style="width: 100%;">
                    <option value="S" <?php echo ($parceiro[0]->ativo == 'S')? 'selected="selected"': '' ?>>ATIVO</option>
                    <option value="N" <?php echo ($parceiro[0]->ativo == 'N')? 'selected="selected"': '' ?>>INATIVO</option>
                  </select>
                </div>

              <button type="submit" class="btn btn-primary" >Alterar</button>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

      <div class="box box-solid box-success">
          <div class="box-header">
            <h3 class="box-title">Imagem Atual </h3>
            <div class="box-tools pull-right">
            <span class="label label-default">Selecione para excluir</span>
          </div><!-- /.box-tools -->
          </div><!-- /.box-header -->
          <div class="box-body">
            <p id="img_<?php echo $parceiro[0]->idParceiros ?>">
              <img src="<?php echo IMAGEM_PARCEIRO. $parceiro[0]->imagem?>" class="img-responsive img-thumbnail" width="170" height="110">
              <a href="#" class="excluirImagem" id="<?php echo $parceiro[0]->idParceiros ?>">
                  <span class="fa-stack fa-lg">
                      <i class="fa fa-square-o fa-stack-2x text-red"></i>
                      <i class="fa fa-trash  fa-stack-1x text-red"></i>
                  </span>			                 				
              </a> 							 	
            </p>
          </div><!-- /.box-body -->
          
      </div><!-- /.box -->

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Upload de Imagem</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="imagens" class="control-label">Selecionar Imagens:</label>
                  <input id="imagens" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                      <div id="resp"></div>                    
                </div>
              </div>              
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

      </form>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  
</script> 