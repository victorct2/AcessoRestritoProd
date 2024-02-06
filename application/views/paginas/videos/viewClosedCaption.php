<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Vídeos
        <small>Closed Caption</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('VideosController/viewLista') ?>">Sistema de Vídeos</a></li>
        <li class="active">Closed Caption</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações</h3>

          <div class="box-tools pull-right">
            <a href="<?php echo base_url('VideosController/viewLista')?>" class="btn btn-warning"><i class="fa fa-reply"></i> Voltar</a>

          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <input type="hidden" name="id" value="<?php echo $video[0]->id ?>">

          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                  <label for="titulo">Título :</label>
                  <input name="titulo" type="text" class="form-control" id="titulo" placeholder="Informe o Título" value="<?php echo $video[0]->nome ?>" disabled>
              </div>

              <div class="form-group">
                  <label for="descricao">Descrição :</label>
                  <textarea name="descricao" placeholder="Informe a descrição" class="form-control" id="descricao" cols="30" rows="10" disabled><?php echo $video[0]->descricao ?></textarea>
              </div>

              <div class="form-group">
                <label>Situação</label>
                <select name="status" class="form-control" style="width: 100%;" disabled>
                  <option value="S" <?php echo ($video[0]->situacao == 'S')? 'selected="selected"':'' ?>>ATIVO</option>
                    <option value="N" <?php echo ($video[0]->situacao == 'N')? 'selected="selected"':'' ?>>INATIVO</option>
                </select>
              </div>

            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="form-group">
                <div class="embed-responsive embed-responsive-16by9" style="margin-top:25px" >
                      <video class="embed-responsive-item" controls poster="<?php echo IMAGEM_VIDEO.$video[0]->imagem ?>" >
                        <source src="<?php echo URL_VIDEO.$arquivo; ?>" type="video/mp4">
                        <?php foreach ($closedCaption as $cc) {?>
                          <track label="<?php echo $cc->label ?>" kind="subtitles"
                            srclang="<?php echo $cc->srclang ?>"
                            src="<?php echo CLOSED_CAPTION.$cc->closedCaption?>" <?php echo ($cc->default == 'S')? 'default': '' ?>>
                        <?php } ?>

                        Your browser does not support HTML5 video.
                      </video>
                  </div>
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
            <h3 class="box-title"><i class="fa fa-microphone"></i> Closed Caption</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-warning" id="<?php echo $video[0]->id ?>" data-toggle="modal" data-target="#modal-incluirClosedCaption">
                <i class="fa fa-plus"></i> Novo Closed Caption
              </button>
            </div><!-- /.box-tools -->
          </div><!-- /.box-header -->
          <div class="box-body">
              <?php $this->load->view('include/alertsMsg') ?>
              <ul class="products-list product-list-in-box">
                <?php foreach ($closedCaption as $cc) { ?>
                    <li class="item">
                      <div class="product-info">
                          <h4><span class="product-title label alert-warning">Closed Caption</span></h4>

                          <a href="#" class="btn btn-app bg-red pull-right excluirClosedCaption" id="<?php echo $cc->id ?>" ><i class="fa fa-trash"></i> Excluir</a>
                          <a href="#" class="btn btn-app bg-green pull-right " id="<?php echo $cc->id ?>" data-toggle="modal" data-target="#modal-alterarClosedCaption"><i class="fa fa-pencil"></i> Alterar</a>

                          <span class="product-description">
                            <b>Label:</b> <?php echo $cc->label ?><br>
                            <b>srcLang:</b> <?php echo $cc->srclang ?><br>
                            <b>Status:</b> <?php echo ($cc->status == 'S')? '<span style="color:green">ATIVO' :'<span style="color:red">INATIVO' ?>
                          </span>
                      </div>
                    </li>
                    <!-- /.item -->
                <?php } ?>
              </ul>
          </div><!-- /.box-body -->

      </div><!-- /.box -->

      <div class="modal face" id="modal-incluirClosedCaption" role="dialog"></div>
      <div class="modal face" id="modal-alterarClosedCaption" role="dialog"></div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>

</script>
