<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Upload de arquivo
        <small>Cadastro</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('RestritoController/viewLista') ?>">Inserir Arquivo</a></li>
        <li class="active">Cadastro</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <form action="<?php echo base_url('RestritoController/cadastrarRestrito') ?>" method="POST">

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
                <label>Colaborador</label>
                <select name="cooperado" class="form-control select2" style="width: 100%;">  
                 <!-- <li><option value="GERAL" ><?php# echo "Arquivo Global"?></option></li>	-->                
                  <?php foreach ($listCooperado as $cooperado) { ?>
                      <option value="<?php echo $cooperado->id .' - '. $cooperado->email.' - '.$cooperado->nome ?>" ><?php echo $cooperado->nome ?></option>
					<?php } ?>    
                    
                </select>
				
                    
              </div>
              
            </div>
            <!-- /.col -->
            <div class="col-md-6">
               
            

              <div class="form-group">
                <label>Tipo de Arquivo</label>
                <select name="TipoArquivo" class="form-control select2" style="width: 100%;">                  
                  <?php foreach ($listTipoArquivo as $TipoArquivo) { ?>
                      <option value="<?php echo $TipoArquivo->id ?>" ><?php echo $TipoArquivo->descricao ?></option>
                  <?php } ?>                  
                </select>
              </div>

          

              <!--<button type="submit" class="btn btn-primary">Cadastrar</button>-->

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
          <h3 class="box-title">Upload de Arquivo</h3>

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
                  <label for="arquivos" class="control-label">Selecionar Arquivos:</label>
                  <input id="arquivos" name="arquivos[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                      <div id="resp"></div>  
				  
                </div>
				<button type="submit" class="btn btn-primary">Cadastrar</button>	
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