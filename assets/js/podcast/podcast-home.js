  $('#listaPodcast').DataTable({
      "processing":true,  
      "serverSide":true,  
      "order":[],  
      "ajax":{  
          url:CI_ROOT +'PodcastController/listaPodcastDataTables',  
          type:"POST"  
      },  
      "columnDefs":[  
          {  
                "targets":[0,3, 4],  
                "orderable":false,  
          },  
      ],
      "columns": [
        {"width": "20%"},
        {"width": "20%"},
        {"width": "20%"},
        {"width": "20%"},
        {"width": "20%"}
      ],  
      "oLanguage": {
        "sUrl": CI_ROOT +"assets/js/dataTables_pt-br.json"
      }
  });