<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	
      <h1>
        Sistema de Podcasts
        <small>Cadastro</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('PodcastController/viewLista') ?>">Sistema de Podcasts</a></li>
        <li class="active">Cadastro</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
       <form action="<?php echo base_url('PodcastController/cadastrarPodcast') ?>" method="POST" id="formPodcast">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações</h3>

          <?php $this->load->view('include/alertsMsg') ?>

          <div class="box-tools pull-right">
            <a href="<?php echo base_url('PodcastController/viewLista')?>" class="btn btn-warning"><i class="fa fa-reply"></i> Voltar</a>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                  <label for="titulo">Título :</label>
                  <input name="titulo" type="text" class="form-control" id="titulo" placeholder="Informe o Título">
              </div>

              <div class="form-group">
                  <label for="descricao">Descrição :</label>
                  <!--<textarea name="descricao" placeholder="Informe a descrição" class="form-control" id="descricao" cols="30" rows="10"></textarea>-->
                  <textarea id="editor1" name="descricao" cols="30" rows="10">
                  </textarea>
              </div>

              <div class="form-group">
                  <label for="link_anchor">Link Anchor :</label>
                  <input name="link_anchor" type="text" class="form-control" id="link_anchor" placeholder="Informe o Link do Anchor">
              </div>

              <div class="form-group">
                  <label for="link_spotify">Link Spotify :</label>
                  <input name="link_spotify" type="text" class="form-control" id="link_spotify" placeholder="Informe o Link do Spotify">
              </div>

              <div class="form-group">
                  <label for="link_google">Link Google Podcast :</label>
                  <input name="link_google" type="text" class="form-control" id="link_google" placeholder="Informe o Link do Google Podcast">
              </div>

            </div>
            <!-- /.col -->
            <div class="col-md-6">     
                            
                               
              <div class="form-group">
                  <label for="link_apple">Link Apple Podcast :</label>
                  <input name="link_apple" type="text" class="form-control" id="link_apple" placeholder="Informe o Link do Apple Podcast">
              </div>
                               
              <div class="form-group">
                  <label for="link_deezer">Link Deezer Podcast :</label>
                  <input name="link_deezer" type="text" class="form-control" id="link_deezer" placeholder="Informe o Link do Deezer Podcast">
              </div>
                               
              <div class="form-group">
                  <label for="link_pocket">Link Pocket Casts Podcast :</label>
                  <input name="link_pocket" type="text" class="form-control" id="link_pocket" placeholder="Informe o Link do Pocket Casts  Podcast">
              </div>
                               
              <div class="form-group">
                  <label for="link_breaker">Link Breaker Podcast :</label>
                  <input name="link_breaker" type="text" class="form-control" id="link_breaker" placeholder="Informe o Link do Breaker Podcast">
              </div>
                               
              <div class="form-group">
                  <label for="link_radioPublic">Link RadioPublic Podcast :</label>
                  <input name="link_radioPublic" type="text" class="form-control" id="link_radioPublic" placeholder="Informe o Link do RadioPublic Podcast">
              </div>
                     
                               
              <div class="form-group">
                <label>Situação</label>
                <select name="status" class="form-control" style="width: 100%;">
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
	  	         <div class="row">

            <div class="col-md-6">
              <div class="box box-primary box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Imagem Programa</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="form-group">
                      <label for="imagens" class="control-label">Selecionar Imagens:</label>
                      <input id="imagens" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                      <div id="resp"></div>                    
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->



            <div class="col-md-6">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Imagem App</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="form-group">
                      <label for="imagemApp" class="control-label">Selecionar Imagem App:</label>
                      <input id="imagemApp" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                      <div id="respImagemApp"></div>                    
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->

         


           
          </div>
	  

      
	 
        
      </div>
      <!-- /.box -->
</form>
     

    </section>
    <!-- /.content -->
  <!-- </div>-->
  <!-- /.content-wrapper -->
<script>
  
</script> 


