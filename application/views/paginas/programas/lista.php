<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de Programas
        <small>Lista</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sistema de Programas</a></li>
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

           

            <table id="listaProgramas" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="20%">Imagem</th>
                  <th width="10%">Nome</th>
                  <th width="10%">Sigla</th>
                  <th width="50%">Descrição</th>
                  <th width="5%">Informações</th>                   
                  <th>Ação</th>
                </tr>
              </thead>
              <thead>
                <tr class="busca">
                  <th></th>
                  <th>
                    <select data-column="1" class="form-control select2 search-input-select-programa" style="width: 100%;">
                      <option value="">Selecione ...</option> 
                      <?php foreach ($listProgramas as $programa) { ?>
                            <option value="<?php echo $programa->titulo ?>" ><?php echo $programa->titulo ?></option>  
                      <?php } ?>                                     
                    </select>
                  </th>                  
                  <th><input type="text" data-column="2" class="form-control search-input-text"  placeholder="pesquisar sigla ..." style="width:100%;"></th>
                  <th><input type="text" data-column="3" class="form-control search-input-text"  placeholder="pesquisar descricao ..." style="width:100%;"></th>                
                  <th>
                      <select  data-column="4" class="form-control search-input-select-informacao" style="width: 80%;">
                        <option value="">Selecione ...</option>      
                        <option value="ATIVO" >Ativo</option>
                        <option value="INATIVO" >Inativo</option>
                        <option value="NOSITE">ativo site</option>
                        <option value="FORASITE">desativado no site</option>
                      </select>
                  </th>                   
                  <th></th>
                </tr>
              </thead>
              <tbody>
               
              </tbody>
              <tfoot>
                <tr>
                  <th>Imagem</th>
                  <th>Nome</th>
                  <th>Sigla</th>
                  <th>Descrição</th>
                  <th>Informações</th>                   
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
<script>
  
</script> 