$(".campos").hide(),$(".ordem_mask").mask("0"),$("#frm").validate({debug:!1,errorClass:"error",errorElement:"p",errorPlacement:function(e,r){r.parents(".form-group").append(e);var a=$(r).next(".help-block").text();$(r).attr("aria-label",a)},highlight:function(e,r){$(e).attr("aria-invalid",!0).parents(".form-group").addClass("has-error")},unhighlight:function(e,r){$(e).removeAttr("aria-invalid").removeAttr("aria-label").parents(".form-group").removeClass("has-error")},rules:{relatorio_categoria_id:{required:!0},nome:{required:!0},descricao:{required:!0},banco_conexao:{required:!0},query:{required:!0}},messages:{relatorio_categoria_id:{required:"Selecione, por favor!"},nome:{required:"Informe, por favor!"},descricao:{required:"Informe, por favor!"},banco_conexao:{required:"Selecione, por favor!"},query:{required:"Cole a query, por favor!"}}}),$("#salvar").on("click",function(){$("#frm").valid()&&($.each($(".campo_nome"),function(){if(""==$(this).val()){var e=$(this).attr("cont");$(".campo_legenda"+e).remove(),$(".campo_ordem"+e).remove(),$(this).remove()}}),$(this).prop("disabled",!0).html("Aguarde..."),$("#frm").submit())}),$("#add_sumarizar").on("click",function(e){e.preventDefault();var r=$("input[name^='campo_observado']").length;if(4==r)return alert("Limite máximo alcançado!"),!1;var a="<tr>";a+='<td class="tableSemPadding form-group"><input type="text" class="form-control" name="campo_observado['+r+']"></td>',a+='<td class="tableSemPadding form-group"><input type="text" class="form-control" name="campos_sumarizados['+r+']"></td>',a+='<td class="tableSemPadding align-middle" width="7px"><a href="#" data-toggle="tooltip" data-placement="bottom" title="Remover" class="remover_sumarizacao"><i class="fas fa-minus-circle fa-lg"></i></a></td>',$("#sumarizacao_adicionada").append(a),$('[data-toggle="tooltip"]').tooltip(),$(".remover_sumarizacao").on("click",function(e){e.preventDefault(),$(this).parent().parent().remove()}),$('[name*="campo_observado"]').each(function(){$(this).rules("add",{required:!0,messages:{required:"Informe, por favor."}})}),$('[name*="campos_sumarizados"]').each(function(){$(this).rules("add",{required:!0,messages:{required:"Informe, por favor."}})})}),$(".marcado").on("click",function(){var e=$(this).attr("identcampo");1==$(this).prop("checked")?($("input[name='campo_nome["+e+"]']").show().rules("add",{required:!0,messages:{required:"Preencha, por favor."}}),$("input[name='campo_legenda["+e+"]']").show().rules("add",{required:!0,messages:{required:"Preencha, por favor."}}),$("input[name='campo_ordem["+e+"]']").show(),$("select[name='campo_obrigatorio["+e+"]']").show()):($("input[name='campo_nome["+e+"]']").hide().rules("remove"),$("input[name='campo_legenda["+e+"]']").hide().rules("remove"),$("input[name='campo_ordem["+e+"]']").hide(),$("select[name='campo_obrigatorio["+e+"]']").hide())}),$(".perfil_checkbox").shiftcheckbox(),$("#todos").on("click",function(){1==$(this).prop("checked")?$(".perfil_checkbox").prop("checked",!0):$(".perfil_checkbox").prop("checked",!1)}),$(".campo_marcado,.campo_marcado_obrigatorio,.campo_marcado_ordem").show(),$(".campo_marcado").length>0&&$(".campo_marcado").each(function(){$(this).rules("add",{required:!0,messages:{required:"Informe, por favor."}})}),$("input[name^='campo_observado']").length>0&&($('[name*="campo_observado"]').each(function(){$(this).rules("add",{required:!0,messages:{required:"Informe, por favor."}})}),$('[name*="campos_sumarizados"]').each(function(){$(this).rules("add",{required:!0,messages:{required:"Informe, por favor."}})}),$(".remover_sumarizacao").on("click",function(e){e.preventDefault(),$(this).parent().parent().remove()}));