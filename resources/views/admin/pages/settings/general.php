<?php

use DoatKolom\Ui\Utils\Common;

$dataKey = Common::generateRandomString();
?>
<div class="px-6" x-data="<?php wp_commander_render($dataKey)?>">
	<form @submit.prevent="saveGeneralSettings" class="generalSettingsForm">
		<table class="border-separate border-spacing-y-6">
			<tbody>
			<?php foreach( superdocs_general_settings() as $name => $input ):
					switch ($input['type']) {
						case 'checkbox':
							?>
							<tr>
								<th class="w-72 text-left">
									<label class="text-base font-semibold">
										<?php wp_commander_render($input['title']) ?>
									</label>
								</th>
								<td class="inline-flex gap-6 font-medium text-sm">
									<?php foreach($input['options'] as $option):?>
										<span>
											<input 
												type="checkbox" 
												id="<?php wp_commander_render( $option['value'] ) ?>"
												<?php wp_commander_render( $input['required'] ? 'required' : '' ) ?> 
												<?php wp_commander_render( in_array($option['value'], $input['value']) ? 'checked' : '' ) ?> 
												name="settings[<?php wp_commander_render( $name ) ?>][]"
												value="<?php wp_commander_render( $option['value'] ) ?>"
												class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 before:invisible checked:border-primary checked:bg-primary hover:border-primary focus:border-primary">
											<label for="<?php wp_commander_render( $option['value'] ) ?>">
												<?php wp_commander_render($option['title']) ?>
											</label>
										</span>
									<?php endforeach;?>
								</td>
							</tr>
							<?php
							break;
						default:
							?>
							<tr>
								<th class="w-72 text-left">
									<label class="text-base font-semibold">
										<?php wp_commander_render($input['title']) ?>
									</label>
								</th>
								<td>
									<input 
										type="text" 
										<?php wp_commander_render($input['required'] ? 'required' : '') ?> 
										name="settings[<?php wp_commander_render($name) ?>]" 
										value="<?php wp_commander_render($input['value']) ?>" 
										class="w-[400px] form-input rounded-lg border border-slate-300 bg-slate-100 px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary" />
								</td>
							</tr>
							<?php
						break;
					}
				?>
				<?php endforeach;?>
				
			</tbody>
		</table>

		<button 
			class="inline-flex mt-7 font-semibold rounded-md px-7 py-3 text-white items-center bg-primary hover:bg-primary-hover" 
			:class="(submitGeneralSettingRequest ? 'pointer-events-none' : '')">
			<svg x-show="submitGeneralSettingRequest" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
				<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
				<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
			</svg>
		<?php esc_html_e('Save Changes', 'superdocs')?>
		</button>
	</form>
</div>
<script>
	Alpine.data("<?php wp_commander_render($dataKey)?>", () =>  ({
		submitGeneralSettingRequest: false,
		saveGeneralSettings() {
			let alpineData = this;
			alpineData.submitGeneralSettingRequest = true;
			jQuery(function ($) {
				$.ajax({
					url: "<?php wp_commander_render( get_rest_url( null, 'superdocs/settings/general' ) )?>",
					method: 'POST',
					beforeSend: function(xhr) {
						xhr.setRequestHeader( 'X-WP-Nonce', "<?php wp_commander_render(wp_create_nonce('wp_rest'))?>" );
					},
					data: $(alpineData.$el).serialize(),
					success: function(data) {
						alpineData.$dispatch('notify', { content: data.message, type: 'success' })
						alpineData.submitGeneralSettingRequest = false;
					},
					complete: function() {}
				})
			})
		}
	}))
	
</script>