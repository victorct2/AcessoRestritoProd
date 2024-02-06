window.onload = function(){

    $('.gradeProgramas').each(function(){
        var idParceiro = $(this).attr('id');
        $.ajax({
            url: CI_ROOT +'MidiasParceirosController/dadosFluxoParceiro/'+idParceiro,
            dataType: 'json',
            type: "GET",
            async: true,
            cache:false,
            success: function(retorno){
                $('.gradeProgramas#'+idParceiro+' > span.carregando').hide();

                $.each(retorno, function (index, data) {

                    if(data[0]['totalCorrecao'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/ingest"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalCorrecao']+' nova(s) Correção(ões)" class="badge bg-red">'+
                        data[0]['totalCorrecao']+' Correção(ões)</span></a>').appendTo('.gradeProgramas#'+idParceiro);

                    }

                    if(data[0]['totalRevisao'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/revisaoIngest"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalRevisao']+' nova(s) Revisão(ões)" class="badge bg-yellow">'+
                        data[0]['totalRevisao']+' Revisão(ões)</span></a>').appendTo('.gradeProgramas#'+idParceiro);

                    }

                    if(data[0]['totalIngestClosedCaption'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/ingestClosedCaption"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalIngestClosedCaption']+' novo(s) ingest de Closed Caption" class="badge bg-grey">'+
                        data[0]['totalIngestClosedCaption']+' Ingest <i class="fa fa-cc" aria-hidden="true"></i></span></a>').appendTo('.gradeProgramas#'+idParceiro);

                    }

                    if(data[0]['totalCorrecaoClosedCaption'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/ingestClosedCaption"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalCorrecaoClosedCaption']+' nova(s) Correção(ões) Ingest Closed Caption" class="badge bg-navy">'+
                        data[0]['totalCorrecaoClosedCaption']+' Correção(ões) <i class="fa fa-cc" aria-hidden="true"></i></span></a>').appendTo('.gradeProgramas#'+idParceiro);

                    }

                    if(data[0]['totalRevisaoClosedCaption'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/revisaoClosedCaption"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalRevisaoClosedCaption']+' nova(s) Revisão(ões) de Closed Caption" class="badge bg-orange">'+
                        data[0]['totalRevisaoClosedCaption']+' Revisão <i class="fa fa-cc" aria-hidden="true"></i></span></a>').appendTo('.gradeProgramas#'+idParceiro);

                    }

                    if(data[0]['totalFichaConclusao'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/fichaConclusao"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalFichaConclusao']+' nova(s) Ficha(s) de Conclusão(ões)" class="badge bg-blue">'+
                        data[0]['totalFichaConclusao']+' fic. Conclusão(ões)</span></a>').appendTo('.gradeProgramas#'+idParceiro);
                    }

                    if(data[0]['totalCatalogacao'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/catalogacao"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalCatalogacao']+' nova(s) Catalogação(ões)" class="badge bg-purple">'+
                        data[0]['totalCatalogacao']+' catalogação(ões)</span></a>').appendTo('.gradeProgramas#'+idParceiro);
                    }

                    if(data[0]['totalCatalogacaoClosedCaption'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/catalogacao"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalCatalogacaoClosedCaption']+' nova(s) Catalogação(ões)" class="badge bg-purple">'+
                        data[0]['totalCatalogacaoClosedCaption']+' catalogação(ões) <i class="fa fa-cc" aria-hidden="true"></i></span></a>').appendTo('.gradeProgramas#'+idParceiro);
                    }

                    if(data[0]['totalCorrecaoCatalogacao'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/catalogacao"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalCorrecaoCatalogacao']+' nova(s) correção(ões) de Catalogação(ões)" class="badge bg-red">'+
                        data[0]['totalCorrecaoCatalogacao']+' correção de catalogação</span></a>').appendTo('.gradeProgramas#'+idParceiro);
                    }

                    if(data[0]['totalCorrecaoCatalogacaoClosedCaption'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/catalogacao"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalCorrecaoCatalogacaoClosedCaption']+' nova(s) correção(ões) de Catalogação(ões)" class="badge bg-red">'+
                        data[0]['totalCorrecaoCatalogacaoClosedCaption']+' correção de catalogação <i class="fa fa-cc" aria-hidden="true"></i></span></a>').appendTo('.gradeProgramas#'+idParceiro);
                    }

                    if(data[0]['totalRevisaoCatalogacao'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/revisaoExclusao"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalRevisaoCatalogacao']+' nova(s) Revisão(ões) de Catalogação(ões)" class="badge bg-teal">'+
                        data[0]['totalRevisaoCatalogacao']+' rev. Catalogação</span></a>').appendTo('.gradeProgramas#'+idParceiro);
                    }

                    if(data[0]['totalRevisaoCatalogacaoClosedCaption'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/revisaoExclusao"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalRevisaoCatalogacaoClosedCaption']+' nova(s) Revisão(ões) de Catalogação(ões)" class="badge bg-teal">'+
                        data[0]['totalRevisaoCatalogacaoClosedCaption']+' rev. Catalogação <i class="fa fa-cc" aria-hidden="true"></i></span></a>').appendTo('.gradeProgramas#'+idParceiro);
                    }

                    if(data[0]['totalAutorizacao'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/autorizacao"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalRetotalAutorizacaoisaoCatalogacao']+' nova(s) autorização(ões)" class="badge bg-green">'+
                        data[0]['totalAutorizacao']+' autorização</span></a>').appendTo('.gradeProgramas#'+idParceiro);
                    }

                    if(data[0]['totalAutorizacaoClosedCaption'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/autorizacao"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalAutorizacaoClosedCaption']+' nova(s) autorização(ões)" class="badge bg-green">'+
                        data[0]['totalAutorizacaoClosedCaption']+' autorização <i class="fa fa-cc" aria-hidden="true"></i></span></a>').appendTo('.gradeProgramas#'+idParceiro);
                    }

                    if(data[0]['totalExclusao'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/revisaoExclusao"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalExclusao']+' nova(s) exclusão(ões)" class="badge bg-black">'+
                        data[0]['totalExclusao']+' exclusão</span></a>').appendTo('.gradeProgramas#'+idParceiro);
                    }

                    if(data[0]['totalExclusaoClosedCaption'] > 0){
                        $('<a href="'+CI_ROOT+'midiasParceirosController/viewfluxoParceiros/'+idParceiro+'/revisaoExclusao"'+
                        'class="btn btn-box-tool"><span data-toggle="tooltip" title="'+data[0]['totalExclusaoClosedCaption']+' nova(s) exclusão(ões)" class="badge bg-black">'+
                        data[0]['totalExclusaoClosedCaption']+' exclusão <i class="fa fa-cc" aria-hidden="true"></i></span></a>').appendTo('.gradeProgramas#'+idParceiro);
                    }

                });

            }
        });
    });




}
