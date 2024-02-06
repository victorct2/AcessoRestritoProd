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
          
          <form action="<?php echo base_url('UsuariosController/alterarUsuario') ?>" method="POST">

          <input type="hidden" name="id" value="<?php echo $usuario[0]->id ?>">
            
          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                  <label for="nome">Nome Completo:</label>
                  <input type="text" name="nome" class="form-control" id="nome" placeholder="Informe o nome" value="<?php echo $usuario[0]->nome ?>">
              </div>

              <div id="loginUsuario" class="form-group">
                  <label for="login">Login:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <input type="text" name="login" class="form-control" id="login" placeholder="Informe o login" value="<?php echo $usuario[0]->login ?>">
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

                            
              <div class="form-group">
                <label>Grupos:</label>
                <select name="grupos[]" class="form-control selectGrupos" multiple="multiple" data-placeholder="Selecione os grupos"
                        style="width: 100%;">
                  <?php foreach ($listGrupos as $grupos) {      
                          if(in_array($grupos->id,$gruposUsuario)){
                            echo '<option value="'. $grupos->id .'" selected="selected">'. $grupos->nome .'</option>';
                          } else{
                            echo '<option value="'. $grupos->id .'" >'. $grupos->nome .'</option>';
                          }                          
                        } ?>
                </select>
              </div> 

            
              
              <!-- /.form group -->

              <div class="form-group">
                  <label for="profissao">Profissão:</label>                  
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-briefcase"></i>
                    </div>
                    <input type="text" name="profissao" class="form-control" id="profissao" placeholder="Informe a profissão" value="<?php echo $usuario[0]->profissao ?>">
                  </div>
                  <!-- /.input group -->
              </div>

              <div class="form-group">
                  <label for="cargo">Cargo:</label>                  
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-id-card"></i>
                    </div>
                    <input type="text" name="cargo" class="form-control" id="cargo" placeholder="Informe o cargo" value="<?php echo $usuario[0]->cargo ?>">
                  </div>
                  <!-- /.input group -->
              </div>

            </div>
            <!-- /.col -->
            <div class="col-md-6">


              <!-- Date -->
                <div class="form-group">
                  <label>Data de Nascimento:</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="dataNascimento" class="form-control" value="<?php echo converteDataInterface($usuario[0]->dataNascimento) ?>"  data-inputmask='"mask": "99/99/9999"' data-mask >
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
                
                 <div class="form-group">
                  <label>Telefone:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-phone"></i>
                    </div>
                    <input type="text" name="telefone" class="form-control" value="<?php echo $usuario[0]->telefones ?>"  data-inputmask='"mask": "(99)9999-9999"' data-mask >
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->

               <div class="form-group">
                  <label>celular:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-mobile"></i>
                    </div>
                    <input type="text" name="celular" class="form-control" value="<?php echo $usuario[0]->celular ?>"  data-inputmask='"mask": "(99)99999-9999"' data-mask >
                  </div>
                  <!-- /.input group -->
                </div>
				<div class="form-group">
                  <label>E-mail:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-envelope"></i>
                    </div>
                    <input type="email" name="email" class="form-control" placeholder="Informe o email" value="<?php echo $usuario[0]->email ?>">
                  </div>
                  <!-- /.input group -->
              </div>
                <!-- /.form group -->

             
               
              <div class="form-group">
                <label>Situação</label>
                <select name="situacao" class="form-control" style="width: 100%;">
                  <option value="S" <?php echo ($usuario[0]->ativo =="S")? 'selected="selected"':'' ?>>ATIVO</option>
                  <option value="N" <?php echo ($usuario[0]->ativo =="N")? 'selected="selected"':'' ?>>INATIVO</option>
                </select>
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