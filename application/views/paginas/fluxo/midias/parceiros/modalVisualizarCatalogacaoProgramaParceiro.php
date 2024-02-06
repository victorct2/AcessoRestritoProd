<div class="modal-dialog modal-lg">
  <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>        
        <?php $programa =  $this->parceirosDao->selectProgramaParceiroById($ingest[0]->idPrograma)?>
        <img src="<?php echo IMAGEM_PROGRAMA_PARCEIRO.$programa[0]->imagem?>" class="img-thumbnail imgProgramaParceiro" width="160" height="100" />
        <hr />
        <h4 class="modal-title">Visualizar Catalogação de Programa Parceiro -  <?php echo $ingest[0]->tituloPrograma?></h4>
        
      </div>
      <div class="modal-body">
          
            <ul class="list-group">
              <li class="list-group-item">
                <span class="badge"><?php echo $ingest[0]->claquetes ?></span>
                Claquetes
              </li>
              <li class="list-group-item">
                <span class="badge"><?php echo $ingest[0]->blocos ?></span>
                Blocos
              </li>                         
            </ul>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
      </div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
