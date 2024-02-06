<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Usuários
        <small>Alterar</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('UsuariosController/viewLista') ?>">Sistema de Usuários</a></li>
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
          
         <form action="<?php echo base_url('AlterarSenha/alterarUsuario2') ?>" method="POST">

          <input type="hidden" name="id" value="<?php echo $usuario[0]->id ?>">
            
          <div class="row">
            <div class="col-md-6">

             <div class="form-group">
                  <label for="nome">Nome Completo:</label>
                  <input type="text" name="nome" readonly="true" class="form-control" id="nome" placeholder="Informe o nome" value="<?php echo $usuario[0]->nome ?>">
              </div>

              <div id="loginUsuario" class="form-group">
                  <label for="login">Login:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <input type="text" name="login" readonly="true" class="form-control" id="login" placeholder="Informe o login" value="<?php echo $usuario[0]->login ?>">
                  </div>
                  <!-- /.input group -->
              </div>
              
              <div class="form-group">
                  <label for="senha">Senha:</label>                  
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-unlock-alt"></i>
                    </div>
                    <input type="password" name="senha" class="form-control" id="senha" placeholder="Informe a senha">
                  </div>
                  <!-- /.input group -->
              </div>

                            
             
              <button type="submit" class="btn btn-warning">Alterar Usuário</button>
              
              </form>
            </div>
            <!-- /.col -->
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