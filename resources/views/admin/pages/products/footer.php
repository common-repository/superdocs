<script>
	(function($) {
		$('.page-title-action').removeAttr('href');
		let menus = $('#toplevel_page_superdocs-menu li');
		$(menus[1]).removeClass('current');
		$(menus[2]).addClass('current');
		$('.wrap .subsubsub a').each((index, element) => {
			element = $(element);
			element.attr('href', element.attr('href') + '&product=true')
		})
		$('#posts-filter').append("<input type='hidden' name='product' value='true'>");
		$('.tablenav-pages a').each((index, element) => {
			element = $(element);
			element.attr('href', element.attr('href') + '&product=true')
		})
		$('.inline-edit-wrapper .inline-edit-col-right .inline-edit-col').append($('.inline-edit-wrapper .superdocs-product').html())
		$('.inline-edit-wrapper .superdocs-product').remove()
	})(jQuery)
</script>
