<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <form action="<?php echo base_url('PodcastController/alterarEpisodio') ?>" method="POST" id="formArquivoPodcast">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Alterar Episodio</h4>
      </div>
      <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
              

                <input type="hidden" name="id" value="<?php echo $episodio[0]->id ?>">
                <input type="hidden" name="idPodcast" value="<?php echo $episodio[0]->podcast_id ?>">
                
                <div class="form-group">
                    <label for="titulo">Título do episódio :</label>
                    <input name="titulo" type="text" class="form-control" id="titulo" placeholder="Informe o Título" value="<?php echo $episodio[0]->titulo ?>">
                </div>

                <div class="form-group">
                    <label for="datepickerAlterar">Data :</label>
                    <input name="data" type="text" class="form-control" id="datepickerAlterar" placeholder="Informe a Data" value="<?php echo converteDataInterface($episodio[0]->data) ?>"> 
                </div>

                <div class="form-group">
                  <label for="descricao">Descrição :</label>
                  <!--<textarea name="descricao" placeholder="Informe a descrição" class="form-control" id="descricao" cols="30" rows="10"></textarea>-->
                  <textarea id="editor2" name="descricao" cols="30" rows="10">
                    <?php echo $episodio[0]->descricao ?>
                  </textarea>
                </div> 
                
                <div class="form-group">
                    <label for="embed">Código Embed :</label>
                    <textarea name="embed" class="form-control" rows="4" placeholder="Código Embed ..." ><?php echo $episodio[0]->embed ?></textarea>
                </div>

                <div class="form-group">					
                  <label>Associar ao vídeo:</label>
                  <select name="idVideo" id="idVideo" class="form-control selectVideoAlterar"  style="width: 100%;"> 
                          
                      <?php if($episodio[0]->video_id != ''){ ?>   
                        <option></option>                          
                        <option id="<?php echo $episodio[0]->video_id ?>" selected="selected"><?php echo $nomeVideo[0]->nomeVideo ?></option> 
                      <?php } ?>          
                      
                  </select>
                </div>

                <div class="form-group">
                  <label>Situação</label>
                  <select name="status" class="form-control" style="width: 100%;">
                    <option value="S" <?php echo ($episodio[0]->status == 'S')? 'selected="selected"':'' ?>>ATIVO</option>
                      <option value="N" <?php echo ($episodio[0]->status == 'N')? 'selected="selected"':'' ?>>INATIVO</option>
                  </select>
                </div>

              </div>
              
            </div>
            <!-- /.row -->
            <?php if($episodio[0]->midia != ''){ ?>
              <div class="box box-solid box-success">
                <div class="box-header">
                  <h3 class="box-title">Imagem Atual </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <p id="podcast_<?php echo $episodio[0]->id ?>">
                  <audio controls >
                    <source src="<?php echo base_url('assets/podcast/'.$episodio[0]->midia) ?>" type="audio/mpeg">
                  </audio>
                  </audio>
                    <a href="#" class="excluirMidia" id="<?php echo $episodio[0]->id ?>">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square-o fa-stack-2x text-red"></i>
                            <i class="fa fa-trash  fa-stack-1x text-red"></i>
                        </span>			                 				
                    </a> 							 	
                  </p>
                </div><!-- /.box-body -->
              <div id="respMidia"></div>
            <?php } ?>
            <div id="resp"></div>
          
      </div><!-- /.box -->
      
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-warning">Alterar Episódio</button>
        </form>
          <?= form_open_multipart("UploadController/uploadPodcast", ['id' => 'uploader','class'=>'pull-left']); ?>
            <div class="col-md-10">
              <div class="form-group pull-left">
                <label for="videos" class="control-label">Selecionar Arquivo:</label>
              </div>
            </div>
            <div class="form-group">
              <span class="butn butn-success fileinput-button">
                  <span>Procurar</span><input type="file" name="userfile" id="uploadBtn">
              </span>
              <div class="col-md-6">
                <input id="uploadFile" placeholder="Choose File" disabled="disabled" class="form-control" />
              </div>
              <button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Upload</button>

            </div>
            <div class="col-md-12">
              <div class="progress">
                <div class="progress-bar progress-bar-success progress-bar-striped" id="progressBarUpload" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                </div>                
              </div>
              <div id="message"></div>
            </div>
          <?php echo form_close() ?>
      </div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script>
  $(document).ready(function () {

    $(".selectVideoAlterar").select2({
		  placeholder: {
        id: '',
        text: 'Selecione --->'
      },
      allowClear: true,
      tags: true,
        ajax: {
          url: CI_ROOT + 'PodcastController/videosSearch',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {            
            return {
              results: data
            };
          },
          cache: false
        }
	  });	

    CKEDITOR.replace('editor2',
    {      
        uiColor : '#9AB8F3'
        //customConfig: '/custom/ckeditor_config.js'
    });

    $("#datepickerAlterar").datepicker({
      dateFormat : 'dd/mm/yy',
      dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
      dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
      dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
      monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
      monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
      showAnim: "clip"
    });

    $('.excluirMidia').click(function(e){
      e.preventDefault();		
      var idMidia = $(this).attr('id');	
      $('#podcast_'+idMidia).fadeOut();
      $('#formArquivoPodcast #respMidia').append('<input type="hidden" name="midiaExcluir" value="S" />');
    });

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
            url: CI_ROOT + 'UploadController/uploadPodcast',
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

                $('#formArquivoPodcast #resp').append('<input type="hidden" name="listaArquivos[]" value="'+data.file_name+'" />');
                //etapasConversao(data.file_name,720);
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
</script>