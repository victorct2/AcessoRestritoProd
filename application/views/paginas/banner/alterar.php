<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Banners
        <small>Alterar</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('BannerController/viewLista') ?>">Sistema de Banners</a></li>
        <li class="active">Alterar</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
       <form action="<?php echo base_url('BannerController/alterarBanner') ?>" method="POST" id="formBanner">
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

          <input type="hidden" name="id" value="<?php echo $banner[0]->id ?>">

          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                  <label for="nome">Nome :</label>
                  <input name="nome" type="text" class="form-control" id="nome" placeholder="Informe o nome" value="<?php echo $banner[0]->nome ?>">
              </div>

              <div class="form-group">
                  <label for="url">URL :</label>
                  <input name="url" type="text" class="form-control" id="url" placeholder="Informe o URL" value="<?php echo $banner[0]->url ?>">
              </div>              
              
            </div>
            <!-- /.col -->
            <div class="col-md-6">  

              <div class="form-group">
                  <label>Mostrar Site novo</label>
                  <select name="site_novo" class="form-control" style="width: 100%;">
                    <option value="S" <?php echo ($banner[0]->site_novo == 'S')? 'selected="selected"':'' ?>>SIM</option>
                    <option value="N" <?php echo ($banner[0]->site_novo == 'N')? 'selected="selected"':'' ?>>Não</option>
                  </select>
                </div>              
               
              <div class="form-group">
                <label>Situação</label>
                <select name="situacao" class="form-control" style="width: 100%;">
                  <option value="S" <?php echo ($banner[0]->ativo == 'S')? 'selected="selected"':'' ?>>ATIVO</option>
                    <option value="N" <?php echo ($banner[0]->ativo == 'N')? 'selected="selected"':'' ?>>INATIVO</option>
                </select>
              </div>

              <button type="submit" class="btn btn-warning" >Alterar Banner</button>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

      <div class="box box-solid box-success">
          <div class="box-header">
            <h3 class="box-title">Imagem Atual </h3>
            <div class="box-tools pull-right">
            <span class="label label-default">Selecione para excluir</span>
          </div><!-- /.box-tools -->
          </div><!-- /.box-header -->
          <div class="box-body">
            <p id="img_<?php echo $banner[0]->id ?>">
              <img src="<?php echo IMAGEM_BANNER. $banner[0]->imagem?>" class="img-responsive img-thumbnail" width="170" height="110">
              <a href="#" class="excluirImagem" id="<?php echo $banner[0]->id ?>">
                  <span class="fa-stack fa-lg">
                      <i class="fa fa-square-o fa-stack-2x text-red"></i>
                      <i class="fa fa-trash  fa-stack-1x text-red"></i>
                  </span>			                 				
              </a> 							 	
            </p>
          </div><!-- /.box-body -->
          
      </div><!-- /.box -->
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