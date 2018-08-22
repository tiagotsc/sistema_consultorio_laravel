var table;
table = $('#frm-pesq').DataTable({
    "ajax": {
        "url": $("#base_url").val()+'/funcionario/getpesq',
        "type": 'POST',
        "data": function(data){ // Criando a function ele pega os dados do inputs dinamicamente
            data._token = $( "input[name='_token']" ).val();
            data.nome_cpf = $("#nome_cpf").val();
           //data.email = $("#email").val();
           //data.status = $("#status").val();
        }
    },
    'processing': true,
    'columnDefs': [
        {
           targets: 0, 
           data: 'matricula', 
           className: 'dt-body-center'
        },
        {
           targets: 1, 
           data: 'nome',
           className: 'dt-body-center' // Centraliza o conteúdo da TD
        },
        {
           targets: 2,
           data: 'status',
           className: 'dt-body-center' // Centraliza o conteúdo da TD
        },
        {
            targets: 3,
            data: 'idPerfil',
            className: 'dt-body-center' // Centraliza o conteúdo da TD
        },
        {
           targets: 4,
           data:   'id',
           orderable: false, // Habilita ou desabilita ordenação da coluna
           render: function ( data, type, row ) { 
               if ( type === 'display' ) {
                   return '<a href="'+$("#base_url").val()+'/funcionario/edit/'+data+'" idEdit="'+data+'" class="editar">Editar</a><a idDel="'+data+'" titulo="'+row.nome+'" href="#" class="apagar">Apagar</a>';
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