$(document).ready(function () {
	$('#error_1_id_public_key strong').each(function () {
		var text = $(this).text();
		if(text == 'Your license has taken by another user' || 
		   text == 'Su licencia ya está siendo usada por otro usuario') {
			$('#myModal').modal();
		}
	});
});
