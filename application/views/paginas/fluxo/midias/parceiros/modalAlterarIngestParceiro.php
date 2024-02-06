<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <form action="<?php echo base_url('IngestController/alterarIngestParceiro') ?>" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>        
        <?php $programa =  $this->parceirosDao->selectProgramaParceiroById($ingest[0]->idPrograma)?>
        <img src="<?php echo IMAGEM_PROGRAMA_PARCEIRO.$programa[0]->imagem?>" class="img-thumbnail imgProgramaParceiro" width="160" height="100" />
        <hr />
        <h4 class="modal-title">Ingest Programa Parceiro -  <?php echo $ingest[0]->tituloPrograma?></h4>
        
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-6">    
              <input type="hidden" name="idParceiros" value="<?php echo $parceiro[0]->idParceiros ?>" />                  

              <div class="form-group">
                  <label for="programaParceiro">Programa Parceiro</label>
                  <select name="programaParceiro" class="form-control select2" style="width: 100%;" required >
                  <?php foreach ($listSerieParceiros as $programa) { ?>
                        <option value="<?php echo $programa->idProgramasParceiros ?>" <?php echo ($ingest[0]->idPrograma == $programa->idProgramasParceiros)? 'selected="selected"':'' ?> ><?php echo $programa->sigla . ' - ' . $programa->nomePrograma ?></option>  
                  <?php } ?>                                      
                  </select>
              </div>
              <div class="form-group">
                  <label for="tituloPrograma">Título do Programa :</label>
                  <input name="tituloPrograma" type="text" class="form-control" id="tituloPrograma" placeholder="Título do Programa" value="<?php echo $ingest[0]->tituloPrograma?>" required >
              </div>
              
              <div class="form-group">
                  <label for="numeroPGM">Número do Programa :</label>
                  <input type="text" name="numeroPGM" class="form-control" id="numeroPGM" placeholder="Número do Programa" value="<?php echo $ingest[0]->numeroPGM?>" min="1"  required >
              </div>

              <!--<div class="form-group">
                  <label for="closedCaption"><i class="fa fa-cc" aria-hidden="true"></i> Closed Caption:</label>
                  <select name="closedCaption" class="form-control" style="width: 80%;">
                      <option value="">Selecione ...</option>
                      <option value="S" <?php echo ($ingest[0]->closedCaption == 'S')? 'selected="selected"': '' ?>>SIM</option>
                      <option value="N" <?php echo ($ingest[0]->closedCaption == 'N')? 'selected="selected"': '' ?>>NÃO</option>
                  </select>
              </div>-->
              

            </div>
            <!-- /.col -->
            <div class="col-md-6">

              <div class="form-group">
                  <label for="claquetes">O Programa possui quantas Claquetes ?</label>
                  <input name="claquetes" type="number" class="form-control" id="claquetes" placeholder="Número de Claquetes" value="<?php echo $ingest[0]->claquetes?>" min="1"  required >
              </div>

              <div class="form-group">
                  <label for="blocos">O Programa possui quantos Blocos ?</label>
                  <input name="blocos" type="number" class="form-control" id="blocos" placeholder="Número de Blocos" value="<?php echo $ingest[0]->blocos?>" min="1"  required>
              </div>
          

              <div class="form-group">
                  <label for="observacao">Observações :</label>
                  <textarea name="observacao" class="form-control" rows="4" placeholder="Observações ..." ><?php echo $ingest[0]->observacao?></textarea>
              </div>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
      </div>
      <input type="hidden" name="idIngestParceiro" value="<?php echo $ingest[0]->idIngestParceiro ?>"/>
			<input type="hidden" name="idParceiros" value="<?php echo $ingest[0]->parceiro_id ?>"/>			  	
			<input type="hidden" name="idIngest" value="<?php echo $ingest[0]->idIngest ?>" />
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Salvar Ingest</button>
      </div>
    </form>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
