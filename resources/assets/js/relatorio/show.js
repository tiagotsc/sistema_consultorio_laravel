/*$.getScript('/assets/plugins/bootstrap/4.1.3/js/bootstrap.bundle.min.js', function()
{
    $.getScript('/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', function()
    {
        $.getScript('/assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js', function()
        {
            $.getScript('/js/jquery.mask.min.js', function()
            {
                $.getScript('/js/jquery.validate.min.js', function()
                {*/
                    $.getScript('/js/personalizado.js', function()
                    {
                
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
                            }
                        });
                        
                        $("#salvar").on("click", function(){
                            if($("#frm").valid()){
                                //loadingShow('Gravando...');
                                //$(this).prop('disabled', true).html('Aguarde...');
                                $('#frm').submit();
                            }
                        });

                        $( $("input[tipo]") ).each(function() {
                            if($(this).attr('mascara') !== undefined){
                                if($(this).attr('tipo') == 'dinheiro' || $(this).attr('tipo') == 'numero'){
                                    $(this).mask($(this).attr('mascara'), {reverse: true});
                                }else{
                                    $(this).mask($(this).attr('mascara'));
                                }
                            }
                            if($(this).attr('tipo') == 'data'){
                                $($(this)).datepicker({
                                    format: 'dd/mm/yyyy',
                                    autoclose: 'true',
                                    language: 'pt-BR',
                                    weekStart: 0,
                                    //startDate:'0d',
                                    todayHighlight: true
                                }).on('changeDate', function(valor) {
                                    /*let dataFull = valor.date.getDate()+'/'+valor.date.getMonth()+'/'+valor.date.getFullYear();*/
                                    /*alert($('.data').val());*/
                                });
                            }
                            if($(this).attr('tipo') == 'mesano'){
                                $(this).datepicker({
                                    autoclose: true,
                                    minViewMode: 1,
                                    format: 'mm/yyyy',
                                    language: 'pt-BR'
                                });
                            }
                            if($(this).attr('tipo') == 'horario'){
                                $(this).horario();
                                $(this).mask('00:00');
                            }
                            if($(this).attr('obrigatorio') == 'S'){
                                $(this).rules('add', {
                                    required: true,
                                    messages: {
                                            required: "Informe, por favor."
                                    }
                                });
                            }
                        });

                        $(function () {
                            $('[data-toggle="tooltip"]').tooltip()
                        });

                   });
                /*});
            });
        });
    });
//});*/