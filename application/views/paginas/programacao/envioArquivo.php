<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Programação
        <small>Envio de Arquivo</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('ProgramacaoController/viewLista') ?>">Sistema de Programação</a></li>
        <li class="active">Cadastro</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <form action="<?php echo base_url('ProgramacaoController/cadastrarArquivo')?>" method="POST" id="formArquivo">    

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Upload de Arquivo</h3>

          <div class="box-tools pull-right">
              
              <button type="submit" class="btn btn-primary ">Cadastrar</button>  
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div id="resp"></div>
          </form>
            <div class="row">
            <?= form_open_multipart("UploadController/uploadArquivos", ['id' => 'uploader']); ?>
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
        <div class="box-footer">
          
        </div>
        
      </div>
      <!-- /.box -->

        

      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  
</script> 