<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Mídias
        <small>Área de Parceiros</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sistema de Mídias</a></li>
        <li class="active">Área de Parceiros</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Área de de Parceiros</h3>
          <div class="box-tools pull-right">           
          <a href="<?php echo base_url('midiasParceirosController/viewProgramasParceiros')?>" class="btn btn-primary"><i class="fa fa-list-alt"></i> Listagem Programas Parceiros</a>                                  
            <a href="<?php echo base_url('midiasParceirosController/viewCadastroParceiro')?>" class="btn btn-success"><i class="fa fa-plus"></i> Cadastro de Parceiro</a>           
          </div>
          <?php $this->load->view('include/alertsMsg') ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="listaParceiros" class="table table-bordered table-striped">            
              <thead>
                <tr>
                  <th>Imagem Parceiro</th>
                  <th>Nome Parceiro</th>
                  <th>descricao Parceiro</th>
                  <th>Informação</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <thead>
                <tr class="busca">
                  <th></th>                  
                  <th>
                    <select data-column="1" class="form-control select2 search-input-select-parceiro" style="width: 100%;">
                      <option value="">Selecione ...</option> 
                      <?php foreach ($listParceiros as $parceiro) { ?>
                            <option value="<?php echo $parceiro->idParceiros ?>" ><?php echo $parceiro->nomeParceiro ?></option>  
                      <?php } ?>                                     
                    </select>
                  </th>
                  <th><input type="text" data-column="2" class="form-control search-input-text"  placeholder="pesquisar descrição ..." style="width:100%;"></th>
                  <th>
                      <select  data-column="3" class="form-control search-input-select-informacao" style="width: 80%;">
                        <option value="">Selecione ...</option>                        
                        <option value="SITE">No Site</option>
                        <option value="FORASITE">Fora do Site</option>
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
                  <th>Imagem Parceiro</th>
                  <th>Nome Parceiro</th>
                  <th>descricao Parceiro</th>
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
