$("#frm-pesq").DataTable({language:{url:"js/datatable/language/dataTables.pt-br.json",select:{rows:{0:"Clique na linha para selecionar",1:"Apenas 1 linha foi selecionada"}},buttons:{copyTitle:"Tabela copiada",copySuccess:{_:"%d linhas copiadas",1:"1 linha copiada"}}},pageLength:50,drawCallback:function(a){$('[data-toggle="tooltip"]').tooltip()},columnDefs:[{orderable:!1,targets:3}]}),$(".apagar").on("click",function(a){a.preventDefault(),$("#frm-deletar").attr("action",$("#rota-deletar").val().replace(0,$(this).attr("idDel"))),$("#del-nome").val($(this).attr("titulo"))});