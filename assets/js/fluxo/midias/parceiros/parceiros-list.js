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
    

var dataTable = $('#listaParceiros').DataTable({
    "processing":true, 
    "serverSide":true,
    "responsive": true,    
    "scrollX": true,  
    "order":[],  
    "autoWidth": false,
    "dom": '<"top"i>rt<"bottom"lp><"clear">',
    "ajax":{  
        url:CI_ROOT +'midiasParceirosController/listaAreaParceirosDataTables',  
        type:"POST"  
    },  
    "columnDefs":[  
        {  
            "targets":[0,3,4],  
            "orderable":false,  
        },  
    ],
        "oLanguage": {
        "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
    },
    "columns": [
        {"width": "20%"},
        {"width": "15%"},
        {"width": "40%"},
        {"width": "15%"},
        {"width": "10%"}
    ]
});
  
  
  
  
$('.search-input-text').on( 'keyup click', function () {   // for text boxes
    var i =$(this).attr('data-column');  // getting column index
    var v =$(this).val();  // getting search input value
    dataTable.columns(i).search(v).draw();
});

$('.search-input-select-parceiro').on( 'change', function () {   // for select box
    var i =$(this).attr('data-column');
    var v =$(this).val();
    dataTable.columns(i).search(v).draw();
});

$('.search-input-select-informacao').on( 'change', function () {   // for select box
    var i =$(this).attr('data-column');
    var v =$(this).val();
    dataTable.columns(i).search(v).draw();
});

 

$('#listaParceiros tbody').on('click','.ativarSite', function() {		   
    var idParceiros = $(this).attr("title");        
    $.ajax({				
        url: CI_ROOT +'midiasParceirosController/ativarSite',
        type: "POST",
        data:{
            idParceiros : idParceiros
        },
        success: function(retorno){
            //alert(retorno);
            if(retorno == 'success'){
                alert("Ação executada com sucesso!");
            }else if(retorno = 'false'){
                alert("Erro executar a ação!");
            }
           location.reload();                        
        }
    });
  
});