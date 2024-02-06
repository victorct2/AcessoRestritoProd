
<div class="wrapper">

  <?php $this->load->view('include/header');?>
  <?php $this->load->view('include/menuLateral');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Meu Perfil
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Dados Pessoais</a></li>
        <li class="active">Meu Perfil</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-4">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <?php if($usuario[0]->avatar == '' || $usuario[0]->avatar == null) { ?>
                  <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() ?>assets/img/avatar/logo-verde-claro.png" alt="User profile picture">
              <?php } else{ ?>  
                  <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() ?>assets/img/avatar/<?php echo  $usuario[0]->avatar?>" alt="User profile picture">
              <?php } ?>      
              <h3 class="profile-username text-center"><?php echo  $usuario[0]->nome?></h3>

              <p class="text-muted text-center"><?php echo  $usuario[0]->cargo?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>E-mail</b> <a class="pull-right"><?php echo  $usuario[0]->email?></a>
                </li>
                
                <li class="list-group-item">
                  <b>Celular</b> <a class="pull-right"><?php echo formatar ($usuario[0]->celular, 'cel'); ?></a>
                </li>

              </ul>

              <!--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Sobre</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <strong><i class="fa fa-briefcase margin-r-5"></i> Cargo</strong>
              <p class="text-muted">
                 <?php echo  $usuario[0]->cargo?>
              </p>
              <hr>
              <strong><i class="fa fa-industry margin-r-5"></i> Instituição</strong>
              <p class="text-muted">
                 <?php echo  $usuario[0]->instituicao?>
              </p>
              <hr>
              <strong><i class="fa fa-address-card margin-r-5"></i> Data de Nascimento</strong>
              <p class="text-muted">
                 <?php echo converteDataInterface($usuario[0]->dataNascimento)?>
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Endereço</strong>

              <p class="text-muted">Brasil, Rio de Janeiro</p>

              <hr>

              <!--<strong><i class="fa fa-pencil margin-r-5"></i> Conhecimentos Técnicos</strong>

              <p>
                <span class="label label-danger">Banco de Dados</span>
                <span class="label label-success">Engenharia de Software</span>
                <span class="label label-info">Análise de Sistemas</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-warning">JAVA</span>
                <span class="label label-warning">Web Design</span>
                <span class="label label-primary">Node.js</span>
              </p> -->

              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-8">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings" data-toggle="tab">Dados Pessoais</a></li>
              <!--<li><a href="#avatar" data-toggle="tab">Avatar</a></li>-->
            </ul>
            <div class="tab-content">
                            

              <div class="active tab-pane" id="settings">

                <?php $this->load->view('include/alertsMsg') ?>

                <form action="<?php echo base_url('UsuariosController/alterarPerfil') ?>" method="POST" class="form-horizontal">

                  <div class="form-group">
                    <label for="nome" class="col-sm-2 control-label">Nome</label>
                    <div class="col-sm-10">
                      <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome" value="<?php echo $usuario[0]->nome ?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input name="email" type="email" class="form-control" id="emal" placeholder="Email" value="<?php echo $usuario[0]->email ?>">
                    </div>
                  </div>
                  
                  <div id="loginUsuario" class="form-group">
                    <label for="login" class="col-sm-2 control-label">Login</label>
                    <div class="col-sm-10">
                      <input name="login" type="text" class="form-control" id="login" placeholder="Login" value="<?php echo $usuario[0]->login ?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="senha" class="col-sm-2 control-label">Senha</label>
                    <div class="col-sm-10">
                      <input name="senha" type="password" class="form-control" id="senha" placeholder="Senha" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="telefone" class="col-sm-2 control-label">Telefone</label>
                    <div class="col-sm-10">
                      <input name="telefone" type="text" class="form-control" id="telefone" placeholder="Telefone" value="<?php echo $usuario[0]->telefones ?>" data-inputmask='"mask": "(99)9999-9999"' data-mask>
                    </div>
                  </div>  

                  <div class="form-group">
                    <label for="celular" class="col-sm-2 control-label">Celular</label>
                    <div class="col-sm-10">
                      <input name="celular" type="text" class="form-control" id="celular" placeholder="celular" value="<?php echo $usuario[0]->celular ?>" data-inputmask='"mask": "(99)99999-9999"' data-mask>
                    </div>
                  </div>
                 
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Alterar</button>
                    </div>
                  </div>

                </form>
				        <div class="box-body">
          
          <!--<div class="row">
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
                 <!-- <button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Upload</button>
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
                <?php #echo form_close() ?>
              <div id="message"></div>
              
          </div>
          <!-- /.row -->
        </div>
              </div>
              <!-- /.tab-pane -->

             <!-- <div class="tab-pane" id="avatar">
                    <ul id="listAvatar">                      
                      <?php #for ($i=1; $i <=33 ; $i++) {                          
                          #$avatar = 'avatar'.$i.'.png';
                          #if ($this->session->userdata("avatar") == $avatar){ ?>
                              <li><img id="<?php# echo $i ?>" src="<?php# echo base_url().'assets/img/avatar/'.$avatar ?>" class="img-responsive img-thumbnail imgAvatar selected" title="<?php# echo $avatar ?>"></li>
                          <?php #}else{ ?>  
                              <li><img id="<?php #echo $i ?>" src="<?php# echo base_url().'assets/img/avatar/'.$avatar ?>" class="img-responsive img-thumbnail imgAvatar" title="<?php #echo $avatar ?>"></li>
                          <?php #} ?>
                        <?php #} ?>
                    </ul>
              </div>-->
			  
			  


            </div>
			
            <!-- /.tab-content -->
          </div>
		  
          <!-- /.nav-tabs-custom -->
        </div>
		
        <!-- /.col -->
      </div>
	  
      <!-- /.row -->

    </section>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
