<div class="wrapper">

  <?php $this->load->view('include/systemoff') ?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <!-- <section class="content-header">
      <h1>
        Sistema de Usuários
        <small>Alterar</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php #echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php #echo base_url('UsuariosController/viewLista') ?>">Sistema de Usuários</a></li>
        <li class="active">Alterar</li>
      </ol>
    </section>-->

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações</h3>
		  <p class="login-box-msg"><h3>Para recuperação de senha, digite o login de acesso ao sistema. Por padrão, o login é O primeiro nome '.' o último nome do usuário.</h3></p>

          <?php $this->load->view('include/alertsMsg') ?>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
         <form action="<?php echo base_url('AlterarSenha/recuperaSenha2') ?>" method="POST">

          <!--<input type="hidden" name="id" value="<?php echo $usuario[0]->id ?>">-->
            
          <div class="row">
            <div class="col-md-6">
 <?php 
echo validation_errors('<div class="alert alert-danger">','</div>');
                   
echo form_open('AlterarSenha/alterarSenha2');
                 
                 ?>
             <div class="form-group">
                  <label for="nome">Login</label>
                  <input type="text" name="login" class="form-control" id="login" placeholder="Informe o login" value="">
              </div>

             
             
             
                            
             
              <button type="submit" class="btn btn-warning">Recuperar Senha</button>
			  
			   <?php	
                 						   
							   echo form_close();
							   ?>
              
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