<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Programacao
        <small>Cadastro</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('ProgramacaoController/viewLista') ?>">Sistema de Programacao</a></li>
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

          <form action="<?php echo base_url('ProgramacaoController/cadastrarProgramacao')?>" method="POST">            
          
          <div class="row">
            <div class="col-md-6">

              
              <div class="form-group">
                  <label>Programa</label>
                  <select name="programa" class="form-control select2" style="width: 100%;" >
                    <?php foreach ($listProgramas as $value) { ?>
                          <option value="<?php echo $value->titulo ?>" ><?php echo $value->titulo ?></option>  
                    <?php } ?>                                     
                  </select>
              </div>

               <div class="form-group">
                  <label>Tema</label>
                  <textarea class="form-control" name="tema" rows="5" placeholder="Tema ..."></textarea>
              </div>

              <!-- Date -->
                <div class="form-group">
                  <label>Dia:</label>

                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="dia" class="form-control pull-right" id="datepicker">
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              
              
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                
                <div class="form-group">
                  <label>Hora Inicial:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" name="hrinicial" class="form-control"  data-inputmask='"mask": "99:99"' data-mask >
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->

                <div class="form-group">
                  <label>Hora Final:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" name="hrfinal" class="form-control"  data-inputmask='"mask": "99:99"' data-mask >
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
               
               
                <div class="form-group">
                <label>Situação</label>
                <select class="form-control" name="situacao" style="width: 100%;">
                  <option value="S" selected="selected">ATIVO</option>
                  <option value="N">INATIVO</option>
                </select>
              </div>

              <button type="submit" class="btn btn-primary" >Cadastrar</button>

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