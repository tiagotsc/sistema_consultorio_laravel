$("#buscaPacientes,#pacientesEncontrados,#dadosPaciente").hide();
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
		nome_paciente: {
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
        nome_paciente: {
			required: "Informe, por favor!"
        }
	}
});

$("#salvarConsultar").on("click", function(){
	if($("#frmMarcar").valid()){
        loadingShow('Marcando consulta...');
		$(this).prop('disabled', true).html('Aguarde...');
		$('#frmMarcar').submit();
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
                horarios += '<label><input type="radio" class="horario_marcado" name="horario_marcado" value="'+v+'"> '+v+'</label>';
                horarios += '</div>';
            });
            $('#horarios').html(horarios);
            $(".horario_marcado" ).rules( "add", {
                required: true,
                messages: {
                  required: "Marque."
                }
            });
            loadingHide();
        }, "json" )
        .fail(function() {
            alert( "Erro ao oberter horários!" );
        });
    }
});

$("#primeira_vez").on("change", function(){
    $("#nome_paciente, #telefone, #celular, #paciente_id").val('');
    if($(this).val() != ''){
        if($(this).val() == 'S'){
            $("#nome_paciente").prop('readonly', false);
            $("#dadosPaciente").show();
            $("#localizar").val('').hide();
            $("#buscaPacientes").hide();
        }else{
            $("#localizar").val('');
            $("#dadosPaciente").hide();
            $("#buscaPacientes").show();
            $("#localizar").val('').show();

        }
    }else{
        $("#buscaPacientes,#pacientesEncontrados,#dadosPaciente").hide();
    }
});

$("#localizar").on("keyup", function(){
    if($(this).val().length > 0){
        $("#salvarConsultar").hide();
    }
    if($(this).val().length >= 3){
        $("#pacientesEncontrados").show();
        $('#encontrados').html('<tr><th colspan="5">Buscando paciente, aguarde...</th></tr>');
        $.get( $("#rota_paciente_busca").val(),{
            dadoBusca: $(this).val()
        }, function( data ) {
            var encontrados = '<tr>';
                encontrados += '<th>Nome</th>';
                encontrados += '<th>CPF</th>';
                encontrados += '<th>Fixo</th>';
                encontrados += '<th>Celular</th>';
                encontrados += '<th>Ação</th>';
                encontrados += '</tr>';
            $( data ).each(function() {
                encontrados += '<tr>';
                encontrados += '<td>'+this.nome+'</td>';
                encontrados += '<td>'+this.cpf+'</td>';
                encontrados += '<td>'+this.telefone+'</td>';
                encontrados += '<td>'+this.celular+'</td>';
                encontrados += '<td><a href="#" class="selecionar" title="Selecionar" paciente_id="'+this.id+'" nome="'+this.nome+'" telefone="'+this.telefone+'" celular="'+this.celular+'"><i class="fas fa-user-check"></i></a></td>';
                encontrados += '</tr>';
            });
            $('#encontrados').html(encontrados);
            selecionarPaciente();
            loadingHide();
        }, "json" )
        .fail(function() {
            alert( "Erro ao localizar paciente!" );
        });
    }else{
        $("#pacientesEncontrados").hide();
    }
});

function selecionarPaciente(){
    $(".selecionar").on("click", function(){
        $("#paciente_id").val($(this).attr('paciente_id'));
        $("#nome_paciente").val($(this).attr('nome')).prop('readonly', true);
        $("#telefone").val($(this).attr('telefone'));
        $("#celular").val($(this).attr('celular'));
        $("#dadosPaciente").show();
        $("#buscaPacientes, #pacientesEncontrados").hide();
        $("#salvarConsultar").show();
    });
}

/*$("#salvarConsultar").on("click", function(){
    alert('Salvando');
});*/