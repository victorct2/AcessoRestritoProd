

//-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvasSexo = $('#pieChartSexo').get(0).getContext('2d')
    var pieChartSexo       = new Chart(pieChartCanvasSexo)
    var PieDataSexo        = []
    var pieOptionsSexo     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.


//-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvasDispositivo = $('#pieChartDispositivo').get(0).getContext('2d')
    var pieChartDispositivo      = new Chart(pieChartCanvasDispositivo)
    var PieDataDispositivo        = []
    var pieOptionsDispositivo     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.

//-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvasBrowser = $('#pieChartBrowser').get(0).getContext('2d')
    var pieChartBrowser       = new Chart(pieChartCanvasBrowser)
    var PieDataBrowser        = []
    var pieOptionsBrowser     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    

    



window.onload = function () {

    $.ajax({				
      url: CI_ROOT +'RelatoriosController/getRedesSociaisAnalytics',
      dataType: 'json',
      method: "POST",   
    })
    .done(function( retorno ) {
      //console.log(retorno);

      $.each(retorno.reports[0].data.rows, function (key, valor) {		
        if(valor.dimensions[0] != '(not set)'){
            $('#redesSociais').append('<li><a href="#"><i class="fa fa-'+valor.dimensions[0].toLowerCase()+'" aria-hidden="true"></i> '+key+'.  '+valor.dimensions[0]+' <span class="pull-right badge bg-blue">'+valor.metrics[0].values[0]+'</span></a></li>');       
        }        
        if(key >7){
          return false;
        }  
      });       

    })
    .fail(function( jqXHR, textStatus ) {
      console.log("Request failed: " + textStatus);
    });

    $.ajax({				
      url: CI_ROOT +'RelatoriosController/getDispositivosAnalytics',
      dataType: 'json',
      method: "POST",   
    })
    .done(function( retorno ) {

      $.each(retorno.reports[0].data.rows, function (key, valor) {			       
        var obj= new Object();
          obj.value = valor.metrics[0].values[0];
          if(valor.dimensions[0]=='mobile'){
            obj.color = '#f56954';
            obj.highlight = '#f56954';          
          }
          if(valor.dimensions[0]=='desktop'){
            obj.color = '#00c0ef';
            obj.highlight = '#00c0ef';
          }   
          if(valor.dimensions[0]=='tablet'){
            obj.color = '#f39c12';
            obj.highlight = '#f39c12'; 
          }  
          obj.label = valor.dimensions[0];             
          PieDataDispositivo.push(obj);         
        
      });
      pieChartDispositivo.Doughnut(PieDataDispositivo, pieOptionsDispositivo);
       
    })
    .fail(function( jqXHR, textStatus ) {
      console.log("Request failed: " + textStatus);
    });

        
    $.ajax({				
      url: CI_ROOT +'RelatoriosController/getInfoDemografAnalytics',
      dataType: 'json',
      method: "POST",   
    })
    .done(function( retorno ) {
      //console.log(retorno);

      $.each(retorno.reports[0].data.rows, function (key, valor) {			 
        /*console.log(key);
        console.log(valor.dimensions[0]);
        console.log(valor.metrics[0].values[0]);*/
        
          var obj= new Object();
          obj.value = valor.metrics[0].values[0];
          if(valor.dimensions[0]=='female'){
            obj.color = '#f56954';
            obj.highlight = '#f56954'; 
            obj.label = 'Feminino'            
          }
          if(valor.dimensions[0]=='male'){
            obj.color = '#00c0ef';
            obj.highlight = '#00c0ef'; 
            obj.label = 'Masculino'
          }                  
          PieDataSexo.push(obj);
         
        
      });
      pieChartSexo.Doughnut(PieDataSexo, pieOptionsSexo);
       

    })
    .fail(function( jqXHR, textStatus ) {
      console.log("Request failed: " + textStatus);
    });

    /// Browser

    //console.log('verificando google analytics Browser...');
    $.ajax({				
      url: CI_ROOT +'RelatoriosController/getBrowserAnalytics',
      dataType: 'json',
      method: "POST",   
    })
    .done(function( retorno ) {
      //console.log(retorno);

      $.each(retorno.reports[0].data.rows, function (key, valor) {			 
        /*console.log(key);
        console.log(valor.dimensions[0]);
        console.log(valor.metrics[0].values[0]);*/
        if(valor.dimensions[0]=='Chrome' || valor.dimensions[0]=='Firefox' || 
         valor.dimensions[0]=='Safari' || valor.dimensions[0]=='Internet Explorer' ||
         valor.dimensions[0]=='Edge' || valor.dimensions[0]=='Opera' ){
          var obj= new Object();
          obj.value = valor.metrics[0].values[0];
          if(valor.dimensions[0]=='Chrome'){
            obj.color = '#f56954';
            obj.highlight = '#f56954';             
          }
          if(valor.dimensions[0]=='Firefox'){
            obj.color = '#f39c12';
            obj.highlight = '#f39c12'; 
          }
          if(valor.dimensions[0]=='Safari'){
            obj.color = '#00c0ef';
            obj.highlight = '#00c0ef'; 
          }
          if(valor.dimensions[0]=='Internet Explorer'){
            obj.color = '#00a65a';
            obj.highlight = '#00a65a'; 
          }
          if(valor.dimensions[0]=='Edge'){
            obj.color = '#d2d6de';
            obj.highlight = '#d2d6de'; 
          }
          if(valor.dimensions[0]=='Opera'){
            obj.color = '#3c8dbc';
            obj.highlight = '#3c8dbc'; 
          }
        
          obj.label = valor.dimensions[0];
          PieDataBrowser.push(obj);
         // $('#browserAcesosFooter').append('<li><a href="#">'+valor.dimensions[0]+'<span class="pull-right">'+valor.metrics[0].values[0]+'</span></a></li>');
                    
        }
        
        
      });   
      pieChartBrowser.Doughnut(PieDataBrowser, pieOptionsBrowser);       

    })
    .fail(function( jqXHR, textStatus ) {
      console.log("Request failed: " + textStatus);
    });
}
