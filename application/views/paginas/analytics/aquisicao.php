<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Google Analytics
        <small>Aquisição</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Google Analytics</a></li>
        <li class="active">Aquisição</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Filtros</h3>                   
        </div>
        <div class="box-body">          
          <form action="<?php echo base_url('RelatoriosControllerAnalytics/aquisicao')?>" method="POST">
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
      <!-- Small boxes (Stat box) -->
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

      
      
      
      

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 ">
        
         
          <!-- Acessos box -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Canais - Google Analytics</h3>

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
                          
                          <h3 class="widget-user-username">Canais</h3>
                          <h5 class="widget-user-desc">Google Analytics</h5>
                        </div>
                        <div class="box-footer no-padding">
                          <ul class="nav nav-stacked" id="dispositivos">
                            <?php foreach ($listaCanais as $key => $value) { ?>
                                <li><a href="#"> <?php echo $key+1 .'.  '.  $value->dimensions[0]?>  <span class="pull-right badge bg-blue"><?php echo $value->metrics[0]->values[0] ?></span></a></li>
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

              <h3 class="box-title">Todo Tráfego - Google Analytics</h3>

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
                          
                          <h3 class="widget-user-username">Todo Tráfego</h3>
                          <h5 class="widget-user-desc">Google Analytics</h5>
                        </div>
                        <div class="box-footer no-padding">
                          <ul class="nav nav-stacked" >
                            <?php foreach ($todoTrafego as $key => $value) { ?>
                                <li><a href="#"> <?php echo $key+1 .'.  '.  $value->dimensions[0]?>  <span class="pull-right badge bg-blue"><?php echo $value->metrics[0]->values[0] ?></span></a></li>
                            <?php 
                              if($key > 8){
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
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Tráfego de pesquisa orgânica - Google Analytics</h3>

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
                          
                          <h3 class="widget-user-username">Tráfego de pesquisa orgânica</h3>
                          <h5 class="widget-user-desc">Google Analytics</h5>
                        </div>
                        <div class="box-footer no-padding">
                          <ul class="nav nav-stacked" >
                            <?php foreach ($pesquisaOrganica as $key => $value) {
                                    if($value->dimensions[0] != '(not set)'){ ?>
                                      <li><a href="#"> <?php echo $key+1 .'.  '.  $value->dimensions[0]?>  <span class="pull-right badge bg-blue"><?php echo $value->metrics[0]->values[0] ?></span></a></li>
                            <?php   } 
                                  if($key > 8){
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

              <h3 class="box-title">Referência de redes Sociais - Google Analytics</h3>

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
                          
                          <h3 class="widget-user-username">Referência de redes Sociais</h3>
                          <h5 class="widget-user-desc">Google Analytics</h5>
                        </div>
                        <div class="box-footer no-padding">
                          <ul class="nav nav-stacked" >
                            <?php foreach ($referenciaRedesSociais as $key => $value) { 
                                  if($value->dimensions[0] != '(not set)'){ ?>
                                      <li><a href="#"> <?php echo $key .'.  <i class="fa fa-'.strtolower($value->dimensions[0]).'" aria-hidden="true"></i>  '.  $value->dimensions[0]?>  <span class="pull-right badge bg-blue"><?php echo $value->metrics[0]->values[0] ?></span></a></li>
                            <?php }                                                        
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

              <h3 class="box-title">Tráfego de Referência - Google Analytics</h3>

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
                          
                          <h3 class="widget-user-username">Tráfego de Referência</h3>
                          <h5 class="widget-user-desc">Google Analytics</h5>
                        </div>
                        <div class="box-footer no-padding">
                          <ul class="nav nav-stacked" >
                            <?php foreach ($trafegoReferencia as $key => $value) { 
                                if($value->dimensions[0] != '(direct)' && $value->dimensions[0] != 'google'){ ?>
                                <li><a href="#"> <?php echo $key-1 .'.  '.  $value->dimensions[0]?>  <span class="pull-right badge bg-blue"><?php echo $value->metrics[0]->values[0] ?></span></a></li>
                           <?php } 
                              if($key > 10){
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

  