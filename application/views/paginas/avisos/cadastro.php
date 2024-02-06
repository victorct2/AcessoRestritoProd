<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Avisos
        <small>Cadastro</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('AvisosController/viewCadastro') ?>">Sistema de Avisos</a></li>
        <li class="active">Cadastro</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <form action="<?php echo base_url('AvisosController/cadastrarAvisos') ?>" method="POST" id="formAvisos">

              

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
                     <label for="descricao">Descrição :</label>
                  <input name="descricao" type="text" class="form-control" id="descricao" placeholder="Informe a Descrição">
                </div>                

                <div class="form-group">
                    <label>Sinopse</label>
                    <input name="sinopse" type="text" class="form-control" id="sinopse" placeholder="Informe a Descrição">
                </div>

              
                              
              </div>
              <!-- /.col -->
              <div class="col-md-6">

                

                <!-- Date -->
                  <div class="form-group">
                    <label>Data:</label>

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input name="dia" type="text" class="form-control pull-right" id="datepicker">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->
                  
                 <div class="form-group">
                    <label>Situação</label>
                    <select name="ativa" class="form-control select2" style="width: 100%;">
                      <option value="S" >ATIVO</option>
                      <option value="N" >INATIVO</option>
                    </select>
                  </div>

                
                  <div id="resp"></div>
                <button type="submit" class="btn btn-primary">Cadastrar</button>

              
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
          
        </div>
        <!-- /.box -->

        

        <!-- NOTÌCIA -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Aviso</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">          
            <div class="row">
                
                <div class="box-body pad">
                  <form>
                        <textarea id="editor1" name="descricao_completa" rows="10" cols="80">
                           
                        </textarea>
                  </form>
                </div>
              
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
          
        </div>
        <!-- /.box -->

     </form>

     <br><br><br>

     <!-- IMAGEM -->
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
          <?= form_open_multipart("AvisosController/upload", ['id' => 'uploader']); ?>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="imagens" class="control-label">Selecionar Imagens:</label>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <span class="butn butn-success fileinput-button">
                      <span>Procurar</span><input type="file" name="userfile[]" id="uploadBtn" multiple>
                      <?php //echo form_upload('userfile[]','','multiple'); ?>
                  </span>
                  <!--<div class="col-md-6">
                    <input id="uploadFile" placeholder="Choose File" disabled="disabled" class="form-control" />
                  </div>-->
                  <button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Upload</button>
                </div>

              </div>
              <div class="form-group">
                <div class="col-md-6">
                <br>
                  <div class="progress">
                    <div class="progress-bar progress-bar-success progress-bar-striped" id="progressBarUpload" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    </div>
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


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->