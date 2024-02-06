//Initialize Select2 Elements
	$('[data-mask]').inputmask();

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

/*======== Imagem Programação ============== */
	$("#imagemProgramacao").fileinput({
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
	  $('#respImagemProgramacao').html('');
	  var out = '';
	  $.each(data.response, function(key, file) {	    	
		  $.each(file, function(key, file) {
			  var fname = file.caption;
			  out = out + '<li>' + 'Upload do arquivo # ' + (key + 1) + ' - '  +  fname + '  foi feito com sucesso.' + '</li>';
			  $('#respImagemProgramacao').append('<input type="hidden" name="listaImagemProgramacao[]" value="'  +  fname + '" />');	        	
		  });
	  });  	    
  }).on('filebatchuploadcomplete', function(event, files, extra) {
	  alert('Upload feito com sucesso!');    	
  });
  
  
  $('.excluirImagemProgramacao').click(function(e){
	  e.preventDefault();		
	  var idImagem = $(this).attr('id');	
	  $('#imgProgramacao_'+idImagem).fadeOut();
  });

  /*======== Imagem App ============== */
	$("#imagemApp").fileinput({
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
	  $('#respImagemApp').html('');
	  var out = '';
	  $.each(data.response, function(key, file) {	    	
		  $.each(file, function(key, file) {
			  var fname = file.caption;
			  out = out + '<li>' + 'Upload do arquivo # ' + (key + 1) + ' - '  +  fname + '  foi feito com sucesso.' + '</li>';
			  $('#respImagemApp').append('<input type="hidden" name="listaImagemApp[]" value="'  +  fname + '" />');	        	
		  });
	  });  	    
  }).on('filebatchuploadcomplete', function(event, files, extra) {
	  alert('Upload feito com sucesso!');    	
  });
  
  
  $('.excluirImagemApp').click(function(e){
	  e.preventDefault();		
	  var idImagem = $(this).attr('id');	
	  $('#imgApp_'+idImagem).fadeOut();
  });

  /*======== Imagem Apresentador ============== */
	$("#imagemApresentador").fileinput({
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
	  $('#respImagemApresentador').html('');
	  var out = '';
	  $.each(data.response, function(key, file) {	    	
		  $.each(file, function(key, file) {
			  var fname = file.caption;
			  out = out + '<li>' + 'Upload do arquivo # ' + (key + 1) + ' - '  +  fname + '  foi feito com sucesso.' + '</li>';
			  $('#respImagemApresentador').append('<input type="hidden" name="listaImagemApresentador[]" value="'  +  fname + '" />');	        	
		  });
	  });  	    
  }).on('filebatchuploadcomplete', function(event, files, extra) {
	  alert('Upload feito com sucesso!');    	
  });
  
  
  $('.excluirImagemApresentador').click(function(e){
	  e.preventDefault();		
	  var idImagem = $(this).attr('id');	
	  $('#imgApresentador_'+idImagem).fadeOut();
  });