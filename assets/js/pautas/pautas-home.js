  $('#listaPautas').DataTable({
      "processing":true,  
      "serverSide":true,  
      "order":[],  
      "ajax":{  
          url:CI_ROOT +'PautasController/listaPautasDataTables',  
          type:"POST"  
      },  
      "columnDefs":[  
          {  
                "targets":[0,6],  
                "orderable":false,  
          },  
      ],
      "oLanguage": {
        "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
      },
      "columns": [
        {"width": "10%"},
        {"width": "10%"},
        {"width": "35%"},
        {"width": "3%"},
        {"width": "4%"},
        {"width": "2%"},
        {"width": "13%"}
    ]  
  });
