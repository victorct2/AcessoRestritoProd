<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <form action="<?php echo base_url('RevisaoController/cadastrarRevisao') ?>" method="POST">
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
              <?php $claquetes = $ingest[0]->claquetes;					
                for ($i=1; $i <= $claquetes ; $i++) {?>
                    <div class="panel panel-default">
                      <div class="panel-heading">Revisão da Claquete <?php echo $i ?>:</div>
                      <div class="panel-body">
                        <div class="form-group">
                            <label for="claquete"  class="control-label">Aprovação da Claquete <?php echo $i ?>:</label><br>
                            <div class="col-sm-6">
                              <select name="claquete[<?php echo $i ?>][]" class="form-control claquete">
                                  <option>Selecione --></option>
                              <option value="APROVADO">Aprovado</option>
                              <option value="REPROVADO">Reprovado</option>
                            </select>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group observacaoClaquete">
                            <label for="prazo"  class="control-label">Observação da Claquete <?php echo $i ?>:</label><br>
                            <div class="col-sm-6">
                              <textarea name="obs_claquete[<?php echo $i ?>][]" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                      </div>
                    </div>						
                        
              <?php } ?>

              <?php $blocos = $ingest[0]->blocos;					
                for ($i=1; $i <= $blocos ; $i++) {?>
                  <div class="panel panel-default">
                    <div class="panel-heading">Revisão do Bloco <?php echo $i ?>:</div>
                    <div class="panel-body">
                      <div class="form-group">
                          <label for="prazo"  class="control-label">Aprovação do Bloco <?php echo $i ?>:</label><br>
                          <div class="col-sm-6">
                            <select name="bloco[<?php echo $i ?>][]" class="form-control bloco">
                              <option>Selecione --></option>
                              <option value="APROVADO">Aprovado</option>
                              <option value="REPROVADO">Reprovado</option>
                            </select>
                          </div>
                      </div>	
                      <br><br>				
                      <div class="form-group observacaoClaquete">
                          <label for="prazo" class="control-label">Observação do Bloco <?php echo $i ?>:</label><br>
                          <div class="col-sm-6">
                            <textarea name="obs_bloco[<?php echo $i ?>][]" class="form-control" rows="3"></textarea>
                          </div>
                      </div>	
                    </div>
                  </div>											
                          
              <?php } ?>
            
          <input type="hidden" name="idIngestParceiro" value="<?php echo $ingest[0]->idIngestParceiro ?>"/>
			  	<input type="hidden" name="idParceiros" value="<?php echo $ingest[0]->parceiro_id ?>"/>
			  	<input type="hidden" name="idIngest" value="<?php echo $ingest[0]->idIngest ?>" />
			  	<input type="hidden" name="tipoFluxo" value="M"/> 
			  	<input type="hidden" name="tipoIngest" value="P"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Cadastrar Revisão</button>
      </div>
    </form>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
