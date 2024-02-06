<div class="modal-dialog modal-lg">
  <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>        
        <?php $programa =  $this->parceirosDao->selectProgramaParceiroById($ingest[0]->idPrograma)?>
        <img src="<?php echo IMAGEM_PROGRAMA_PARCEIRO.$programa[0]->imagem?>" class="img-thumbnail imgProgramaParceiro" width="160" height="100" />
        <hr />
        <h4 class="modal-title">Visualizar Revisão de Ingest de Programa Parceiro -  <?php echo $ingest[0]->tituloPrograma?></h4>
        
      </div>
      <div class="modal-body">

          <div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Claquetes</h3>
							<span class="badge"><?php echo $ingest[0]->claquetes ?></span>
							<span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
						</div>
						<div class="panel-body">
							<ul class="list-group">
							  <?php foreach ($claquetes as $claquete) {?>								  	
								  <li class="list-group-item">								  
								  	<?php  if($claquete->statusRevCatalogacao == 'APROVADO'){?>
								     	 		<small class="label label-success pull-right">Aprovado</small>
								     	 		
								    <?php }else if($claquete->statusRevCatalogacao == 'REPROVADO'){?>
								    	 		<small class="label label-danger pull-right">Reprovado</small>								    	 		
								    <?php } 							    								    	 
								    echo 'Claquete ' .$claquete->numeroClaquete ?>
								    <br><br>
								    <div class="panel panel-default">
                      <div class="panel-heading">Relação de Problemas encontrados:</div>
                      <div class="panel-body">
                        <div class="form-group">										    
                          <?php						
                            $problemasClaquete = $this->revisaoCatalogacaoDao->selectProblemas($ingest[0]->idIngest,$claquete->idClaqueteRevisao,'C','C')	;	
                              foreach ($problemasClaquete as $problema) { ?>	
                                  <small class="label label-info pull-left"><?php echo $problema->descricao ?></small>													  
                                  <?php  if($problema->corrigido == 'S'){?>
                                        <small class="label label-warning pull-left">Corrigido</small>		
                                  <?php }else { ?>
                                        <small class="label label-warning pull-left">Não Corrigido</small>
                                  <?php } ?>                            
                                  <br>	
                            <?php } ?>
                        </div>						    
                      </div>
                    </div>

								  </li>
							  <?php } ?>
							</ul>
						</div>
					</div>
          
          <div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Blocos</h3>
							<span class="badge"><?php echo $ingest[0]->blocos ?></span>
							<span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
						</div>
						<div class="panel-body">
							<ul class="list-group">
							  <?php foreach ($blocos as $bloco) {?>								  	
								  <li class="list-group-item">								  
								  	<?php  if($bloco->statusRevCatalogacao == 'APROVADO'){?>
								     	 		<small class="label label-success pull-right">Aprovado</small>
								     	 		
								    <?php }else if($bloco->statusRevCatalogacao == 'REPROVADO'){?>
								    	 		<small class="label label-danger pull-right">Reprovado</small>								    	 		
								    <?php } 							    								    	 
								    echo 'Bloco ' .$bloco->numeroBloco ?>
								    <br><br>
								    <div class="panel panel-default">
                      <div class="panel-heading">Relação de Problemas encontrados:</div>
                      <div class="panel-body">
                        <div class="form-group">										    
                          <?php						
                            $problemasBloco = $this->revisaoCatalogacaoDao->selectProblemas($ingest[0]->idIngest,$bloco->idBlocoRevisao,'C','B')	;	
                              foreach ($problemasBloco as $problema) { ?>	
                                  <small class="label label-info pull-left"><?php echo $problema->descricao ?></small>													  
                                  <?php  if($problema->corrigido == 'S'){?>
                                        <small class="label label-warning pull-left">Corrigido</small>		
                                  <?php }else { ?>
                                        <small class="label label-warning pull-left">Não Corrigido</small>
                                  <?php } ?>                            
                                  <br>	
                            <?php } ?>
                        </div>						    
                      </div>
                    </div>

								  </li>
							  <?php } ?>
							</ul>
						</div>
					</div>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
      </div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
