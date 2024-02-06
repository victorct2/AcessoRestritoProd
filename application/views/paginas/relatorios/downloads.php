<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Relatórios
        <small>Downloads On-Demand</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sistema de Relatórios</a></li>
        <li class="active">Downloads On-Demand</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Relatório de Downloads aos Vídeos On-Demand | Canal Saúde </h3>                   
          </div>
          <div class="box-body">          
              <div class="col-lg-3 col-xs-6">
                <img src="<?php echo base_url()?>assets/img/logos/logoIntranet.png" class="img-responsive img-thumbnail">
              </div>
              <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-purple">
                <div class="inner">
                  <h3><?php echo $totalDownloadsOnDemand ?></h3>    
                  <p>Total de Downloads</p>
                </div>
                <div class="icon">
                  <i class="ion-android-contacts"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
        </div>                         
      </div>

      <div class="box box-default box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Filtros</h3>                   
        </div>
        <div class="box-body">          
          <form action="<?php echo base_url('RelatorioDownloadsController/relatorioDeDownload')?>" method="POST">
              <div class="col-lg-3 col-xs-6">
                <!-- Date range -->
                <div class="form-group">
                  <label>Filtrar Por Datas: (<?php echo (isset($periodo))? $periodo:'' ?>)</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input name="periodo" type="text" class="form-control pull-right" id="reservation" value="<?php echo (isset($periodo))? $periodo:'' ?>" >
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>
              <div class="col-lg-3 col-xs-6">
                
                <button type="submit" class="btn btn-info filtrar">Aplicar Filtro</button>
              </div>                
          </form>
        </div>  
                        
      </div>

      <div class="box box-warning box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Top Five</h3>                   
        </div>
        <div class="box-body">          
          <ul class="nav nav-stacked">
              <?php foreach ($topFiveMaisBaixados as $topFive) { ?>
                  <li><a><?php echo $topFive->nome_video ?><span class="pull-right badge bg-blue"><?php echo $topFive->total_downloads ?></span></a></li>  
              <?php } ?>              
          </ul>
        </div>                         
      </div>

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

           

            <table id="listaDownloads" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Título Programa</th>
                  <th>Programa</th>
                  <th>Número PGM</th>
                  <th>Total de Downloads</th>  
                </tr>
              </thead>
              <tbody>
               
              </tbody>
              <tfoot>
                <tr>
                  <th>Título Programa</th>
                  <th>Programa</th>
                  <th>Número PGM</th>
                  <th>Total de Downloads</th>
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