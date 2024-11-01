<?php

namespace SuperDocs\App\Http\Controllers;

use SuperDocs\Bootstrap\Application;
use SuperDocs\Bootstrap\Utils;
use SuperDocs\Bootstrap\View;
use WP_REST_Request;

class TemplateController
{
    public function index( WP_REST_Request $wpRestRequest )
    {
        wp_send_json( superdocs_get_select2_posts( $wpRestRequest, superdocs_template_post_type() ) );
    }

    public function create( WP_REST_Request $wpRestRequest )
    {
        if ( !did_action( 'elementor/loaded' ) ) {
            wp_send_json( [
                'message' => esc_html__( 'Please activate elementor plugin', 'superdocs' )
            ], 404 );
        }

        $template_name = $wpRestRequest->get_param( 'template-name' );

        if ( empty( $template_name ) ) {
            $template_name = '#Template ' . time();
        }

        $templateId = wp_insert_post( [
            'post_type'   => superdocs_template_post_type(),
            'post_title'  => $template_name,
            'post_status' => 'publish'
        ] );

        update_post_meta( $templateId, 'superdocs_edit_with_option', 'elementor' );
        update_post_meta( $templateId, '_wp_page_template', 'elementor_header_footer' );
        update_post_meta( $templateId, '_elementor_edit_mode', 'builder' );
        update_post_meta( $templateId, '_elementor_version', '3.9.2' );

        $template = $wpRestRequest->get_param( 'template' );

        if ( !empty( $template ) && 'blank' !== $template ) {
            $rootDir   = Application::$instance->get_root_dir();
            $json_path = $rootDir . '/app/Demo/Elementor/' . $template . '/demo.json';
            Utils::import_elementor_demo( $json_path, $templateId, 'file' );
        }

        wp_send_json( [
            'message'    => esc_html__( 'Template create successfully!', 'superdocs' ),
            'templateId' => $templateId
        ], 200 );
    }

    public function create_page()
    {
        return View::send( 'admin/pages/template/create' );
    }
}
