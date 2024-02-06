<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Tipo de Arquivos
        <small>Cadastro</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('GruposController/viewLista') ?>">Sistema de Grupos</a></li>
        <li class="active">Cadastro</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

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

          <form action="<?php echo base_url('RestritoController/cadastrarTipoArquivo') ?>" method="POST">
          
          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                  <label for="nome">Tipo de Arquivo:</label>
                  <input type="text" name="descricao" class="form-control" id="descricao" placeholder="Informe o nome">
              </div>

               
               
              <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" style="width: 100%;">
                  <option value="S" selected="selected">ATIVO</option>
                  <option value="N">INATIVO</option>
                </select>
              </div>

              <button type="submit" class="btn btn-primary">Cadastrar</button>   
              <button type="submit" formaction="<?php echo base_url('RestritoController/viewListaTipoArquivo') ?>" class="btn btn-primary">Alterar</button>


              </form>


            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

     


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->