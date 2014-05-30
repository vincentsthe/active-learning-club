function infoSuccess(message){
	$('#server-info').html(message);
	$('#server-info').attr('color','2dc400');
}
function infoError(message){
	$('#server-info').html(message);
	$('#server-info').attr('color','ff0000');
}