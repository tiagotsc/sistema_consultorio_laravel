$('[data-toggle="tooltip"]').tooltip();

buscaCep("#cep","#endereco","#bairro","#cidade","#estado_id");

$("#frm").validate({
	debug: false,
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
		nome: {
			required: true
        },
        email: {
			email: true
        },
        cep: {
			required: true
        },
        endereco: {
			required: true
        },
        numero: {
			required: true
        },
        bairro: {
			required: true
        },
        cidade: {
			required: true
        },
        estado_id: {
			required: true
        }
	},
	messages: {
		nome: {
			required: "Informe, por favor!"
        },
        email: {
			email: "Informe um email válido, por favor!"
        },
        cep: {
			required: "Informe, por favor!"
        },
        endereco: {
			required: "Informe, por favor!"
        },
        numero: {
			required: "Informe, por favor!"
        },
        bairro: {
			required: "Informe, por favor!"
        },
        cidade: {
			required: "Informe, por favor!"
        },
        estado_id: {
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

$("#add_telefone").on("click",function(event){
    event.preventDefault();
    var telefone = '<div class="form-group col-md-3">';
        telefone += '<label><span>Telefone</span>';
        telefone += '<input type="text" class="form-control telefone" name="telefone[]">';
        telefone += '</label>';
        telefone += '<a href="#" class="remover" title="Remover" data-toggle="tooltip" data-placement="bottom"><i class="fas fa-minus-circle"></i></a>';
        telefone += '</div>';
    $("#telefones").append(telefone);
    $('.telefone').mask('(00) 0000-00000');
    validaTelefones();
    $('[data-toggle="tooltip"]').tooltip();
    removeTelefone();
});

validaTelefones();
removeTelefone();

function validaTelefones(){
    var cont = 0;
	$("input[name^='telefone']").each(function(){

		$(this).attr('name','telefone['+(cont++)+']').rules( "add", {
			required: true,
			messages: {
				required: "Informe, por favor!"
			}
        });
        $(this).prev().html('Telefone '+cont);
    });
}

function removeTelefone(){
    $(".remover").on("click", function(event){
        event.preventDefault();
        $(this).parent().remove();
        $("div.tooltip-inner,div.arrow").hide();
    });
}
