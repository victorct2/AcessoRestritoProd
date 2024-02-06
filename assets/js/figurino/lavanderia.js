  //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      orientation: "bottom auto",
      format: "dd/mm/yyyy"
    });


    $('.devolucao').click(function(){
      var idServico = $(this).attr('id');
      var idFigurino = $(this).attr('title');
      
        
      	$.ajax({
          url: CI_ROOT +'FigurinoController/devolucaoLavanderia',
          dataType: 'json',
          type: "POST",
          data:{
            idServico  : idServico,
            idFigurino : idFigurino
          },
          success: function(retorno){
             location.reload(true);
          }
        });

    });