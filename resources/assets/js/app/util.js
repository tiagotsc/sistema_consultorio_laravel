function loadingShow(msg){
    
    if(msg === undefined){
        msg = 'Aguarde...';
    }
    
    $.blockUI({
        message: '<b style="font-size: 20px">'+msg+'</b>',
        css: { /* CSS da mensagem */
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff',
            'z-index': 999999999999999999
        },
        overlayCSS: { /* Css da mascara */
            'z-index': 999999999999999999 
        }
    });
}

function loadingHide(){
    $.unblockUI();
}

function buscaCep(elemento,endereco,bairro,cidade,estado){

    $(elemento).on('keyup', function(){
        if($(this).val().length == 9){ // CEP Completo
            loadingShow('Buscando endereço...');
            $.get( 'http://api.postmon.com.br/v1/cep/'+$(this).val(), function( res ) {
                $(endereco).val(res.logradouro).prop('readonly', true);
                $(bairro).val(res.bairro).prop('readonly', true);
                $(cidade).val(res.cidade).prop('readonly', true);
                /*$(estado).val(res.estado).attr('readonly','readonly').css('backgroundColor', '#eee');*/
                $(estado+' option').each(function(){
                    var item = $(this).text();
                    if(item == res.estado){
                       $(this).prop('selected',true);
                    }
                });
              loadingHide();
            }, "json" ).fail(function() {
                $(endereco).val('').prop('readonly', false);
                $(bairro).val('').prop('readonly', false);
                $(cidade).val('').prop('readonly', false);
                $(estado).val('').removeAttr("readonly").css('backgroundColor', 'white');
                $.unblockUI();
            });
        }
    });

}

