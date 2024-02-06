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

   

var dataTable = $('#listaProgramasParceiros').DataTable({
    "processing":true, 
    "serverSide":true,
    "responsive": true,    
    "scrollX": true,  
    "order":[],  
    "autoWidth": false,
    "dom": '<"top"i>rt<"bottom"lp><"clear">',
    "ajax":{  
        url:CI_ROOT +'midiasParceirosController/listaInsertProgramasDataTables',  
        type:"POST",
        data: { 
            idParceiro:$('#idParceiro').val()
        }  
    },  
    "columnDefs":[  
        {  
            "targets":[8],  
            "orderable":false,  
        },
        {
            "targets":[1,2,3,4,5,6], 
            "className": "text-center",  
        }
        
    ],
        "oLanguage": {
        "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
    },
    "columns": [
        {"width": "10%"},
        {"width": "15%"},
        {"width": "10%"},
        {"width": "5%"},
        {"width": "10%"},
        {"width": "25%"},
        {"width": "10%"},
        {"width": "10%"}
    ],
    "createdRow": function ( row, data, index ) {        
        
        if( data[7].indexOf('Revisão de Correção') != -1 ){
            $(row).addClass('warning');
        }
        if( data[7].indexOf('Corrigir') != -1 ){
            $(row).addClass('danger');
        }
        if( data[7].indexOf('Corrigido') != -1 ){
            $(row).addClass('warning');
        }
        
    }
});


  
  
  
$('.search-input-text').on( 'keyup click', function () {   // for text boxes
    var i =$(this).attr('data-column');  // getting column index
    var v =$(this).val();  // getting search input value
    dataTable.columns(i).search(v).draw();
});

$('.search-input-select-programa').on( 'change', function () {   // for select box
    var i =$(this).attr('data-column');
    var v =$(this).val();
    dataTable.columns(i).search(v).draw();
});

$('.search-input-data').on( 'change', function () {   // for text boxes
    var i =$(this).attr('data-column');  // getting column index
    var v =$(this).val();  // getting search input value
    dataTable.columns(i).search(v).draw();
});

$('.search-input-select-informacao').on( 'change', function () {   // for select box
    var i =$(this).attr('data-column');
    var v =$(this).val();
    dataTable.columns(i).search(v).draw();
});

/*=========== Ingest ========================*/
$('#modal-alterarInfoParceiro').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      console.log(idIngest);
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalAlterarInfoParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-alterarInfoParceiro').html(retorno);
        }
    });
});

$('#listaProgramasParceiros tbody').on("click",".excluirInfoParceiro", function(event){ 			
 	
    var idIngest = $(this).attr('id'); 	
             
    $.ajax({				
        url: CI_ROOT +'IngestController/deleteIngestParceiro',
        type: "POST",
        data:{
            idIngest: idIngest
        },
        success: function(retorno){
            if(retorno==true){
                alert("Ingest excluído com sucesso!");
            }else{
                alert("erro ao excluir o Ingest");
            }
            location.reload();                        
        }
    });
        
});

