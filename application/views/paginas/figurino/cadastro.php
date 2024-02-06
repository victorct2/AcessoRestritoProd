<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Figurino
        <small>Cadastro</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('FigurinoController/viewLista') ?>">Sistema de Figurino</a></li>
        <li class="active">Cadastro</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <form action="<?php echo base_url('FigurinoController/cadastrarFigurino') ?>" method="POST">

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

          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                  <label for="descricao">Descrição :</label>
                  <input name="descricao" type="text" class="form-control" id="descricao" placeholder="Informe a Descrição">
              </div>

              <div class="form-group">
                <label>Tipo Figurino</label>
                <select name="tipo" class="form-control select2" style="width: 100%;">                  
                  <?php foreach ($listTipo as $tipo) { ?>
                      <option value="<?php echo $tipo->idTipoFigurino ?>" ><?php echo $tipo->tipo ?></option>
                  <?php } ?>                  
                </select>
              </div>
              
            </div>
            <!-- /.col -->
            <div class="col-md-6">
               
              <div class="form-group">
                <label>Sexo</label>
                <select name="sexo" class="form-control" style="width: 100%;">
                  <option value="M" selected="selected">MASCULINO</option>
                  <option value="F">FEMININO</option>
                </select>
              </div>

              <div class="form-group">
                <label>Situação Figurino</label>
                <select name="situacao" class="form-control select2" style="width: 100%;">                  
                  <?php foreach ($listSituacao as $situacao) { ?>
                      <option value="<?php echo $situacao->idSituacaoFigurino ?>" ><?php echo $situacao->situacao ?></option>
                  <?php } ?>                  
                </select>
              </div>

              <button type="submit" class="btn btn-primary">Cadastrar</button>

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