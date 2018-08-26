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
        }
	},
	messages: {
		name: {
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
