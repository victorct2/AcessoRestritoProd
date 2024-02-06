<div class="modal-dialog modal-lg">
  <div class="modal-content">   
  <form action="<?php echo base_url()?>RevisaoController/revisaoCorrecao" method="post" >  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>        
        <?php $programa =  $this->parceirosDao->selectProgramaParceiroById($ingest[0]->idPrograma)?>
        <img src="<?php echo IMAGEM_PROGRAMA_PARCEIRO.$programa[0]->imagem?>" class="img-thumbnail imgProgramaParceiro" width="160" height="100" />
        <hr />
        <h4 class="modal-title">Revisar Ingest Programa Parceiro -  <?php echo $ingest[0]->tituloPrograma?></h4>
        
      </div>
      <div class="modal-body">
          <?php if($ingest[0]->observacao != ''){ ?>
              <div class="panel panel-warning">
                <div class="panel-heading">Observações</div>
                <div class="panel-body">
                  <h4 class="media-heading"><?php echo $ingest[0]->observacao ?> </h4>										    
                </div>
              </div>
          <?php } ?>
          
          
              
              <?php if (count($claquetes)>0){					
                foreach($claquetes as $claquete) {?>
                  <div class="panel panel-default">
                    <div class="panel-heading">Correção da Claquete <?php echo $claquete->numeroClaquete ?>:</div>
                    <div class="panel-body">
                      <div class="form-group">
                          <label for="claquete"  class="control-label">Aprovação da Claquete <?php echo $claquete->numeroClaquete ?>:</label><br>
                          <div class="col-sm-6">
                            <select name="claquete[<?php echo $claquete->idClaqueteRevisao ?>][]" class="form-control claquete">
                                <option value=''>Selecione --></option>
                                <option value="APROVADO">Aprovado</option>
                                <option value="REPROVADO">Reprovado</option>
                            </select>
                          </div>
                      </div>
                      <br><br>
                      <?php							
                        $problemasClaquete = $this->revisaoDao->selectProblemasCorrigidos($ingest[0]->idIngest ,$claquete->idClaqueteRevisao,'I','C');	
                          foreach ($problemasClaquete as $problema) { ?>										
                            <div class="form-group observacaoClaquete">
                                
                                <div class="col-sm-6">
                                  <label for="prazo"  class="control-label">Observação da Claquete <?php echo $claquete->numeroClaquete ?>:</label><br>
                                  <textarea class="form-control" rows="3" disabled="disabled"><?php echo $problema->descricao ?></textarea>
                                </div>
                                <div class="col-sm-6">
                                  <label for="prazo"  class="control-label">Resposta <?php echo $claquete->numeroClaquete ?>:</label><br>
                                  <textarea class="form-control" rows="3" disabled="disabled"><?php echo $problema->resposta ?></textarea>
                                </div>
                            </div> <br><br><br>	
                      <?php } ?>							
                      <div class="form-group observacaoClaquete">
                          <label for="prazo"  class="control-label">Observação do Problema da Claquete <?php echo $claquete->numeroClaquete ?>:</label><br>
                          <div class="col-sm-6">
                            <textarea name="obs_claquete[<?php echo $claquete->idClaqueteRevisao ?>][]" class="form-control" rows="3" ></textarea>
                          </div>
                      </div>
                    </div>
                  </div>						
                <?php } ?>	
                <hr />				
              <?php } ?>

              <?php if (count($blocos)>0){					
                foreach($blocos as $bloco) {?>
                  <div class="panel panel-default">
                    <div class="panel-heading">Correção do Bloco <?php echo $bloco->numeroBloco ?>:</div>
                    <div class="panel-body">
                      <div class="form-group">
                          <label for="prazo"  class="control-label">Aprovação do Bloco <?php echo $bloco->numeroBloco ?>:</label><br>
                          <div class="col-sm-6">
                            <select name="bloco[<?php echo $bloco->idBlocoRevisao ?>][]" class="form-control bloco">
                                <option value=''>Selecione --></option>
                                <option value="APROVADO">Aprovado</option>
                                <option value="REPROVADO">Reprovado</option>
                            </select>
                          </div>
                      </div>	
                      <br><br>	
                      <?php							
                        $problemasBloco = $this->revisaoDao->selectProblemasCorrigidos($ingest[0]->idIngest ,$bloco->idBlocoRevisao,'I','B');
                          foreach ($problemasBloco as $problema) { ?>										
                            <div class="form-group observacaoClaquete">
                                
                                <div class="col-sm-6">
                                  <label for="prazo" class="control-label">Observação do Bloco <?php echo $bloco->numeroBloco ?>:</label><br>
                                  <textarea class="form-control" rows="3" disabled="disabled"><?php echo $problema->descricao ?></textarea>
                                </div>
                                
                                <div class="col-sm-6">
                                <label for="prazo" class="control-label">Resposta <?php echo $bloco->numeroBloco ?>:</label><br>
                                  <textarea class="form-control" rows="3" disabled="disabled"><?php echo $problema->resposta ?></textarea>
                                </div>
                            </div> <br><br><br>	
                        <?php } ?>										
                        <div class="form-group observacaoClaquete">
                            
                            <div class="col-sm-6">
                              <label for="prazo" class="control-label">Observação do Problema do Bloco <?php echo $bloco->numeroBloco ?>:</label><br>
                              <textarea name="obs_bloco[<?php echo $bloco->idBlocoRevisao ?>][]" class="form-control" rows="3" ></textarea>
                            </div>
                        </div>	
                    </div>
                  </div>											
                          
                <?php } ?>	
                <hr />					
              <?php } ?>
            
            <input type="hidden" name="idRevisao" value="<?php echo $revisao[0]->idRevisao ?>"/>
            <input type="hidden" name="idIngestParceiro" value="<?php echo $ingest[0]->idIngestParceiro ?>"/>
            <input type="hidden" name="idParceiros" value="<?php echo $ingest[0]->parceiro_id ?>"/>
            <input type="hidden" name="idIngest" value="<?php echo $ingest[0]->idIngest ?>" />
            <input type="hidden" name="tipoFluxo" value="M"/> 
            <input type="hidden" name="tipoIngest" value="P"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Cadastrar Revisão de Correção de Ingest</button>
      </div>
    </form>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
