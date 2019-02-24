moment.locale('pt-br');

$('.data').datepicker({
    format: 'dd/mm/yyyy',
    autoclose: 'true',
    language: 'pt-BR',
    weekStart: 0,
    /*startDate:'0d',*/
    todayHighlight: true
}).on('changeDate', function(valor) {
    /*let dataFull = valor.date.getDate()+'/'+valor.date.getMonth()+'/'+valor.date.getFullYear();*/
    /*alert($('.data').val());*/
});

$('.data').mask('00/00/0000');
$('.telefone').mask('(00) 0000-0000');
$('.celular').mask('(00) 0000-00000');
$('.cep').mask('00000-000');
$('.cpf').mask('000.000.000-00');

var agendamentosRetornados = ($("#todos_agendamentos").length > 0)? $("#todos_agendamentos").val(): "[]";

$(".responsive-calendar").responsiveCalendar({
    startFromSunday: true,
    translateMonths: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    time: moment().format('YYYY-MM'),
    onDayClick: function(events) { 
        
        var formataDia = $(this).data('day');
        var formataMes = $(this).data('month');
        
        if($(this).data('day') < 10){
            formataDia = '0'+$(this).data('day');
        }
        
        if($(this).data('month') < 10){
            formataMes = '0'+$(this).data('month');
        }
        
        var dataCompleta = formataDia+'/'+formataMes+'/'+$(this).data('year');
        loadingShow();
        $(location).attr('href', '/agenda/'+dataCompleta);
    },
    events: JSON.parse(agendamentosRetornados)
});

$(".menu-item").on("click", function(){
    loadingShow();
});
$("a[active='sim']").css('color', '#007bff'); //Deixa o link do menu ativo destacado

$("#apagar").on("click", function(){
    $(this).prop('disabled', true).val('Aguarde...');
    $("#frm-deletar").submit();
});

getEstatistica();

function getEstatistica(){
    if($("#rota_estatistica").length > 0){
        var dataEstatistica = ($('input[name="data"]').length > 0 )? $('input[name="data"]').val() : '';
        var unidade = ($('#unidade').length > 0 )? '/'+$('#unidade').val() : '';
        $.getJSON( $("#rota_estatistica").val()+'/'+dataEstatistica+unidade, function( data ) {
            $("#data_estatistica").html(data.data);
            $("#atendidos").attr('style','width: '+data.porc_atendidos+'%').attr('aria-valuenow',data.porc_atendidos).attr('title',data.porc_atendidos+'%').attr('data-original-title',data.porc_atendidos+'%');
            $("#ausentes").attr('style','width: '+data.porc_ausentes+'%').attr('aria-valuenow',data.porc_ausentes).attr('title',data.porc_ausentes+'%').attr('data-original-title',data.porc_ausentes+'%');
            $("#desistiu").attr('style','width: '+data.porc_desistiu+'%').attr('aria-valuenow',data.porc_desistiu).attr('title',data.porc_desistiu+'%').attr('data-original-title',data.porc_desistiu+'%');
            $('[data-toggle="tooltip"]').tooltip();
        });
    }
}

$('[data-toggle="tooltip"]').tooltip();

var pusher = new Pusher($("#pusher_key").val(), {
    cluster: $("#pusher_cluster").val(),
    encrypted: true
});

//Pusher.logToConsole = true;
var channel = pusher.subscribe('consultas_acompanhamento');
// Bind a function to a Event (the full Laravel class)
channel.bind('App\\Events\\AgendaStatusEvento', function(data) {
    if($("#data_hoje").val() == data.agenda.data){
        getEstatistica();
    }
});
