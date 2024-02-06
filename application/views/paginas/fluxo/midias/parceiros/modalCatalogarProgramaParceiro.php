<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <form action="<?php echo base_url('CatalogacaoController/adicionarCatalogacao') ?>" method="POST">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>        
          <?php $programa =  $this->parceirosDao->selectProgramaParceiroById($ingest[0]->idPrograma)?>
          <img src="<?php echo IMAGEM_PROGRAMA_PARCEIRO.$programa[0]->imagem?>" class="img-thumbnail imgProgramaParceiro" width="160" height="100" />
          <hr />
          <h4 class="modal-title">Cadastro de Catalogação de Programa Parceiro -  <b><?php echo $ingest[0]->tituloPrograma?></b></h4>
      </div>
      <div class="modal-body">
            

              <div class="form-group">
                  <label for="claquetes">O Programa possui quantas Claquetes ?</label>
                  <input name="claquetes" type="number" class="form-control" id="claquetes" placeholder="Número de Claquetes" value="<?php echo $ingest[0]->claquetes?>" min="1"  disabled="disabled" >
              </div>

              <div class="form-group">
                  <label for="blocos">O Programa possui quantos Blocos ?</label>
                  <input name="blocos" type="number" class="form-control" id="blocos" placeholder="Número de Blocos" value="<?php echo $ingest[0]->blocos?>" min="1"  disabled="disabled">
              </div>   

            

          <input type="hidden" name="idCatalogacao" value="<?php echo $catalogacao[0]->idCatalogacao ?>" id="idCatalogacao"/>
			  	<input type="hidden" name="idIngestParceiro" value="<?php echo $ingest[0]->idIngestParceiro ?>"/>
			  	<input type="hidden" name="idParceiros" value="<?php echo $ingest[0]->parceiro_id ?>"/>
			  	<input type="hidden" name="idIngest" value="<?php echo $ingest[0]->idIngest ?>" />
			  	<input type="hidden" name="tipoFluxo" value="M"/> 
			  	<input type="hidden" name="tipoIngest" value="P"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-warning">Cadastrar Catalogação de Programa Parceiro</button>
      </div>
    </form>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
