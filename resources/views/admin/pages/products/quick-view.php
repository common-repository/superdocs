<div class="superdocs-product">
	<div class="inline-edit-group wp-clearfix">
		<label class="inline-edit-status alignleft">
			<span class="title"><?php esc_html_e( 'SuperDocs Template', 'superdocs' )?></span>
			<select name="superdocs-template">
				<option value="0"><?php esc_html_e( "-- Select Template --", "superdocs" )?></option>
				<?php foreach ( $templates as $template ) {?>
					<option value="<?php wp_commander_render($template->ID) ?>"><?php wp_commander_render($template->post_title) ?></option>
				<?php }?>
			</select>
		</label>
	</div>
</div>