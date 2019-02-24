
$('#frm-pesq').DataTable({
    language: { /* Traduz o plugin*/
        url: "/js/datatable/language/dataTables.pt-br.json", /* Arquivo de tradução*/
        select: { /* Tradução encima das operações de seleção de linha*/
            rows: { /* Tradução para o Footer da tabela
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
    pageLength: 100, /* Define o número de registros por página*/
    drawCallback: function( settings ) { /* Aplica funções javascript no html que esta sendo renderizado no datatable*/
        $('[data-toggle="tooltip"]').tooltip();
    },
    columnDefs: [
        { orderable: false, "targets": 0 },
        { orderable: false, "targets": 5 }
    ],
    "order": []
});

$("#confirmar").on("click", function(){
    $(this).prop('disabled', true).html('Aguarde...');
    $("#frm").submit();
});

var contMarcado = 0;

$("#todos").on("click", function(){  
    if($(this).prop('checked') == true){
        contMarcado = $(".check_individual:checkbox").length;
        $("input:checkbox").prop('checked', true);
        $( ".desativados" ).prop( "disabled", false );
    }else{
        contMarcado = 0;
        $("input:checkbox").prop('checked', false);
        $( ".desativados" ).prop( "disabled", true );
    }
    $("#qtd_sms").html(contMarcado);
});

$(".check_individual").on("click", function(){  
    if($(this).prop('checked') == true){
        contMarcado++;
        $( "input[name='celular["+$(this).val()+"]']" ).prop( "disabled", false );
        $( "input[name='msg["+$(this).val()+"]']" ).prop( "disabled", false );
    }else{
        $( "input[name='celular["+$(this).val()+"]']" ).prop( "disabled", true );
        $( "input[name='msg["+$(this).val()+"]']" ).prop( "disabled", true );
        $("#todos:checkbox").prop('checked', false);
        contMarcado--;
    }
    $("#qtd_sms").html(contMarcado);
});