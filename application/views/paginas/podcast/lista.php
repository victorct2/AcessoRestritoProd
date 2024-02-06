<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Podcast
        <small>Lista</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sistema de Podcast</a></li>
        <li class="active">Lista</li>
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

           

            <table id="listaPodcast" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Imagem</th>
                  <th>Título</th>
                  <th>Descrição</th>
                  <th>Informações</th>                   
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                                               
              </tbody>
              <tfoot>
                <tr>
                  <th>Imagem</th>
                  <th>Título</th>
                  <th>Descrição</th>
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