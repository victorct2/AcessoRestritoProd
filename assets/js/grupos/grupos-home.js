  $('#listaGrupos').DataTable({
      "processing":true,  
      "serverSide":true,
      "responsive": true,    
      "scrollX": true,  
      "order":[],  
      "ajax":{  
          url:CI_ROOT +'GruposController/listaGruposDataTables',  
          type:"POST"  
      },  
      "columnDefs":[  
          {  
                "targets":[3, 3],  
                "orderable":false,  
          },  
      ],
      "oLanguage": {
        "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
      }
  });
