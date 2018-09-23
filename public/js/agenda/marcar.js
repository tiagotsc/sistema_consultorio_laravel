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

$("#especialidade").on("change", function(){
    $('#medico').html('');
    if($(this).val() != ''){
        loadingShow('Carregando médicos...');
        var comboMedico = '<option>selecione...</option>';
        $.get( $("#rota_medico_espec").val()+'/'+$(this).val(), function( data ) {
            $( data ).each(function( ) {
                comboMedico += '<option value="'+this.id+'">'+this.name+'</option>';
            });
            $('#medico').html(comboMedico);
            loadingHide();
        }, "json" )
        .fail(function() {
            alert( "Erro ao oberter médicos da especialidades!" );
        });
    }
});

$("#medico").on("change", function(){
    $('#horarios').html('');
    loadingShow('Carregando horários...');
    if($(this).val() != ''){
        var horarios = '';
        $.get( $("#rota_horarios_disponiveis").val(),{
            data: $("#data_marcar").val(),
            medico: $("#medico").val(),
            especialidade: $("#especialidade").val()
        }, function( data ) {
            $( data ).each(function(k,v) {
                horarios += '<div class="form-group col-md-1">';
                horarios += '<label><input type="radio" class="" name="horario_marcado" value="'+v+'"> '+v+'</label>';
                horarios += '</div>';
            });
            $('#horarios').html(horarios);
            loadingHide();
        }, "json" )
        .fail(function() {
            alert( "Erro ao oberter horários!" );
        });
    }
});

/*$("#salvarConsultar").on("click", function(){
    alert('Salvando');
});*/