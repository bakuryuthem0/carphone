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
				$('.to-elim').parent('div').parent('div').remove();
			};
			$('.modal').modal('hide');
			setTimeout(function() {
				$('.responseDanger').hide('fast').removeClass('alert-'+response.type)
			},5000);
		}
	})
	
}
jQuery(document).ready(function($) {
	$('.elimColorForm').unbind('submit');
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
	$('.addColor').on('click', function(event) {
		event.preventDefault()
		var cont = $('.newColor.hidden:last');
		var prevId = cont.attr('id');
		var newId  = 'item_'+(parseInt(prevId.substr(-1))+1);
		var clon   = cont.clone();
		cont.removeClass('hidden');
		cont.after(clon)
		clon.removeAttr('id').attr('id',newId).addClass('hidden');
		var colorInput = clon.children('.contColorClon').children('.inputColor');
		var stockInput = clon.children('.contStockClon').children('.inputStock');

		var colorNamePrev = parseInt(colorInput.attr('name').slice(16,colorInput.attr('name').length-1))+1;
		var stockNamePrev = parseInt(stockInput.attr('name').slice(16,stockInput.attr('name').length-1))+1;

		colorInput.attr('name','item_colorNuevo['+colorNamePrev+']');
		stockInput.attr('name','item_stockNuevo['+stockNamePrev+']');
		clon.children('.contDelButton').children('.borrarColor').attr('data-target','#'+newId);
		$('.borrarColor').bind('click')
	});
	$('body').on('click', '.borrarColor',function(event) {
		event.preventDefault();
		var target = $(this).data('target');
		$(target).remove();
	});
	$('.btnSendColors').on('click', function(event) {
		$('.elimColorForm').submit();
	});
});