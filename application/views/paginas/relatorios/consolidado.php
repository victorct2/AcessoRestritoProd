<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Relatório
        <small>Consolidado do Mês Atual</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Relatório</a></li>
        <li class="active">Consolidado</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $this->relatoriosDao_model->totalVideos() ?></h3>

              <p>Total de Vídeos</p>
            </div>
            <div class="icon">
              <i class="ion-android-film"></i>
            </div>
            <a href="<?php echo base_url('VideosController/viewLista') ?>" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>5</h3>

              <p>Acessos ao Aplicativo</p>
            </div>
            <div class="icon">
              <i class="fa fa-mobile"></i>
            </div>
            <a href="#" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $this->relatoriosDao_model->totalAcessosOnDemandAtual() ?></h3>

              <p>Total de Acessos Mensais</p>
            </div>
            <div class="icon">
              <i class="ion-android-contacts"></i> 
            </div>
            <a href="#" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $this->relatoriosDao_model->totalDownloadsOnDemandAtual() ?></h3>

              <p>Total de Downloads</p>
            </div>
            <div class="icon">
              <i class="ion-android-download"></i>
            </div>
            <a href="#" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

     
      

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 ">
         
           <!-- Acessos box -->
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-trophy"></i>

              <h3 class="box-title">Vídeos Mais Acessados - Top Five</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <div class="box-body" >
              <?php foreach ($videosMaisAcessados as $videos) { ?>
                <div class="info-box bg-green">
                  <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text"><?php echo $videos->nome_video ?></span>
                    <span class="info-box-number"><?php echo $videos->total_acesso ?></span>

                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                        <span class="progress-description">
                          <?php echo $videos->nome_programa ?>
                        </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              <?php }?>
                
            </div>              
          </div>
          <!-- /.box (chat box) -->


          <!-- Acessos box -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-trophy"></i>

              <h3 class="box-title">Vídeos Mais Baixados - Top Five</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <div class="box-body" >
              <?php foreach ($videosMaisBaixados as $videos) { ?>
                <div class="info-box bg-yellow">
                  <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text"><?php echo $videos->nome_video ?></span>
                    <span class="info-box-number"><?php echo $videos->total_downloads ?></span>

                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                        <span class="progress-description">
                          <?php echo $videos->nome_programa ?>
                        </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              <?php }?>
                
            </div>              
          </div>
          <!-- /.box (chat box) -->

          <!-- Acessos box -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Visão Geral Dispositivos - Google Analytics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <div class="box-body" >
                  <div class="row">
                    <div class="col-md-6">
                      <div class="chart-responsive">
                        <canvas id="pieChartDispositivo" height="150"></canvas>
                      </div><!-- ./chart-responsive -->
                    </div><!-- /.col -->
                    <div class="col-md-4">
                      <ul class="chart-legend clearfix">
                        <li><i class="fa fa-square text-aqua"></i> Desktop</li>
                        <li><i class="fa fa-square text-red"></i> Mobile</li>
                        <li><i class="fa fa-square text-yellow"></i> Tablet</li>
                      </ul>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
            </div><!-- /.box-body -->                               
          </div>
          <!-- /.box (chat box) -->

          <!-- Acessos box -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Redes Sociais - Google Analytics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <div class="box-body" >
                      <!-- Widget: user widget style 1 -->
                      <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-aqua">
                          
                          <h3 class="widget-user-username">Redes Sociais</h3>
                          <h5 class="widget-user-desc">Google Analytics</h5>
                        </div>
                        <div class="box-footer no-padding">
                          <ul class="nav nav-stacked" id="redesSociais">
                          </ul>
                        </div>
                      </div><!-- /.widget-user -->       
            </div><!-- /.box-body -->                               
          </div>
          <!-- /.box (chat box) -->

          <!-- Acessos box -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Navegadores Utilizados - Google Analytics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <div class="box-body" >
                      <!-- Widget: user widget style 1 -->
                      <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-yellow">
                          
                          <h3 class="widget-user-username">Dispositivos</h3>
                          <h5 class="widget-user-desc">Google Analytics</h5>
                        </div>
                        <div class="box-footer no-padding">
                          <ul class="nav nav-stacked" id="dispositivos">
                              <?php foreach ($listaDispositivos as $key => $value) { ?>
                                  <li><a href="#"><i class="fa fa-mobile" aria-hidden="true"></i> <?php echo  $value->dimensions[0]?>  <span class="pull-right badge bg-blue"><?php echo $value->metrics[0]->values[0] ?></span></a></li>
                              <?php 
                                if($key > 7){
                                  break;
                                }
                              } ?>
                          </ul>
                        </div>
                      </div><!-- /.widget-user -->       
            </div><!-- /.box-body -->                               
          </div>
          <!-- /.box (chat box) -->

         
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-6 ">

          <!-- Acessos box -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Navegadores Utilizados - Google Analytics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <div class="box-body" >
                  <div class="row">
                    <div class="col-md-6">
                      <div class="chart-responsive">
                        <canvas id="pieChartBrowser" height="150"></canvas>
                      </div><!-- ./chart-responsive -->
                    </div><!-- /.col -->
                    <div class="col-md-4">
                      <ul class="chart-legend clearfix">
                        <li><i class="fa fa-circle-o text-red"></i> Chrome</li>
                        <li><i class="fa fa-circle-o text-green"></i> Internet Explorer</li>
                        <li><i class="fa fa-circle-o text-yellow"></i> FireFox</li>
                        <li><i class="fa fa-circle-o text-aqua"></i> Safari</li>
                        <li><i class="fa fa-circle-o text-light-blue"></i> Opera</li>
                        <li><i class="fa fa-circle-o text-gray"></i> Edge</li>
                      </ul>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
            </div><!-- /.box-body -->              
            <div class="box-footer no-padding">
                  <ul class="nav nav-pills nav-stacked" id="browserAcesosFooter">    
                  </ul>                
            </div>
            <!-- /.footer -->            
          </div>
          <!-- /.box (chat box) -->
         
          <!-- Acessos box -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Informações demográficas - Google Analytics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <div class="box-body" >
                  <div class="row">
                    <div class="col-md-6">
                      <div class="chart-responsive">
                        <canvas id="pieChartSexo" height="150"></canvas>
                      </div><!-- ./chart-responsive -->
                    </div><!-- /.col -->
                    <div class="col-md-4">
                      <ul class="chart-legend clearfix">
                        <li><i class="fa fa-square text-aqua"></i> Masculino</li>
                        <li><i class="fa fa-square text-red"></i> Feminino</li>
                      </ul>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
            </div><!-- /.box-body -->                               
          </div>
          <!-- /.box (chat box) -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->



    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  