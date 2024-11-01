<style>
	.select2-results .select2-results__option {
		margin: 0 !important;
	}
	.select2-dropdown {
		border: 1px solid rgb(148 163 184);
	}
	.select2-container {
		width: 100% !important;
	}
</style>
<div class="create-modal">
	<div class="p-7" x-data="DkUiModalSubmit">
		<h2 class="line-clamp-1 dark:text-navy-100 text-xl font-bold tracking-wide text-slate-700 lg:text-base">
			<?php esc_html_e( 'Create Document', 'superdocs' )?>
		</h2>
		<hr class="mt-2" />
		<div class="mt-4" x-init="api='<?php wp_commander_render( get_rest_url( null, 'superdocs/doc/create' ) )?>'">
			<form @submit.prevent="sendRequest">
				<div class="mb-5">
					<label class="block" x-data="DoatKolomUiInput" x-init="name='doc_title'">
						<span class="text-base"><?php esc_html_e( 'Enter Document Title', 'superdocs' )?>:</span>
						<input x-bind="input" required class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-1.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary" type="text" />
					</label>
				</div>
				<div class="mb-5">
					<label class="block">
						<span class="text-base"><?php esc_html_e( 'Select Product', 'superdocs' )?>:</span>
						<div x-data="DoatKolomUiSelect2" class="w-full mt-1.5" x-init="
							api='<?php wp_commander_render( get_rest_url( null, 'superdocs/product' ) )?>';
							name='product';
							select2Init();
						">
							<select x-ref="select2" :multiple="multiple" required class="w-full"></select>
						</div>
					</label>
				</div>
				<button
					:class="(sendRequestStatus ? 'pointer-events-none' : '')"
					class="btn mt-2 inline-flex cursor-pointer rounded-md bg-success py-2 px-8 font-semibold text-white hover:bg-success-hover focus:bg-success-hover active:bg-success-hover/90">
					<svg x-show="sendRequestStatus" class="animate-spin -ml-1 mr-3 h-5 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
						<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
						<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
					</svg>
					<?php esc_html_e( 'Submit', 'superdocs' )?>
				</button>
			</form>
		</div>
	</div>
</div>