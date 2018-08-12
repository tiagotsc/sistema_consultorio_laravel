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
		nome: {
			required: true
        }
	},
	messages: {
		nome: {
			required: "Informe, por favor!"
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