<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Figurino
        <small>Lavanderia</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('FigurinoController/viewLista') ?>">Sistema de Figurino</a></li>
        <li class="active">Lavanderia</li>
      </ol>
    </section>

   
    <!-- Main content -->
    <section class="content">

      <div class="row">
          <div class="col-md-6">      

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
                   

                    <div class="form-group">
                        <label for="descricao">Descrição :</label>
                        <input name="descricao" type="text" class="form-control" id="descricao" value="<?php echo $figurino[0]->descricao ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label for="descricao">Tipo Figurino :</label>
                        <input name="descricao" type="text" class="form-control" id="descricao" value="<?php echo $figurino[0]->tipo ?>" disabled >
                    </div>
                
                    
                    <div class="form-group">
                        <label for="descricao">Sexo :</label>
                        <input name="descricao" type="text" class="form-control" id="descricao" value="<?php echo ($figurino[0]->sexo == 'M')? 'MASCULINO':'FEMININO' ?>" disabled >
                    </div>

                    <div class="form-group">
                        <label for="descricao">Situação :</label>
                        <input name="descricao" type="text" class="form-control" id="descricao" value="<?php echo $figurino[0]->situacao ?>" disabled >
                    </div>


                    <div  class="form-group">
                      <img src="<?php echo base_url().'assets/img/figurino/'.$figurino[0]->foto ?>" class="img-responsive img-rounded imagemLavanderia" alt="">
                    </div>
              </div>
              <!-- /.box-body -->
              
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (left) -->

        <div class="col-md-6">      

            <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">Lavanderia</h3>
                <span class="label pull-rigth bg-maroon total">Total: <?php echo $this->figurinoDao_model->totalServico($figurino[0]->idFigurino,'L') ?>  </span>
                <?php $this->load->view('include/alertsMsg') ?>

                <div class="box-tools pull-right">                    
                    <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#saidaFigurino" >
                      <i class="fa fa-plus"></i> CADASTRAR
                    </button>
                </div> 
                <div id="saidaFigurino" class="col-md-6 collapse" >      

                        <form action="<?php echo base_url('FigurinoController/cadastrarLavanderia')?>" method="POST">
                            <!-- Date range -->
                            <div class="form-group">
                              <label>Data de Saída:</label>

                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input name="dataSaida" type="text" class="form-control pull-right" id="datepicker">
                              </div>
                              <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                            <input type="hidden" name="idFigurino" value="<?php echo $figurino[0]->idFigurino ?>">
                            <button type="submit" class="btn btn-warning">Cadastrar</button>  
                        </form>                        
                      
                </div>                   
              </div>
              <!-- /.box-header -->
              <div class="box-body">

                    <ul class="lavanderia-list">
                    <?php foreach ($listLavanderia as $value) { ?>
                    
                      <li>                        
                        <!-- todo text -->
                        <span class="text">Data de Saída</span>
                        <!-- Emphasis label -->
                        <span class="label label-success datas"><i class="fa fa-calendar"></i>  <?php echo converteDataInterface($value->saidaFigurino) ?></span>
                        <span class="label label-danger datas"><i class="fa fa-calendar"></i>  <?php echo converteDataInterface($value->retornoFigurino) ?></span>
                        <!-- General tools such as edit or delete-->  
                        <div class="tools">     
                          <?php if($value->retornoFigurino == '' ) {?>                 
                            <button type="button" class="btn btn-xs btn-danger devolucao" id="<?php echo $value->idHistoricoServico ?>" title="<?php echo $figurino[0]->idFigurino ?>" >
                              Devolução
                            </button>
                          <?php } ?>
                        </div>
                      </li>
                    <?php } ?>
                    </ul>  
              </div>
              <!-- /.box-body -->              
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  
</script> 