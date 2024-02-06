<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Google Analytics
        <small>Público</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Google Analytics</a></li>
        <li class="active">Público</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="box box-default box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Filtros</h3>                   
        </div>
        <div class="box-body">          
          <form action="<?php echo base_url('RelatoriosControllerAnalytics/visaoGeral')?>" method="POST">
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
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $totalPorSessao ?></h3>
              <p>Sessões</p>
            </div>
            <div class="icon">
              <i class="ion-android-film"></i>
            </div>            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $totalUsuarios ?></h3>

              <p>Total de Usuários</p>
            </div>
            <div class="icon">
              <i class="ion-android-contacts"></i> 
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $totalVisualizacoes ?></h3>

              <p>Total de Visualizações</p>
            </div>
            <div class="icon">
              <i class="fa fa-mobile"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->        
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3><?php echo $totalVisualizacoesUnicas ?></h3>

              <p>Total de Visualizações únicas</p>
            </div>
            <div class="icon">
              <i class="ion-android-download"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      
      <div class="box box-default box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Usuários Ativos</h3>                   
        </div>
            <div class="box-body">
                 <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-gray">
                    <div class="inner">
                      <h3><?php echo $usuariosAtivosUmDia ?></h3>
                      <p>Usuários ativos por um dia</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-users"></i>
                    </div>            
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-maroon">
                    <div class="inner">
                      <h3><?php echo $usuariosAtivosSeteDia ?></h3>

                      <p>Usuários ativos por sete dias</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-users"></i> 
                    </div>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-navy">
                    <div class="inner">
                      <h3><?php echo $usuariosAtivosQuatorzeDia ?></h3>
                      <p>Usuários ativos por 14 dias</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-users"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->        
                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-teal">
                    <div class="inner">
                      <h3><?php echo $usuariosAtivosTrintaDia ?></h3>

                      <p>Usuários ativos por 30 dias</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-users"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->               
            </div>                                 
          </div>
      
      

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 ">

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
            <div class="box-footer">
              <ul class="nav nav-stacked" id="visaoGeralDispositivo">
                  
              </ul>
            </div>                              
          </div>
          <!-- /.box (chat box) -->

          <!-- Acessos box -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Visitantes Novos x Recorrentes - Google Analytics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <div class="box-body" >
                  <div class="row">
                    <div class="col-md-6">
                      <div class="chart-responsive">
                        <canvas id="pieChartVisitantes" height="150"></canvas>
                      </div><!-- ./chart-responsive -->
                    </div><!-- /.col -->
                    <div class="col-md-4">
                      <ul class="chart-legend clearfix">
                        <li><i class="fa fa-square text-green"></i> Novos Visitantes</li>
                        <li><i class="fa fa-square text-yellow"></i> Visitantes Recorrentes</li>                        
                      </ul>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
            </div><!-- /.box-body -->      
            <div class="box-footer">
              <ul class="nav nav-stacked" id="novosRecorrentes">
                  
              </ul>
            </div>                          
          </div>
          <!-- /.box (chat box) -->
         
          <!-- Acessos box -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Dipositivos Utilizados - Google Analytics</h3>

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

          <!-- Acessos box -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Sistemas Operacionais - Google Analytics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <div class="box-body" >
                      <!-- Widget: user widget style 1 -->
                      <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-navy">
                          
                          <h3 class="widget-user-username">Sistemas Operacionais</h3>
                          <h5 class="widget-user-desc">Google Analytics</h5>
                        </div>
                        <div class="box-footer no-padding">
                          <ul class="nav nav-stacked" >
                            <?php foreach ($listaSistemasOperacionais as $key => $value) { ?>
                                <li><a href="#"><i class="fa fa-<?php echo  strtolower($value->dimensions[0])?>" aria-hidden="true"></i> <?php echo  $value->dimensions[0]?>  <span class="pull-right badge bg-blue"><?php echo $value->metrics[0]->values[0] ?></span></a></li>
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
            <div class="box-footer">
              <ul class="nav nav-stacked" id="densidadeDemografica">
                  
              </ul>
            </div>                               
          </div>
          <!-- /.box (chat box) -->

          <!-- Acessos box -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Países - Google Analytics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <div class="box-body" >
                      <!-- Widget: user widget style 1 -->
                      <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-purple">
                          
                          <h3 class="widget-user-username">Países</h3>
                          <h5 class="widget-user-desc">Google Analytics</h5>
                        </div>
                        <div class="box-footer no-padding">
                          <ul class="nav nav-stacked" >
                            <?php foreach ($listaLocais as $key => $value) { ?>
                                <li><a href="#"><img src="<?php echo base_url().'/assets/img/flags/'. strtolower(substr($value->dimensions[0], 0, 2)).'.png' ?>" alt=""> <?php echo  $value->dimensions[0]?>  <span class="pull-right badge bg-blue"><?php echo $value->metrics[0]->values[0] ?></span></a></li>
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

          <!-- Acessos box -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Idioma - Google Analytics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <div class="box-body" >
                      <!-- Widget: user widget style 1 -->
                      <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-green">
                          
                          <h3 class="widget-user-username">Idioma</h3>
                          <h5 class="widget-user-desc">Google Analytics</h5>
                        </div>
                        <div class="box-footer no-padding">
                          <ul class="nav nav-stacked" >
                            <?php foreach ($listaIdioma as $key => $value) { ?>
                                <li><a href="#"> <?php echo  $value->dimensions[0]?>  <span class="pull-right badge bg-blue"><?php echo $value->metrics[0]->values[0] ?></span></a></li>
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
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->



    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  