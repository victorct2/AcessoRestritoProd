<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <form action="<?php echo base_url('FichaConclusaoController/alterarFichaConclusao') ?>" method="POST">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>        
          <?php $programa =  $this->parceirosDao->selectProgramaParceiroById($ingest[0]->idPrograma)?>
          <img src="<?php echo IMAGEM_PROGRAMA_PARCEIRO.$programa[0]->imagem?>" class="img-thumbnail imgProgramaParceiro" width="160" height="100" />
          <hr />
          <h4 class="modal-title">Alterar Ficha de Conclusão de Programa Parceiro -  <b><?php echo $ingest[0]->tituloPrograma?></b></h4>
      </div>
      <div class="modal-body">
            <div class="row">
              <div class="col-md-6">

                <div class="form-group">
                    <label for="dataVeiculacao">Data de Veiculação :</label>
                    <input name="dataVeiculacao" type="date" class="form-control" id="dataVeiculacao" placeholder="Data de Veiculação" value="<?php echo $fichaConclusao[0]->dataVeiculacao ?>">
                </div>
                <div class="form-group">
                    <label for="duracaoReal">Duração real :</label>
                    <input name="duracaoReal" type="text" class="form-control" id="duracaoReal" placeholder="Duração real" value="<?php echo $fichaConclusao[0]->duracaoReal ?>" data-inputmask='"mask": "99:99:99"' data-mask>
                </div>

                <div class="form-group">
                  <label for="closedCaption"><i class="fa fa-cc" aria-hidden="true"></i> Closed Caption:</label>
                    <select class="form-control" style="width: 80%;" disabled>
                        <option value="">Selecione ...</option>
                        <option value="S" <?php echo ($ingest[0]->closedCaption == 'S')? 'selected="selected"': '' ?>>SIM</option>
                        <option value="N" <?php echo ($ingest[0]->closedCaption == 'N' || empty($ingest[0]->closedCaption))? 'selected="selected"': '' ?>>NÃO</option>
                    </select>
                </div>

                <hr />
                <div class="panel panel-default">
                  <div class="panel-heading">Duração dos Blocos(horas, minutos, segundos)</div>
                  <div class="panel-body">
                    <?php foreach ($blocos as $key => $bloco) { ?>
                      <div class="form-group">
                          <label for="bloco">Bloco <?php echo $bloco->numeroBloco?>:</><br>
                          <input type="text" name="bloco[<?php echo $bloco->idBlocoRevisao?>][]" class="form-control" id="bloco" placeholder="Duração do Bloco" value="<?php echo $bloco->duracao?>"  data-inputmask='"mask": "99:99:99"' data-mask required >                        
                      </div>  
                    <?php } ?>				    					
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">Informações</div>
                  <div class="panel-body">
                      <div class="form-group">
                        <label for="apresentadores">Apresentador(es):</label><br>                     
                        <input type="text" name="apresentadores" class="form-control" id="apresentadores" placeholder="Apresentadores" value="<?php echo $fichaConclusao[0]->apresentador ?>" >                      
                      </div>
                      <div class="form-group">
                          <label for="diretor">Diretor(es):</label><br>                          
                          <input type="text" name="diretor" class="form-control" id="diretor" placeholder="Diretor" value="<?php echo $fichaConclusao[0]->diretor ?>" >                          
                      </div>
                      <div class="form-group">
                          <label for="reporter">Repórter:</label><br>                       
                          <input type="text" name="reporter" class="form-control" id="reporter" placeholder="Repórter" value="<?php echo $fichaConclusao[0]->reporter ?>" >                         
                      </div>
                      <div class="form-group">
                          <label for="produtor">Produtor(es):</label><br>                         
                          <input type="text" name="produtor" class="form-control" id="produtor" placeholder="Produtor" value="<?php echo $fichaConclusao[0]->produtor ?>" >                          
                      </div>
                  </div>
                </div>
               

              </div>
              <!-- /.col -->
              <div class="col-md-6">

                  <div class="panel panel-default">
                    <div class="panel-heading">Informações do Programa</div>
                    <div class="panel-body">
                      <div class="form-group">
                        <label for="convidados">Convidados:</label><br>                       
                          <textarea name="convidados" rows="3"  class="form-control" id="convidados" placeholder="Convidados" ><?php echo $fichaConclusao[0]->convidados ?></textarea>                       
                      </div>
                      <div class="form-group">
                          <label for="tags">Tags do Programa:</label><br>                          
                          <textarea name="tags" rows="3"  class="form-control" id="tags" placeholder="Tags"  required><?php echo $fichaConclusao[0]->tags ?></textarea>                         
                      </div>
                      <div class="form-group">
                          <label for="sinopse">Sinopse do Programa:</label><br>
                          <textarea name="sinopse" rows="3"  class="form-control" id="sinopse" placeholder="Sinopse do Programa"  required><?php echo $fichaConclusao[0]->sinopse ?></textarea>                         
                      </div>
                    </div>
                  </div>
                  
                  <div class="panel panel-default">
                    <div class="panel-heading">Indicação de Atualidade</div>
                    <div class="panel-body">
                      <div class="form-group">
                        <label for="observacao">Observações:</label><br>                        
                        <textarea name="observacao" class="form-control" id="observacao" placeholder="Observações" rows="3" ><?php echo $fichaConclusao[0]->observacao ?></textarea>                        
                      </div>
                    </div>
                  </div>

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

          <input type="hidden" name="idFichaConclusao" value="<?php echo $fichaConclusao[0]->idFichaConclusao ?>" id="idFichaConclusao"/>
			  	<input type="hidden" name="idIngestParceiro" value="<?php echo $ingest[0]->idIngestParceiro ?>"/>
			  	<input type="hidden" name="idParceiros" value="<?php echo $ingest[0]->parceiro_id ?>"/>
			  	<input type="hidden" name="idIngest" value="<?php echo $ingest[0]->idIngest ?>" />
			  	<input type="hidden" name="tipoFluxo" value="M"/> 
			  	<input type="hidden" name="tipoIngest" value="P"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-warning">Alterar Ficha Conclusão</button>
      </div>
    </form>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script>
  $("#dataVeiculacao").datepicker({
      dateFormat : 'yy-mm-dd',
      dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
      dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
      dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
      monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
      monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
      showAnim: "clip"
  });
  $('[data-mask]').inputmask();
</script>