
var todasSequencias = JSON.parse($("#todas_sequencias").val());
var table;
table = $('#frm-pesq').DataTable({
    language: { /* Traduz o plugin*/
        url: "/js/datatable/language/dataTables.pt-br.json", /* Arquivo de tradução*/
        select: { /* Tradução encima das operações de seleção de linha*/
            rows: { /* Tradução para o Footer da tabela*/
                _: "Você selecionou %d linhas", /* Footer -> Tradução para mais de uma linha selecionada*/
                0: "Clique na linha para selecionar", /* Footer -> Tradução para nenhuma linha selecionada*/
                1: "Apenas 1 linha foi selecionada" /* Footer -> Tradução para apenas uma linha selecionada*/
            }
        },
        buttons: { /* Tradução encima da mensagem do botão de cópia*/
            copyTitle: 'Tabela copiada',
            copySuccess: {
                _: '%d linhas copiadas',
                1: '1 linha copiada'
            }
        }
    },
    pageLength: 50, /* Define o número de registros por página*/
    drawCallback: function( settings ) { /* Aplica funções javascript no html que esta sendo renderizado no datatable*/
        $('[data-toggle="tooltip"]').tooltip();
    },
    ajax: {
        url: $("#rota_pesquisa_consulta").val(),
        type: 'POST',
        data: function(data){ /* Criando a function ele pega os dados do inputs dinamicamente*/
            data._token = $( "input[name='_token']" ).val();
            data.input_dado = $("#input_dado").val();
            data.horario = $("#horario").val();
            data.data = $("input[name='data']").val();
        }
    },
    processing: true,
    columnDefs: [
        {
           targets: 0, 
           data: 'horario', 
           render: function ( data, type, row ) { 
                return '<span class="agenda-hora agenda-dados'+row.id+' agenda-todos" id="'+row.id+'" status="'+row.status+'">'+data+'</span>';
            },
           className: 'dt-body-center'
        },
        {
            targets: 1, 
            data: 'nome',
            render: function ( data, type, row ) { 
                return '<span class="agenda-dados'+row.id+' agenda-todos" id="'+row.id+'">Paciente: '+data+'<br>Doutor(a): '+row['medico']+'<br>Especialidade: '+row['especialidade']+'</span>';
            },
           className: 'dt-body-left' /* Centraliza o conteúdo da TD*/
        },
        {
           targets: 2,
           data: 'status',
            render: function ( data, type, row ) { 
            return '<a href="#" class="status" agenda_id="'+row['id']+'" status_id="'+row['status_id']+'" horario="'+row['horario']+'" paciente="'+row['nome']+'" medico_id="'+row['medico_id']+'">'+data+'</a>';
            },
           className: 'dt-body-center' /* Centraliza o conteúdo da TD*/
        },
        {
           targets: 3,
           data:   'id',
           orderable: false, /* Habilita ou desabilita ordenação da coluna*/
           render: function ( data, type, row ) { 
               if ( type === 'display' ) {
                   var bt = '<span id="botoes_id'+data+'">'; 
                    if($('#user_type').val() == 'Medico' && row.status == 'Presente'){
                        bt += '<a title="Chamar paciente" data-toggle="tooltip" data-placement="bottom" href="#" id="'+data+'" horario="'+row['horario']+'" paciente="'+row['nome']+'" class="chamar chamarId'+data+' marginIcon"><i class="fas fa-assistive-listening-systems"></i></a>';
                    }
                    if($('#user_type').val() == 'Medico' && (row.status == 'Chamado' || row.status == 'Em atendimento')){ 
                        var linkAtende = $('#rota_atende').val().replace('0',data);
                        bt += '<a title="Atender paciente" data-toggle="tooltip" data-placement="bottom" href="'+linkAtende+'" class="atenderId'+data+' marginIcon"><i class="fas fa-sign-in-alt fa-lg"></i></a>';
                    }
                    
                    if($("#all_permissions").val().indexOf('paciente-editar') > -1 && row.novo == 'S'){
                        var linkEditar = $("#rota-paciente-editar").val().replace('0',row.paciente_id);
                        bt += '<a title="Ficha incompleta" data-toggle="tooltip" data-placement="bottom" href="'+linkEditar+'" class="marginIcon"><i class="fas fa-address-book fa-lg"></i></a>';
                    }
                    if($("#all_permissions").val().indexOf('paciente-editar') > -1){
                        bt += '<a title="Editar consulta" data-toggle="tooltip" data-placement="bottom" href="#" idEdit="'+data+'" class="editar marginIcon"><i class="fas fa-edit fa-lg"></i></a>';
                    }
                    if($("#all_permissions").val().indexOf('paciente-apagar') > -1){
                        bt += '<a idDel="'+data+'" titulo="'+row.nome+'" href="#" data-toggle="modal" data-target="#modalApagar" class="apagar"><i title="Apagar" data-toggle="tooltip" data-placement="bottom" class="fas fa-trash-alt fa-lg"></a>';
                    }
                    bt += '</span>';
                   return bt;
               }
               return data;
           },
           className: 'dt-body-center' /* Centraliza o conteúdo da TD*/
        }
    ]
});

$("#pesq").on('click', function(){
    table.clear().draw();
    table.ajax.reload();
});

$('#frm-pesq tbody').on( 'click', '.editar', function (event) { 
    event.preventDefault(); 
    montaModalDefault($("#rota_edita_consulta").val().replace('0',$(this).attr('idEdit')),'');
});

$('#frm-pesq tbody').on( 'click', '.apagar', function (event) { 
    event.preventDefault(); 
    $("#frm-deletar").attr('action',$("#rota-deletar").val().replace(0, $(this).attr('idDel')));
    $("#del-id").val($(this).attr('idDel'));
    $("#del-nome").val($(this).attr('titulo'));
});

$('#frm-pesq tbody').on( 'click', '.chamar', function (event) { 
    event.preventDefault(); 
    var rota = $("#rota_altera_status").val().replace('0',$(this).attr('id'));
    $("#frmAlteraStatus").attr('action',rota);
    var comboStatus = '<option value="4" selected>Chamado</option>';
    $("#agenda_status_id").html(comboStatus);
    $("#altera_status_paciente").val($(this).attr('paciente'));
    $("#altera_status_horario").val($(this).attr('horario'));
    $("#altera_status_medico_id").val($("#user_id").val());
    $("#frmAlteraStatus").submit();
});


$("#modalMarcar").on("click", function(event){
    event.preventDefault();
    montaModalDefault($("#rota_cadastra_consulta").val(),$(this).attr('data-selecionada'));
});

$('#frm-pesq tbody').on( 'click', '.status', function (event) { 
    event.preventDefault(); 
    var rota = $("#rota_altera_status").val().replace('0',$(this).attr('agenda_id'));
    $("#frmAlteraStatus").attr('action',rota);
    var statusRegistro = $(this).attr('status_id');
    var comboStatus = '';
    $.each(todasSequencias[statusRegistro], function( index, value ) {
        var idStatus = index.replace('_','');
        var marcado = statusRegistro == idStatus ? "selected" : "";
        comboStatus += '<option value="'+idStatus+'" '+marcado+'>'+value+'</option>';
    });
    $("#agenda_status_id").html(comboStatus);
    $("#altera_status_paciente").val($(this).attr('paciente'));
    $("#altera_status_horario").val($(this).attr('horario'));
    $("#altera_status_medico_id").val($(this).attr('medico_id'));
    $('#modalStatus').modal('show');
});

$("#bt-status-altera").on("click", function(){
    $(this).prop('disabled', true).html('Aguarde...');
    $('#frmAlteraStatus').submit();
});

function verificaAgenda(dataSelecionada, dataAtual, agendaHorarios, agendaDados){

    if(agendaHorarios.length != 0){
        $(".agenda-todos").css({'color':'black','text-decoration':'none','font-weight':'normal'});
        $(".editar,.apagar").show();
        $.each(agendaHorarios, function() {//console.log(moment().format('DD/MM/YYYY H:mm')+' - '+moment().format('YYYY-MM-DD '+$(this).html()));
            if(moment().isAfter(moment().format('YYYY-MM-DD '+$(this).html())) && $(this).attr('status') == 'Presente'){ // Se estiver presente e atrasado
                $(".agenda-dados"+$(this).attr('id')).css('color','red');
            }
            if(moment().isAfter(moment().format('YYYY-MM-DD '+$(this).html())) && $(this).attr('status') == 'Marcado'){
                $(".agenda-dados"+$(this).attr('id')).css('color','gray');
            }
            if($(this).attr('status') == 'Chamado'){
                $(".agenda-dados"+$(this).attr('id')).css('font-weight', 'bold');
            }

            if($(this).attr('status') == 'Desistiu'){
                $(".agenda-dados"+$(this).attr('id')).css('text-decoration','line-through');
            }

            if($(this).attr('status') == 'Em atendimento'){
                $(".agenda-dados"+$(this).attr('id')).css('color','Navy');
                $("a[idEdit='"+$(this).attr('id')+"']").hide();
                $("a[idDel='"+$(this).attr('id')+"']").hide();
            }
            //console.log( moment().isBefore(moment().format('YYYY-MM-DD '+$(this).html())) );
            //console.log($(this).html());
        });
    }
        
    //console.log(moment().format('LTS'));
    //if(moment(dataCompleta,"DD/MM/YYYY").isBefore($('input[name="data_atual"]').val())){
      //  $.notify("Data inferior a data atual", "warn");
    //}
}
//var dataSel = $('input[name="data"]').val().split('/').reverse().join('-');
//var dataAtual = $('input[name="data_atual"]').val();
var dataSel = $("input[name='data']").val()
var dataAtual = moment().format('DD/MM/YYYY');
if(dataSel == dataAtual){
    self.setInterval(function(){verificaAgenda(dataSel, dataAtual, $('.agenda-hora'), $('.agenda-dados'))}, 1000);
}
// Enable pusher logging - don't include this in production
// Pusher.logToConsole = true;

var pusher = new Pusher($("#pusher_key").val(), {
cluster: $("#pusher_cluster").val(),
encrypted: true
});

var setCanal = $("#user_type").val() == 'Medico' ? $("#user_type").val()+'.'+$("#user_id").val() : '';
// Subscribe to the channel we specified in our Laravel Event
var channel = pusher.subscribe('agendaStatus'+setCanal);

// Bind a function to a Event (the full Laravel class)
channel.bind('App\\Events\\AgendaStatusEvento', function(data) {
    if(moment().format('DD/MM/YYYY') == data.agenda.data){
        //$.notify("Hello World", "success");
        $('.agenda-dados'+data.agenda.id).attr('status', data.agenda.status_nome);
        $('a[agenda_id="'+data.agenda.id+'"]').attr('status_id',data.agenda.status_id).html(data.agenda.status_nome);
        $('.chamarId'+data.agenda.id).remove(); 
        $('.atenderId'+data.agenda.id).remove(); 
        if(data.medicoId == $("#user_id").val()){
            if($('#user_type').val() == 'Medico' && data.agenda.status_nome == 'Presente'){ 
                $('#botoes_id'+data.agenda.id).prepend('<a title="Chamar paciente" data-toggle="tooltip" data-placement="bottom" href="#" id="'+data.agenda.id+'" horario="'+data.agenda.horario+'" paciente="'+data.agenda.paciente+'" class="chamar chamarId'+data.agenda.id+' marginIcon"><i class="fas fa-assistive-listening-systems"></i></a>');
            }
            /*if($('#user_type').val() == 'Medico' && data.agenda.status_nome == 'Presente'){ 
                var linkAtende = $('#rota_atende').val().replace('0',data.agenda.id);
                $('#botoes_id'+data.agenda.id).prepend('<a title="Atender paciente" data-toggle="tooltip" data-placement="bottom" href="'+linkAtende+'" class="marginIcon atenderId'+data.agenda.id+'"><i class="fas fa-sign-in-alt fa-lg"></i></a>');
            }*/

            $.notify("Dr(a): O paciente "+data.agenda.paciente+" marcado às "+data.agenda.horario+" mudou para "+data.agenda.status_nome+".", "info");
        }
        if($("#user_type").val() == 'Secretaria' && data.agenda.status_id == 4){ // Chamado
            $.notify("O paciente "+data.agenda.paciente+" marcado às "+data.agenda.horario+" esta sendo chamado.", "info");
        }
        $('[data-toggle="tooltip"]').tooltip();
    }
});

/*
Debuga objeto javascript
*/

function dump(obj) {
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }
    alert(out);
}
