<script>
	(function($) {
		$('.page-title-action').removeAttr('href');
		$('.type-<?php wp_commander_render( superdocs_post_type() )?> .row-title').each((index, element) => {
			element.innerHTML = element.innerHTML.replaceAll('— ', '');
			$(element).closest('strong').html($(element).closest('strong a').prop("outerHTML"))
		})
		$('.type-<?php wp_commander_render( superdocs_post_type() )?>').each((index, element) => {
			element.innerHTML = element.innerHTML.replaceAll('— ', '');
			$(element).closest('strong').html($(element).closest('strong a').prop("outerHTML"))
		});

		$('.inline-edit-wrapper .inline-edit-col-right .inline-edit-col').append($('.inline-edit-wrapper .superdocs-product').html())
		$('.inline-edit-wrapper .superdocs-product').remove()
	})(jQuery)
</script>