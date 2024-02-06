$(document).ready(function(){

    //CKEDITOR.replace('editor1');

    $(this).on('click','#cadastrarAviso', function () {

        $.ajax({
            url: CI_ROOT +'AvisosController/cadastrar',
            dataType: 'html',
            type: "POST",
            success: function(retorno){
                $('#myModal').html(retorno);
            }
        });
    });

    $(this).on('click','.fecharModalAviso', function () {
        $('#myModal').html('');
        $('#myModal').FadeOut();
    });


    $(this).on('click','.excluirAviso', function () {

        var idAviso = ($(this).attr('id'));

        var r = confirm("Deseja realmente excluir esse Aviso?");
        if (r == true) {
            $.ajax({
                url: CI_ROOT +'AvisosController/excluir',
                dataType: 'html',
                type: "POST",
                data:{
                    idAviso  : idAviso
                },
                success: function(retorno){
                    if(retorno=='sucesso'){
                        alert('Aviso excluído com sucesso!');
                    }else{
                        alert('Erro ao excluir o Aviso!');
                    }

                    location.reload();
                }
            });
        } else {
            return false;
        }

    });


});

window.onload = function(){
    $.ajax({
        url: CI_ROOT +'Home/carregarTotalAcessosOnDemand',
        dataType: 'json',
        type: "POST",
        async: true,
        cache:false,
        success: function(retorno){
            console.log(retorno);
            $("#totalAcessosOnDemand").text(retorno);
        }
    });

    $.ajax({
        url: CI_ROOT +'Home/carregarTotalDownloadsOnDemand',
        dataType: 'json',
        type: "POST",
        async: true,
        cache:false,
        success: function(retorno){
            console.log(retorno);
            $("#totalDownloadsOnDemand").text(retorno);
        }
    });
}
