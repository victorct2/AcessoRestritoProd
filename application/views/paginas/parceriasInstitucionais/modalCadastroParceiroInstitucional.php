<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <form action="<?php echo base_url('ParceriasInstitucionaisController/cadastrarParceiroInstitucional') ?>" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span></button>   
		  	<h3><i class="fa fa-tv text-blue"></i> Parceiro Institucional <small>Cadastro</small></h3>            
         				
      </div>
      <div class="modal-body">
			<div class="row">
				<div class="col-md-6">

					<div class="form-group">
						<label for="titulo">Título * :</label>
						<input type="text" class="form-control" id="titulo" name="titulo" placeholder="Informe o título" value="">
					</div>

					<div class="form-group">
						<label for="descricao">Descrição :</label>
						<textarea name="descricao" id="descricao" class="form-control" rows="4" placeholder="Entre 10 a 250 caracteres ..."></textarea>
					</div>		
					
					<div class="form-group">
						<label for="link">Link * :</label>
						<input type="text" class="form-control" id="link" name="link" placeholder="Informe o link" value="">
					</div>

				</div>
				<!-- /.col -->
				<div class="col-md-6">					
			
					<div class="form-group">
						<label for="status">Status</label>
						<select name="status" class="form-control" style="width: 100%;"> 					
							<option value="S" >Ativo</option>	
							<option value="N" >Inativo</option>								                
						</select>
					</div>

					<div class="form-group">
						<label for="imagens" class="control-label">Selecionar Imagens:</label>
						<input id="imagens" name="imagens[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
						<div id="respImagem"></div>                    
					</div>                     

				</div>
				<!-- /.col -->
				
					
      </div>      
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Cadastrar Parceiro Institucional</button>
      </div>
    </form>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script>
$("#imagens").fileinput({
	language: "pt-BR",
	uploadUrl: CI_ROOT + 'uploadImagens/uploadify.php', 
	allowedFileExtensions : ['jpg','JPG','jpeg','JPEG','gif','GIF','png','PNG'],
	//overwriteInitial: false,
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
	$('#respImagem').html('');
	var out = '';
	$.each(data.response, function(key, file) {	    	
		$.each(file, function(key, file) {
			var fname = file.caption;
			out = out + '<li>' + 'Upload do arquivo # ' + (key + 1) + ' - '  +  fname + '  foi feito com sucesso.' + '</li>';
			$('#respImagem').append('<input type="hidden" name="listaImagem[]" value="'  +  fname + '" />');	        	
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
