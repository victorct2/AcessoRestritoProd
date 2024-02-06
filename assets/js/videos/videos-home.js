 //Initialize Select2 Elements
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

var dataTable = $('#listaVideos').DataTable({
      "processing":true,  
      "serverSide":true, 
      "responsive": true, 
      "scrollX": true,
      "order":[],  
      "autoWidth": false,
      "dom": '<"top"i>rt<"bottom"lp><"clear">',
      "ajax":{  
          url:CI_ROOT +'VideosController/listaVideosDataTables',  
          type:"POST"  
      },  
      "columnDefs":[  
          {  
                "targets":[0, 6],  
                "orderable":false,  
          },  
      ],
       "oLanguage": {
        "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
      },
      "columns": [
        {"width": "10%"},
        {"width": "10%"},
        {"width": "29%"},
        {"width": "15%"},
        {"width": "10%"},
        {"width": "12%"},
        {"width": "17%"}
    ]  
});

$('.search-input-text').on( 'keyup click', function () {   // for text boxes
    var i =$(this).attr('data-column');  // getting column index
    var v =$(this).val();  // getting search input value
    dataTable.columns(i).search(v).draw();
});
/*$('.search-input-data').on( 'keyup click', function () {   // for text boxes
    var i =$(this).attr('data-column');  // getting column index
    var v =$(this).val();  // getting search input value
    dataTable.columns(i).search(v).draw();
});*/
$('.search-input-data').on( 'change', function () {   // for text boxes
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



$('#listaVideos').on('click','.assistir',function(){
    //e.preventDefault();
    console.log('clicou');
    var title = $(this).attr('title');
    $this = $(this);
    $.fancybox({
        href: $this.attr('href'),
        type: 'ajax',
        title: title,
        'hideOnContentClick' : true,
        'width' : 750,
        'height' : 520,
        'type' : 'iframe',
        'padding' : 5,
        'autoSize': false,
        'onComplete' : function() {
             $('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
               $('#fancybox-content').height($(this).contents().find('body').height()+100);
             });
           }
    });
    return false;
});


