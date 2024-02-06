<div class="wrapper">

  <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Como Assistir <small>Outros Canais</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Home') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('NoticiasController/viewLista') ?>">Como Assistir</a></li>
        <li class="active">Outros Canais</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <form action="<?php echo base_url('ComoAssistirController/alterarTextoOutrosCanais') ?>" method="POST">
              

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

            <input type="hidden" name="idOutrosCanaisTexto" value="<?php echo $textoOutrosCanais[0]->idOutrosCanaisTexto ?>">

            <div class="row">
              <div class="col-md-12">
                <div class="box-body pad">
                  <form>
                        <textarea id="editor1" name="texto" rows="10" cols="80">
                            <?php echo $textoOutrosCanais[0]->texto ?>
                        </textarea>
                  </form>
                </div>
                <hr>
                <button type="submit" class="btn btn-warning ">Alterar Texto</button>
              </div>
              
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
          
        </div>
        <!-- /.box -->
      

     </form>

		 <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Informações</h3>

          <div class="box-tools pull-right">
						<a class="btn btn-success" data-toggle="modal" data-target="#modal-canalCadastro"><i class="fa fa-plus"></i> Cadastrar Canal</a>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>						
          </div>
          <?php $this->load->view('include/alertsMsg') ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> 

            <table id="listaOutrosCanais" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Canal</th>
                  <th>Link</th>
									<th>Status</th>                
                  <th>Ação</th>
                </tr>
              </thead>
              <thead>
                <tr class="busca">
                  <th><input type="text" data-column="1" class="form-control search-input-text"  placeholder="pesquisar id " style="width:100%;"></th>
                  <th><input type="text" data-column="2" class="form-control search-input-text"  placeholder="pesquisar canal ..." style="width:100%;"></th>                
                  <th><input type="text" data-column="3" class="form-control search-input-text"  placeholder="pesquisar link ..." style="width:100%;"></th>                                                   
                  <th>
                      <select  data-column="4" class="form-control search-input-select-informacao" style="width: 80%;">
                        <option value="">Selecione ...</option>                        
                        <option value="ATIVO">Ativo</option>
                        <option value="INATIVO">Inativo</option>
                        
                      </select>
                  </th>     
									<th></th>
                </tr>
              </thead>
              <tbody>
                                               
              </tbody>
              <tfoot>
                <tr>
									<th>ID</th>
                  <th>Canal</th>
                  <th>Link</th> 
									<th>Status</th>                
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

	<div class="modal face" id="modal-canal" role="dialog"></div>
	<div class="modal face" id="modal-canalCadastro" role="dialog"></div>
