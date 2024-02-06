  $('#listaStreaming').DataTable({
      "pageLength": 25,
      "lengthMenu": [10, 25, 50,100, "All"],
      "processing":true,  
      "serverSide":true,  
      "order":[],  
      "ajax":{  
          url:CI_ROOT +'RelatorioStreamingController/listaStreamingDataTables',  
          type:"POST"  
      },  
      "columnDefs":[  
          {  
                "targets":[],  
                "orderable":false,  
          },  
      ],
      "oLanguage": {
        "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
      },
      "createdRow": function ( row, data, index ) {
        if (index < 5) {
            $(row).addClass('success');
        }
      }
  });

  $('#reservation').daterangepicker({
		"timePicker": true,
    "timePicker24Hour": true,
    "timePickerSeconds": true,
    locale: {
      format: 'DD/MM/YYYY HH:mm:ss'
    },      
    ranges   : {
        'Hoje'       : [moment(), moment()],
        'Ontem'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 dias' : [moment().subtract(6, 'days'), moment()],
        'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
        'Este Mês'  : [moment().startOf('month'), moment().endOf('month')],
        'Mês Passado'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },   
    alwaysShowCalendars: true,
    opens: "right",
    function (start, end) {
      //$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    }
  });
