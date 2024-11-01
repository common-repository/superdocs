<div x-data="<?php wp_commander_render( $categoryActionKey )?>">
	<button type="button" x-on:click="showCategoryEditAlert($data)" class="rounded-md text-xs px-4 py-0.5 shadow text-neutral-50 !bg-amber-400" data-categorypostid="<?php wp_commander_render( $categoryId )?>">
		<?php esc_html_e( 'Edit', 'superdocs' )?>
	</button>
	<button type="button" x-on:click="showCategoryDeleteAlert($data)" class="rounded-md text-xs px-4 py-0.5 mr-7 shadow text-neutral-50 !bg-danger hover:bg-danger-hover" data-categorypostid="<?php wp_commander_render( $categoryId )?>">
		<?php esc_html_e( 'Delete', 'superdocs' )?>
	</button>
</div>