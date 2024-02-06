<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Podcasts
        <small>Alterar</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('PodcastController/viewLista') ?>">Sistema de Podcasts</a></li>
        <li class="active">Alterar</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações</h3>

          

          <div class="box-tools pull-right">
            <a href="<?php echo base_url('PodcastController/viewLista')?>" class="btn btn-warning"><i class="fa fa-reply"></i> Voltar</a>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <input type="hidden" name="id" value="<?php echo $podcast[0]->id ?>">

          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                  <label for="titulo">Título :</label>
                  <input name="titulo" type="text" class="form-control" id="titulo" placeholder="Informe o Título" value="<?php echo $podcast[0]->titulo ?>" disabled>
              </div>

              <div class="form-group">
                  <label for="descricao">Descrição :</label>
                  <textarea name="descricao" placeholder="Informe a descrição" class="form-control" id="descricao" cols="30" rows="10" disabled><?php echo $podcast[0]->descricao ?></textarea>
              </div>            
              
            </div>
            <!-- /.col -->
            <div class="col-md-6">  

              <div class="form-group">
                  <label for="link_anchor">Link Anchor :</label>
                  <input name="link_anchor" type="text" class="form-control" id="link_anchor" placeholder="Informe o Link do Anchor" value="<?php echo $podcast[0]->link_anchor ?>" disabled>
              </div>

              <div class="form-group">
                  <label for="link_spotify">Link Spotify :</label>
                  <input name="link_spotify" type="text" class="form-control" id="link_spotify" placeholder="Informe o Link do Spotify" value="<?php echo $podcast[0]->link_spotify ?>" disabled>
              </div>          
               
              <div class="form-group">
                <label>Situação</label>
                <select name="status" class="form-control" style="width: 100%;" disabled>
                  <option value="S" <?php echo ($podcast[0]->status == 'S')? 'selected="selected"':'' ?>>ATIVO</option>
                    <option value="N" <?php echo ($podcast[0]->status == 'N')? 'selected="selected"':'' ?>>INATIVO</option>
                </select>
              </div>
              <div class="form-group">
                <p id="img_<?php echo $podcast[0]->id ?>">
                  <img src="<?php echo IMAGEM_PODCAST. $podcast[0]->imagem?>" class="img-responsive img-thumbnail" width="170" height="110">              							 	
                </p>
              </div>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

      <div class="box box-solid box-primary">
          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-microphone"></i> Episódios do Podcast</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-warning" id="<?php echo $podcast[0]->id ?>" data-toggle="modal" data-target="#modal-incluirEpisodio">
                <i class="fa fa-plus"></i> Novo Episódio
              </button>
            </div><!-- /.box-tools -->
          </div><!-- /.box-header -->
          <div class="box-body">
              <?php $this->load->view('include/alertsMsg') ?>
              <ul class="products-list product-list-in-box">
                <?php foreach ($listEpisodios as $episodio) { ?>              
                    <li class="item">
                      <div class="product-info">
                          <h4><span class="product-title label alert-warning"><?php echo $episodio->titulo?></span></h4>
                          
                          <a href="#" class="btn btn-app bg-red pull-right excluirEpisodio" id="<?php echo $episodio->id ?>" ><i class="fa fa-trash"></i> Excluir</a> 
                          <a href="#" class="btn btn-app bg-green pull-right " id="<?php echo $episodio->id ?>" data-toggle="modal" data-target="#modal-alterarEpisodio"><i class="fa fa-pencil"></i> Alterar</a>                     
                          <?php if($episodio->midia != ''){?>
                            <a href="<?php echo base_url('PodcastController/episodioDownload/'.$episodio->id)?>" target="_blank" class="btn btn-app bg-blue pull-right "><i class="fa fa-download"></i> Download</a>                     
                          <?php } ?>
                          
                          <div class="col-md-9">
                            <div class="col-md-5">
                              <span class="product-description" >
                              <?php echo character_limiter($episodio->descricao, 180) ?><br><br>
                              </span>
                            </div>
                            <div class="col-md-4">
                              <?php echo $episodio->embed ?>
                            </div>
                          </div>
                      </div>
                    </li>
                    <!-- /.item -->
                <?php } ?>
              </ul>
          </div><!-- /.box-body -->
          
      </div><!-- /.box -->
      
      <div class="modal face" id="modal-incluirEpisodio" role="dialog"></div>
      <div class="modal face" id="modal-alterarEpisodio" role="dialog"></div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  
</script> 