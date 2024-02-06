<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Controle de Streaming
        <small>Lista de Streamings</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sistema de Controle de Streaming</a></li>
        <li class="active">Lista de Streamings</li>
      </ol>
    </section>

      <!-- Main content -->
    <section class="content">

      
    

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

            <table id="listaStreaming" class="table table-bordered table-striped dt-responsive">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Streaming</th>
                  <th>Link</th>
                  <th>Iframe</th>                   
                  <th>Status</th>   
                  <th>Ação</th>
                </tr>
              </thead>
              <thead>
                <tr class="busca">
                  <th></th>                
                  <th><input type="text" data-column="1" class="form-control search-input-text"  placeholder="pesquisar Streaming ... " style="width:100%;"></th>
                  <th><input type="text" data-column="2" class="form-control search-input-text"  placeholder="pesquisar link ..." style="width:100%;"></th>
                  <th></th>                                                    
                  <th>
                      <select  data-column="4" class="form-control search-input-select-informacao" style="width: 100%;">
                      <option value="">Selecione ...</option> 
                        <option value="ATIVO" >Ativo</option>
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
                  <th>ID</th>
                  <th>Streaming</th>
                  <th>Link</th>
                  <th>Iframe</th>                   
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