

var dataTable = $('#listaStreaming').DataTable({
    "processing":true, 
    "serverSide":true,
    "responsive": true,    
    "scrollX": true,  
    "order":[],  
    "autoWidth": false,
    "dom": '<"top"i>rt<"bottom"lp><"clear">',
    "ajax":{  
        url:CI_ROOT +'AovivoController/listaAovivoDataTables',  
        type:"POST"  
    },  
    "columnDefs":[  
        {  
            "targets":[3,5],  
            "orderable":false,  
        },  
    ],
       "oLanguage": {
        "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
    },
    "columns": [
        {"width": "5%"},
        {"width": "10%"},
        {"width": "20%"},
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


$('.search-input-select-informacao').on( 'change', function () {   // for select box
    var i =$(this).attr('data-column');
    var v =$(this).val();
    dataTable.columns(i).search(v).draw();
});




$('#listaStreaming tbody').on('click','.ativar', function() {		
   
    var id = $(this).attr("title");
    
    $.ajax({				
        url: CI_ROOT +'AovivoController/ativarAovivo',
        type: "POST",
        data:{
            id : id
        },
        success: function(retorno){
            //alert(retorno);
            if(retorno == 'success'){
                alert("Aovivo ativado com sucesso!");
            }else if(retorno = 'false'){
                alert("Erro ao ativar o Aovivo!");
            }
           location.reload();                        
        }
    });
  
});



