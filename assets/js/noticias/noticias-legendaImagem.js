
$('#modal-incluirLegenda').on('show.bs.modal', function (event) {
  
    var button = $(event.relatedTarget);	    	
    var idNoticia = button[0].id;
    
    $.ajax({				
        url: CI_ROOT + 'NoticiasController/modalIncluirLegenda',
        dataType: 'html',
        type: "POST",
        data:{
            idNoticia : idNoticia,
        },
        success: function(retorno){
            $('#modal-incluirLegenda').html(retorno);
        }
    });
});