$("#divEspecialidade").hide();

buscaCep(".cep","#endereco","#bairro","#cidade","#estado_id");

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
		name: {
			required: true
        },
        email: {
            required: true,
            email: true
		},
        medico: {
			required: true
        },
        estado_id: {
			required: true
        },
        password: {
			required: true
        },
        'especialidade[]':{
            required:{
                depends: function(element){
                    var status = false;
                    if( $("#medico").val() == 'S'){
                        var status = true;
                    }
                    return status;
                }
            }
        },
        'perfis[]': {
            required: true
        }
	},
	messages: {
		name: {
			required: "Informe, por favor!"
        },
        email: {
            required: "Informe, por favor!",
            email: "Informe um email válido, por favor!"
        },
        medico: {
			required: "Selecione, por favor!",
        },
        estado: {
			required: "Selecione, por favor!",
        },
        password: {
			required: "Informe, por favor!",
        },
        'especialidade[]':{
            required: "Selecione, por favor!"
        },
        'perfis[]': {
            required: "Selecione, por favor!"
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

$("#medico").on("change", function(){
    if($(this).val() == 'S'){ /* É médico */
        $("#divEspecialidade").show();
    }else{
        $("#divEspecialidade").hide();
    }
});
