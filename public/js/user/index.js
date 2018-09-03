var table;
table = $('#frm-pesq').DataTable({
    "ajax": {
        "url": $("#base_url").val()+'/usuario/getpesq',
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
           data: 'name',
           className: 'dt-body-center' // Centraliza o conteúdo da TD
        },
        {
           targets: 2,
           data: 'status',
           className: 'dt-body-center' // Centraliza o conteúdo da TD
        },
        {
           targets: 3,
           data:   'id',
           orderable: false, // Habilita ou desabilita ordenação da coluna
           render: function ( data, type, row ) { 
               if ( type === 'display' ) {
                   return '<a title="Editar" href="'+$("#base_url").val()+'/usuario/'+data+'/edit" idEdit="'+data+'" class="editar marginIcon"><i class="fas fa-edit fa-lg"></i></a><a title="Apagar" idDel="'+data+'" titulo="'+row.name+'" href="#" data-toggle="modal" data-target="#modalApagar" class="apagar"><i class="fas fa-trash-alt fa-lg"></a>';
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

$('#frm-pesq tbody').on( 'click', '.apagar', function (event) { 
    event.preventDefault(); 
    $("#frm-deletar").attr('action',$("#rota-deletar").val().replace(0, $(this).attr('idDel')));
    $("#del-id").val($(this).attr('idDel'));
    $("#del-nome").val($(this).attr('titulo'));
});

$("#apagar").on("click", function(){
    $(this).prop('disabled', true).val('Aguarde...');
    $("#frm-deletar").submit();
});