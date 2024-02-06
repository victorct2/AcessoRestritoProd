<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Parcerias Institucionais
        <small>Lista</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Parcerias Institucionais</a></li>
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
						<a class="btn btn-primary" data-toggle="modal" data-target="#modal-cadastrarParceiroInstitucional"><i class="fa fa-plus"></i> Cadastrar Parceiro Institucional</a>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
						
          </div>
          <?php $this->load->view('include/alertsMsg') ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> 

            <table id="listaParceriasInstitucionais" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Imagem</th>
                  <th>Título</th>
                  <th>Descrição</th>
                  <th>link</th>                       
                  <th>Status</th>   
                  <th>Ação</th>
                </tr>
              </thead>
              <thead>
                <tr class="busca">                  
                  <th></th>                  
                  <th><input type="text" data-column="1" class="form-control search-input-text"  placeholder="pesquisar título ..." style="width:100%;"></th>
                  <th><input type="text" data-column="2" class="form-control search-input-text"  placeholder="pesquisar descrição ..." style="width:100%;"></th>
                  <th><input type="text" data-column="3" class="form-control search-input-text"  placeholder="pesquisar link ..." style="width:100%;"></th>                
                  <th>
                      <select  data-column="4" class="form-control search-input-select-informacao" style="width: 80%;">
                        <option value="">Selecione ...</option>                        
                        <option value="S">Ativo</option>
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
                  <th>link</th>                       
                  <th>Status</th>   
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
<div class="modal face" id="modal-alterarParceiroInstitucional" role="dialog"></div>
<div class="modal face" id="modal-cadastrarParceiroInstitucional" role="dialog"></div>
