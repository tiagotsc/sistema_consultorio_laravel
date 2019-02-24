$(".relatorio_selecionado").on("click",function(event){
    var caminho = $("#rota_relatorio_show").val().replace('0',$(this).attr('id'));
    montaModalDefault(caminho,'');
});
