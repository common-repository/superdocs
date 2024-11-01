<?php

namespace SuperDocs\App\Http\Controllers;

use SuperDocs\Bootstrap\View;
use WP_REST_Request;

class DocController
{
    public function create_page()
    {
        View::render( 'admin/pages/docs/create' );
    }

    public function create( WP_REST_Request $wpRestRequest )
    {
        $templateId = wp_insert_post( [
            'post_type'      => superdocs_post_type(),
            'post_title'     => $wpRestRequest->get_param( 'doc_title' ),
            'post_status'    => 'publish',
            'post_mime_type' => 'doc',
            'post_parent'    => $wpRestRequest->get_param( 'product' )
        ] );

        add_post_meta( $templateId, 'productId', $wpRestRequest->get_param( 'product' ) );
        add_post_meta( $templateId, 'superdocs-template','0' );
    
        wp_send_json( [
            'message' => esc_html__( 'Document Created Successfully!', 'superdocs' )
        ] );
    }
}
