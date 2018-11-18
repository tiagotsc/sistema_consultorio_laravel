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

$(".responsive-calendar").responsiveCalendar({
    startFromSunday: true,
    translateMonths: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    time: moment().format('YYYY-MM'),
    onDayClick: function(events) { 
        
        let formataDia = $(this).data('day');
        let formataMes = $(this).data('month');
        
        if($(this).data('day') < 10){
            formataDia = '0'+$(this).data('day');
        }
        
        if($(this).data('month') < 10){
            formataMes = '0'+$(this).data('month');
        }
        
        var dataCompleta = formataDia+'/'+formataMes+'/'+$(this).data('year');
        if(moment().isAfter(dataCompleta.split('/').reverse().join('-')+' 23:59:00')){
            $.notify("Data inferior a data atual", "warn");
        }else{
            loadingShow();
            $(location).attr('href', '/agenda/'+dataCompleta);
        }
    },
    events: JSON.parse($("#todos_agendamentos").val())
});

$(".menu-item").on("click", function(){
    loadingShow();
});
$("a[active='sim']").css('color', '#007bff'); /* Deixa o link do menu ativo destacado*/

$("#apagar").on("click", function(){
    $(this).prop('disabled', true).val('Aguarde...');
    $("#frm-deletar").submit();
});


/*
$(".cep").on('keyup', function(){
    if($(this).val().length == 9){ // CEP Completo
        $.get( 'http://api.postmon.com.br/v1/cep/'+$(this).val(), function( res ) {
          alert(res.bairro);
        }, "json" );
    }
});*/

