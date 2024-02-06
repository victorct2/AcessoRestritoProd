<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Pautas
        <small>Cadastro</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('Pautas/viewLista') ?>">Sistema de Pautas</a></li>
        <li class="active">Cadastro</li>
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

          <form action="<?php echo base_url('Pautas/cadastrarPauta') ?>" method="POST">
          
          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                <label>Programa</label>
                <select name="programa" class="form-control selectProgramas" data-placeholder="Selecione o programa"
                        style="width: 100%;">
                  <?php foreach ($listProgramas as $programa) { ?>
                    <option value="<?php echo $programa->id ?>"><?php echo $programa->titulo ?></option>
                  <?php } ?>
                </select>
              </div>

              <div id="numeroPrograma" class="form-group">
                  <label for="numeroPgm">Nº PGM:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <input type="text" name="numeroPgm" class="form-control" id="numeroPgm" placeholder="Informe o Nº do PGM">
                  </div>
                  <!-- /.input group -->
              </div>

             <div class="form-group">
                  <label for="tema">Tema / Matéria Principal:</label>
                  <textarea class="form-control" name="tema" rows="5" placeholder="Tema ..."></textarea>
              </div>
                        
                            
            </div>
            <!-- /.col -->
            <div class="col-md-6">

              <div class="form-group">
                  <label for="convidados">Convidados:</label>
                  <textarea class="form-control" name="convidados" rows="5" placeholder="Convidados ..."></textarea>
              </div>                   
               
               
              <!-- Date -->
              <div class="form-group">
                <label>Data de Exibição:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="dataExibicao" class="form-control pull-right" id="datepicker1">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->

              <!-- Date -->
              <div class="form-group">
                <label>Data da Reunião de Pauta com equipe:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="dia" class="form-control pull-right" id="datepicker2">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->

              <button type="submit" class="btn btn-primary">Cadastrar</button>

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