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
          <img src="<?php echo IMAGEM_PARCEIRO. $parceiro[0]->imagem?>" class="img-responsive img-thumbnail" width="130" height="70">                 
          <div class="box-tools pull-left">          						
							<a href="<?php echo base_url('midiasParceirosController/viewProgramasParceiros')?>" class="btn btn-primary"><i class="fa fa-list-alt"></i> Listagem Programas Parceiros</a>
              <a href="<?php echo base_url('midiasParceirosController/viewfluxoParceiros/'.$parceiro[0]->idParceiros)?>" class="btn btn-warning"><i class="fa fa-reply"></i> Voltar</a>
          </div>
          <?php $this->load->view('include/alertsMsg') ?>
            
        </div>
        <!-- /.box-header -->
        <div class="box-body" id="menu-fluxo">        
            
            <input type="hidden" name="idParceiro" value="<?php echo $idParceiro ?>" id="idParceiro"/>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-ingestPrograma">
              <i class="fa fa-plus"></i> Inserir Programa Parceiro
            </button>
                        
            
            <table id="listaProgramasParceiros" class="table table-bordered table-striped">            
              <thead>
                <tr>
                  <th>Programa</th>
                  <th>Nome Programa</th>
                  <th>Título PGM</th>
                  <th>Nº PGM</th>
									<th>Recebido por</th>
									<th>Observação</th>
									<th>Data Cadastro</th>
                  <th>Status</th>                  
                  <th>Ação</th>
                </tr>
              </thead>
              <thead>
                <tr class="busca">                                   
                  <th>
                    <select data-column="0" class="form-control select2 search-input-select-programa" style="width: 100%;">
                      <option value="">Selecione ...</option> 
                      <?php foreach ($listSerieParceiros as $programa) { ?>
                            <option value="<?php echo $programa->idProgramasParceiros ?>" ><?php echo $programa->sigla .' - '. $programa->nomePrograma ?></option>  
                      <?php } ?>                                     
                    </select>
                  </th>
                  <th><input type="text" data-column="1" class="form-control search-input-text"  placeholder="pesquisar nome programa ..." style="width:100%;"></th>
                  <th><input type="text" data-column="2" class="form-control search-input-text"  placeholder="pesquisar titulo PGM ..." style="width:100%;"></th>
                  <th><input type="text" data-column="3" class="form-control search-input-text"  placeholder="pesquisar nº pgm ..." style="width:100%;"></th>
                  <th>
                      <select  data-column="4" class="form-control search-input-select-informacao" style="width: 80%;">
												<option value="">Selecione ...</option>
												<option value="FTP">FTP</option>
												<option value="NUVEM">Nuvem</option>
												<option value="YOUTUBE">Youtube</option>
												<option value="HD">HD</option>                      
												<option value="PG">Plano Geral</option>                      
                      </select>
									</th>     
									<th><input type="text" data-column="5" class="form-control search-input-text"  placeholder="pesquisar observação ..." style="width:100%;"></th>
                  <th><input type="text" data-column="6" value=""  class="form-control pull-right search-input-data" id="datepicker" placeholder="Data ..." style="width:100%;"></th>                  
                  <th>
                      <select  data-column="7" class="form-control search-input-select-informacao" style="width: 80%;">
												<option value="">Selecione ...</option>
												<option value="LIBERADO">Liberado para Edição</option>
												<option value="AGUARDANDO">Aguardando Liberação para edição</option> 
												<option value="CANCELADO">Programa Cancelado</option>                     
                      </select>
									</th> 
									<th></th>    
                </tr>
              </thead>
              <tbody>
              </tbody>  
              <tfoot>
                <tr>
									<th>Programa</th>
                  <th>Nome Programa</th>
                  <th>Título PGM</th>
                  <th>Nº PGM</th>
									<th>Recebido por</th>
									<th>Observação</th>
									<th>Data Cadastro</th>
                  <th>Status</th>                  
                  <th>Ação</th>
                </tr>
              </tfoot>
            </table>


        </div>
        <!-- /.box-body -->

      </div>
      <!-- /.box -->
      
      <div class="modal fade" id="modal-ingestPrograma">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <form action="<?php echo base_url('IngestController/inserirProgramaParceiro') ?>" method="POST">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Cadastro de Programa</h4>
                </div>
                <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6">    
                          <input type="hidden" name="idParceiros" value="<?php echo $idParceiro ?>" />                  

                          <div class="form-group">
                              <label for="programaParceiro">Programa Parceiro</label>
                              <select name="programaParceiro" class="form-control select2" style="width: 100%;" required >
                              <?php foreach ($listSerieParceiros as $programa) { ?>
                                    <option value="<?php echo $programa->idProgramasParceiros ?>" ><?php echo $programa->sigla . ' - ' . $programa->nomePrograma ?></option>  
                              <?php } ?>                                      
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="tituloPrograma">Título do Programa :</label>
                              <input name="tituloPrograma" type="text" class="form-control" id="tituloPrograma" placeholder="Título do Programa" required >
                          </div>
                          
                          <div class="form-group">
                              <label for="numeroPGM">Número do Programa :</label>
                              <input type="text" name="numeroPGM" class="form-control" id="numeroPGM" placeholder="Número do Programa" value="" min="1"  required >
                          </div>
                          

                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">

													<div class="form-group">
                              <label for="recebido">Como o Programa foi recebido :</label>
                              <select name="recebido" class="form-control" style="width: 80%;">
																	<option value="">Selecione ...</option>
																	<option value="FTP">FTP</option>
																	<option value="NUVEM">Nuvem</option>
																	<option value="YOUTUBE">Youtube</option>
																	<option value="HD">HD</option>
																	<option value="PG">Plano Geral</option>
                              </select>
													</div>										

													<div class="form-group">
                              <label for="numeroPGM">Status :</label>
                              <select name="statusIngest" class="form-control" style="width: 80%;">
																	<option value="">Selecione ...</option>
																	<option value="LIBERADO">Liberado para Edição</option>
																	<option value="AGUARDANDO">Aguardando Liberação para edição</option>
																	<option value="CANCELADO">Programa Cancelado</option>
                              </select>
                          </div>

                          <div class="form-group">
                              <label for="observacao">Observações :</label>
                              <textarea name="observacao" class="form-control" rows="4" placeholder="Observações ..." ></textarea>
                          </div>

                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                  <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
        <div class="modal face" id="modal-alterarInfoParceiro" role="dialog"></div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
