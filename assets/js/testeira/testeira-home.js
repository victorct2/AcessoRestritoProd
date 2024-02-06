  $('#listaTesteiras').DataTable({
      "processing":true,  
      "serverSide":true,
      "responsive": true,    
      "scrollX": true,  
      "order":[],  
      "ajax":{  
          url:CI_ROOT +'TesteiraController/listaTesteirasDataTables',  
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