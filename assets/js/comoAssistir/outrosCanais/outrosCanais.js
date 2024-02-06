CKEDITOR.replace('editor1',
{      
    uiColor : '#9AB8F3',
    customConfig: '/custom/ckeditor_config.js'
});

var dataTable = $('#listaOutrosCanais').DataTable({
    "processing":true, 
    "serverSide":true,
    "responsive": true,    
    "scrollX": true,  
    "order":[],  
    "autoWidth": false,
    "dom": '<"top"i>rt<"bottom"lp><"clear">',
    "ajax":{  
        url:CI_ROOT +'ComoAssistirController/listaOutrosCanaisDataTables',  
        type:"POST"  
    },  
    "columnDefs":[  
        {  
            "targets":[4],  
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

$('.search-input-select-informacao').on( 'change', function () {   // for select box
	var i =$(this).attr('data-column');
	var v =$(this).val();
	dataTable.columns(i).search(v).draw();
});


$('#modal-canal').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idOutrosCanais = button[0].id;
      //console.log(idChamado);
      $.ajax({				
        url: CI_ROOT + 'ComoAssistirController/modalCanal',
        dataType: 'html',
        type: "POST",
        data:{
            idOutrosCanais : idOutrosCanais
        },
        success: function(retorno){
			$('#modal-canal').html(retorno);			
        }
	});	

});

$('#modal-canalCadastro').on('show.bs.modal', function (event) {
       	
    $.ajax({				
        url: CI_ROOT + 'ComoAssistirController/modalCanalCadastro',
        dataType: 'html',
        type: "POST",
        data:{
        },
        success: function(retorno){
			$('#modal-canalCadastro').html(retorno);			
        }
	});	

});
