var dataTable = $('#listaRestrito').DataTable({
    "processing":true, 
    "serverSide":true,
    "responsive": true,    
    "scrollX": true,  
    "order":[],  
    "autoWidth": false,
    "dom": '<"top"i>rt<"bottom"lp><"clear">',
    "ajax":{  
        url:CI_ROOT +'EnvioController/listaUsuariosDataTables',  
        type:"POST"  
    },  
    "columnDefs":[  
        {  
            "targets":[4,4],  
            "orderable":false,  
        },  
    ],
       "oLanguage": {
        "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
    },
    "columns": [
        {"width": "20%"},
        {"width": "20%"},
        {"width": "20%"},
        {"width": "20%"},
        {"width": "20%"}
    ]   

      
});


$('.search-input-text').on( 'keyup click', function () {   // for text boxes
    var i =$(this).attr('data-column');  // getting column index
    var v =$(this).val();  // getting search input value
    dataTable.columns(i).search(v).draw();
});

