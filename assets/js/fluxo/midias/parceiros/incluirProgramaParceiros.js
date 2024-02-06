
    $("#imagens").fileinput({
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
		$('#resp').html('');
		var out = '';
		$.each(data.response, function(key, file) {	    	
	    	$.each(file, function(key, file) {
	        	var fname = file.caption;
	        	out = out + '<li>' + 'Upload do arquivo # ' + (key + 1) + ' - '  +  fname + '  foi feito com sucesso.' + '</li>';
	        	$('#resp').append('<input type="hidden" name="listaImagem[]" value="'  +  fname + '" />');	        	
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

	$('.excluirPrograma').click(function(e){
		e.preventDefault();		
		var idProgramaParceiro = $(this).attr('id');	
		$.ajax({				
			url: CI_ROOT +'MidiasParceirosController/excluirProgramaParceiro',
			type: "POST",
			data:{
				idProgramaParceiro : idProgramaParceiro
			},
			success: function(retorno){
				//alert(retorno);
				if(retorno == 'success'){
					alert("Programa parceiro excluído com sucesso!");
				}else if(retorno = 'false'){
					alert("Erro ao excluir o programa parceiro!");
				}
			   location.reload();                        
			}
		});
	});
	
	
	$('#modal-alterarPrograma').on('show.bs.modal', function (event) {
		console.log('entrou aqui');
		var button = $(event.relatedTarget);		
		  var idProgramaParceiro = button[0].id;
		  console.log(idProgramaParceiro);
		  $.ajax({				
			url: CI_ROOT + 'MidiasParceirosController/modalAlterarProgramaParceiro',
			dataType: 'html',
			type: "POST",
			data:{
				idProgramaParceiro : idProgramaParceiro
			},
			success: function(retorno){
				console.log(retorno);
				$('#modal-alterarPrograma').html(retorno);
			}
		});
	  });

	
