<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <form action="<?php echo base_url('PodcastController/inserirEpisodio') ?>" method="POST" id="formArquivoPodcast">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Inserir Episodio</h4>
      </div>
      <div class="modal-body">
            <div class="row">
              <div class="col-md-12">

                <input type="hidden" name="idPodcast" value="<?php echo $idPodcast ?>">
                
                <div class="form-group">
                    <label for="titulo">Título do episódio :</label>
                    <input name="titulo" type="text" class="form-control" id="titulo" placeholder="Informe o Título">
                </div>

                <div class="form-group">
                    <label for="data">Data :</label>
                    <input name="data" type="text" class="form-control datepicker" id="data" placeholder="Informe a Data">
                </div>

                <div class="form-group">
                  <label for="descricao">Descrição :</label>
                  <!--<textarea name="descricao" placeholder="Informe a descrição" class="form-control" id="descricao" cols="30" rows="10"></textarea>-->
                  <textarea id="editor1" name="descricao" cols="30" rows="10">
                      Escreva a descrição aqui...
                  </textarea>
                </div>
                
                <div class="form-group">
                    <label for="embed">Código Embed :</label>
                    <textarea name="embed" class="form-control" rows="4" placeholder="Código Embed ..." ></textarea>
                </div>

                <div class="form-group">					
                  <label>Associar ao vídeo:</label>
                  <select name="idVideo" id="idVideo" class="form-control selectVideo"  style="width: 100%;">                      
                  </select>
                </div>

                <div class="form-group">
                    <label>Situação</label>
                    <select name="status" class="form-control" style="width: 100%;" >
                      <option value="S">ATIVO</option>
                      <option value="N">INATIVO</option>
                    </select>
                  </div>

              </div>
              <div id="resp"></div>
            </div>
            <!-- /.row -->
      </div>
      <div class="modal-footer">      
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-warning">Inserir Episódio</button>
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

    $(".selectVideo").select2({
		  placeholder: '--- Selecione  ---',
        ajax: {
          url: CI_ROOT + 'PodcastController/videosSearch',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {            
            return {
              results: data
            };
          },
          cache: true
        }
	  });	

    CKEDITOR.replace('editor1',
    {      
        uiColor : '#9AB8F3'
        //customConfig: '/custom/ckeditor_config.js'
    });

    $(".datepicker").datepicker({
      dateFormat : 'dd/mm/yy',
      dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
      dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
      dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
      monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
      monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
      showAnim: "clip"
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