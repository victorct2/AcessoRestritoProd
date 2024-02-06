$("#datepicker").datepicker({
    dateFormat : 'yy-mm-dd',
    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    showAnim: "clip"
});


var dataTable = $('#listaComentarios').DataTable({
    "processing":true, 
    "serverSide":true,
    "responsive": true,    
    "scrollX": true,  
    "order":[],  
    "autoWidth": false,
    "dom": '<"top"i>rt<"bottom"lp><"clear">',
    "ajax":{  
        url:CI_ROOT +'ComentariosController/listaComentariosDataTables',  
        type:"POST"  
    },  
    "columnDefs":[  
        {  
            "targets":[3,5,6,7],  
            "orderable":false,  
        },  
    ],
       "oLanguage": {
        "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
    },
    "columns": [
        {"width": "5%"},
        {"width": "20%"},
        {"width": "20%"},
        {"width": "20%"},
        {"width": "5%"},
        {"width": "5%"},
        {"width": "10%"},
        {"width": "10%"}
    ]  
      
});


$('.search-input-text').on( 'keyup click', function () {   // for text boxes
    var i =$(this).attr('data-column');  // getting column index
    var v =$(this).val();  // getting search input value
    dataTable.columns(i).search(v).draw();
});


$('.search-input-select-informacao').on( 'change', function () {   // for select box
    var i =$(this).attr('data-column');
    var v =$(this).val();
    dataTable.columns(i).search(v).draw();
});

$('.search-input-data').on( 'change', function () {   // for text boxes
    var i =$(this).attr('data-column');  // getting column index
    var v =$(this).val();  // getting search input value
    dataTable.columns(i).search(v).draw();
});

/*
$('#liberar').click(function(){
    alert('teste');
    console.log('teste de liberar');
});*/

$('#listaComentarios tbody').on('click','#liberar', function() {		
   
    var idComentario = $(this).attr("title");
    
    $.ajax({				
        url: CI_ROOT +'ComentariosController/liberarComentario',
        type: "POST",
        data:{
            idComentario : idComentario
        },
        success: function(retorno){
            //alert(retorno);
            if(retorno == 'success'){
                alert("Comentário Liberado com sucesso!");
                console.log('Comentário Liberado com sucesso!');
            }else if(retorno = 'false'){
                alert("Erro ao liberar o Comentário!");
                console.log("Erro ao liberar o Comentário!");
            }
           location.reload();                        
        }
    });
  
});

$('#listaComentarios tbody').on('click','#negar', function() {		
   
    var idComentario = $(this).attr("title");
    
    $.ajax({				
        url: CI_ROOT +'ComentariosController/negarComentario',
        type: "POST",
        data:{
            idComentario : idComentario
        },
        success: function(retorno){
            //alert(retorno);
            if(retorno == 'success'){
                alert("Comentário Negado com sucesso!");
                console.log('Comentário Negado com sucesso!');
            }else if(retorno = 'false'){
                alert("Erro ao negar o Comentário!");
                console.log("Erro ao negar o Comentário!");
            }
           location.reload();                        
        }
    });
  
});

