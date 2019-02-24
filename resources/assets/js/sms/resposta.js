$("#verificar").on("click", function(){
	$(this).prop('disabled', true).html('Aguarde...');
	$('#frm').submit();
});