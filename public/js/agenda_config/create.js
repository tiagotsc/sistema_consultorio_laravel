$("#frm").validate({debug:!1,errorClass:"error",errorElement:"p",errorPlacement:function(r,a){a.parents(".form-group").append(r);var e=$(a).next(".help-block").text();$(a).attr("aria-label",e)},highlight:function(r,a){$(r).attr("aria-invalid",!0).parents(".form-group").addClass("has-error")},unhighlight:function(r,a){$(r).removeAttr("aria-invalid").removeAttr("aria-label").parents(".form-group").removeClass("has-error")},rules:{inicio:{required:!0,max:15},fim:{required:!0,min:17},intervalo:{required:!0,max:59}},messages:{inicio:{required:"Informe, por favor!",max:"hora superior a máxima!"},fim:{required:"Informe, por favor!",min:"Hora abaixo da mínima!"},intervalo:{required:"Informe, por favor!",max:"Minutos inválidos!"}}}),$("#salvar").on("click",function(){$("#frm").valid()&&(loadingShow("Gravando..."),$(this).prop("disabled",!0).html("Aguarde..."),$("#frm").submit())});