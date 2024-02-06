<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Vídeos
        <small>Lista</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sistema de Vídeos</a></li>
        <li class="active">Lista</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-file-video-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total de Vídeos</span>
              <span class="info-box-number"><?php echo $this->videosDao_model->totalVideos() ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-star-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total de vídeos em Destaque</span>
              <span class="info-box-number"><?php echo $this->videosDao_model->totalVideos(true,false,false) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-outdent"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total de Vídeos Incompletos</span>
              <span class="info-box-number"><?php echo $this->videosDao_model->totalVideos(false,true,false) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-power-off"></i></span> 

            <div class="info-box-content">
              <span class="info-box-text">Total de Vídeos Inativos</span>
              <span class="info-box-number"><?php echo $this->videosDao_model->totalVideos(false,false,true) ?></span>
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

            <table id="listaVideos" class="table table-bordered table-striped dt-responsive">
              <thead>
                <tr>
                  <th>Imagem</th>
                  <th>Nome</th>
                  <th>Descrição</th>
                  <th>Programa</th>
                  <th>Data</th>
                  <th>Informações</th>                   
                  <th>Ação</th>
                </tr>
              </thead>
              <thead>
                <tr class="busca">
                  <th></th>
                  <th><input type="text" data-column="1" class="form-control search-input-text"  placeholder="pesquisar nome " style="width:100%;"></th>
                  <th><input type="text" data-column="2" class="form-control search-input-text"  placeholder="pesquisar descricao ..." style="width:100%;"></th>
                  <th>
                    <select data-column="3" class="form-control select2 search-input-select-programa" style="width: 100%;">
                      <option value="">Selecione ...</option> 
                      <?php foreach ($listProgramas as $value) { ?>
                            <option value="<?php echo $value->id ?>" ><?php echo $value->titulo ?></option>  
                      <?php } ?>                                     
                    </select>
                  </th>
                  <th><input type="text" data-column="4"  class="form-control pull-right search-input-data" id="datepicker" placeholder="Data ..." style="width:100%;"></th>
                  <th>
                      <select  data-column="5" class="form-control search-input-select-informacao" style="width: 80%;">
                      <option value="">Selecione ...</option> 
                        <option value="ATIVO" >Ativo</option>
                        <option value="INCOMPLETO">Incompleto</option>
                        <option value="INATIVO">Inativo</option>
                        <option value="DESTAQUE">Em Destaque</option>
                        <option value="SEMDESTAQUE">Sem Destaque</option>
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
                  <th>Nome</th>
                  <th>Descrição</th>
                  <th>Programa</th>
                  <th>Data</th>
                  <th>Informações</th>                   
                  <th>Ação</th>
                </tr>
              </tfoot>
            </table>
            
      
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Canal Saúde - Vídeos</h4>
            </div>
            <div class="modal-body">
            
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>    
        </div>    
    </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
