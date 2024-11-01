<?php

defined( 'ABSPATH' ) || exit;

\Elementor\Plugin::$instance->frontend->add_body_class( 'elementor-template-full-width' );

get_header();

do_action( 'elementor/page_templates/header-footer/before_content' );

\Elementor\Plugin::$instance->modules_manager->get_modules( 'page-templates' )->print_content();

do_action( 'elementor/page_templates/header-footer/after_content' );

get_footer();
