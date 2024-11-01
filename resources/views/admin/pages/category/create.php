<?php

use DoatKolom\Ui\Utils\Common;
use SuperDocs\Bootstrap\View;

$dataKey = Common::generateRandomString(10);

?>

<div class="p-7" x-data="<?php wp_commander_render($dataKey) ?>">
	<h2 class="line-clamp-1 dark:text-navy-100 text-xl font-bold tracking-wide text-slate-700 lg:text-base"><?php esc_html_e('Create Category', 'superdocs')?></h2>
	<hr class="mt-2" />
	<div class="mt-4">
		<form action="" method="post" @submit.prevent="sendCategoryCreateRequest($data)">
			<input type="hidden" name="productId" value="<?php wp_commander_render($productId)?>">
			<div class="mb-5">
				<label class="block">
					<span class="text-base"><?php esc_html_e('Category Name', 'superdocs')?>:</span>
					<input name="categoryName" required class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-1.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary" placeholder="Category Name" type="text" />
				</label>
			</div>
			<button 
				:class="(sendCategoryCreateRequestStatus ? 'pointer-events-none' : '')" 
				class="btn mt-2 inline-flex cursor-pointer rounded-md bg-success py-2 px-8 font-semibold text-white hover:bg-success-hover focus:bg-success-hover active:bg-success-hover/90">
				<svg x-show="sendCategoryCreateRequestStatus" class="animate-spin -ml-1 mr-3 h-5 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
					<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
					<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
				</svg>	
				<?php esc_html_e('Submit', 'superdocs')?>
			</button>	
		</form>
	</div>
</div>
<script>
	Alpine.data('<?php wp_commander_render( $dataKey )?>', () => ({
		sendCategoryCreateRequestStatus: false,
		sendCategoryCreateRequest($data) {
			this.sendCategoryCreateRequestStatus = true;
			var modal = Alpine.store('DoatKolomUiModal');
			modal.lock();
			var alpineData = this;
			var form = alpineData.$el;
			var jqueryForm = jQuery(form);
			var formSubmitButton = form.querySelector('button');
			formSubmitButton.disabled = true;
			formSubmitButton.classList.remove('cursor-pointer');
			jQuery.ajax({
				url: "<?php wp_commander_render( get_rest_url( null, 'superdocs/category/create' ) )?>",
				method: 'POST',
				beforeSend: function(xhr) {
					xhr.setRequestHeader( 'X-WP-Nonce', "<?php wp_commander_render(wp_create_nonce('wp_rest'))?>" );
				},
				data: jqueryForm.serialize(),
				success: function(data) {
					alpineData.$dispatch('notify', { content: data.message, type: 'success' })
					modal.getCategories.accordions.push(data);
				},
				complete: function() {
					alpineData.sendCategoryCreateRequestStatus = false;
					modal.changeStatus(true);
					formSubmitButton.disabled = false;
					formSubmitButton.classList.add('cursor-pointer');
					jqueryForm[0].reset();
  					<?php View::render( 'admin/pages/category/sortjs', ['productId' => $productId] );?>
				}
			})
		}
	}));
</script>