<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Mídias
        <small>Cadastro de Parceiros</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('MidiasParceirosController/viewAreaParceiros') ?>">Sistema de Mídias</a></li>
        <li class="active">Cadastro de Parceiros</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
       <form action="<?php echo base_url('MidiasParceirosController/cadastroParceiro') ?>" method="POST">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações Parceiros</h3>

          <?php $this->load->view('include/alertsMsg') ?>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                  <label for="nome">Nome :</label>
                  <input name="nome" type="text" class="form-control" id="nome" placeholder="Informe o nome">
              </div>

              <div class="form-group">
                  <label for="descricao">Descrição :</label>
                  <textarea name="descricao" class="form-control" rows="4" placeholder="Descrição ..."></textarea>
              </div>

            </div>
            <!-- /.col -->
            <div class="col-md-6">

                <div class="form-group">
                  <label>Mostrar Site novo</label>
                  <select name="site_novo" class="form-control" style="width: 100%;">
                    <option value="S" selected="selected">SIM</option>
                    <option value="N">Não</option>
                  </select>
                </div>
                               
                <div class="form-group">
                  <label>Situação</label>
                  <select name="situacao" class="form-control" style="width: 100%;">
                    <option value="S" selected="selected">ATIVO</option>
                    <option value="N">INATIVO</option>
                  </select>
                </div>

              <button type="submit" class="btn btn-primary" >Cadastrar</button>

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
          <h3 class="box-title">Upload de Imagem</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="imagens" class="control-label">Selecionar Imagens:</label>
                  <input id="imagens" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                      <div id="resp"></div>                    
                </div>
              </div>
              
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

      </form>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  
</script> 