var table = $('#frm-pesq').DataTable({
    "ajax": {
        "url": $("#base_url").val()+'/funcionario/getpesq',
        "type": 'GET',
        "data": function(data){ // Criando a function ele pega os dados do inputs dinamicamente
           /*data.nome = $("#nome").val();
           data.email = $("#email").val();
           data.status = $("#status").val();*/
        }
    },
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
                   return '<a href="#" idEdit="'+data+'" class="editar">Editar</a><a idDel="'+data+'" titulo="'+row.nome+'" href="#" class="apagar">Apagar</a>';
               }
               return data;
           },
           className: 'dt-body-center' // Centraliza o conteúdo da TD
        }
    ]
});