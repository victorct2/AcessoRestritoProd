<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Vídeos
        <small>Alterar</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('VideosController/viewLista') ?>">Sistema de Vídeos</a></li>
        <li class="active">Alterar</li>
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

          <form action="<?php echo base_url('VideosController/alterarVideo') ?>" method="POST" id="formVideos">

            <input type="hidden" name="idVideo" value="<?php echo $video[0]->id ?>">

            <div id="resp"></div>

            <div class="row">
              <div class="col-md-6">

                <div id="nomeUsuario" class="form-group">
                    <label for="nome">Nome Vídeo:</label>
                    <input type="text" name="nome" class="form-control" id="nome" placeholder="Informe o nome" value="<?php echo $video[0]->nome ?>">
                </div>

                <div class="form-group">
                    <label for="numeroPgm">Número PGM:</label>
                    <input type="number" name="numeroPgm" class="form-control" id="numeroPgm" placeholder="Informe o número do PGM" value="<?php echo $video[0]->numeroPgm ?>">
                </div>

                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control" rows="5" placeholder="Descrição ..."><?php echo $video[0]->descricao ?></textarea>
                </div>

                <div class="form-group">
                  <label>Programa</label>
                  <select name="programa" class="form-control select2" style="width: 100%;" >
                    <?php foreach ($listProgramas as $value) { ?>
                          <option value="<?php echo $value->id ?>" <?php echo ($video[0]->id_programa == $value->id)? 'selected="selected"':'' ?>><?php echo $value->titulo ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div id="apresentador" class="form-group">
                    <label for="apresentador">Apresentador:</label>
                    <input type="text" name="apresentador" class="form-control" id="apresentador" placeholder="Informe o apresentador" value="<?php echo $video[0]->apresentador ?>">
                </div>

                <div id="diretor" class="form-group">
                    <label for="diretor">Diretor:</label>
                    <input type="text" name="diretor" class="form-control" id="diretor" placeholder="Informe o diretor" value="<?php echo $video[0]->diretor ?>">
                </div>

                <div id="reporter" class="form-group">
                    <label for="reporter">Repórter:</label>
                    <input type="text" name="reporter" class="form-control" id="reporter" placeholder="Informe o repórter" value="<?php echo $video[0]->reporter ?>">
                </div>

                <div id="convidados" class="form-group">
                    <label for="convidados">Convidados:</label>
                    <input type="text" name="convidados" class="form-control" id="convidados" placeholder="Informe o convidados" value="<?php echo $video[0]->convidados ?>">
                </div>

                <div class="form-group">
                  <label>Qualidade</label>
                  <select id="qualidade" class="form-control" style="width: 100%;">
                    <option value="HD" selected="selected">HD</option>
                    <option value="SD">SD</option>
                  </select>
                </div>

                <hr>
                <p id="img_<?php echo $video[0]->id ?>">
                  <img src="<?php echo base_url() .'assets/img/videos/'.$video[0]->imagem ?>" class="img-responsive img-thumbnail imgAlterar" alt="First slide">
                  <a href="#" class="excluirImagem" id="<?php echo $video[0]->id ?>">
                      <span class="fa-stack fa-lg">
                          <i class="fa fa-square-o fa-stack-2x text-red"></i>
                          <i class="fa fa-trash  fa-stack-1x text-red"></i>
                      </span>
                  </a>
                </p>
                <hr>
                <button type="submit" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Alterar Vídeo</button>

              </div>
              <!-- /.col -->
              <div class="col-md-6">

                  <div class="form-group">
                    <label>Duração:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                      </div>
                      <input type="text" name="duracao" class="form-control"  data-inputmask='"mask": "99:99:99"' data-mask value="<?php echo $video[0]->duracao ?>">
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
                      <input type="text" name="dataExibicao" class="form-control pull-right" id="datepicker" value="<?php echo converteDataInterface($video[0]->data_video) ?>">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->

                  <div class="form-group">
                    <label>Situação</label>
                    <select name="situacao" class="form-control" style="width: 100%;">
                      <option value="ATIVO" <?php echo ($video[0]->situacao == 'ATIVO')? 'selected="selected"':'' ?>>Ativo</option>
                      <option value="INCOMPLETO" <?php echo ($video[0]->situacao == 'INCOMPLETO')? 'selected="selected"':'' ?>>Incompleto</option>
                      <option value="INATIVO" <?php echo ($video[0]->situacao == 'INATIVO')? 'selected="selected"':'' ?>>Inativo</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Destaque</label>
                    <select name="destaque" class="form-control" style="width: 100%;">
                      <option value="N" <?php echo ($video[0]->destaque == 'N')? 'selected="selected"':'' ?>>Não</option>
                      <option value="S" <?php echo ($video[0]->destaque == 'S')? 'selected="selected"':'' ?>>Sim</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>15ª Conferência</label>
                    <select name="conferencia" class="form-control" style="width: 100%;">
                      <option value="S" <?php echo ($video[0]->xvconferencia == 'S')? 'selected="selected"':'' ?>>Sim</option>
                      <option value="N" <?php echo ($video[0]->xvconferencia == 'N')? 'selected="selected"':'' ?>>Não</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Página Coronavírus</label>
                    <select name="coronavirus" class="form-control" style="width: 100%;">
                      <option value="S" <?php echo ($video[0]->coronavirus == 'S')? 'selected="selected"':'' ?>>Sim</option>
                      <option value="N" <?php echo ($video[0]->coronavirus == 'N')? 'selected="selected"':'' ?>>Não</option>
                    </select>
                  </div>

                  <div id="produtor" class="form-group">
                      <label for="produtor">Produtor:</label>
                      <input type="text" name="produtor" class="form-control" id="produtor" placeholder="Informe o produtor" value="<?php echo $video[0]->produtor ?>">
                  </div>

                  <div id="entrevistados" class="form-group">
                      <label for="entrevistados">Entrevistados:</label>
                      <input type="text" name="entrevistados" class="form-control" id="entrevistados" placeholder="Informe o entrevistados" value="<?php echo $video[0]->entrevistados ?>">
                  </div>

                  <div id="tags" class="form-group">
                      <label for="tags">TAGS:</label>
                      <input type="text" name="tags" class="form-control" id="tags" placeholder="Informe o tags" value="<?php echo $video[0]->tags ?>">
                  </div>

                  <div class="form-group">
                    <label for="imagens" class="control-label">Selecionar Imagens:</label>
                    <input id="imagens" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                    <div id="resp"></div>
                  </div>

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
              <div class="col-md-12">

              <?php foreach ($arquivo as $value) { ?>
                <?php if($value->formato != 'ZIP'){ ?>
                    <div class="videos">
                      <p><code><?php echo $value->formato .' '. $value->resolucao ?></code></p>
                      <video id="videotest" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="400" height="300"
                        poster="<?php echo base_url() ?>assets/img/videoPoster.jpg" data-setup='{"playbackRates": [1, 1.5, 2, 2.5, 3]}'>
                          <source src="<?php echo base_url() .'streaming/'.$value->nome ?>" type='video/mp4'>
                          <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a web browser that
                            <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                          </p>
                      </video>
                    </div>

                <?php }else{?>
                  <div id="zip">
                    <p><code>ARQUIVO ZIP</code></p>
                    <?php foreach ($arquivo as $value) { ?>
                      <?php if($value->formato == 'ZIP'){ ?>
                        <a href="<?php echo base_url() .'download/'.$value->nome ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/zipImg.png" class="img-responsive img-thumbnail zipImg"></a>
                      <?php }?>
                    <?php }?>
                  </div>
                  <br>
                <?php }?>
              <?php }?>



              </div>
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

              </div>

              <div class="col-md-6">

                <div>
                  <p><code>ARQUIVO ZIP</code></p>
                  <div id="progressLoader">

                  </div>
                </div>

              </div>
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
