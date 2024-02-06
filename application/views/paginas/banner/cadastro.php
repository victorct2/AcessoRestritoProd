<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Banners
        <small>Cadastro</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('BannerController/viewLista') ?>">Sistema de Banners</a></li>
        <li class="active">Cadastro</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
       <form action="<?php echo base_url('BannerController/cadastrarBanner') ?>" method="POST" id="formBanner">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações</h3>

          <?php $this->load->view('include/alertsMsg') ?>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                  <label for="nome">Nome :</label>
                  <input name="nome" type="text" class="form-control" id="nome" placeholder="Informe o nome">
              </div>

              <div class="form-group">
                  <label for="url">URL :</label>
                  <input name="url" type="text" class="form-control" id="url" placeholder="Informe o URL">
              </div>

            </div>
            <!-- /.col -->
            <div class="col-md-6">

                <div class="form-group">
                  <label>Mostrar Site novo</label>
                  <select name="site_novo" class="form-control" style="width: 100%;">
                    <option value="S" selected="selected">SIM</option>
                    <option value="N">Não</option>
                  </select>
                </div>
                               
                <div class="form-group">
                  <label>Situação</label>
                  <select name="situacao" class="form-control" style="width: 100%;">
                    <option value="S" selected="selected">ATIVO</option>
                    <option value="N">INATIVO</option>
                  </select>
                </div>

              <div id="resp"></div>
              <button type="submit" class="btn btn-primary" >Cadastrar</button>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

      </form>

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Upload de Imagem</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
              <?= form_open_multipart("UploadController/uploadImagens", ['id' => 'uploader']); ?>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="videos" class="control-label">Selecionar Arquivo:</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <span class="butn butn-success fileinput-button">
                        <span>Procurar</span><input type="file" name="userfile" id="uploadBtn">
                    </span>
                    <div class="col-md-6">
                      <input id="uploadFile" placeholder="Choose File" disabled="disabled" class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Upload</button>

                  </div>
                  <div class="col-md-6">
                    <div class="progress">
                      <div class="progress-bar progress-bar-success progress-bar-striped" id="progressBarUpload" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                      </div>
                    </div>
                  </div>
                  <?php echo form_close() ?>
                  <div id="message"></div>
                
            </div>
            <!-- /.row -->
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