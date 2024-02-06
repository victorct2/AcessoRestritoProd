$('.select2').select2();

var dataTable = $('#listaProgramas').DataTable({
  "processing":true, 
  "serverSide":true,
  "responsive": true,    
  "scrollX": true,  
  "order":[],  
  "autoWidth": false,
  "dom": '<"top"i>rt<"bottom"lp><"clear">',
  "ajax":{  
      url:CI_ROOT +'ProgramasController/listaProgramasDataTables',  
      type:"POST"  
  },  
  "columnDefs":[  
      {  
            "targets":[0,3, 4],  
            "orderable":false,  
      },  
  ],
  "oLanguage": {
    "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
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

$('.search-input-select-informacao').on( 'change', function () {   // for select box
  var i =$(this).attr('data-column');
  var v =$(this).val();
  dataTable.columns(i).search(v).draw();
});