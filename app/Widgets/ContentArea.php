<?php

namespace SuperDocs\App\Widgets;

use Elementor\Widget_Base;

class ContentArea extends Widget_Base {

	public function get_name() {
		return 'superdocs-content';
	}

	public function get_title() {
		return esc_html__( 'Content Area', 'superdocs' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'superdocs' ];
	}

	public function get_keywords() {
		return [ 'superdocs', 'doc', 'content', 'knowledge base' ];
	}

	protected function render() {
		$elementor = \Elementor\Plugin::$instance;
		global $post;
		if( $elementor->editor->is_edit_mode() || is_preview() || (isset($post->post_type) && superdocs_template_post_type() === $post->post_type)) {
			?>

            <h1>SuperDocs Content Area</h1>
			<h3>This is where your single documentation content will appear</h3>

            <?php
		} else { ?>
			{{ SuperDocs Content Area }}
		<?php }
	}
}
