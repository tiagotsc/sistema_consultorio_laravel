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

function montaModalDefault(caminho, parametros){
    loadingShow();
    $( "#modalDefault" ).html( '' );
	$.get(caminho, { valores: parametros }, function( data ) {
        $( "#modalDefault" ).html( data );
        $('#modalDefault').modal('show');
        loadingHide();
    }).fail(function() {
        alert( "Error! Recarrega a página, por favor!" );
    });
}

// Mostra o limite de caracteres, conforme digitado
$.fn.textareaLimit = function() {
    return this.each(function() {
        var limiteMaximo = $(this).attr('maxlength');
        if(limiteMaximo !== undefined){
            $(this).after("<span>"+limiteMaximo+"</span> Caracter(es) restante(s)");
            $(this).on("keyup", function(){
                var textlen = limiteMaximo - $(this).val().length;
                $(this).next().text(textlen);
            });
        }
    });
};

// Verificador de horário
$.fn.horario = function() {
    return this.each(function() {
        $(this).on("keyup", function(){
            var value = $(this).val();
            if(value.length == 2){
                if(parseInt(value, 10) > 23){ // Se a hora for incorreta, limpa o campo
                    $(this).val('23');
                }
            }
            if(value.length == 5){
                if(parseInt(value.substring(3, 5),10) > 59){
                    $(this).val(value.substring(0, 2)+':');
                }
            }
        });
    });
};

function dump(obj) {
    var out = '';
    for (var i in obj) {
    out += i + ": " + obj[i] + "\n";
    }
   alert(out);
}
