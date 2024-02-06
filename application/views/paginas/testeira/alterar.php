<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Testeiras
        <small>Alterar</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('TesteiraController/viewLista') ?>">Sistema de Testeiras</a></li>
        <li class="active">Alterar</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
       <form action="<?php echo base_url('TesteiraController/alterarTesteira') ?>" method="POST">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações</h3>

          <?php $this->load->view('include/alertsMsg') ?>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <input type="hidden" name="id" value="<?php echo $testeira[0]->id ?>">

          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                  <label for="nome">Nome :</label>
                  <input name="nome" type="text" class="form-control" id="nome" placeholder="Informe o nome" value="<?php echo $testeira[0]->nome ?>">
              </div>

              <div class="form-group">
                  <label for="url">URL :</label>
                  <input name="url" type="text" class="form-control" id="url" placeholder="Informe o URL" value="<?php echo $testeira[0]->url ?>">
              </div>
              
              
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              
              <div class="form-group">
                <label>Janela Modal</label>
                <select name="dialog" class="form-control" style="width: 100%;">
                  <option value="S" <?php echo ($testeira[0]->dialog == 'S')? 'selected="selected"':'' ?>>ATIVO</option>
                  <option value="N" <?php echo ($testeira[0]->dialog == 'N')? 'selected="selected"':'' ?>>INATIVO</option>
                </select>
              </div>
               
              <div class="form-group">
                <label>Situação</label>
                <select name="situacao" class="form-control" style="width: 100%;">
                  <option value="S" <?php echo ($testeira[0]->ativo == 'S')? 'selected="selected"':'' ?>>ATIVO</option>
                    <option value="N" <?php echo ($testeira[0]->ativo == 'N')? 'selected="selected"':'' ?>>INATIVO</option>
                </select>
              </div>

              <button type="submit" class="btn btn-warning" >Alterar Testeira</button>

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
            <p id="img_<?php echo $testeira[0]->id ?>">
              <img src="<?php echo base_url().'assets/img/testeira/'. $testeira[0]->imagem?>" class="img-responsive img-thumbnail" width="453" height="84">
              <a href="#" class="excluirImagem" id="<?php echo $testeira[0]->id ?>">
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