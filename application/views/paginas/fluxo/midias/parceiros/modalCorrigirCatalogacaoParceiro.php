<div class="modal-dialog modal-lg">
  <div class="modal-content">   
  <form action="<?php echo base_url()?>CatalogacaoController/corrigirCatalogacao" method="post" >  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>        
        <?php $programa =  $this->parceirosDao->selectProgramaParceiroById($ingest[0]->idPrograma)?>
        <img src="<?php echo IMAGEM_PROGRAMA_PARCEIRO.$programa[0]->imagem?>" class="img-thumbnail imgProgramaParceiro" width="160" height="100" />
        <hr />
        <h4 class="modal-title">Corrigir Catalogação Programa Parceiro -  <?php echo $ingest[0]->tituloPrograma?></h4>
        
      </div>
      <div class="modal-body">
                
              
          <?php if (count($claquetes)>0){					
            foreach($claquetes as $claquete) {?>
              <div class="panel panel-default">
                <div class="panel-heading">Correção da Claquete <?php echo $claquete->numeroClaquete ?>:</div>
                <div class="panel-body">
                <div class="form-group">
                    <label for="claquete"  class="control-label">Aprovação da Claquete <?php echo $claquete->numeroClaquete ?>:</label><br>
                    <div class="col-sm-6">
                      <select name="claquete[<?php echo $claquete->idClaqueteRevisao ?>][]" class="form-control claquete" required>
                          <option value=''>Selecione --></option>
                      <option value="CORRIGIDO">Corrigido</option>
                    </select>
                    </div>
                </div>
                <br><br>
                <?php
                    $problemasClaquete = $this->revisaoCatalogacaoDao->selectProblemaCorrigir($ingest[0]->idIngest ,$claquete->idClaqueteRevisao,'C','C');
                      foreach ($problemasClaquete as $problema) { ?>
                        <div class="panel panel-default">
                          <div class="panel-body">
                          <div class="form-group observacaoClaquete">
                              <label for="prazo"  class="control-label">Observação da Claquete <?php echo $claquete->numeroClaquete ?>:</label><br>
                              <div class="col-sm-6">
                                <textarea class="form-control" rows="3" disabled="disabled"><?php echo $problema->descricao ?></textarea>
                              </div>
                          </div>
                          <input type="hidden" name="claqueteProblema[]" value="<?php echo $problema->idProblema ?>" id="claqueteProblema"/>
                          <br><br><br><br>
                          <div class="form-group observacaoClaquete">
                              <label for="prazo" class="control-label"><b>Resposta</b> Observação da Claquete <?php echo $claquete->numeroClaquete ?>:</label><br>
                              <div class="col-sm-6">
                                <textarea name="respostaClaqueteProblema[<?php echo $problema->idProblema ?>]" class="form-control" rows="3" ></textarea>
                              </div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
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
                      <select name="bloco[<?php echo $bloco->idBlocoRevisao ?>][]" class="form-control bloco" required>
                          <option value=''>Selecione --></option>
                      <option value="CORRIGIDO">Corrigido</option>
                    </select>
                    </div>
                </div>	
                <br><br>				
                <?php
                  $problemasBloco = $this->revisaoCatalogacaoDao->selectProblemaCorrigir($ingest[0]->idIngest ,$bloco->idBlocoRevisao,'C','B');
                    foreach ($problemasBloco as $problema) { ?>
                      <div class="panel panel-default">
                        <div class="panel-body">
                          <div class="form-group observacaoClaquete">
                              <label for="prazo" class="control-label">Observação do Bloco <?php echo $bloco->numeroBloco ?>:</label><br>
                              <div class="col-sm-6">
                                <textarea class="form-control" rows="3" disabled="disabled"><?php echo $problema->descricao ?></textarea>
                              </div>
                          </div>
                          <input type="hidden" name="blocoProblema[]" value="<?php echo $problema->idProblema ?>" id="claqueteProblema"/>
                          <br><br><br><br>
                          <div class="form-group observacaoClaquete">
                              <label for="prazo" class="control-label"><b>Resposta</b> Observação do Bloco <?php echo $bloco->numeroBloco ?>:</label><br>
                              <div class="col-sm-6">
                                <textarea name="respostaBlocoProblema[<?php echo $problema->idProblema ?>]" class="form-control" rows="3" ></textarea>
                              </div>
                          </div>
                        </div>
                      </div>
                  <?php } ?>	
              </div>
              </div>											
                      
            <?php } ?>	
            <hr />					
          <?php } ?>
            
          <input type="hidden" name="idCatalogacao" value="<?php echo $catalogacao[0]->idCatalogacao ?>"/>
			  	<input type="hidden" name="idIngestParceiro" value="<?php echo $ingest[0]->idIngestParceiro ?>"/>
			  	<input type="hidden" name="idParceiros" value="<?php echo $ingest[0]->parceiro_id ?>"/>
			  	<input type="hidden" name="idIngest" value="<?php echo $ingest[0]->idIngest ?>" />
			  	<input type="hidden" name="tipoFluxo" value="M"/> 
			  	<input type="hidden" name="tipoIngest" value="P"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Cadastrar Correção de Catalogação</button>
      </div>
    </form>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
