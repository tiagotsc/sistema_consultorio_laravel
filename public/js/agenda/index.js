
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
        }
    },
    processing: true,
    columnDefs: [
        {
           targets: 0, 
           data: 'horario', 
           className: 'dt-body-center'
        },
        {
            targets: 1, 
            data: 'nome',
            render: function ( data, type, row ) { 
                return 'Paciente: '+data+'<br>Doutor(a): '+row['medico']+'<br>Especialidade: '+row['especialidade'];
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
                   var bt = ''; 
                    if($('#user_type').val() == 'Medico' && row.status == 'Presente'){ 
                        var linkAtende = $('#rota_atende').val().replace('0',data);
                        bt += '<a title="Atender paciente" data-toggle="tooltip" data-placement="bottom" href="'+linkAtende+'" class="atenderId'+data+' marginIcon"><i class="fas fa-sign-in-alt fa-lg"></i></a>';
                    }
                    if($("#all_permissions").val().indexOf('paciente-editar') > -1){
                        bt += '<a title="Editar" data-toggle="tooltip" data-placement="bottom" href="#" idEdit="'+data+'" class="editar marginIcon"><i class="fas fa-edit fa-lg"></i></a>';
                    }
                    if($("#all_permissions").val().indexOf('paciente-apagar') > -1){
                        bt += '<a idDel="'+data+'" titulo="'+row.nome+'" href="#" data-toggle="modal" data-target="#modalApagar" class="apagar"><i title="Apagar" data-toggle="tooltip" data-placement="bottom" class="fas fa-trash-alt fa-lg"></a>';
                    }
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

// Enable pusher logging - don't include this in production
      // Pusher.logToConsole = true;

      var pusher = new Pusher($("#pusher_key").val(), {
        cluster: $("#pusher_cluster").val(),
        encrypted: true
      });

      // Subscribe to the channel we specified in our Laravel Event
      var channel = pusher.subscribe('agendaStatus'+$("#user_type").val()+'.'+$("#user_id").val());

      // Bind a function to a Event (the full Laravel class)
      channel.bind('App\\Events\\AgendaStatusEvento', function(data) {
        //$.notify("Hello World", "success");
        $('a[agenda_id="'+data.agenda.id+'"]').attr('status_id',data.agenda.status_id).html(data.agenda.status_nome);
        $('.atenderId'+data.agenda.id).remove();
        if($('#user_type').val() == 'Medico' && data.agenda.status_nome == 'Presente'){ 
            var linkAtende = $('#rota_atende').val().replace('0',data.agenda.id);
            $('a[idedit="'+data.agenda.id+'"]').parent().prepend('<a title="Atender paciente" data-toggle="tooltip" data-placement="bottom" href="'+linkAtende+'" class="marginIcon atenderId'+data.agenda.id+'"><i class="fas fa-sign-in-alt fa-lg"></i></a>');
        }
        $.notify("Dr(a): O status do paciente "+data.agenda.paciente+" marcado às "+data.agenda.horario+", mudou para "+data.agenda.status_nome+".", "info");
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
