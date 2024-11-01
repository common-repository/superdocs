<style>
	.form-checkbox.is-basic::before,
	.form-radio.is-basic::before {
		background-image: var(--tw-thumb) !important;
		content: var(--tw-content) !important;
	}
</style>
<?php

use DoatKolom\Ui\Utils\Common;
use SuperDocs\Bootstrap\Application;

$demos   = Application::$instance->get_config('demo');
$rootUrl = Application::$instance->get_root_url();
$dataKey = Common::generateRandomString();
?>
<div class="superdocs">
	<div class="h-screen relative" x-data="<?php wp_commander_render($dataKey) ?>">
		<div class="pt-8 w-full h-full flex flex-col">
			<div class="py-4 px-6 border-b">
				<h2 class="text-lg font-semibold text-gray-900">
					<?php esc_html_e('Create Template', 'superdocs') ?>
				</h2>
			</div>
			<div class="overflow-y-scroll p-5 h-screen mb-20">
				<form action="" x-ref="templateForm">
					<div>
						<label class="block text-base"><?php esc_html_e('Template Name', 'superdocs') ?></label>
						<input type="text" required name="template-name" class="mt-2 form-input w-full rounded-lg border border-slate-300 bg-slate-100 px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary" />
					</div>
					<div class="mt-4">
						<label class="block text-base"><?php esc_html_e('Editor', 'superdocs') ?></label>
						<select name="edit_with" class="form-select mt-1.5 w-full max-w-full rounded-lg border border-slate-300  bg-slate-100 px-3 py-2 hover:border-slate-400 focus:border-primary">
							<option value="elementor" selected>Elementor</option>
						</select>
					</div>
					<div class="mt-4">
						<label class="block text-base font-semibold">Select Template</label>
						<div class="mt-2 mb-1 grid grid-cols-3 gap-4">
							<label class="relative group">
								<input type="radio" name="template" value="blank" required checked class="peer absolute z-50 float-right top-2 right-2 form-checkbox is-basic h-5 w-5 rounded bg-slate-100 border-slate-400/70 before:invisible checked:border-primary checked:bg-primary hover:border-primary focus:border-primary">
								<div class="border h-72 overflow-hidden bg-white group-hover:border-primary/50 peer-checked:border-primary/50">
								</div>
								<div class="relative w-full h-12 border-x border-b group-hover:border-primary/50 peer-checked:border-primary/50 bg-white">
									<span class="absolute text-base top-2/4 -translate-y-1/2 pl-4"><?php esc_html_e('Blank', 'superdocs') ?></span>
								</div>
							</label>
							<?php foreach($demos as $key => $demo):
								$screenshotUrl = '';
								if( 'local' === $demo['location'] ) {
									$screenshotUrl = $rootUrl . 'app/Demo/Elementor/'.$key.'/screenshot.webp';
								}
								
								?>
								<label class="relative group">
								<input type="radio" name="template" value="<?php wp_commander_render($key)?>" required checked class="peer absolute z-50 float-right top-2 right-2 form-checkbox is-basic h-5 w-5 rounded bg-slate-100 border-slate-400/70 before:invisible checked:border-primary checked:bg-primary hover:border-primary focus:border-primary">
								<div class="border h-72 overflow-hidden bg-white group-hover:border-primary/50 peer-checked:border-primary/50">
									<img src="<?php wp_commander_render($screenshotUrl)?>">
								</div>
								<div class="relative w-full h-12 border-x border-b group-hover:border-primary/50 peer-checked:border-primary/50 bg-white">
									<span class="absolute text-base top-2/4 -translate-y-1/2 pl-4"><?php wp_commander_render($demo['title']) ?></span>
								</div>
							</label>
							<?php endforeach;?>
						</div>
					</div>
				</form>
			</div>
			<div class="absolute bg-white inline-flex grid-rows-2 grid-flow-col gap-4 border-t bottom-0 right-0 w-full py-4 px-6">
				<button x-on:click="insertAndRedirect()" :class="(submitCreateTemplateRequest ? 'pointer-events-none' : '')" class="w-1/2 cursor-pointer font-semibold px-7 py-3 items-center border border-indigo-200 hover:bg-slate-100 text-primary">
					<div class="pl-6">
						<div class="float-left pt-1" x-show="insertAndRedirectStatus">
							<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
								<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
								<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
							</svg>
						</div>
						<div class="float-left mt-1 pr-3">
							<div class="w-4 h-5">
								<div class="w-3/12 float-left h-full bg-primary"></div>
								<div class="w-2/12 float-left h-full"></div>
								<div class="w-7/12 float-left h-full grid grid-rows-3 gap-1">
									<div class="bg-primary h-full"></div>
									<div class="bg-primary h-full"></div>
									<div class="bg-primary h-full"></div>
								</div>
							</div>
						</div>
						<div class="float-left text-base">
							Edit With Elementor
						</div>
					</div>
				</button>
				<button 
					x-on:click="insertAndReload()" 
					:class="(submitCreateTemplateRequest ? 'pointer-events-none' : '')" 
					class="w-1/2 inline-flex cursor-pointer text-base font-semibold pl-24 py-3 text-white items-center bg-primary hover:bg-primary-hover">
					<svg x-show="insertAndReloadStatus" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
						<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
						<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
					</svg>
					<?php esc_html_e('Save Changes', 'superdocs') ?>
				</button>
			</div>
		</div>
	</div>
</div>
<script>
	Alpine.data("<?php wp_commander_render($dataKey) ?>", () => ({
		submitCreateTemplateRequest: false,
		insertAndReloadStatus: false,
		insertAndRedirectStatus: false,
		insertAndReload() {
			this.insertAndReloadStatus = true;
			this.insert({
				'reload': true
			});
		},
		insertAndRedirect() {
			this.insertAndRedirectStatus = true;
			this.insert({
				'reload': false
			});
		},
		insert(options) {
			let alpineData = this;
			let form = alpineData.$refs.templateForm;
			alpineData.submitCreateTemplateRequest = true;
			var drawer = Alpine.store('DoatKolomUiDrawer');
			drawer.lock();
			jQuery.ajax({
				url: "<?php wp_commander_render(get_rest_url(null, 'superdocs/template/create')) ?>",
				method: 'POST',
				beforeSend: function(xhr) {
					xhr.setRequestHeader('X-WP-Nonce', "<?php wp_commander_render(wp_create_nonce('wp_rest')) ?>");
				},
				data: jQuery(form).serialize(),
				success: function(data) {
					alpineData.$dispatch('notify', { content: data.message, type: 'success' })
					drawer.changeStatus(true);
					if (options.reload) {
						location.reload();
					} else {
						let editUrl = window.location.origin + '/wp-admin/post.php?action=elementor&post=' + data.templateId;
						location.href = editUrl;
					}
				},
				error: function(data) {
					alpineData.$dispatch('notify', { content: data.responseJSON.message, type: 'error' });
					alpineData.submitCreateTemplateRequest = false;
					alpineData.insertAndReloadStatus = false;
					alpineData.insertAndRedirectStatus = false;
					drawer.unLock();
				},
				complete: function() {}
			})
		}
	}));
</script>