var table;
table = $('#frm-pesq').DataTable({
    language: { // Traduz o plugin
        url: "js/datatable/language/dataTables.pt-br.json", // Arquivo de tradução
        select: { // Tradução encima das operações de seleção de linha
            rows: { // Tradução para o Footer da tabela
                _: "Você selecionou %d linhas", // Footer -> Tradução para mais de uma linha selecionada
                0: "Clique na linha para selecionar", // Footer -> Tradução para nenhuma linha selecionada
                1: "Apenas 1 linha foi selecionada" // Footer -> Tradução para apenas uma linha selecionada
            }
        },
        buttons: { // Tradução encima da mensagem do botão de cópia
            copyTitle: 'Tabela copiada',
            copySuccess: {
                _: '%d linhas copiadas',
                1: '1 linha copiada'
            }
        }
    },
    ajax: {
        "url": $("#rota_ajax").val(),
        "type": 'POST',
        "data": function(data){ // Criando a function ele pega os dados do inputs dinamicamente
            data._token = $( "input[name='_token']" ).val();
            data.nome = $("#nome").val();
           //data.email = $("#email").val();
           //data.status = $("#status").val();
        }
    },
    drawCallback: function( settings ) { // Aplica funções javascript no html que esta sendo renderizado no datatable
        $('[data-toggle="tooltip"]').tooltip();
    },
    processing: true,
    columnDefs: [
        {
           targets: 0, 
           data: 'name',
           className: 'dt-body-center' // Centraliza o conteúdo da TD
        },
        {
           targets: 1,
           data:   'id',
           orderable: false, // Habilita ou desabilita ordenação da coluna
           render: function ( data, type, row ) { 
               if ( type === 'display' ) {
                   var bt = '';
                   if($("#all_permissions").val().indexOf('perfil-editar') > -1){
                       bt += '<a title="Editar" data-toggle="tooltip" data-placement="bottom" href="'+$("#base_url").val()+'/roles/'+data+'/edit" idEdit="'+data+'" class="editar marginIcon"><i class="fas fa-edit fa-lg"></i></a>';
                   }
                   return bt;
               }
               return data;
           },
           className: 'dt-body-center' // Centraliza o conteúdo da TD
        }
    ]
});

$("#pesq").on('click', function(){
    table.clear().draw();
    table.ajax.reload();
});
