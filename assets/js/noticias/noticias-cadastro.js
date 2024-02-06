//Initialize Select2 Elements
    $('.select2').select2();

   $('[data-mask]').inputmask();

  //Date picker[]
  $("#datepicker").datepicker({
    dateFormat : 'dd/mm/yy',
    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    showAnim: "clip"
  });

   //CKEDITOR.replace('editor1');

   CKEDITOR.replace('editor1',
   {      
       uiColor : '#9AB8F3'
       //customConfig: '/custom/ckeditor_config.js'
   });

   /* =====================================================*/

   /*$("#imagens").fileinput({
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
    });*/

    $('.excluirImagem').click(function(e){
    e.preventDefault();		
    var idImagem = $(this).attr('id');	
    $('#respImagem').append('<input type="hidden" name="imagensExcluir[]" value="'  +  idImagem + '" />');
    $('#img_'+idImagem).fadeOut();
    });


    $(document).ready(function () {
        $('#uploader').submit(function (event) {
            event.preventDefault();
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                      if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $('#progressBarUpload').css('width',percentComplete+"%");
                        $('#progressBarUpload').html(percentComplete+"%");
                        if (percentComplete === 100) {
    
                        }
                      }
                    }, false);
                    return xhr;
                },
                url: CI_ROOT + 'AvisosController/upload',
                type: "POST",
                dataType: 'json',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    //uncomment the next line to log the returned data in the javascript console
                     console.log(data);
                   	    	
                        $.each(data.file_name, function(key, file) {                           
                            console.log(file);
                            $('#formAvisos #resp').append('<input type="hidden" name="listaImagem[]" value="'+file+'" />');	        	
                        });
                   
                    if (data.result === true) {
                        $("#message").append('<label class="control-label result" for="inputSuccess"><i class="fa fa-check"></i> Upload efetuado com sucesso</label>');
                    } else {
                        $("#message").append('<label class="control-label result" for="inputError"><i class="fa fa-times-circle-o"></i>Erro ao efetuar o upload</p>');
                    }
    
                    //$('#formNoticias #resp').append('<input type="hidden" name="listVideos[]" value="'+data.file_name+'" />');
                    //etapasConversao(data.file_name,720);
                }
            });
        });
    
    
        document.getElementById("uploadBtn").onchange = function () {
            //document.getElementById("uploadFile").files[0].name;
            //$image_file
            console.log(this.value);
            //var valor = this.value;
            //var limpando = valor.replace(/[\\"]/g, '/');
            //var value = limpando.split("/");
            //var ultimo = $(value).get(-1);
            //document.getElementById("uploadFile").value = ultimo;
        };
    });
   
   