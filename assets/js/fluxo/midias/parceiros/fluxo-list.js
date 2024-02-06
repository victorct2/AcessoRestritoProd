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

var arraySearch = {};

var dataTable = $('#listaProgramasParceiros').DataTable({
    "processing":true, 
    "serverSide":true,
    "responsive": true,    
    "scrollX": true,  
    "order":[],  
    "autoWidth": false,
    "dom": '<"top"i>rt<"bottom"lp><"clear">',
    "ajax":{  
        url:CI_ROOT +'midiasParceirosController/listaProgramasDataTables',  
        type:"POST",
        data: { 
            idParceiro:$('#idParceiro').val(), 
            etapa:$('#etapa').val()
        },
        complete: function(response) {
            console.log(response);
       }
    },  
    "columnDefs":[  
        {  
            "targets":[0,7],  
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
        {"width": "10%"},
        {"width": "10%"},
        {"width": "20%"}
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
    arraySearch[i] = v;
});

$('.search-input-select-programa').on( 'change', function () {   // for select box
    var i =$(this).attr('data-column');
    var v =$(this).val();
    dataTable.columns(i).search(v).draw();
    arraySearch[i] = v;
});

$('.search-input-data').on( 'change', function () {   // for text boxes
    var i =$(this).attr('data-column');  // getting column index
    var v =$(this).val();  // getting search input value
    dataTable.columns(i).search(v).draw();
    arraySearch[i] = v;
});

$('.search-input-select-informacao').on( 'change', function () {   // for select box
    var i =$(this).attr('data-column');
    var v =$(this).val();
    dataTable.columns(i).search(v).draw();
    arraySearch[i] = v;
});


function recarregarDataTable(page){
    console.log(arraySearch);
    dataTable.ajax.reload();
    dataTable.page(page).draw('page');

}  

/*=========== Ingest ========================*/
$('#modal-alterarIngest').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      console.log(idIngest);
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalAlterarIngestParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-alterarIngest').html(retorno);
        }
    });
});

$('#modal-visualizarIngest').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      console.log(idIngest);
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalVisualizarIngestParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-visualizarIngest').html(retorno);
        }
    });
});

$('#modal-corrigirIngest').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      console.log(idIngest);
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalCorrigirIngestParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-corrigirIngest').html(retorno);
        }
    });
});

$('#listaProgramasParceiros tbody').on("click",".excluirIngest", function(event){ 			
     
    $(this).prop('disabled', true);	
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
            var page = dataTable.page();
            recarregarDataTable(page);                         
        }
    });
        
});


/*=========== Revisão ========================*/
$('#modal-revisarIngest').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      console.log(idIngest);
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalRevisarIngestParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-revisarIngest').html(retorno);
        }
    });
});

$('#modal-alterarRevisao').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      console.log(idIngest);
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalAlterarRevisaoParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-alterarRevisao').html(retorno);
        }
    });
});

$('#modal-corrigirRevisaoIngest').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      console.log(idIngest);
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalRevisarCorrecaoIngestParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-corrigirRevisaoIngest').html(retorno);
        }
    });
});

$('#modal-visualizarRevisao').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      console.log(idIngest);
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalVisualizarRevisaoParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-visualizarRevisao').html(retorno);
        }
    });
});

$('#listaProgramasParceiros tbody').on("click",".excluirRevisao", function(event){ 			
     
    $(this).prop('disabled', true);	
    var idIngest = $(this).attr('id');
    var idRevisaoIngest = $(this).attr('title'); 	
             
    $.ajax({				
        url: CI_ROOT +'RevisaoController/deleteRevisaoParceiro',
        type: "POST",
        data:{
            idIngest: idIngest,
            idRevisaoIngest: idRevisaoIngest
        },
        success: function(retorno){
            if(retorno==true){
                alert("Revisão de Ingest excluída com sucesso!");
            }else{
                alert("erro ao excluir a Revisão de Ingest");
            }
            var page = dataTable.page();
            recarregarDataTable(page);                      
        }
    });
        
});

/*=================== Ingest Closed Caption =====================================*/
$('#listaProgramasParceiros tbody').on("click",".ingestClosedCaption", function(event){ 			
     
    $(this).prop('disabled', true);	
    var idIngest = $(this).attr('id'); 	
             
    $.ajax({				
        url: CI_ROOT +'IngestController/ingestClosedCaption',
        type: "POST",
        data:{
            idIngest: idIngest
        },
        success: function(retorno){
            if(retorno==true){
                alert("Ingest de Closed Caption cadastrado com sucesso!");
            }else{
                alert("erro ao cadastrar o Ingest de Closed Caption");
            }
           
            var page = dataTable.page();
            recarregarDataTable(page);                  
        }
    });
        
});

$('#listaProgramasParceiros tbody').on("click",".semIngestClosedCaption", function(event){ 			
     
    $(this).prop('disabled', true);	
    var idIngest = $(this).attr('id'); 	
             
    $.ajax({				
        url: CI_ROOT +'IngestController/semIngestClosedCaption',
        type: "POST",
        data:{
            idIngest: idIngest
        },
        success: function(retorno){
            if(retorno==true){
                alert("Informação registrada com sucesso!");
            }else{
                alert("erro ao registrar a informação");
            }
            var page = dataTable.page();
            recarregarDataTable(page);                     
        }
    });
        
});

$('#listaProgramasParceiros tbody').on("click",".desfazerClosedCaption", function(event){ 			
    
    $(this).prop('disabled', true);	
    var idIngest = $(this).attr('id'); 	
             
    $.ajax({				
        url: CI_ROOT +'IngestController/desfazerClosedCaption',
        type: "POST",
        data:{
            idIngest: idIngest
        },
        success: function(retorno){
            if(retorno==true){
                alert("Ação desfeita com sucesso!");
            }else{
                alert("erro ao desfazer a ação anterior");
            }
            var page = dataTable.page();
            recarregarDataTable(page);                     
        }
    });
        
});

$('#modal-corrigirIngestClosedCaption').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);	
    var idIngest = button[0].id;
    console.log(idIngest);
    $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalCorrigirIngestClosedCaption',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-corrigirIngestClosedCaption').html(retorno);
        }
    });
});

/*=========== Revisão Closed Caption ========================*/
$('#modal-visualizarRevisaoClosedCaption').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);	
    var	idRevisaoClosedCaption = button[0].title;
    var idIngest = button[0].id;
    console.log(button);
    console.log(idIngest);
    console.log(idRevisaoClosedCaption);
    $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalVisualizarRevisaoClosedCaption',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idRevisaoClosedCaption:idRevisaoClosedCaption,
            idParceiro:$('#idParceiro').val()           
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-visualizarRevisaoClosedCaption').html(retorno);
        }
    });
});

$('#modal-revisarClosedCaption').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      console.log(idIngest);
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalRevisarClosedCaption',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-revisarClosedCaption').html(retorno);
        }
    });
});

$('#modal-corrigirRevisaoIngestClosedCaption').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      console.log(idIngest);
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalRevisarCorrecaoIngestClosedCaption',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-corrigirRevisaoIngestClosedCaption').html(retorno);
        }
    });
});

/*=========== Ficha de Conclusão ========================*/
$('#modal-cadastrarFichaConclusao').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      console.log(idIngest);
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalCadastrarFichaConclusaoParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-cadastrarFichaConclusao').html(retorno);
        }
    });
});


$('#modal-alterarFichaConclusao').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      console.log(idIngest);
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalAlterarFichaConclusaoParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-alterarFichaConclusao').html(retorno);
        }
    });
});


$('#modal-visualizarFichaConclusao').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      console.log(idIngest);
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalVisualizarFichaConclusaoParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-visualizarFichaConclusao').html(retorno);
        }
    });
});

$('#listaProgramasParceiros tbody').on("click",".excluirFichaDeConclusao", function(event){ 			
     
    $(this).prop('disabled', true);	
    var idIngest = $(this).attr('id');
    var idFichaConclusao = $(this).attr('title'); 	
             
    $.ajax({				
        url: CI_ROOT +'FichaConclusaoController/deleteFichaConclusaoParceiro',
        type: "POST",
        data:{
            idIngest: idIngest,
            idFichaConclusao: idFichaConclusao
        },
        success: function(retorno){
            if(retorno==true){
                alert("Ficha de Conclusão excluída com sucesso!");
            }else{
                alert("erro ao excluir a Ficha de Conclusão");
            }
            var page = dataTable.page();
            recarregarDataTable(page);                       
        }
    });
        
});



/*=========== Modal Catalogação ========================*/
$('#listaProgramasParceiros tbody').on("click",".iniciarCatalogacao", function(event){ 			
     
    $(this).prop('disabled', true);	
    var idIngest = $(this).attr('id'); 	
             
    $.ajax({				
        url: CI_ROOT +'CatalogacaoController/iniciarCatalogacao',
        type: "POST",
        data:{
            idIngest: idIngest
        },
        success: function(retorno){
            if(retorno==true){
                alert("Catalogação iniciada com sucesso!");
            }else{
                alert("erro ao iniciar a Catalogação");
            }
            var page = dataTable.page();
            recarregarDataTable(page);                        
        }
    });
        
});

$('#listaProgramasParceiros tbody').on("click",".catalogarClosedCaption", function(event){ 			
     
    $(this).prop('disabled', true);	
    var idCatalogacao = $(this).attr('id'); 	
             
    $.ajax({				
        url: CI_ROOT +'CatalogacaoController/catalogarClosedCaption',
        type: "POST",
        data:{
            idCatalogacao: idCatalogacao
        },
        success: function(retorno){
            if(retorno==true){
                alert("Catalogação de Closed Caption efetuada com sucesso!");
            }else{
                alert("erro ao efetuar a Catalogação de Closed Caption");
            }
            var page = dataTable.page();
            recarregarDataTable(page);                     
        }
    });
        
});

$('#modal-catalogar').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget);		
        var idIngest = button[0].id;
        console.log(idIngest);
        $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalCatalogarProgramaParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-catalogar').html(retorno);
        }
    });
});

$('#modal-visualizarCatalogacao').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget);		
        var idIngest = button[0].id;
        console.log(idIngest);
        $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalVisualizarCatalogacaoProgramaParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-visualizarCatalogacao').html(retorno);
        }
    });
});

$('#modal-corrigirCatalogacao').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalCorrigirCatalogacaoParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-corrigirCatalogacao').html(retorno);
        }
    });
});

$('#modal-corrigirCatalogacaoClosedCaption').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalCorrigirCatalogacaoClosedCaption',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-corrigirCatalogacaoClosedCaption').html(retorno);
        }
    });
});

$('#listaProgramasParceiros tbody').on("click",".excluirCatalogacao", function(event){ 			
     
    $(this).prop('disabled', true);	
    var idIngest = $(this).attr('id'); 
    var idCatalogacao = $(this).attr('title'); 	
             
    $.ajax({				
        url: CI_ROOT +'CatalogacaoController/deleteCatalogacaoParceiro',
        type: "POST",
        data:{
            idIngest: idIngest,
            idCatalogacao: idCatalogacao
        },
        success: function(retorno){
            if(retorno==true){
                alert("Catalogação excluída com sucesso!");
            }else{
                alert("erro ao excluir a Catalogação");
            }
            var page = dataTable.page();
            recarregarDataTable(page);                        
        }
    });
        
});

/*=========== Autorizar ========================*/
$('#listaProgramasParceiros tbody').on("click",".autorizar", function(event){ 			
    
    $(this).prop('disabled', true);	
    var idIngest = $(this).attr('id'); 
                 
    $.ajax({				
        url: CI_ROOT +'MidiasParceirosController/autorizar',
        type: "POST",
        data:{
            idIngest: idIngest
        },
        success: function(retorno){
            if(retorno==true){
                alert("Autorização cadastrada com sucesso!");
            }else{
                alert("erro ao cadastrar a autorização");
            }
            var page = dataTable.page();
            recarregarDataTable(page);                        
        }
    });
        
});

$('#listaProgramasParceiros tbody').on("click",".autorizarClosedCaption", function(event){ 			
     
    $(this).prop('disabled', true);	
    var idAutorizacao = $(this).attr('id'); 	
             
    $.ajax({				
        url: CI_ROOT +'MidiasParceirosController/autorizarClosedCaption',
        type: "POST",
        data:{
            idAutorizacao: idAutorizacao
        },
        success: function(retorno){
            if(retorno==true){
                alert("Autorização Closed Caption cadastrada com sucesso!");
            }else{
                alert("erro ao cadastrar a autorização Closed Caption");
            }
            var page = dataTable.page();
            recarregarDataTable(page);                        
        }
    });
        
});

$('#listaProgramasParceiros tbody').on("click",".excluirAutorizacao", function(event){ 			
     
    $(this).prop('disabled', true);	
    var idIngest = $(this).attr('id'); 
    var idAutorizacao = $(this).attr('title'); 	
             
    $.ajax({				
        url: CI_ROOT +'MidiasParceirosController/deleteAutorizacao',
        type: "POST",
        data:{
            idIngest: idIngest,
            idAutorizacao: idAutorizacao
        },
        success: function(retorno){
            if(retorno==true){
                alert("Autorização excluída com sucesso!");
            }else{
                alert("erro ao excluir a autorização");
            }
            var page = dataTable.page();
            recarregarDataTable(page);                        
        }
    });
        
});

 
/*===========  Revisão de Catalogação ========================*/
$('#modal-revisarCatalogacao').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalRevisarCatalogacaoParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-revisarCatalogacao').html(retorno);
        }
    });
});

$('#modal-revisarCatalogacaoClosedCaption').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalRevisarCatalogacaoClosedCaption',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-revisarCatalogacaoClosedCaption').html(retorno);
        }
    });
  });


$('#modal-corrigirRevisaoCatalogacao').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalRevisarCorrecaoCatalogacaoParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-corrigirRevisaoCatalogacao').html(retorno);
        }
    });
});

$('#modal-corrigirRevisaoCatalogacaoClosedCaption').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalRevisarCorrecaoCatalogacaoClosedCaption',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-corrigirRevisaoCatalogacaoClosedCaption').html(retorno);
        }
    });
  });

$('#modal-visualizarRevisaoCatalogacao').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);		
      var idIngest = button[0].id;
      $.ajax({				
        url: CI_ROOT + 'MidiasParceirosController/modalVisualizarRevisaoCatalogacaoParceiro',
        dataType: 'html',
        type: "POST",
        data:{
            idIngest : idIngest,
            idParceiro:$('#idParceiro').val()
        },
        success: function(retorno){
            console.log(retorno);
            $('#modal-visualizarRevisaoCatalogacao').html(retorno);
        }
    });
});

$('#listaProgramasParceiros tbody').on("click",".excluirRevisaoCatalogacao", function(event){ 			
     
    $(this).prop('disabled', true);	
    var idIngest = $(this).attr('id');
    var idRevisaoCatalogacao = $(this).attr('title'); 	
             
    $.ajax({				
        url: CI_ROOT +'RevisaoCatalogacaoController/deleteRevisaoCatalogacao',
        type: "POST",
        data:{
            idIngest: idIngest,
            idRevisaoCatalogacao: idRevisaoCatalogacao
        },
        success: function(retorno){
            if(retorno==true){
                alert("Revisao de Catalogação excluída com sucesso!");
            }else{
                alert("erro ao excluir a Revisao de Catalogação");
            }
            var page = dataTable.page();
            recarregarDataTable(page);                        
        }
    });
        
});


/*=========== Excluir ========================*/
$('#listaProgramasParceiros tbody').on("click",".excluir", function(event){ 			
     
    $(this).prop('disabled', true);	
    var idIngest = $(this).attr('id'); 	
             
    $.ajax({				
        url: CI_ROOT +'MidiasParceirosController/excluir',
        type: "POST",
        data:{
            idIngest: idIngest
        },
        success: function(retorno){
            if(retorno==true){
                alert("Exclusão informada com sucesso!");
            }else{
                alert("erro ao informar à exclusão");
            }
            var page = dataTable.page();
            recarregarDataTable(page);                     
        }
    });
        
});

$('#listaProgramasParceiros tbody').on("click",".excluirClosedCaption", function(event){ 			
     
    $(this).prop('disabled', true);	
    var idExclusao = $(this).attr('id'); 	
             
    $.ajax({				
        url: CI_ROOT +'MidiasParceirosController/excluirClosedCaption',
        type: "POST",
        data:{
            idExclusao: idExclusao
        },
        success: function(retorno){
            if(retorno==true){
                alert("Exclusão Closed Caption informada com sucesso!");
            }else{
                alert("erro ao informar à exclusão de Closed Caption");
            }
            var page = dataTable.page();
            recarregarDataTable(page);                     
        }
    });
        
});