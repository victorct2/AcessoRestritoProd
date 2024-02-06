//Initialize Select2 Elements
   $('.select2').select2();

    $("#arquivos").fileinput({
  		language: "pt-BR",
        uploadUrl: CI_ROOT + 'uploadArquivos/uploadify.php', 
        allowedFileExtensions : ['pdf','PDF','csv','CSV','XLSX','xlsx','TXT','txt','doc','docx'],
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
	        	$('#resp').append('<input type="hidden" name="listaArquivo[]" value="'  +  fname + '" />');	        	
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