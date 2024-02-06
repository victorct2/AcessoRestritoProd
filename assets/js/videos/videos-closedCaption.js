
$('#modal-incluirClosedCaption').on('show.bs.modal', function (event) {
  
  var button = $(event.relatedTarget);		
  var idVideo = button[0].id;
  $.ajax({				
    url: CI_ROOT + 'VideosController/modalInserirClosedCaption',
    dataType: 'html',
    type: "POST",
    data:{
      idVideo : idVideo
    },
    success: function(retorno){
      $('#modal-incluirClosedCaption').html(retorno);
    }
  });
});

$('#modal-alterarClosedCaption').on('show.bs.modal', function (event) {
  
  var button = $(event.relatedTarget);		
  var idClosedCaption = button[0].id;
  $.ajax({				
    url: CI_ROOT + 'VideosController/modalAlterarClosedCaption',
    dataType: 'html',
    type: "POST",
    data:{
      idClosedCaption : idClosedCaption
    },
    success: function(retorno){
      $('#modal-alterarClosedCaption').html(retorno);
    }
  });
});

$('.excluirClosedCaption').on('click', function (event) {
  var id = $(this).attr('id');
  $.ajax({				
    url: CI_ROOT +'VideosController/excluirClosedCaption',
    type: "POST",
    data:{
        id: id
    },
    success: function(retorno){
        if(retorno==true){
            alert("Ação realizada com sucesso!");
        }else{
            alert("erro ao realizar a ação");
        }     
       
      location.reload();
        
    }
  });
});

