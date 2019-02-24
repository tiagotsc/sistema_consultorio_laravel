
$(".campos").hide();
$(".ordem_mask").mask('0');
//$("#tabelaRelatorioCampos").css('width','97%').fixedHeader(230);
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
		relatorio_categoria_id: {
			required: true
		},
		nome: {
			required: true
		},
		descricao: {
			required: true
		},
		banco_conexao: {
			required: true
		},
		query: {
			required: true
    }
	},
	messages: {
		relatorio_categoria_id: {
			required: "Selecione, por favor!"
		},
		nome: {
			required: "Informe, por favor!"
		},
		descricao: {
			required: "Informe, por favor!"
		},
		banco_conexao: {
			required: "Selecione, por favor!"
		},
		query: {
			required: "Cole a query, por favor!"
		}
		
	}
});

$("#salvar").on("click", function(){
	if($("#frm").valid()){
		//loadingShow('Gravando...');
		$.each($('.campo_nome'), function() {
			if($(this).val() == ''){
				var cont = $(this).attr('cont');
				$(".campo_legenda"+cont).remove();
				$(".campo_ordem"+cont).remove();
				$(this).remove();
			}
		});
		$(this).prop('disabled', true).html('Aguarde...');
		$('#frm').submit();
	}
});

$("#add_sumarizar").on("click", function(event){
	event.preventDefault(); 
	var cont = $("input[name^='campo_observado']").length;
	if(cont == 4){
		alert('Limite máximo alcançado!');
		return false;
	}
	var campos = '<tr>';
			campos += '<td class="tableSemPadding form-group"><input type="text" class="form-control" name="campo_observado['+cont+']"></td>';
			campos += '<td class="tableSemPadding form-group"><input type="text" class="form-control" name="campos_sumarizados['+cont+']"></td>';
			campos += '<td class="tableSemPadding align-middle" width="7px"><a href="#" data-toggle="tooltip" data-placement="bottom" title="Remover" class="remover_sumarizacao"><i class="fas fa-minus-circle fa-lg"></i></a></td>';
			$("#sumarizacao_adicionada").append(campos);
			$('[data-toggle="tooltip"]').tooltip();
			$(".remover_sumarizacao").on("click",function(event){
				event.preventDefault(); 
				$(this).parent().parent().remove();
			});
	$('[name*="campo_observado"]').each(function () {
			$(this).rules('add', {
					required: true,
					messages: {
							required: "Informe, por favor."
					}
			});
	});
	$('[name*="campos_sumarizados"]').each(function () {
			$(this).rules('add', {
					required: true,
					messages: {
							required: "Informe, por favor."
					}
			});
	});
});

$(".marcado").on("click", function(){
	var ident = $(this).attr('identcampo');
	if($(this).prop('checked') == true){
		$("input[name='campo_nome["+ident+"]']").show().rules('add', {
			required: true,
			messages: {
					required: "Preencha, por favor."
			}
		});
		$("input[name='campo_legenda["+ident+"]']").show().rules('add', {
			required: true,
			messages: {
					required: "Preencha, por favor."
			}
		});
		$("input[name='campo_ordem["+ident+"]']").show();
		$("select[name='campo_obrigatorio["+ident+"]']").show();
	}else{
		$("input[name='campo_nome["+ident+"]']").hide().rules( "remove" );
		$("input[name='campo_legenda["+ident+"]']").hide().rules( "remove" );
		$("input[name='campo_ordem["+ident+"]']").hide();
		$("select[name='campo_obrigatorio["+ident+"]']").hide();
	}
});

$('.perfil_checkbox').shiftcheckbox();

$("#todos").on("click", function(){
	if($(this).prop('checked') == true){
			$('.perfil_checkbox').prop('checked', true);
	}else{
			$('.perfil_checkbox').prop('checked', false);
	}
});

/**
 * Edição de relatório
 */
$(".campo_marcado,.campo_marcado_obrigatorio,.campo_marcado_ordem").show();
if($(".campo_marcado").length > 0){
	$('.campo_marcado').each(function () {
		$(this).rules('add', {
				required: true,
				messages: {
						required: "Informe, por favor."
				}
		});
	});
}
if($("input[name^='campo_observado']").length > 0){
	$('[name*="campo_observado"]').each(function () {
		$(this).rules('add', {
				required: true,
				messages: {
						required: "Informe, por favor."
				}
		});
	});
	$('[name*="campos_sumarizados"]').each(function () {
		$(this).rules('add', {
				required: true,
				messages: {
						required: "Informe, por favor."
				}
		});
	});
	$(".remover_sumarizacao").on("click",function(event){
		event.preventDefault(); 
		$(this).parent().parent().remove();
	});
}


