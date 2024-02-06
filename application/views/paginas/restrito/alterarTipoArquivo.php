<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Tipo de Arquivo
        <small>Alterar</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('RestritoController/viewListaTipoArquivo') ?>">Tipo de Arquivo</a></li>
        <li class="active">Alterar</li>
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

          <form action="<?php echo base_url('RestritoController/alterarTipoArquivo') ?>" method="POST" >
             <input type="hidden" name="id" value="<?php echo $restritoTipo[0]->id ?>">

         
          
          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                  <label form="descricao">Descricao:</label>
                  <input type="text" name="descricao" class="form-control" id="descricao" placeholder="Informe o nome" value="<?php echo $restritoTipo[0]->descricao ?>">
              </div>
                          
              <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" style="width: 100%;">
                  <option value="S" <?php echo ($restritoTipo[0]->ativa == 'S')? 'selected="selected"':'' ?>>ATIVO</option>
                  <option value="N" <?php echo ($restritoTipo[0]->ativa == 'N')? 'selected="selected"':'' ?>>INATIVO</option>
                </select>
              </div>
                <div id="resp"></div>
              <button type="submit" class="btn btn-warning">Alterar tipo de arquivo</button>

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