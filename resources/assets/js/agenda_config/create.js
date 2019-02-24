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
		inicio: {
            required: true,
            max: 15
        },
        fim: {
            required: true,
            min: 17
        },
        intervalo: {
            required: true,
            max: 59
        }
	},
	messages: {
		inicio: {
            required: "Informe, por favor!",
            max: "hora superior a máxima!"
        },
        fim: {
            required: "Informe, por favor!",
            min: "Hora abaixo da mínima!"
        },
        intervalo: {
            required: "Informe, por favor!",
            max: "Minutos inválidos!"
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
