var dataTable = $('#listaSlideShow').DataTable({
  "processing":true, 
  "serverSide":true,
  "responsive": true,    
  "scrollX": true,  
  "order":[],  
  "autoWidth": false,
  "dom": '<"top"i>rt<"bottom"lp><"clear">',
  "ajax":{  
      url:CI_ROOT +'SlideShowController/listaSlideDataTables',  
      type:"POST"  
  },  
  "columnDefs":[  
      {  
          "targets":[0, 5],  
          "orderable":false,  
      },  
  ],
     "oLanguage": {
      "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
  },
  "columns": [
      {"width": "40%"},
      {"width": "10%"},
      {"width": "25%"},
      {"width": "10%"},
      {"width": "5%"},
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