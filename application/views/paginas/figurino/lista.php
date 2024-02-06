<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Figurino
        <small>Lista</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sistema de Figurino</a></li>
        <li class="active">Lista</li>
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
          <?php $this->load->view('include/alertsMsg') ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> 

             <div class="box box-default box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title">Funções e filtros</h3>                   
                  </div>
                  <div class="box-body">                    
                    <div class="row">
                      <div class="col-lg-3">
                        <a href="<?php echo base_url('FigurinoController/viewCadastro')?>" class="btn btn-primary"><i class="fa fa-plus"></i> Cadastrar Figurino</a>
                      </div><!-- /.col-lg-3 -->
                      <form action="<?php echo base_url('FigurinoController/buscar')?>" method="POST">
                          <div class="col-lg-3">
                            <div class="form-group">
                              <!--<label>Sexo</label>-->
                              <select name="tipo" class="form-control select2" style="width: 100%;">                  
                              <option value="" >Selecione o tipo...</option>
                                <?php foreach ($listTipo as $tipo) { ?>
                                    <option value="<?php echo $tipo->idTipoFigurino ?>" ><?php echo $tipo->tipo ?></option>
                                <?php } ?>                  
                              </select>
                            </div>
                          </div><!-- /.col-lg-3 -->
                          <div class="col-lg-3">
                            <div class="form-group">
                              <!--<label>Sexo</label>-->
                              <select name="sexo" class="form-control" style="width: 100%;">
                                <option value="">Selecione o sexo...</option>   
                                <option value="M">MASCULINO</option>
                                <option value="F">FEMININO</option>
                              </select>
                            </div>
                          </div><!-- /.col-lg-3 -->
                          <div class="col-lg-3">                            
                              <div class="input-group">
                                <input type="descricao" name="descricao" class="form-control" placeholder="Descrição ...">
                                <span class="input-group-btn">
                                  <input type="submit" class="btn btn-warning">Buscar</input>
                                </span>
                              </div><!-- /input-group -->                                                      
                          </div><!-- /.col-lg-3 -->
                      </form>                        
                    </div><!-- /.row -->                                                         
                  </div>
                    
            </div>
            <div class="row">                
                <div class="col-lg-6 pull-right">                
                  <nav aria-label="Page navigation ">                             
                    <ul class="pagination pull-right">                      
                      <?php echo $paginacao; ?>                      
                    </ul>
                  </nav>
                </div>
            </div>
            <hr>
             <?php foreach ($listFigurino as $figurino) { ?>
              <div class="col-md-2">
                <div class="box box-warning box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $figurino->codigo ?></h3>

                    
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <a class="fancybox" rel="gallery1" href="<?php echo base_url().'assets/img/figurino/'.$figurino->foto ?>" title="<?php echo $figurino->descricao ?>">
                      <img src="<?php echo  base_url().'assets/img/figurino/'.$figurino->foto ?>" class="img-responsive img-rounded  imgList zoom" alt="" />
                    </a>
                    
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                      <div class="info">
                          <?php
                            echo '<span class="label pull-left bg-navy ">'.$figurino->descricao .'</span><br><br>'; 
                            echo ($figurino->sexo == 'M')? '<span class="label pull-left bg-primary ">MASCULINO</span><br><br>': '' ;
                            echo ($figurino->sexo == 'F')? '<span class="label pull-left bg-purple ">FEMININO</span><br><br>': '' ;
                            echo ($figurino->situacaoFigurino_id == '1')? '<span class="label pull-left bg-green ">DISPONÍVEL</span>': '' ;
                            echo ($figurino->situacaoFigurino_id == '2')? '<span class="label pull-left bg-orange ">EM USO</span>': '' ;
                            echo ($figurino->situacaoFigurino_id == '3')? '<span class="label pull-left bg-danger ">LAVANDERIA</span>': '' ;
                            echo ($figurino->situacaoFigurino_id == '4')? '<span class="label pull-left bg-danger ">COSTUREIRA</span>': '' ;
                          ?>  
                      </div>
                      
                      <hr>
                      <a href="<?php echo base_url('FigurinoController/viewAlterar/'.$figurino->idFigurino) ?>" class="btn btn-app">
                        <i class="fa fa-edit"></i> Alterar
                      </a>
                       <a href="<?php echo base_url('FigurinoController/excluirFigurino/'.$figurino->idFigurino) ?>" class="btn btn-app">
                        <i class="fa fa-trash"></i> Excluir
                      </a>
                      </a>
                       <a href="<?php echo base_url('FigurinoController/viewLavanderia/'.$figurino->idFigurino) ?>" class="btn btn-app">
                        <span class="badge bg-yellow"><?php echo $this->figurinoDao_model->totalServico($figurino->idFigurino,'L') ?></span>
                        <i class="fa fa-shower"></i> Lavanderia
                      </a>
                      </a>
                       <a href="<?php echo base_url('FigurinoController/viewCostureira/'.$figurino->idFigurino) ?>" class="btn btn-app">
                        <span class="badge bg-purple"><?php echo $this->figurinoDao_model->totalServico($figurino->idFigurino,'C') ?></span>
                        <i class="fa fa-american-sign-language-interpreting"></i> Costureira
                      </a>
                  </div>
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
            <?php } ?>

      
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <nav aria-label="Page navigation ">
              <ul class="pagination pull-right">
                <?php echo $paginacao; ?>
              </ul>
            </nav>
        </div>
      </div>
      <!-- /.box -->

    


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  
</script> 