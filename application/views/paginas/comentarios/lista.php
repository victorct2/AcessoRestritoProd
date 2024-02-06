<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Filtro de Comentários
        <small>Lista de Comentários</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sistema de Filtro de Comentários</a></li>
        <li class="active">Lista de Comentários</li>
      </ol>
    </section>

      <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-commenting-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total de Comentários</span>
              <span class="info-box-number"><?php echo $this->comentariosDao_model->totalComentarios() ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-commenting-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total de Comentários Ativos</span>
              <span class="info-box-number"><?php echo $this->comentariosDao_model->totalComentarios(true,false,false) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-commenting-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total de Comentários à Liberar</span>
              <span class="info-box-number"><?php echo $this->comentariosDao_model->totalComentarios(false,false,true) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-commenting-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total de Comentários Inativos</span>
              <span class="info-box-number"><?php echo $this->comentariosDao_model->totalComentarios(false,true,false) ?></span>
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

            <table id="listaComentarios" class="table table-bordered table-striped dt-responsive">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Usuario</th>
                  <th>Tema do Vídeo</th>
                  <th>Comentário</th>                   
                  <th>Data do Comentário</th>    
                  <th>link do Vídeo</th>   
                  <th>Status</th>   
                  <th>Ação</th>
                </tr>
              </thead>
              <thead>
                <tr class="busca">
                  <th></th>                
                  <th><input type="text" data-column="1" class="form-control search-input-text"  placeholder="pesquisar usuário " style="width:100%;"></th>
                  <th><input type="text" data-column="2" class="form-control search-input-text"  placeholder="pesquisar vídeo ..." style="width:100%;"></th>
                  <th><input type="text" data-column="3" class="form-control search-input-text"  placeholder="pesquisar comentário ..." style="width:100%;"></th>                                  
                  <th><input type="text" data-column="4" value=""  class="form-control pull-right search-input-data" id="datepicker" placeholder="Data ..." style="width:100%;"></th>
                  <th></th>
                  <th>
                      <select  data-column="6" class="form-control search-input-select-informacao" style="width: 100%;">
                      <option value="">Selecione ...</option> 
                        <option value="S" >Ativo</option>
                        <option value="N">Inativo</option>
                        <option value="AC">À Confirmar</option>
                      </select>
                  </th>                   
                  <th></th>
                </tr>
              </thead>
              <tbody>
                
                               
              </tbody>
              <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Usuario</th>
                  <th>Tema do Vídeo</th>
                  <th>Comentário</th>                   
                  <th>Data do Comentário</th>    
                  <th>link do Vídeo</th>   
                  <th>Status</th>   
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