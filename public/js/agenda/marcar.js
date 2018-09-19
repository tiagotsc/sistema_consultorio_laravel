$("#frmMarcar").validate({
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
        primeira_vez: {
            required: true
        },
        data_marcar: {
            required: true
        },
        especialidade: {
            required: true
        },
        medico: {
            required: true
        },
        plano: {
            required: true
        },
		nome: {
			required: true
        },
        hora_marcada: {
			required: true
        }
	},
	messages: {
		primeira_vez: {
			required: "Selecione, por favor!"
        },
        data_marcar: {
			required: "Informe, por favor!"
        },
        especialidade: {
            required: "Selecione, por favor!"
        },
        medico: {
            required: "Selecione, por favor!"
        },
        plano: {
            required: "Selecione, por favor!"
        },
        nome: {
			required: "Informe, por favor!"
        },
        hora_marcada: {
			required: "Marque!"
        }
	}
});

$("#salvarConsultar").on("click", function(){
	if($("#frmMarcar").valid()){
        loadingShow('Gravando...');
		$(this).prop('disabled', true).html('Aguarde...');
		//$('#frmMarcar').submit();
	}
});

/*$("#salvarConsultar").on("click", function(){
    alert('Salvando');
});*/