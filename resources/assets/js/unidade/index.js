
$('#frm-pesq').DataTable({
    language: { /* Traduz o plugin*/
        url: "js/datatable/language/dataTables.pt-br.json", /* Arquivo de tradução*/
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
    pageLength: 50, /* Define o número de registros por página*/
    drawCallback: function( settings ) { /* Aplica funções javascript no html que esta sendo renderizado no datatable*/
        $('[data-toggle="tooltip"]').tooltip();
    },
    columnDefs: [
        { orderable: false, "targets": 4 }
    ]
});

$('#frm-pesq tbody').on( 'click', '.apagar', function (event) { 
    event.preventDefault(); 
    $("#frm-deletar").attr('action',$("#rota-deletar").val().replace(0, $(this).attr('idDel')));
    $("#del-nome").val($(this).attr('titulo'));
});
