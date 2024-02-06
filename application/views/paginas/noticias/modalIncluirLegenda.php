<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <form action="<?php echo base_url('NoticiasController/adicionarLegenda') ?>" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>        
          <h4 class="modal-title">Inlcusão de Legendas para Imagens</h4>
        <hr />        
      </div>
      <div class="modal-body">             
            
        <?php if(count($imagensNoticias)>0) { ?>
          <div class="box box-solid box-success">
              <div class="box-header">
                <h3 class="box-title">Imagens Atuais </h3>
                <div class="box-tools pull-right">
              </div><!-- /.box-tools -->
              </div><!-- /.box-header -->
              <div class="box-body">
              <div id="respImagem"></div>
                <?php foreach($imagensNoticias as $imagem){ ?>
                  <p id="img_<?php echo $imagem->idImagem ?>">
                    <img src="<?php echo base_url().'assets/img/noticias/'. $imagem->nomeImagem?>" class="img-responsive img-thumbnail" width="250" height="150">                                        
                    <div class="form-group">
                        <label for="legendaImagem">Legenda :</label>
                        <textarea name="legendaImagem[<?php echo $imagem->idImagem ?>]" class="form-control" rows="4" placeholder="Legenda da Imagem ..." ><?php echo $imagem->legendaImagem?></textarea>
                    </div>                    						 	
                  </p>
                  <hr>
                <?php } ?>              
              </div><!-- /.box-body -->            
          </div><!-- /.box --> 
        <?php } ?>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Incluir Legenda</button>
      </div>
    </form>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
