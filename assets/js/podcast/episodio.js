
$('#modal-incluirEpisodio').on('show.bs.modal', function (event) {
  console.log('entrou aqui');
  var button = $(event.relatedTarget);		
  var idPodcast = button[0].id;
  console.log(idPodcast);
  $.ajax({				
    url: CI_ROOT + 'PodcastController/modalInserirEpisodio',
    dataType: 'html',
    type: "POST",
    data:{
      idPodcast : idPodcast
    },
    success: function(retorno){
      console.log(retorno);
      $('#modal-incluirEpisodio').html(retorno);
    }
  });
});

$('#modal-alterarEpisodio').on('show.bs.modal', function (event) {
  console.log('entrou aqui');
  var button = $(event.relatedTarget);		
    var idEpisodio = button[0].id;
    console.log(idEpisodio);
    $.ajax({				
    url: CI_ROOT + 'PodcastController/modalAlterarEpisodio',
    dataType: 'html',
    type: "POST",
    data:{
      idEpisodio : idEpisodio
    },
    success: function(retorno){
      console.log(retorno);
      $('#modal-alterarEpisodio').html(retorno);
    }
  });
});

$('.excluirEpisodio').on('click', function (event) {
  var id = $(this).attr('id');
  console.log(id);
  $.ajax({				
    url: CI_ROOT +'PodcastController/excluirEpisodio',
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