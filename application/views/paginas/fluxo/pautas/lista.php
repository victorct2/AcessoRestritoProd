<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Pautas
        <small>Lista</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sistema de Pautas</a></li>
        <li class="active">Lista</li>
      </ol>
    </section>

      <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-file-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total de Pautas</span>
              <span class="info-box-number"><?php echo $this->pautasDao_model->totalPautas() ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-file-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total de Pautas Ativos</span>
              <span class="info-box-number"><?php echo $this->pautasDao_model->totalPautas(true,false) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-file-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total de Pautas Bloqueadas</span>
              <span class="info-box-number"><?php echo $this->pautasDao_model->totalPautas(false,true) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
      </div>
      <!-- /.row -->
    

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
          <?php $this->load->view('include/alertsMsg') ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> 

            <table id="listaPautas" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th></th>                  
                  <th>Tema</th>
                  <th>Descrição</th>
                  <th>Nº PGM</th>
                  <th>Programa</th>
                  <th>Informações</th>  
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                
                               
              </tbody>
              <tfoot>
                <tr>
                  <th></th>  
                  <th>Tema</th>
                  <th>Descrição</th>
                  <th>Nº PGM</th>
                  <th>Programa</th>
                  <th>Informações</th>  
                  <th>Ação</th>
                </tr>
              </tfoot>
            </table>
            
      
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

    


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  
</script> 