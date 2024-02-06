<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <form action="<?php echo base_url('MidiasParceirosController/alterarProgramaParceiro') ?>" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Alterar Programa</h4>
      </div>
      <div class="modal-body">
            <div class="row">
              <div class="col-md-6">

                <input type="hidden" name="idParceiro" value="<?php echo $programa[0]->parceiros_id ?>">
                <input type="hidden" name="idProgramaParceiro" value="<?php echo $programa[0]->idProgramasParceiros ?>">

                <div class="form-group">
                    <label for="nome">Nome :</label>
                    <input name="nome" type="text" class="form-control" id="nome" placeholder="Informe o nome" value="<?php echo $programa[0]->nomePrograma ?>">
                </div>
                <div class="form-group">
                    <label for="sigla">Sigla :</label>
                    <input name="sigla" type="text" class="form-control" id="sigla" placeholder="Informe a sigla" value="<?php echo $programa[0]->sigla ?>">
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição :</label>
                    <textarea name="descricao" class="form-control" rows="4" placeholder="Descrição ..." ><?php echo $programa[0]->descricao ?></textarea>
                </div>
                <div class="form-group">
                    <label for="duracao">Duração :</label>
                    <input name="duracao" type="text" class="form-control" id="duracao" placeholder="00:00:00" value="<?php echo $programa[0]->duracao ?>">
                </div>
                <div class="form-group">
                    <label for="inedito">inédito :</label>
                    <textarea name="inedito" class="form-control" rows="4" placeholder="Terça - 08:30" ><?php echo $programa[0]->inedito ?></textarea>
                </div>
                <div class="form-group">
                    <label for="horariosAlternativos">Horários Alternativos :</label>
                    <textarea name="horariosAlternativos" class="form-control" rows="4" placeholder="Horários Alternativos ..." ><?php echo $programa[0]->horariosAlternativos ?></textarea>
                </div>

              </div>
              <!-- /.col -->
              <div class="col-md-6">

                  <div class="form-group">
                    <label>Mostrar Site novo</label>
                    <select name="site_novo" class="form-control" style="width: 100%;" >
                      <option value="S" <?php echo ($programa[0]->site == 'S')? 'selected="selected"': '' ?>>SIM</option>
                      <option value="N" <?php echo ($programa[0]->site == 'N')? 'selected="selected"': '' ?>>Não</option>
                    </select>
                  </div>
                                
                  <div class="form-group">
                    <label>Situação</label>
                    <select name="situacao" class="form-control" style="width: 100%;" >
                      <option value="S" <?php echo ($programa[0]->ativo == 'S')? 'selected="selected"': '' ?>>ATIVO</option>
                      <option value="N" <?php echo ($programa[0]->ativo == 'N')? 'selected="selected"': '' ?>>INATIVO</option>
                    </select>
                  </div>

                  <div class="box box-solid box-success">
                      <div class="box-header">
                        <h3 class="box-title">Imagem Atual </h3>
                        <div class="box-tools pull-right">
                      </div><!-- /.box-tools -->
                      </div><!-- /.box-header -->
                      <div class="box-body">
                        <p id="img_<?php echo $programa[0]->idProgramasParceiros ?>">
                          <img src="<?php echo base_url().'assets/img/parceiros/programas/'. $programa[0]->imagem?>" class="img-responsive img-thumbnail" width="170" height="110">
                          <a href="#" class="excluirImagem" id="<?php echo $programa[0]->idProgramasParceiros ?>">
                              <span class="fa-stack fa-lg">
                                  <i class="fa fa-square-o fa-stack-2x text-red"></i>
                                  <i class="fa fa-trash  fa-stack-1x text-red"></i>
                              </span>			                 				
                          </a> 							 	
                        </p>
                      </div><!-- /.box-body -->
                      
                  </div><!-- /.box -->

                  <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="imagens" class="control-label">Selecionar Imagens:</label>
                          <input id="imagensAlterar" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                              <div id="respImagemAlterar"></div>                    
                        </div>
                      </div>              
                  </div>
                  <!-- /.row -->

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-warning">Alterar</button>
      </div>
    </form>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script>
$("#imagensAlterar").fileinput({
  		language: "pt-BR",
        uploadUrl: CI_ROOT + 'uploadImagens/uploadify.php', 
        allowedFileExtensions : ['jpg','JPG','jpeg','JPEG','gif','GIF','png','PNG'],
        /*overwriteInitial: false,*/
        uploadAsync: false,
        maxFileSize: 100000,
        maxFilesNum: 10,
        showUpload: true,
        maxFileCount: 10,
        browseClass: "btn btn-success",
        browseLabel: "Procurar",
        browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
        removeClass: "btn btn-danger",
        uploadClass: "btn btn-info",
        previewClass: "bg-warning"
	}).on('filebatchuploadsuccess', function(event, data) {
		$('#respImagemAlterar').html('');
		var out = '';
		$.each(data.response, function(key, file) {	    	
	    	$.each(file, function(key, file) {
	        	var fname = file.caption;
	        	out = out + '<li>' + 'Upload do arquivo # ' + (key + 1) + ' - '  +  fname + '  foi feito com sucesso.' + '</li>';
	        	$('#respImagemAlterar').append('<input type="hidden" name="listaImagem[]" value="'  +  fname + '" />');	        	
	    	});
	    });		
		
	  	    
	}).on('filebatchuploadcomplete', function(event, files, extra) {
    	alert('Upload feito com sucesso!');    	
	});
	
	$('.excluirImagem').click(function(e){
		e.preventDefault();		
		var idImagem = $(this).attr('id');	
		$('#img_'+idImagem).fadeOut();
	});
</script>