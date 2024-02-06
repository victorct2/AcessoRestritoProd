$('.select2').select2();
  

$("#datepicker").datepicker({
    dateFormat : 'yy-mm-dd',
    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    showAnim: "clip"
});  
  
  



$('#reservation').daterangepicker({
    locale: {
    format: 'DD/MM/YYYY'
    }
});

var dataTable = $('#listaProgramacao').DataTable({
      "processing":true, 
      "serverSide":true,
      "responsive": true,    
      "scrollX": true,  
      "order":[],  
      "autoWidth": false,
      "dom": '<"top"i>rt<"bottom"lp><"clear">',
      "ajax":{  
          url:CI_ROOT +'ProgramacaoController/listaProgramacaoDataTables',  
          type:"POST"  
      },  
      "columnDefs":[  
          {  
              "targets":[0,8,9],  
              "orderable":false,  
          },  
      ],
         "oLanguage": {
          "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
      },
      "columns": [
          {"width": "10%"},
          {"width": "5%"},
          {"width": "20%"},
          {"width": "10%"},
          {"width": "5%"},
          {"width": "5%"},
          {"width": "15%"},
          {"width": "15%"},
          {"width": "10%"},
          {"width": "5%"}
      ]       
});
  
  
  
  
    $('.search-input-text').on( 'keyup click', function () {   // for text boxes
        var i =$(this).attr('data-column');  // getting column index
        var v =$(this).val();  // getting search input value
        dataTable.columns(i).search(v).draw();
    });
    $('.search-input-data').on( 'change', function () {   // for text boxes
        var i =$(this).attr('data-column');  // getting column index
        var v =$(this).val();  // getting search input value
        dataTable.columns(i).search(v).draw();
    });
    $('.search-input-select-programa').on( 'change', function () {   // for select box
        var i =$(this).attr('data-column');
        var v =$(this).val();
        dataTable.columns(i).search(v).draw();
    });

    $('.search-input-select-informacao').on( 'change', function () {   // for select box
        var i =$(this).attr('data-column');
        var v =$(this).val();
        dataTable.columns(i).search(v).draw();
    });

 

$('#listaProgramacao tbody').on('click','.inedito', function() {		
   
    var idProgramacao = $(this).attr("title");    
    
    $.ajax({				
        url: CI_ROOT +'ProgramacaoController/marcarComoInedito',
        type: "POST",
        data:{
            idProgramacao : idProgramacao
        },
        success: function(retorno){
            //alert(retorno);
            if(retorno == 'success'){
                alert("Programa inédito marcado com sucesso!");
            }else if(retorno = 'false'){
                alert("Erro ao marcar o programa como inédito!");
            }
           location.reload();                        
        }
    });
  
});

$('#listaProgramacao tbody').on('click','.destaque', function() {		
   
    var idProgramacao = $(this).attr("title");    
    
    $.ajax({				
        url: CI_ROOT +'ProgramacaoController/marcarComoDestaque',
        type: "POST",
        data:{
            idProgramacao : idProgramacao
        },
        success: function(retorno){
            //console.log(retorno);
            if(retorno == 'success'){
                alert("Programa Em destaque marcado com sucesso!");
            }else if(retorno = 'false'){
                alert("Erro ao marcar o programa como destaque!");
            }
            location.reload();                   
        }
    });
  
});