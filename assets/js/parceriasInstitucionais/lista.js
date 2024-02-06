var dataTable = $('#listaParceriasInstitucionais').DataTable({
    "processing":true, 
    "serverSide":true,
    "responsive": true,    
    "scrollX": true,  
    "order":[],  
    "autoWidth": false,
    "dom": '<"top"i>rt<"bottom"lp><"clear">',
    "ajax":{  
        url:CI_ROOT +'ParceriasInstitucionaisController/listaParceriasInstitucionaisDataTables',  
        type:"POST"  
    },  
    "columnDefs":[  
        {  
            "targets":[0,4,5],  
            "orderable":false,  
        },  
    ],
       "oLanguage": {
        "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
    },
    "columns": [
        {"width": "20%"},
        {"width": "15%"},
        {"width": "20%"},
        {"width": "20%"},
        {"width": "10%"},
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


$('#modal-alterarParceiroInstitucional').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idParceirosInstitucionais = button[0].id;
      //console.log(idChamado);
      $.ajax({				
        url: CI_ROOT + 'ParceriasInstitucionaisController/modalAlterarParceiroInstitucional',
        dataType: 'html',
        type: "POST",
        data:{
            idParceirosInstitucionais : idParceirosInstitucionais
        },
        success: function(retorno){
			$('#modal-alterarParceiroInstitucional').html(retorno);			
        }
	});	

});

$('#modal-cadastrarParceiroInstitucional').on('show.bs.modal', function (event) {
       	
    $.ajax({				
        url: CI_ROOT + 'ParceriasInstitucionaisController/modalCadastroParceiroInstitucional',
        dataType: 'html',
        type: "POST",
        data:{
        },
        success: function(retorno){
			$('#modal-cadastrarParceiroInstitucional').html(retorno);			
        }
	});	

});
