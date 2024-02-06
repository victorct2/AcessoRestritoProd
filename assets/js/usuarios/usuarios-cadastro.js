  //Initialize Select2 Elements
  $('.selectGrupos').select2();
  $('.selectProgramas').select2();

  $('[data-mask]').inputmask();

  //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

    $('#login').bind('focusout', function() {		
				 		
		if($("#login").val() != ""){				
        $("#loginUsuario .result").html('');
        $('#loginUsuario').removeClass('has-error');
        $('#loginUsuario').removeClass('has-success');
        /*Enviar os dados para uma arquivo do servidor*/
        $.post(				
          CI_ROOT +'UsuariosController/loginExistente',
          {
            loginUsuario : $("#login").val(),
          },
          function(retorno){        
            if(retorno == 'false'){            
              $('#loginUsuario').addClass(' has-error');            
              $("#loginUsuario").append('<label class="control-label result" for="inputError"><i class="fa fa-times-circle-o"></i> Login já cadastrado</label>');
            }else if(retorno == 'success'){
              $('#loginUsuario').addClass(' has-success');
              $("#loginUsuario").append('<label class="control-label result" for="inputSuccess"><i class="fa fa-check"></i> Login liberado</label>');	
            }
          }
        );	   
		}
		return false;
	});

   