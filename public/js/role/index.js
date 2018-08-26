var table;
table = $('#frm-pesq').DataTable({
    "ajax": {
        "url": $("#rota_ajax").val(),
        "type": 'POST',
        "data": function(data){ // Criando a function ele pega os dados do inputs dinamicamente
            data._token = $( "input[name='_token']" ).val();
            data.nome = $("#nome").val();
           //data.email = $("#email").val();
           //data.status = $("#status").val();
        }
    },
    'processing': true,
    'columnDefs': [
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
                   return '<a title="Editar" href="'+$("#base_url").val()+'/roles/'+data+'/edit" idEdit="'+data+'" class="editar marginIcon"><i class="fas fa-edit fa-lg"></i></a>';
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
