$(document).ready(function(){
	$('#add-img').click(function(){
		$('#insert').append('<div class="form-group"><input type="file" name="fProductDetail[]"></div>');
	});
});