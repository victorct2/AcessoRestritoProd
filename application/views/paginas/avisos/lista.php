<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Notícias
        <small>Lista</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sistema de Notícias</a></li>
        <li class="active">Lista</li>
      </ol>
    </section>

      <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-newspaper-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total de Notícias</span>
              <span class="info-box-number"><?php echo $this->AvisosDao_model->totalAvisos() ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-newspaper-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total de Notícias Ativos</span>
              <span class="info-box-number"><?php echo $this->AvisosDao_model->totalAvisos(true,false) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-newspaper-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total de Notícias Inativos</span>
              <span class="info-box-number"><?php echo $this->AvisosDao_model->totalAvisos(false,true) ?></span>
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

            <table id="listaNoticias" class="table table-bordered table-striped">
              <thead>
                <tr> 
                  <th>Imagem</th>
                  <th>Data</th>
                  <th>Descrição</th>
                  <th>Sinopse</th>                       
                  <th>Status/Ação</th>   
                 
                </tr>
              </thead>
              <thead>
                <tr class="busca">                  
                    <th></th>         
                   <th><input type="text" data-column="1" value=""  class="form-control pull-right search-input-data" id="datepicker" placeholder="Data ..." style="width:100%;"></th>                 
                  <th><input type="text" data-column="2" class="form-control search-input-text"  placeholder="pesquisar descrição ..." style="width:100%;"></th>
                  <th><input type="text" data-column="3" class="form-control search-input-text"  placeholder="pesquisar sinopse ..." style="width:100%;"></th>                    
                  <th>
                      <select  data-column="4" class="form-control search-input-select-informacao" style="width: 100%;">
                        <option value="">Selecione ...</option>                        
                        <option value="ATIVO">Ativo</option>
                        <option value="INATIVO">Inativo</option>                        
                      </select>
                  </th>                   
                  <th></th>
                </tr>
              </thead>
              <tbody>
                                               
              </tbody>
              <tfoot>
                <tr>
                <th>Imagem</th>
                  <th>Data</th>
                  <th>Descrição</th>
                  <th>Sinopse</th>                       
                  <th>Status/Ação</th>   
                  
                </tr>
              </tfoot>
            </table>
            
      
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

    
      <div class="modal face" id="modal-incluirLegenda" role="dialog"></div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
