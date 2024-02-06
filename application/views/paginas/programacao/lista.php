<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Programação
        <small>Lista</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sistema de Programação</a></li>
        <li class="active">Lista</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações</h3>
          <?php $this->load->view('include/alertsMsg') ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
            <table id="listaProgramacao" class="table table-bordered table-striped">
              
              <div class="box box-default box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title">Funções e filtros</h3>                   
                  </div>
                  <div class="box-body">
                    <button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#excluirProgramacao">
                      <i class="fa fa-trash"></i> Excluir Programação por Período
                    </button>
                    <a href="<?php echo base_url('ProgramacaoController/viewCadastro')?>" class="btn btn-primary"><i class="fa fa-plus"></i> Cadastrar Programação</a>
                    <a href="<?php echo base_url('ProgramacaoController/viewArquivo')?>" class="btn btn-success"><i class="fa fa-file"></i> Enviar Arquivo</a>
                                      
                  </div>  
                  <div class="box-footer">
                      <div id="excluirProgramacao" class="col-md-6 collapse" >      

                        <form action="<?php echo base_url('ProgramacaoController/excluirPorPeriodo')?>" method="POST">
                            <!-- Date range -->
                            <div class="form-group">
                              <label>Date range:</label>

                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input name="periodo" type="text" class="form-control pull-right" id="reservation">
                              </div>
                              <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                            <button type="submit" class="btn btn-info">Excluir Programação</button>  
                        </form>                        
                      </div>
                  </div>              
              </div>
              <thead>
                <tr>
                  <th>imagemPrograma</th>
                  <th>Veiculação</th>
                  <th>Programa</th>
                  <th>Data</th>
                  <th>Hora Inicial</th>
                  <th>Hora Final</th>
                  <th>Tema</th>
                  <th>Descrição</th>
                  <th>Informação</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <thead>
                <tr class="busca">
                  <th></th>
                  <th></th>
                  <th>
                    <select data-column="1" class="form-control select2 search-input-select-programa" style="width: 100%;">
                      <option value="">Selecione ...</option> 
                      <?php foreach ($listProgramas as $programa) { ?>
                            <option value="<?php echo $programa->titulo ?>" ><?php echo $programa->titulo ?></option>  
                      <?php } ?>                                     
                    </select>
                  </th>
                  <th><input type="text" data-column="2" value=""  class="form-control pull-right search-input-data" id="datepicker" placeholder="Data ..." style="width:100%;"></th>                 
                  <th></th>
                  <th></th>
                  <th><input type="text" data-column="3" class="form-control search-input-text"  placeholder="pesquisar tema ..." style="width:100%;"></th>
                  <th><input type="text" data-column="4" class="form-control search-input-text"  placeholder="pesquisar descricao ..." style="width:100%;"></th>                
                  <th>
                      <select  data-column="5" class="form-control search-input-select-informacao" style="width: 80%;">
                        <option value="">Selecione ...</option>                        
                        <option value="DESTAQUE">Em Destaque</option>
                        <option value="INEDITO">Inédito</option>
                        <option value="SEMINEDITO">Não inédito</option>
                        <option value="SEMDESTAQUE">Sem Destaque</option>
                        <option value="ATIVO" >Ativo</option>
                        <option value="INATIVO" >Inativo</option>
                        
                      </select>
                  </th>                   
                  <th></th>
                </tr>
              </thead>
              <tbody>
              </tbody>  
              <tfoot>
                <tr>
                  <th>imagemPrograma</th>      
                  <th>Veiculação</th>
                  <th>Programa</th>
                  <th>Data</th>
                  <th>Hora Inicial</th>
                  <th>Hora Final</th>
                  <th>Tema</th>
                  <th>Descrição</th>
                  <th>Informação</th>
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
