<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <form action="<?php echo base_url('VideosController/inserirClosedCaption') ?>" method="POST" id="formArquivo">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Inserir Closed Caption</h4>
      </div>
      <div class="modal-body">
            <div class="row">
              <div class="col-md-12">

                <input type="hidden" name="idVideo" value="<?php echo $idVideo ?>">
                
                <div class="form-group">
                    <label for="label">Label :</label>
                    <input name="label" type="text" class="form-control" id="label" placeholder="ex: Português, Inglês">
                </div>

                <div class="form-group">
                    <label for="srcLang">Lang :</label>
                    <input name="srcLang" type="text" class="form-control" id="srcLang" placeholder="ex: pt-br, en, fr">
                </div>  

                <div class="form-group">
                  <label>Default</label>
                  <select name="default" class="form-control" style="width: 100%;" >
                    <option value="S">SIM</option>
                    <option value="N">NÃO</option>
                  </select>
                </div>              

                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control" style="width: 100%;" >
                    <option value="S">ATIVO</option>
                    <option value="N">INATIVO</option>
                  </select>
                </div>
                <div id="resp"></div>
                <button type="submit" class="btn btn-warning">Inserir Closed Caption</button>
                <hr />
                </form>

            
              
                <?= form_open_multipart("UploadController/uploadClosedCaption", ['id' => 'uploader']); ?>
                  <div class="col-md-12">
                    <div class="form-group">
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
                  <div class="col-md-6">
                    <div class="progress">
                      <div class="progress-bar progress-bar-success progress-bar-striped" id="progressBarUpload" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                      </div>
                    </div>
                  </div>
                  <?php echo form_close() ?>
                  <div id="message"></div>
              
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
      </div>
    
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script>

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
            url: CI_ROOT + 'UploadController/uploadClosedCaption',
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

                $('#formArquivo #resp').append('<input type="hidden" name="listaArquivos[]" value="'+data.file_name+'" />');
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