<?php

$docsParentClass     = 'superdocs_product_content_' . $productId;
$categoryParentClass = 'superdocs_product_' . $productId;
$sortMethod          = 'superdocs_sort_'. $productId;

?>
jQuery( function($) {
	var	<?php wp_commander_render($sortMethod) ?> = function(event, ui) {
		if(event.type === 'sortstop') {
			/**
			 * check if dragged is docs
			 */
			let draggedDocs = {};

			if(!ui.item[0].classList.contains('accordionItem')) {
				var category = ui.item[0].closest('.<?php wp_commander_render($docsParentClass)?>');
				draggedDocs  = { categoryPostId: category.dataset.category, docId: ui.item[0].dataset.doc };
			}

			let categoriesElement = document.querySelector(".<?php wp_commander_render($categoryParentClass) ?>");
			var categories = [];
			for (let category of categoriesElement.children) {
				var docsElement = category.querySelector('.<?php wp_commander_render($docsParentClass) ?>');
				if(docsElement) {
					var docs = [];
					for(let doc of docsElement.children) {
						docs.push(doc.dataset.doc);
					}
					categories.push({'categoryPostId': docsElement.dataset.category, docs});
				}
			}
			jQuery.ajax({
				url: "<?php wp_commander_render( get_rest_url( null, 'superdocs/category/order' ) )?>",
				method: 'POST',
				beforeSend: function(xhr) {
					xhr.setRequestHeader( 'X-WP-Nonce', "<?php wp_commander_render( wp_create_nonce( 'wp_rest' ) )?>" );
				},
				data: { categories, draggedDocs, productId: '<?php wp_commander_render($productId) ?>' },
				success(data) {
					document.getElementById('notifications').dispatchEvent(
						new CustomEvent('notify', {
							detail: { 
								content: data.message, 
								type: 'success' 
							},
							bubbles: true
						})
					);
				}
			})
		}
	}

	/**
	 * Category sort
	 */
    var <?php wp_commander_render($categoryParentClass) ?> = $( ".<?php wp_commander_render($categoryParentClass) ?>" );
    <?php wp_commander_render($categoryParentClass) ?>.sortable({
        stop: <?php wp_commander_render($sortMethod) ?>,
		connectWith: ".<?php wp_commander_render($categoryParentClass) ?>"
    }).disableSelection();
    <?php wp_commander_render($categoryParentClass) ?>.on("sortchange",<?php wp_commander_render($sortMethod) ?>);

	/**
	 * Docs sort
	 */
    var <?php wp_commander_render($docsParentClass) ?> = $( ".<?php wp_commander_render($docsParentClass) ?>" );
    <?php wp_commander_render($docsParentClass) ?>.sortable({
        stop: <?php wp_commander_render($sortMethod) ?>,
		connectWith: ".<?php wp_commander_render($docsParentClass) ?>"
    }).disableSelection();
    <?php wp_commander_render($docsParentClass) ?>.on("sortchange",<?php wp_commander_render($sortMethod) ?>);
} );