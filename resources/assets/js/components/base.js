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
$(".responsive-calendar").responsiveCalendar({
    startFromSunday: true,
    translateMonths: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    /*time: '2018-07',*/
    onDayClick: function(events) { 
        
        let formataDia = $(this).data('day');
        let formataMes = $(this).data('month');
        
        if($(this).data('day') < 10){
            formataDia = '0'+$(this).data('day');
        }
        
        if($(this).data('month') < 10){
            formataMes = '0'+$(this).data('month');
        }
        
        let data = formataDia+'/'+formataMes+'/'+$(this).data('year');
        /*$(window.document.location).attr('href','http://localhost/consultorio/agenda/secretaria/'+data);*/
        /*alert($(this).data('day')+'/'+$(this).data('month')+'/'+$(this).data('year'));*/
        $(location).attr('href', '/agenda/secretaria/'+data);
    }
});

$(".menu-item").on("click", function(){
    $.blockUI({
        message: '<b style="font-size: 20px">Aguarde...</b>',
        css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
        } 
    }); 
});