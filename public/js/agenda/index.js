function montaModalDefault(caminho, parametros){
    $( "#modalDefault" ).html( '' );
	$.get($("#base_url").val()+ caminho, { valores: parametros }, function( data ) {
        $( "#modalDefault" ).html( data );
        loadingHide();
    }).fail(function() {
        alert( "Error! Recarrega a página, por favor!" );
    });
}
$("#modalMarcar").on("click", function(){
    montaModalDefault('/agenda/marcar',$(this).attr('data-selecionada'));
});

$("#salvar").on("click", function(){
    alert('Salvando');
});