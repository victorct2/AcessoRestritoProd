<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <form action="<?php echo base_url('RevisaoCatalogacaoController/cadastrarRevisao') ?>" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>        
        <?php $programa =  $this->parceirosDao->selectProgramaParceiroById($ingest[0]->idPrograma)?>
        <img src="<?php echo IMAGEM_PROGRAMA_PARCEIRO.$programa[0]->imagem?>" class="img-thumbnail imgProgramaParceiro" width="160" height="100" />
        <hr />
        <h4 class="modal-title">Revisar Catalogação Programa Parceiro -  <?php echo $ingest[0]->tituloPrograma?></h4>
        
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
                        <select name="claquete[<?php echo $claquete->idClaqueteRevisao ?>][]" class="form-control claquete">
                            <option value=''>Selecione --></option>
                        <option value="APROVADO">Aprovado</option>
                        <option value="REPROVADO">Reprovado</option>
                      </select>
                      </div>
                  </div>
                  <br><br>
                  <div class="form-group observacaoClaquete">
                      <label for="prazo"  class="control-label">Observação da Claquete <?php echo $claquete->numeroClaquete ?>:</label><br>
                      <div class="col-sm-6">
                        <textarea name="obs_claquete[<?php echo $claquete->idClaqueteRevisao ?>][]" class="form-control" rows="3" ><?php echo $claquete->observacaoRevCatalogacao ?></textarea>
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
                <div class="form-group observacaoClaquete">
                    <label for="prazo" class="control-label">Observação do Bloco <?php echo $bloco->numeroBloco ?>:</label><br>
                    <div class="col-sm-6">
                      <textarea name="obs_bloco[<?php echo $bloco->idBlocoRevisao ?>][]" class="form-control" rows="3" ><?php echo $bloco->observacaoRevCatalogacao ?> </textarea>
                    </div>
                </div>	
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
        <button type="submit" class="btn btn-primary">Cadastrar Revisão de Catalogação</button>
      </div>
    </form>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
