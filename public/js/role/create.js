$('.marcado').shiftcheckbox();
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

$("#permissoes_grupo").on("change",function(){
    $("#todos").prop('checked', false);
    if($(this).val() != 0){
        var escolhido = $('input.'+$(this).val()+'_checkbox').length;
        var escolhidoMarcado = $('input.'+$(this).val()+'_checkbox:checked').length;
        if(escolhido == escolhidoMarcado){
            $("#todos").prop('checked', true);
        }
        $(".permissao_item").hide();
        $("."+$(this).val()).show();
    }else{
        var todosCheckbox = $(".marcado").length;
        var todosCheckboxMarcados = $("input.marcado:checked").length;
        if(todosCheckbox == todosCheckboxMarcados){
            $("#todos").prop('checked', true);
        }
        $(".permissao_item").show();
    }
});

$("#todos").on("click", function(){
    var seletor = '.marcado';
    if($("#permissoes_grupo").val() != 0){ 
        seletor = '.'+$("#permissoes_grupo").val()+'_checkbox';
    }
    
    if($(this).prop('checked') == true){
        $(seletor).prop('checked', true);
    }else{
        $(seletor).prop('checked', false);
    }
});