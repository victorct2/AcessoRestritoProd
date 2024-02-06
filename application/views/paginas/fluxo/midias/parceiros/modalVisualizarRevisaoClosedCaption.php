<div class="modal-dialog modal-lg">
  <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>        
        <?php $programa =  $this->parceirosDao->selectProgramaParceiroById($ingest[0]->idPrograma)?>
        <img src="<?php echo IMAGEM_PROGRAMA_PARCEIRO.$programa[0]->imagem?>" class="img-thumbnail imgProgramaParceiro" width="160" height="100" />
        <hr />
        <h4 class="modal-title">Visualizar Revisão de Closed Caption <i class="fa fa-cc" aria-hidden="true"></i> -  <?php echo $ingest[0]->tituloPrograma?></h4>
        
      </div>
      <div class="modal-body">

          <div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Closed Caption <i class="fa fa-cc" aria-hidden="true"></i> </h3>							
							<span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
						</div>
						<div class="panel-body">
							<ul class="list-group">
							  							  	
								  <li class="list-group-item">								  
								  	<?php  if($revisaoClosedCaption[0]->statusRevisaoClosedCaption == 'A'){?>
								     	 		<small class="label label-success pull-right">Aprovado</small>
								     	 		
								    <?php }else if($revisaoClosedCaption[0]->statusRevisaoClosedCaption == 'R'){?>
								    	 		<small class="label label-danger pull-right">Reprovado</small>								    	 		
								    <?php } 							    								    	 
								    echo 'Erros <i class="fa fa-cc" aria-hidden="true"></i>: '?>
								    <br><br>
								    <div class="panel panel-default">
                      <div class="panel-heading">Relação de Problemas encontrados:</div>
                      <div class="panel-body">
                        <div class="form-group">										    
                          <?php						
                            
                              foreach ($problemaClosedCaption as $problema) { ?>	
                                  <small class="label label-info pull-left"><?php echo $problema->problema ?></small>													  
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
