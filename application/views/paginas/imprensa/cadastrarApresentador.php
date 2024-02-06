<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Apresentadores
        <small>Cadastro</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('ImprensaController/viewApresentadores') ?>">Apresentadores</a></li>
        <li class="active">Cadastro</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <form action="<?php echo base_url('ImprensaController/cadastrarApresentador') ?>" method="POST">
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
                  <label for="nomeCompleto">Nome Completo :</label>
                  <input name="nomeCompleto" type="text" class="form-control" id="nomeCompleto" placeholder="Nome Completo" value="">
              </div>

              <div class="form-group">
                  <label for="nomeArtistico">Nome Artístico :</label>
                  <input name="nomeArtistico" type="text" class="form-control" id="nomeArtistico" placeholder="Nome Artístico" value="">
              </div>

              <div class="form-group">
                  <label for="resumoProfissional">Resumo Profissional :</label>
                  <textarea name="resumoProfissional" class="form-control" rows="4" placeholder="Resumo Profissional ..."></textarea>
              </div>
              

              <button type="submit" class="btn btn-warning" >Cadastrar Apresentador</button>
              
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                
                <div class="form-group">
                  <label>Mostrar no Site ?</label>
                  <select name="situacao" class="form-control" style="width: 100%;">
                    <option value="S" selected="selected">SIM</option>
                    <option value="N">NÃO</option>
                  </select>
                </div>

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