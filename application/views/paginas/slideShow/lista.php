<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sistema de SlideShow
        <small>Lista</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sistema de SlideShow</a></li>
        <li class="active">Lista</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      
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
                      <div class="col-lg-4">
                        <a href="<?php echo base_url('SlideShowController/viewCadastro')?>" class="btn btn-primary"><i class="fa fa-plus"></i> Cadastrar SlideShow</a>                        
                      </div><!-- /.col-lg-4 -->                      
                    </div><!-- /.row -->                                                         
                  </div>                    
            </div> 


            <table id="listaSlideShow" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Imagem</th>
                  <th>Título</th>
                  <th>Descrição</th>
                  <th>URL</th>
                  <th>Informações</th>                   
                  <th>Ação</th>
                </tr>
              </thead>
              <thead>
                <tr class="busca">
                  <th></th>
                  <th><input type="text" data-column="1" class="form-control search-input-text"  placeholder="pesquisar titulo " style="width:100%;"></th>
                  <th><input type="text" data-column="2" class="form-control search-input-text"  placeholder="pesquisar descricao ..." style="width:100%;"></th>                
                  <th><input type="text" data-column="3" class="form-control search-input-text"  placeholder="pesquisar url ..." style="width:100%;"></th>                
                  <th>
                      <select  data-column="4" class="form-control search-input-select-informacao" style="width: 80%;">
                      <option value="">Selecione ...</option> 
                        <option value="S" >Ativo</option>
                        <option value="N">Inativo</option>
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
                  <th>Título</th>
                  <th>Descrição</th>
                  <th>URL</th>
                  <th>Informações</th>                   
                  <th>Ação</th>
                </tr>
              </tfoot>
            </table>


      
        </div>

      </div>
      <!-- /.box -->

    


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  
</script> 