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

           <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
          <form action="<?php echo base_url('UsuariosController/alterarUsuario') ?>" method="POST">
          <input type="hidden" name="id" value="<?php echo $usuario[0]->id ?>">
          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id ?>">
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
              
              
            <!--  <button type="submit" class="btn btn-warning">Alterar Usuário</button>-->
              
              </form>


            </div>
            <!-- /.col -->
          </div>
        </div>
                
      </div>    

   
  <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
          <?php $this->load->view('include/alertsMsg') ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> 

            <table id="listArquivoUsuario" class="table table-bordered table-striped dt-responsive " >
              <thead>
                <tr>
                  <th>Tipo de Arquivo</th>               
                  <th>Nome do Arquivo</th>                                     
                  <th>Arquivo</th>                     
                  <th>Data de Criação</th>
                  <th>Ação</th>
                </tr>
              </thead>
              
                 <thead>
                <tr class="busca">
                 <!--<th ><div class="list-group-item checkbox">
                 <?php #foreach ($listTipoArquivo as $row) { ?>
                  
                  <input type="checkbox"data-column="1" name="servicos" class="common_selector brand" name="<?php  echo $row->id ?>" value="<?php   echo $row->id  ?>"/> <?php   echo $row->descricao;  ?>
                   
                   
                <?php #}  ?>
          </div></th> -->
                  <th ><input type="text"  data-column="1" class="form-control search-input-text"  placeholder="Tipo de Arquivo " style="width:100%;" ></th>
                  <th><input type="text" data-column="2" class="form-control search-input-text"  placeholder="Nome do Arquivo..." style="width:100%;"></th>
                  <th><input type="text" data-column="3" class="form-control search-input-text"  placeholder="Arquivo ..." style="width:100%;"></th>                 
                  <th><input type="text" data-column="4" class="form-control search-input-text"  placeholder="Data de criação ..." style="width:100%;"></th>                        
                  
                </tr>
              </thead>
               
      
                      
                
            
              <tfoot>
                <tr>
                  <th>Tipo de Arquivo</th>                  
                  <th>Nome do Arquivo</th>                                     
                  <th>Arquivo</th>                     
                  <th>Data de Criação</th>
                  <th>Ação</th>
                </tr>
              </tfoot>
            </table>
            
      
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