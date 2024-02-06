<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Notícias
        <small>Alterar</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('NoticiasController/viewLista') ?>">Sistema de Notícias</a></li>
        <li class="active">Alterar</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <form action="<?php echo base_url('NoticiasController/alterarNoticias') ?>" method="POST" id="formNoticias">


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

            <input type="hidden" name="id" value="<?php echo $noticias[0]->id ?>">

            <div class="row">
              <div class="col-md-6">

                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control" rows="4" placeholder="Descrição ..."><?php echo $noticias[0]->descricao ?></textarea>
                </div>

                <div class="form-group">
                    <label>Sinopse</label>
                    <textarea name="sinopse" class="form-control" rows="4" placeholder="Sinopse ..."><?php echo $noticias[0]->sinopse ?></textarea>
                </div>

                <div class="form-group">
                    <label>Subtítulo</label>
                    <textarea name="subtitulo" class="form-control" rows="4" placeholder="Subtítulo ..."><?php echo $noticias[0]->subtitulo ?></textarea>
                </div>

                <div class="form-group">
                    <label>Código Embed de vídeo</label>
                    <textarea name="codigoEmbed" class="form-control" rows="4" placeholder="Código Embed ..."><?php echo $noticias[0]->codigoEmbed ?></textarea>
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
                      <input name="link" type="text" class="form-control" id="link" placeholder="Informe o Link" value="<?php echo $noticias[0]->link ?>">
                    </div>
                    <!-- /.input group -->
                </div>

                <div class="form-group">
                    <label for="linkVideo">Link do vídeo do Canal Saúde:</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-film"></i>
                      </div>
                      <input name="linkVideo" type="text" class="form-control" id="linkVideo" placeholder="Informe o Link do vídeo do Canal Saúde" value="<?php echo $noticias[0]->linkVideo ?>">
                    </div>
                    <!-- /.input group -->
                </div>

                <div class="form-group">
                    <label for="legendaVideo">Legenda do Vídeo:</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-commenting"></i>
                      </div>
                      <input name="legendaVideo" type="text" class="form-control" id="link" placeholder="Informe a legenda do Vídeo" value="<?php echo $noticias[0]->legendaVideo ?>">
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
                      <input name="dia" type="text" class="form-control pull-right" id="datepicker" value="<?php echo converteDataInterface($noticias[0]->dia) ?>">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->

                  <div class="form-group">
                    <label>Mostrar em:</label>
                    <select name="releaseNoticia" class="form-control" style="width: 100%;">
                      <option value="N" <?php echo ($noticias[0]->releaseNoticia == 'N')? 'selected="selected"':'' ?>>Notícia</option>
                      <option value="R" <?php echo ($noticias[0]->releaseNoticia == 'R')? 'selected="selected"':'' ?>>Release</option>
                      <option value="NR" <?php echo ($noticias[0]->releaseNoticia == 'NR')? 'selected="selected"':'' ?>>Notícia e Release</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Ativar no novo Site</label>
                    <select name="site_novo" class="form-control" style="width: 100%;">
                      <option value="S" <?php echo ($noticias[0]->site_novo == 'S')? 'selected="selected"':'' ?>>SIM</option>
                      <option value="N" <?php echo ($noticias[0]->site_novo == 'N')? 'selected="selected"':'' ?>>NÃO</option>
                    </select>
                  </div>

                  <div class="form-group">
                  <label>Situação</label>
                  <select name="situacao" class="form-control" style="width: 100%;">
                    <option value="S" <?php echo ($noticias[0]->ativa == 'S')? 'selected="selected"':'' ?>>ATIVO</option>
                    <option value="N" <?php echo ($noticias[0]->ativa == 'N')? 'selected="selected"':'' ?>>INATIVO</option>
                  </select>
                </div>
                <div id="resp"></div>
                <button type="submit" class="btn btn-warning">Alterar Notícia</button>

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->

        </div>
        <!-- /.box -->

      <?php if(count($imagensNoticias)>0) { ?>
        <div class="box box-solid box-success">
            <div class="box-header">
              <h3 class="box-title">Imagem Atual </h3>
              <div class="box-tools pull-right">
              <span class="label label-default">Selecione para excluir</span>
            </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
            <div id="respImagem"></div>
              <?php foreach($imagensNoticias as $imagem){ ?>
                <p id="img_<?php echo $imagem->idImagem ?>">
                  <img src="<?php echo base_url().'assets/img/noticias/'. $imagem->nomeImagem?>" class="img-responsive img-thumbnail" width="250" height="150">
                  <a href="#" class="excluirImagem" id="<?php echo $imagem->idImagem ?>">
                      <span class="fa-stack fa-lg">
                          <i class="fa fa-square-o fa-stack-2x text-red"></i>
                          <i class="fa fa-trash  fa-stack-1x text-red"></i>
                      </span>
                  </a>
                </p>
              <?php } ?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
      <?php } ?>



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
                            <?php echo $noticias[0]->descricao_completa ?>
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
