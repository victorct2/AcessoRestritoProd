<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Notícias
        <small>Cadastro</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('NoticiasController/viewLista') ?>">Sistema de Notícias</a></li>
        <li class="active">Cadastro</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <form action="<?php echo base_url('NoticiasController/cadastrarNoticias') ?>" method="POST" id="formAvisos">
              

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Informações</h3>

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
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control" rows="4" placeholder="Descrição ..."></textarea>
                </div>                

                <div class="form-group">
                    <label>Sinopse</label>
                    <textarea name="sinopse" class="form-control" rows="4" placeholder="Sinopse ..."></textarea>
                </div>

                <div class="form-group">
                    <label>Subtítulo</label>
                    <textarea name="subtitulo" class="form-control" rows="4" placeholder="Subtítulo ..."></textarea>
                </div>

                <div class="form-group">
                    <label>Código Embed de vídeo</label>
                    <textarea name="codigoEmbed" class="form-control" rows="4" placeholder="Código Embed ..."></textarea>
                </div>
                              
              </div>
              <!-- /.col -->
              <div class="col-md-6">

                <div class="form-group">
                    <label for="link">Link:</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-link"></i>
                      </div>
                      <input name="linkVideo" type="text" class="form-control" id="link" placeholder="Informe o Link">
                    </div>
                    <!-- /.input group -->
                </div>

                <div class="form-group">
                    <label for="linkVideo">Link do vídeo do Canal Saúde:</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-film"></i>
                      </div>
                      <input name="linkVideo" type="text" class="form-control" id="linkVideo" placeholder="Informe o Link do vídeo do Canal Saúde">
                    </div>
                    <!-- /.input group -->
                </div>

                <div class="form-group">
                    <label for="legendaVideo">Legenda do Vídeo:</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-commenting"></i>
                      </div>
                      <input name="legendaVideo" type="text" class="form-control" id="link" placeholder="Informe a legenda do Vídeo">
                    </div>
                    <!-- /.input group -->
                </div>


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
                    <label>Mostrar em:</label>
                    <select name="releaseNoticia" class="form-control" style="width: 100%;">
                      <option value="N" selected="selected">Notícia</option>
                      <option value="R" >Release</option>
                      <option value="NR" >Notícia e Release</option>
                    </select>
                  </div>             

                  <div class="form-group">
                    <label>Ativar no novo Site</label>
                    <select name="site_novo" class="form-control" style="width: 100%;">
                      <option value="S" selected="selected">SIM</option>
                      <option value="N">NÃO</option>
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

                <button type="submit" class="btn btn-primary">Cadastrar</button>

              </div>
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
            <h3 class="box-title">Notícia</h3>

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
                        <textarea id="editor1" name="descricaoCompleta" rows="10" cols="80">
                            Escreva a notícia completa aqui...
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
          <?= form_open_multipart("NoticiasController/upload", ['id' => 'uploader']); ?>
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
      <!-- /.box -->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->