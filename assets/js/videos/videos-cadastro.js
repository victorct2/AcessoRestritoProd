
    var i = 0;
    var nomeDoVideo = '';
    var formato = '';

    //Initialize Select2 Elements
    $('.select2').select2();

   $('[data-mask]').inputmask();

   $("#datepicker").datepicker({
      dateFormat : 'dd/mm/yy',
      dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
      dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
      dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
      monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
      monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
      showAnim: "clip"
    });


    $('#nome').bind('focusout', function() {

        if($("#nome").val() != ""){
            $("#nomeUsuario .result").html('');
            $('#nomeUsuario').removeClass('has-error');
            $('#nomeUsuario').removeClass('has-success');
            /*Enviar os dados para uma arquivo do servidor*/
            $.post(
                CI_ROOT +'VideosController/nomeExistente',
                {
                    nomeUsuario : $("#nome").val(),
                },
                function(retorno){
                    if(retorno == 'false'){
                        $('#nomeUsuario').addClass(' has-error');
                        $("#nomeUsuario").append('<label class="control-label result" for="inputError"><i class="fa fa-times-circle-o"></i> Nome já cadastrado</label>');
                    }else if(retorno == 'success'){
                        $('#nomeUsuario').addClass(' has-success');
                        $("#nomeUsuario").append('<label class="control-label result" for="inputSuccess"><i class="fa fa-check"></i> Nome liberado</label>');
                    }
                }
            );
        }
        return false;
    });


    $("#videos").fileinput({
  		language: "pt-BR",
        uploadUrl: CI_ROOT + 'uploadVideos/uploadify.php',
        //uploadUrl:  'https://intranet.canalsaude.fiocruz.br/VideosController/upload',
        allowedFileExtensions : ['mp4','mov','dif','flv','mkv','wmv','rmvb','vob','mpg','dv','mxf','jpeg','png'],
        /*overwriteInitial: false,*/
        uploadAsync: false,
        /*maxFileSize: 1000000,*/
        maxFilesNum: 10,
        showUpload: false,
        showPreview: false,
        maxFileCount: 10,
        browseClass: "btn btn-success",
        browseLabel: "Procurar",
        browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
        removeClass: "btn btn-danger",
        uploadClass: "btn btn-info",
        previewClass: "bg-warning",
	}).on('filebatchuploadsuccess', function(event, data) {
    console.log('entrou aqui');
		$('#formVideos #resp').html('');
		var out = '';
		$.each(data.response, function(key, file) {
	    	$.each(file, function(key, file) {
	        	var fname = file.caption;
	        	//out = out + '<li>' + 'Upload do arquivo # ' + (key + 1) + ' - '  +  fname + '  foi feito com sucesso.' + '</li>';
	        	$('#formVideos #resp').append('<input type="hidden" name="listVideos[]" value="'+fname+'" />');
                nomeDoVideo = fname;
                etapasConversao(fname,720);

	    	});
	    });
	}).on('filebatchuploadcomplete', function(event, files, extra) {
    console.log(event);
    console.log(files);
    console.log(extra);
  }).on('fileuploaded', function(event, previewId, index, fileId) {
    console.log('File uploaded', previewId, index, fileId);
}).on('filepreupload', function(event, data, previewId, index) {
    var form = data.form, files = data.files, extra = data.extra,
        response = data.response, reader = data.reader;
    console.log('File pre upload triggered');
});

	$('.excluirImagem').click(function(e){
		e.preventDefault();
		var idImagem = $(this).attr('id');
		$('#respImagem').append('<input type="hidden" name="imagensExcluir[]" value="'  +  idImagem + '" />');
		$('#imagensBanco #img_'+idImagem).fadeOut();
	});



    function etapasConversao(videoName,funcao) {

        switch (funcao) {
            case 720:
                converterFFMPEG720(videoName);
                break;
            case 240:
                converterFFMPEG240(videoName);
                break;
            case 'ZIP':
                console.log('chamando ZIP...');
                $("#progressLoader").html('<img src="'+CI_ROOT+'assets/img/Bars.gif" class="ziploader">');
                setTimeout(function() {
                    geradorDeZIP(videoName);
                }, 3000);
                break;
            case 'IMG':
                console.log('chamando IMG...');
                setTimeout(function() {
                    FFMPEGGerarImagens(videoName);
                }, 3000);
                break;
            default:
                break;
        }
        return;
    }

    function converterFFMPEG720(videoName){
        //console.log(videoName);
        console.log('iniciando 720p ....');
        console.log('Qualidade da Conversão:' + $('#qualidade').val());
        var qualidade = $('#qualidade').val();
        $.ajax({
            url: CI_ROOT +'ConvertVideoController/convertVideoFffmpeg720',
            dataType: 'json',
            method: "POST",
            data:{
                videoName:videoName,
                qualidade:qualidade
            }
        })
        .done(function(retorno) {
            //console.log(retorno);
            etapasConversao(videoName,240);
        })
        .fail(function(jqXHR,textStatus) {
            //console.log("Request failed: " + textStatus);
        });
        formato = 720;
        setTimeout(function() {
            barraProgresso(0,videoName,720);
        }, 3000);
    }

    function converterFFMPEG240(videoName){
        //console.log(videoName);
        console.log('iniciando 240p ....');
        console.log('Qualidade da Conversão:' + $('#qualidade').val());
        var qualidade = $('#qualidade').val();
        $.ajax({
            url: CI_ROOT +'ConvertVideoController/convertVideoFffmpeg240',
            dataType: 'json',
            method: "POST",
            data:{
                videoName:videoName,
                qualidade:qualidade
            }
        })
        .done(function(retorno){
            //console.log(retorno);
            etapasConversao(videoName,'ZIP');
        })
        .fail(function(jqXHR,textStatus) {
            //console.log("Request failed: " + textStatus);
        });
        formato = 240;
        setTimeout(function() {
            barraProgresso(0,videoName,240);
        }, 3000);

    }

    function FFMPEGGerarImagens(videoName){
        //console.log(videoName);

        console.log('iniciando IMG ....');
        console.log('Qualidade da Conversão:' + $('#qualidade').val());
        var qualidade = $('#qualidade').val();
        $.ajax({
            url: CI_ROOT +'ConvertVideoController/imagensVideo',
            dataType: 'json',
            method: "POST",
            data:{
                videoName:videoName,
                qualidade:qualidade
            },
            beforeSend: function () {
                //Aqui adicionas o loader
                $('#imagens').html('');
                $("#imagens").html('<img src="'+CI_ROOT+'assets/img/Spinner.gif">');
            },
        })
        .done(function(retorno) {
            console.log('retorno: '+retorno);
            $('#imagens').html('');
            $('#imagens').append('<img src="'+CI_ROOT+'uploadVideos/videos/img/'+retorno.imagens[0]+'" class="img-responsive img-thumbnail imgGenerate" id="'+retorno.imagens[0]+'">');
            $('#imagens').append('<img src="'+CI_ROOT+'uploadVideos/videos/img/'+retorno.imagens[1]+'" class="img-responsive img-thumbnail imgGenerate" id="'+retorno.imagens[1]+'">');
            $('#imagens').append('<img src="'+CI_ROOT+'uploadVideos/videos/img/'+retorno.imagens[2]+'" class="img-responsive img-thumbnail imgGenerate" id="'+retorno.imagens[2]+'">');
        })
        .fail(function(jqXHR,textStatus) {
            console.log("Request failed: " + textStatus);
            //return false;
        });


    }

    function geradorDeZIP(videoName){
        $videoNameArray = videoName.split('.');
        //console.log(videoName);
        console.log('iniciando ZIP ....');
        $.ajax({
            url: CI_ROOT +'ConvertVideoController/zipVideo',
            dataType: 'json',
            method: "POST",
            data:{
                videoName:videoName
            }
        })
        .done(function(retorno) {
           // console.log(retorno);
            $('#progressLoader').html('');
            $('#progressLoader').append('<a href="'+CI_ROOT+'uploadVideos/videos/zip/'+$videoNameArray[0]+'.zip" target="_blank"><img src="'+CI_ROOT+'assets/img/zipImg.png" class="img-responsive img-thumbnail zipImg"></a>');
            etapasConversao(videoName,'IMG');
        })
        .fail(function(jqXHR,textStatus) {
            console.log("Request failed: " + textStatus);
        });
    }


    function barraProgresso(i,videoName,formato){
            i++;
            $videoNameArray = videoName.split('.');

            var logfile = CI_ROOT +'uploadVideos/arquivos/'+$videoNameArray[0]+'_'+formato+'.txt';

            $.ajax({
                url: logfile,
                dataType: 'text',
                method: "GET"
            })
            .done(function(content) {

                var duration = 0, time = 0, progress = 0;
                var result = {};

                // get duration of source
                var matches = (content) ? content.match(/Duration: (.*?), start:/) : [];
                if(matches == null){
                   barraProgresso(0,videoName,formato);
                }
                if( matches.length>0 ){
                    var rawDuration = matches[1];
                    // convert rawDuration from 00:00:00.00 to seconds.
                    var ar = rawDuration.split(":").reverse();
                    duration = parseFloat(ar[0]);
                    if (ar[1]) duration += parseInt(ar[1]) * 60;
                    if (ar[2]) duration += parseInt(ar[2]) * 60 * 60;

                    // get the time
                    matches = content.match(/time=(.*?) bitrate/g);

                    if( matches.length>0 ){
                        var rawTime = matches.pop();
                        // needed if there is more than one match
                        if ($.isArray(rawTime)){
                            rawTime = rawTime.pop().replace('time=','').replace(' bitrate','');
                        } else {
                            rawTime = rawTime.replace('time=','').replace(' bitrate','');
                        }

                        // convert rawTime from 00:00:00.00 to seconds.
                        ar = rawTime.split(":").reverse();
                        time = parseFloat(ar[0]);
                        if (ar[1]) time += parseInt(ar[1]) * 60;
                        if (ar[2]) time += parseInt(ar[2]) * 60 * 60;

                        //calculate the progress
                        progress = Math.round((time/duration) * 100);
                    }

                    result.status = 200;
                    result.duration = duration;
                    result.current  = time;
                    result.progress = progress;

                    $('#mp4'+formato+'p').html('');
                    $('#mp4'+formato+'p').css("width", progress+"%");
                    $('#mp4'+formato+'p').append(progress+'% Complete');

                    /* UPDATE YOUR PROGRESSBAR HERE with above values ... */
                    /*console.log('progress: '+ progress);
                    console.log('i: '+ i);*/
                    if(progress<100){
                        setTimeout(barraProgresso(i,videoName,formato), 400);
                    }
                } else if( content.indexOf('Permission denied') > -1) {
                    // TODO - err - ffmpeg is not executable ...
                    console.log('{"status":-400, "error":"ffmpeg : Permission denied, either for ffmpeg or upload location ..." }');
                }

            })
            .fail(function(jqXHR,textStatus) {

                   if(i<20){
                        // retry
                        setTimeout(barraProgresso(i,videoName,formato), 400);
                    }else{
                        console.log('{"status":-400, "error":"there is no progress while we tried to encode the video" }');
                        console.log(textStatus);
                        barraProgresso(0,videoName,formato);
                    }

                   return;
            });



    }

    $('#imagens').on('click',"img", function(e) {
          e.preventDefault();
          $('#imagens img').fadeTo(300,1);
          $(this).fadeTo(300,0.4);
          var srcImg = $(this).attr("id");
          console.log();
          $('#imgHidden').html('');
          $('#imgHidden').append('<input type="hidden" name="hidden_imagem" id="hidden-imagem" value="'+srcImg+'"/>');
          console.log('<input type="hidden" name="hidden_imagem" id="hidden-imagem" class="required" value="'+srcImg+'"/>');

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
            url: CI_ROOT + 'VideosController/upload',
            type: "POST",
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (data) {
                //uncomment the next line to log the returned data in the javascript console
                 console.log(data);
                if (data.result === true) {
                    $("#message").append('<label class="control-label result" for="inputSuccess"><i class="fa fa-check"></i> Upload efetuado com sucesso</label>');
                } else {
                    $("#message").append('<label class="control-label result" for="inputError"><i class="fa fa-times-circle-o"></i>Erro ao efetuar o upload</p>');
                }

                $('#formVideos #resp').append('<input type="hidden" name="listVideos[]" value="'+data.file_name+'" />');
                etapasConversao(data.file_name,720);
            }
        });
    });


    document.getElementById("uploadBtn").onchange = function () {
        //document.getElementById("uploadFile").files[0].name;
        //$image_file
        console.log(this.value);
        var valor = this.value;
        var limpando = valor.replace(/[\\"]/g, '/');
        var value = limpando.split("/");
        var ultimo = $(value).get(-1);
        document.getElementById("uploadFile").value = ultimo;
    };
});
