function elimSomethig(id,url) {
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: {id: id},
		beforeSend:function() {
			$('.envElim').after('<img src="http://localhost/carphone/public/images/loader.gif" class="miniLoader">');
			$('.envElim').addClass('disabled');
		},
		success:function(response)
		{
			$('.miniLoader').remove();
			$('.envElim').removeClass('disabled');
			$('.responseDanger').addClass('alert-'+response.type).html(response.msg).show('fast');
			if (response.type == 'success') {
				$('.to-elim').parent('td').parent('tr').remove();
			};
			$('.modal').modal('hide');
			setTimeout(function() {
				$('.responseDanger').hide('fast').removeClass('alert-'+response.type)
			},5000);
		}
	})
	
}
jQuery(document).ready(function($) {
	$('.elimBtn').on('click',function(event) {
		$(this).addClass('to-elim');
		$('.envElim').val($(this).val())
		$('.envElim').attr('data-url',$(this).data('url'));
	});
	$('.envElim').on('click',function() {
		elimSomethig($(this).val(),$(this).data('url'));
	})
	$('.modal').on('hide.bs.modal', function(event) {
		$('.to-elim').removeClass('to-elim');
	});
});