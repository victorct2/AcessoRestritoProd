<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Apresentadores
        <small>Lista</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Apresentadores</a></li>
        <li class="active">Lista</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações</h3>

          <div class="box-tools pull-right">
            <a href="<?php echo base_url('ImprensaController/viewCadastroApresentador')?>" class="btn btn-success"><i class="fa fa-plus"></i> Cadastrar Apresentador</a>           
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>            
          </div>
          <?php $this->load->view('include/alertsMsg') ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> 

            <table id="listaApresentadores" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Foto</th>
                  <th>Nome</th>
                  <th>Nome Artístico</th>
                  <th>Resumo Profissional</th>                  
                  <th>Ação</th>
                </tr>
              </thead>
              <thead>
                <tr class="busca">
                  <th></th>
                  <th><input type="text" data-column="1" class="form-control search-input-text"  placeholder="pesquisar nome " style="width:100%;"></th>
                  <th><input type="text" data-column="2" class="form-control search-input-text"  placeholder="pesquisar nome artístico ..." style="width:100%;"></th>                
                  <th><input type="text" data-column="3" class="form-control search-input-text"  placeholder="pesquisar resumo profissional ..." style="width:100%;"></th>                                                   
                  <th></th>
                </tr>
              </thead>
              <tbody>
                                               
              </tbody>
              <tfoot>
                <tr>
                  <th>Foto</th>
                  <th>Nome</th>
                  <th>Nome Artístico</th>
                  <th>Resumo Profissional</th>                  
                  <th>Ação</th>
                </tr>
              </tfoot>
            </table>


      
        </div>

      </div>
      <!-- /.box -->

    


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  
</script> 