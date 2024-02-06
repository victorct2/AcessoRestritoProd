  $('#listaTipoArquivo').DataTable({
      "processing":true,  
      "serverSide":true,
      "responsive": true,    
      "scrollX": true,  
      "order":[],  
      "ajax":{  
          url:CI_ROOT +'EnvioController/listaTipoArquivoDataTables',  
          type:"POST"  
      },  
      "columnDefs":[  
          {  
                "targets":[4,4 ],  
                "orderable":false,  
          },  
      ],
      "oLanguage": {
        "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
      }
  });
