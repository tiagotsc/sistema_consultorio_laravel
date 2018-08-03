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

$(".responsive-calendar").responsiveCalendar({
    startFromSunday: true,
    translateMonths: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    /*time: '2018-07',*/
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
        /*$(window.document.location).attr('href','http://localhost/consultorio/agenda/secretaria/'+data);*/
        /*alert($(this).data('day')+'/'+$(this).data('month')+'/'+$(this).data('year'));*/
        $(location).attr('href', '/agenda/secretaria/'+dataCompleta);
    }
});

$(".menu-item").on("click", function(){
    loadingShow();
});

/*
$(".cep").on('keyup', function(){
    if($(this).val().length == 9){ // CEP Completo
        $.get( 'http://api.postmon.com.br/v1/cep/'+$(this).val(), function( res ) {
          alert(res.bairro);
        }, "json" );
    }
});*/

