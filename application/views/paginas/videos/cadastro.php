<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Vídeos
        <small>Cadastro</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('VideosController/viewLista') ?>">Sistema de Vídeos</a></li>
        <li class="active">Cadastro</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

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

          <form  action="<?php echo base_url('VideosController/adicionarVideo') ?>" method="POST" id="formVideos">

            <div id="resp"></div>

            <div class="row">
              <div class="col-md-6">

                <div id="nomeUsuario" class="form-group">
                    <label for="nome">Nome Vídeo:</label>
                    <input type="text" name="nome" class="form-control" id="nome" placeholder="Informe o nome">
                </div>

                <div class="form-group">
                    <label for="numeroPgm">Número PGM:</label>
                    <input type="number" name="numeroPgm" class="form-control" id="numeroPgm" placeholder="Informe o número do PGM">
                </div>

                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control" rows="5" placeholder="Descrição ..."></textarea>
                </div>

                <div class="form-group">
                  <label>Programa</label>
                  <select name="programa" class="form-control select2" style="width: 100%;" >
                    <?php foreach ($listProgramas as $value) { ?>
                          <option value="<?php echo $value->id ?>" ><?php echo $value->titulo ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Qualidade</label>
                  <select id="qualidade" class="form-control" style="width: 100%;">
                    <option value="HD" selected="selected">HD</option>
                    <option value="SD">SD</option>
                  </select>
                </div>

              </div>
              <!-- /.col -->
              <div class="col-md-6">

                  <div class="form-group">
                    <label>Duração:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                      </div>
                      <input type="text" name="duracao" class="form-control"  data-inputmask='"mask": "99:99:99"' data-mask >
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->

                  <!-- Date -->
                  <div class="form-group">
                    <label>Data Exibição:</label>

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="dataExibicao" class="form-control pull-right" id="datepicker">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->

                  <div class="form-group">
                    <label>Situação</label>
                    <select name="situacao" class="form-control" style="width: 100%;">
                      <option value="ATIVO" selected="selected">Ativo</option>
                      <option value="INCOMPLETO">Incompleto</option>
                      <option value="INATIVO">Inativo</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Destaque</label>
                    <select name="destaque" class="form-control" style="width: 100%;">
                      <option value="N" selected="selected">Não</option>
                      <option value="S">Sim</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>15ª Conferência</label>
                    <select name="conferencia" class="form-control" style="width: 100%;">
                      <option value="S">Sim</option>
                      <option value="N" selected="selected">Não</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Página Coronavírus</label>
                    <select name="coronavirus" class="form-control" style="width: 100%;">
                      <option value="S">Sim</option>
                      <option value="N" selected="selected">Não</option>
                    </select>
                  </div>

                  <div id="imgHidden"></div>

                  <button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Cadastrar Vídeo</button>

                  </form>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->

      </div>
      <!-- /.box -->

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Upload de Vídeo</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <?= form_open_multipart("VideosController/upload", ['id' => 'uploader']); ?>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="videos" class="control-label">Selecionar Vídeo:</label>
                </div>
              </div>
              <div class="form-group">
                <span class="butn butn-success fileinput-button">
                    <span>Select file</span><input type="file" name="userfile" id="uploadBtn">
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
          <hr>
          <div class="row">
              <div class="col-md-6">

                <p class="720"><code>FFMPEG Converter MP4 720p</code></p>
                <div class="progress">
                  <div class="progress-bar progress-bar-primary progress-bar-striped" id="mp4720p" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                  </div>
                </div>
                <p class="240"><code>FFMPEG Converter MP4 240p</code></p>
                <div class="progress">
                  <div class="progress-bar progress-bar-warning progress-bar-striped" id="mp4240p" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                  </div>
                </div>
                <!--<video id="videotest" class="video-js" controls preload="auto" width="450" height="300"
                  poster="<?php echo base_url() ?>assets/img/videoPoster.jpg" data-setup="{}">
                    <source src="http://localhost/canalintranet/uploadVideos/videos/720/b2d28a55a9f83a42ac3622be5461e281.mp4" type='video/mp4'>
                    <p class="vjs-no-js">
                      To view this video please enable JavaScript, and consider upgrading to a web browser that
                      <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                </video>    -->
              </div>

              <div class="col-md-6">
                <div>
                  <p><code>ARQUIVO ZIP</code></p>
                  <div id="progressLoader">

                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                  <label for="videos" class="control-label">Selecione uma Imagem:</label><br><br>
                  <div id="imagens">
                    <img src="https://placehold.it/390x210/39CCCC/ffffff&text=Imagem 1" class="img-responsive img-thumbnail imagePlace" alt="First slide">
                    <img src="https://placehold.it/390x210/39CCCC/ffffff&text=Imagem 2" class="img-responsive img-thumbnail imagePlace" alt="First slide">
                    <img src="https://placehold.it/390x210/39CCCC/ffffff&text=Imagem 3" class="img-responsive img-thumbnail imagePlace" alt="First slide">
                  </div>
                </div>

          </div>
          <!-- /.row -->


        </div>
        <!-- /.box-body -->



      </div>
      <!-- /.box -->




      <!--<form method="POST" enctype="multipart/form-data" id="myform">
          <input type="text" name="title" id="texto"/><br/><br/>
          <input type="file" name="files" id="arquivo"/><br/><br/>
          <input type="submit" value="Submit" id="btnSubmit"/>
      </form>-->

      <!--<form method="post" enctype="multipart/form-data" action="<?php echo base_url('VideosController/upload') ?>">
         Selecione uma imagem: <input name="arquivo" type="file"/>
  	   <br />
         <input type="submit" value="Salvar" />
      </form>-->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
