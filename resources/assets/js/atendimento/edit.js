$("textarea").jqte({
	link: false,
	outdent: false,
	sub: false,
	unlink: false,
	format: false,
	source: false
});

$('[data-toggle="tooltip"]').tooltip();

$("#frm").validate({
    debug: false,
    ignore: '*:not([name])',
	errorClass: 'error',
	errorElement: 'p',
	errorPlacement: function(error, element) {
	  element.parents('.form-group').append(error);
	  var msg = $(element).next('.help-block').text();
	  $(element).attr('aria-label', msg );
	},
	highlight: function(element, errorClass){
	  $(element)
	  .attr('aria-invalid', true)
	  .parents('.form-group')
	  .addClass('has-error');
	},
	unhighlight: function(element, errorClass){
	  $(element).removeAttr('aria-invalid')
	  .removeAttr('aria-label')
	  .parents('.form-group').removeClass('has-error');
	},
	rules: {
		medico_anotacoes: {
            required: {
                depends: function(element){
                    var status = true;
                    if( $("#medico_anotacoes").val() === ''){
                        var status = true;
                    }
                    return status;
                }
            }
        }
	},
	messages: {
		medico_anotacoes: {
            required: "Informe, por favor!"
        }
	}
});

$("#salvar").on("click", function(){
	if($("#frm").valid()){
        loadingShow('Gravando...');
		$(this).prop('disabled', true).html('Aguarde...');
		$('#frm').submit();
	}
});

$(".jqte_editor").on("keyup", function(){
    $('textarea').valid();
});

$(".remove_receita").on("click", function(event){
    event.preventDefault(); 
    $(this).parent().remove();
    $("div.tooltip-inner,div.arrow").hide();
});

$("#add_receita").on("click", function(event){
    event.preventDefault(); 
    $("textarea").jqte({
        link: false,
        outdent: false,
        sub: false,
        unlink: false,
        format: false,
        source: false
    });
    var contReceita = $(".receita_adicionada").length + 1;
    var textarea = '<div class="form-group col-md-12">';
        textarea += '<textarea rows="8" name="receita['+contReceita+']" class="receita_adicionada" class="form-control"></textarea>';
        textarea += '</textarea>';
        //textarea += '<p title="Remover receita" data-toggle="tooltip" data-placement="bottom"><a href="#"><i class="fas fa-minus-circle"></i></a></p>';
        textarea += '</div>';
    $("#receitas").append(textarea);
    $("textarea[name='receita["+contReceita+"]']").after('<a href="#" class="remove_receita"><i title="Remover receita" data-toggle="tooltip" data-placement="bottom" class="fas fa-minus-circle fa-lg"></i></a>');
    
    $("textarea[name='receita["+contReceita+"]']").rules( "add", {
        required: true,
        messages: {
            required: "Informe, por favor!"
        }
    });
    
    $('[data-toggle="tooltip"]').tooltip();
    $(".remove_receita").on("click", function(event){
        event.preventDefault(); 
        $(this).parent().remove();
        $("div.tooltip-inner,div.arrow").hide();
    });
    $("textarea").jqte({
        link: false,
        outdent: false,
        sub: false,
        unlink: false,
        format: false,
        source: false
    });
    $(".jqte_editor").on("keyup", function(){
        $('textarea').valid();
    });
});

$(".imprimir_receita").on("click", function(event){
    event.preventDefault(); 
    window.open($(this).attr('href'), '_blank', 'width=800,height=600');
    //var popupWin = window.open('', '_blank', 'width=800,height=600');
    //popupWin.document.open();
    //popupWin.document.write('<html><head><style>@media print {.teste{color:red}}</style></head><body onload="window.print()"><p class="teste">Medi<span>+</span></p><p>'+$("textarea[name='receita["+$(this).attr('receita')+"]']").val()+'</p></body></html>');
    //popupWin.document.close();
});


function dump(obj) {
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }
    alert(out);
}
