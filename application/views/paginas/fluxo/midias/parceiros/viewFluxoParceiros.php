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
							<a href="<?php echo base_url('midiasParceirosController/viewInsertProgramasParceiros/'.$idParceiro)?>" class="btn btn-warning"><i class="fa fa-cog"></i> Programas Parceiros</a>	
							<a href="<?php echo base_url('midiasParceirosController/viewProgramasParceiros')?>" class="btn btn-primary"><i class="fa fa-list-alt"></i> Listagem Programas Parceiros</a>
          </div>
          <?php $this->load->view('include/alertsMsg') ?>
            
        </div>
        <!-- /.box-header -->
        <div class="box-body" id="menu-fluxo">        
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs ">
                <li <?php echo ($tab =='ingest' || $tab == '')? 'class="active"': ''?>><a href="<?php echo base_url('MidiasParceirosController/viewfluxoParceiros/'.$idParceiro.'/ingest') ?>">Ingest</a></li>
                <li <?php echo ($tab =='revisaoIngest')? 'class="active"': ''?>><a href="<?php echo base_url('MidiasParceirosController/viewfluxoParceiros/'.$idParceiro.'/revisaoIngest') ?>">Revisão Ingest</a></li>
                <li <?php echo ($tab =='ingestClosedCaption')? 'class="active"': ''?>><a href="<?php echo base_url('MidiasParceirosController/viewfluxoParceiros/'.$idParceiro.'/ingestClosedCaption') ?>">Ingest <i class="fa fa-cc" aria-hidden="true"></i></a></li>
                <li <?php echo ($tab =='revisaoClosedCaption')? 'class="active"': ''?>><a href="<?php echo base_url('MidiasParceirosController/viewfluxoParceiros/'.$idParceiro.'/revisaoClosedCaption') ?>">Revisão <i class="fa fa-cc" aria-hidden="true"></i></a></li>
                <li <?php echo ($tab =='fichaConclusao')? 'class="active"': ''?>><a href="<?php echo base_url('MidiasParceirosController/viewfluxoParceiros/'.$idParceiro.'/fichaConclusao') ?>">Ficha de Conclusão</a></li>
                <li <?php echo ($tab =='catalogacao')? 'class="active"': ''?>><a href="<?php echo base_url('MidiasParceirosController/viewfluxoParceiros/'.$idParceiro.'/catalogacao') ?>">Catalogação</a></li>
                <li <?php echo ($tab =='autorizacao')? 'class="active"': ''?>><a href="<?php echo base_url('MidiasParceirosController/viewfluxoParceiros/'.$idParceiro.'/autorizacao') ?>">Autorização</a></li>
                <li <?php echo ($tab =='revisaoExclusao')? 'class="active"': ''?>><a href="<?php echo base_url('MidiasParceirosController/viewfluxoParceiros/'.$idParceiro.'/revisaoExclusao') ?>">Revisar/Excluir</a></li>
              </ul>
            </div>
            <input type="hidden" name="idParceiro" value="<?php echo $idParceiro ?>" id="idParceiro"/>
		        <input type="hidden" name="etapa" value="<?php echo ($tab != '')? $tab:'ingest'  ?>" id="etapa"/>
            <?php /*if ($tab =='ingest' || $tab == '') { ?>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-ingestPrograma">
                <i class="fa fa-plus"></i> Ingestar Programa Parceiro
              </button>
            <?php }*/ ?> 
              
            
            <table id="listaProgramasParceiros" class="table table-bordered table-striped">            
              <thead>
                <tr>
                  <th>Programa</th>
                  <th>Nome Programa</th>
                  <th>Título PGM</th>
                  <th>Nº PGM</th>
                  <th>Versão</th>
                  <th>Datas</th>
                  <th>Usuário</th>
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
                  <th><input type="text" data-column="4" class="form-control search-input-text"  placeholder="pesquisar versao ..." style="width:100%;"></th>
                  <th><input type="text" data-column="5" value=""  class="form-control pull-right search-input-data" id="datepicker" placeholder="Data ..." style="width:100%;"></th>
                  <th><input type="text" data-column="6" class="form-control search-input-text"  placeholder="pesquisar usuários ..." style="width:100%;"></th>
                  <th>
                      <select  data-column="7" class="form-control search-input-select-informacao" style="width: 80%;">
                        <option value="">Selecione ...</option>
                        <?php 
                            switch ($tab) {
                              case 'ingest':
                                  echo '                        
                                  <option value="CORRIGIDO">Corrigido</option>
                                  <option value="APROVADO">Aprovado</option>
                                  <option value="REPROVADO" >Reprovado</option>
                                  <option value="NAOREVISADO" >Não Revisado</option>';
                                  break;
                              case 'revisaoIngest':
                                  echo '                        
                                  <option value="CORRIGIDO">Corrigido</option>
                                  <option value="APROVADO">Aprovado</option>
                                  <option value="REPROVADO" >Reprovado</option>
                                  <option value="NAOREVISADO" >Não Revisado</option>';
                                  break;     
                              case 'ingestClosedCaption':
                                    echo '                        
                                    <option value="SEMINGESTCC">Não Ingestado</option>
                                    <option value="NAOCC">Sem Ingest CC</option>
                                    <option value="INGESTCC">Com Ingest CC</option>
                                    <option value="APROVADOCC">Aprovado</option>
                                    <option value="REPROVADOCC" >Reprovado</option>
                                    <option value="NAOREVISADOCC" >Não Revisado</option>';
                                    break;
                              case 'revisaoClosedCaption':
                                    echo '                        
                                    <option value="CORRIGIDOCC">Corrigido</option>
                                    <option value="APROVADOCC">Aprovado</option>
                                    <option value="REPROVADOCC" >Reprovado</option>
                                    <option value="NAOREVISADOCC" >Não Revisado</option>';
                                    break;                       
                              case 'fichaConclusao':
                                  echo ' 
                                  <option value="COMFICHA">Com ficha</option>                       
                                  <option value="SEMFICHA">Sem Ficha</option>';
                                  break;                        
                              case 'catalogacao':
                                  echo '                        
                                  <option value="NAOCATALOGADA">Não Catalogada</option>
                                  <option value="CATINICIADA">Cat. Iniciada</option>
                                  <option value="CATFINALIZADA">Cat. Finalizada</option>
                                  <option value="CATCORRIGIDO">Corrigida</option>
                                  <option value="CATAPROVADO">Aprovada</option>
                                  <option value="CATREPROVADO" >Reprovada</option>
                                  <option value="CATNAOREVISADO" >Não Revisada</option>
                                  <option value="NAOCATALOGADACC">Não Catalogada - CC</option>
                                  <option value="CATALOGADACC">Cat. Finalizada - CC</option>
                                  <option value="CATCORRIGIDOCC">Corrigida - CC</option>
                                  <option value="CATAPROVADOCC">Aprovada - CC</option>
                                  <option value="CATREPROVADOCC" >Reprovada - CC</option>
                                  <option value="CATNAOREVISADOCC" >Não Revisada - CC</option>
                                  ';                                  
                                  break;
                              case 'autorizacao':
                                  echo ' 
                                  <option value="AUTORIZADO">Autorizado</option>                       
                                  <option value="NAOAUTORIZADO">Aguardando Autorização</option>
                                  <option value="AUTORIZADOCC">Autorizado - CC</option>
                                  <option value="NAOAUTORIZADOCC">Aguardando Autorização - CC </option>';
                                  break;     
                              case 'revisaoExclusao':
                                  echo '                        
                                  <option value="CATCORRIGIDO">Corrigida</option>
                                  <option value="CATAPROVADO">Aprovada</option>
                                  <option value="CATREPROVADO" >Reprovada</option>
                                  <option value="CATNAOREVISADO" >Não Revisada</option>
                                  <option value="EXCLUIDO" >Excluído</option>
                                  <option value="NAOEXCLUIDO" >Aguardando Exclusão</option>
                                  <option value="CATCORRIGIDOCC">Corrigida - CC</option>
                                  <option value="CATAPROVADOCC">Aprovada - CC </option>
                                  <option value="CATREPROVADOCC" >Reprovada - CC</option>
                                  <option value="CATNAOREVISADOCC" >Não Revisada - CC</option>
                                  <option value="EXCLUIDOCC" >Excluído - CC</option>
                                  <option value="NAOEXCLUIDOCC" >Aguardando Exclusão - CC</option>
                                  ';                                 
                                  break;
                              default:                         
                                  echo '                        
                                  <option value="CORRIGIDO">Corrigido</option>
                                  <option value="APROVADO">Aprovado</option>
                                  <option value="REPROVADO" >Reprovado</option>
                                  <option value="NAOREVISADO" >Não Revisado</option>';
                                  break;
                            }
                        ?>                      
                        
                      </select>
                  </th>     
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
                  <th>Versão</th>
                  <th>Datas</th>
                  <th>Usuário</th>
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
              <form action="<?php echo base_url('IngestController/ingestarParceiro') ?>" method="POST">
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
                              <input type="number" name="numeroPGM" class="form-control" id="numeroPGM" placeholder="Número do Programa" value="" min="1"  required >
                          </div>
                          

                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">

                          <div class="form-group">
                              <label for="claquetes">O Programa possui quantas Claquetes ?</label>
                              <input name="claquetes" type="number" class="form-control" id="claquetes" placeholder="Número de Claquetes" value="1" min="1"  required >
                          </div>

                          <div class="form-group">
                              <label for="blocos">O Programa possui quantos Blocos ?</label>
                              <input name="blocos" type="number" class="form-control" id="blocos" placeholder="Número de Blocos" value="1" min="1"  required>
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
        
        <div class="modal face" id="modal-alterarIngest" role="dialog"></div>
        <div class="modal face" id="modal-visualizarIngest" role="dialog"></div>
        <div class="modal face" id="modal-excluirIngest" role="dialog"></div>

        <div class="modal face" id="modal-revisarIngest" role="dialog"></div> 
        <div class="modal face" id="modal-alterarRevisao" role="dialog"></div> 
        <div class="modal face" id="modal-visualizarRevisao" role="dialog"></div>        
        <div class="modal face" id="modal-corrigirIngest" role="dialog"></div>
        <div class="modal face" id="modal-corrigirRevisaoIngest" role="dialog"></div>

        <!-- Closed Caption -->

        <div class="modal face" id="modal-alterarIngestClosedCaption" role="dialog"></div>
        <div class="modal face" id="modal-visualizarIngestClosedCaption" role="dialog"></div>
        <div class="modal face" id="modal-excluirIngestClosedCaption" role="dialog"></div>
        <div class="modal face" id="modal-corrigirIngestClosedCaption" role="dialog"></div>

        <div class="modal face" id="modal-revisarClosedCaption" role="dialog"></div> 
        <div class="modal face" id="modal-alterarRevisaoClosedCaption" role="dialog"></div> 
        <div class="modal face" id="modal-visualizarRevisaoClosedCaption" role="dialog"></div>        
        <div class="modal face" id="modal-corrigirCatalogacaoClosedCaption" role="dialog"></div>
        <div class="modal face" id="modal-corrigirRevisaoIngestClosedCaption" role="dialog"></div>      

        <div class="modal face" id="modal-revisarCatalogacaoClosedCaption" role="dialog"></div> 
        <div class="modal face" id="modal-alterarCatalogacaoRevisaoClosedCaption" role="dialog"></div> 
        <div class="modal face" id="modal-visualizarCatalogacaoRevisaoClosedCaption" role="dialog"></div>        
        <div class="modal face" id="modal-corrigirCatalogacaoIngestClosedCaption" role="dialog"></div>
        <div class="modal face" id="modal-corrigirRevisaoCatalogacaoClosedCaption" role="dialog"></div>                   
        

        <!---- FIM --------->

        <div class="modal face" id="modal-cadastrarFichaConclusao" role="dialog"></div>
        <div class="modal face" id="modal-alterarFichaConclusao" role="dialog"></div>
        <div class="modal face" id="modal-visualizarFichaConclusao" role="dialog"></div>
        <div class="modal face" id="modal-excluirFichaConclusao" role="dialog"></div>

        <div class="modal face" id="modal-catalogar" role="dialog"></div>
        <div class="modal face" id="modal-visualizarCatalogacao" role="dialog"></div>
        <div class="modal face" id="modal-excluirCatalogacao" role="dialog"></div>

        <div class="modal face" id="modal-revisarCatalogacao" role="dialog"></div>
        <div class="modal face" id="modal-corrigirCatalogacao" role="dialog"></div>
        <div class="modal face" id="modal-corrigirRevisaoCatalogacao" role="dialog"></div>
        <div class="modal face" id="modal-visualizarRevisaoCatalogacao" role="dialog"></div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
