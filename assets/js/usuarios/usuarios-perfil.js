    $('[data-mask]').inputmask();


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
              $("#loginUsuario").append('<label class="col-sm-3 control-label result" for="inputError"><i class="fa fa-times-circle-o"></i> Login já cadastrado</label>');
            }else if(retorno == 'success'){
              $('#loginUsuario').addClass(' has-success');
              $("#loginUsuario").append('<label class="col-sm-3 control-label result" for="inputSuccess"><i class="fa fa-check"></i> Login liberado</label>');	
            }
          }
        );	   
		}
		return false;
  });
  
  $('.imgAvatar').click(function() {
    var id = $(this).attr('id');
    var avatar = $(this).attr('title');	  
    //alert(id + ' -- '+ avatar);
    $.post(				
      CI_ROOT +'UsuariosController/alterarAvatar',
      {
        avatar : avatar,
      },
      function(retorno){        
        if(retorno == 'false'){            
          alert('Erro ao trocar a imagem do Avatar!');
        }else if(retorno == 'success'){
            window.location = CI_ROOT +'UsuariosController/viewPerfil';
        }
      }
    );
  });
    
  

   