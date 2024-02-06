/*======== Logo 1 ============== */

$("#logo1").fileinput({
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
  $('#respLogo1').html('');
  var out = '';
  $.each(data.response, function(key, file) {	    	
      $.each(file, function(key, file) {
          var fname = file.caption;
          out = out + '<li>' + 'Upload do arquivo # ' + (key + 1) + ' - '  +  fname + '  foi feito com sucesso.' + '</li>';
          $('#respLogo1').append('<input type="hidden" name="logo[]" value="'  +  fname + '" />');	        	
      });
  });  	    
}).on('filebatchuploadcomplete', function(event, files, extra) {
  alert('Upload feito com sucesso!');    	
});


$('.excluirLogo1').click(function(e){
  e.preventDefault();		
  var idImagem = $(this).attr('id');	
  $('#imgLogo1_'+idImagem).fadeOut();
});

/*======== Logo 2 ============== */

$("#logo2").fileinput({
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
  $('#respLogo2').html('');
  var out = '';
  $.each(data.response, function(key, file) {	    	
    $.each(file, function(key, file) {
      var fname = file.caption;
      out = out + '<li>' + 'Upload do arquivo # ' + (key + 1) + ' - '  +  fname + '  foi feito com sucesso.' + '</li>';
      $('#respLogo2').append('<input type="hidden" name="logo[]" value="'  +  fname + '" />');	        	
    });
});  	    
}).on('filebatchuploadcomplete', function(event, files, extra) {
  alert('Upload feito com sucesso!');    	
});


$('.excluirLogo2').click(function(e){
e.preventDefault();		
var idImagem = $(this).attr('id');	
$('#imgLogo2_'+idImagem).fadeOut();
});

/*======== Logo 3 ============== */

$("#logo3").fileinput({
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
  $('#respLogo3').html('');
  var out = '';
  $.each(data.response, function(key, file) {	    	
    $.each(file, function(key, file) {
      var fname = file.caption;
      out = out + '<li>' + 'Upload do arquivo # ' + (key + 1) + ' - '  +  fname + '  foi feito com sucesso.' + '</li>';
      $('#respLogo3').append('<input type="hidden" name="logo[]" value="'  +  fname + '" />');	        	
  });
});  	    
}).on('filebatchuploadcomplete', function(event, files, extra) {
  alert('Upload feito com sucesso!');    	
});


$('.excluirLogo3').click(function(e){
e.preventDefault();		
var idImagem = $(this).attr('id');	
$('#imgLogo3_'+idImagem).fadeOut();
});

/*======== Logo 4 ============== */

$("#logo4").fileinput({
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
  $('#respLogo4').html('');
  var out = '';
  $.each(data.response, function(key, file) {	    	
    $.each(file, function(key, file) {
      var fname = file.caption;
      out = out + '<li>' + 'Upload do arquivo # ' + (key + 1) + ' - '  +  fname + '  foi feito com sucesso.' + '</li>';
      $('#respLogo4').append('<input type="hidden" name="logo[]" value="'  +  fname + '" />');	        	
  });
});  	    
}).on('filebatchuploadcomplete', function(event, files, extra) {
  alert('Upload feito com sucesso!');    	
});


$('.excluirLogo4').click(function(e){
e.preventDefault();		
var idImagem = $(this).attr('id');	
$('#imgLogo4_'+idImagem).fadeOut();
});

/*======== Logo 5 ============== */

$("#logo5").fileinput({
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
  $('#respLogo5').html('');
  var out = '';
  $.each(data.response, function(key, file) {	    	
    $.each(file, function(key, file) {
      var fname = file.caption;
      out = out + '<li>' + 'Upload do arquivo # ' + (key + 1) + ' - '  +  fname + '  foi feito com sucesso.' + '</li>';
      $('#respLogo5').append('<input type="hidden" name="logo[]" value="'  +  fname + '" />');	        	
  });
});  	    
}).on('filebatchuploadcomplete', function(event, files, extra) {
  alert('Upload feito com sucesso!');    	
});


$('.excluirLogo5').click(function(e){
e.preventDefault();		
var idImagem = $(this).attr('id');	
$('#imgLogo5_'+idImagem).fadeOut();
});

/*======== Logo 6 ============== */

$("#logo6").fileinput({
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
  $('#respLogo6').html('');
  var out = '';
  $.each(data.response, function(key, file) {	    	
    $.each(file, function(key, file) {
      var fname = file.caption;
      out = out + '<li>' + 'Upload do arquivo # ' + (key + 1) + ' - '  +  fname + '  foi feito com sucesso.' + '</li>';
      $('#respLogo6').append('<input type="hidden" name="logo[]" value="'  +  fname + '" />');	        	
  });
});  	    
}).on('filebatchuploadcomplete', function(event, files, extra) {
  alert('Upload feito com sucesso!');    	
});


$('.excluirLogo6').click(function(e){
e.preventDefault();		
var idImagem = $(this).attr('id');	
$('#imgLogo6_'+idImagem).fadeOut();
});