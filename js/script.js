jQuery(document).ready(function($){

	const ajaxUrl = "https://dev-echo.fr/configurateur/configurateur/";

	$.ajax({
		url:ajaxUrl,
		type:"GET",
		data: {
			'test':1
		}
	});

});