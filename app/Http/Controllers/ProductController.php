<?php

namespace SuperDocs\App\Http\Controllers;

use SuperDocs\Bootstrap\View;
use WP_REST_Request;

class ProductController
{
    public function index( WP_REST_Request $wpRestRequest )
    {
        wp_send_json(
            superdocs_get_select2_posts(
                $wpRestRequest,
                superdocs_post_type(), [
                    [
                        'key'     => 'superdocs_product',
                        'compare' => 'EXISTS'
                    ]
                ]
            )
        );
    }

    public function create_page()
    {
        View::render( 'admin/pages/products/create' );
    }

    public function create( WP_REST_Request $wpRestRequest )
    {
        $templateId = wp_insert_post( [
            'post_type'      => superdocs_post_type(),
            'post_title'     => $wpRestRequest->get_param( 'product_name' ),
            'post_status'    => 'publish',
            'post_mime_type' => 'product'
        ] );

        add_post_meta( $templateId, 'superdocs_product', true );
        add_post_meta( $templateId, 'superdocs-template', $wpRestRequest->get_param( 'template' ) );

        wp_send_json( [
            'message' => esc_html__( 'Product Created Successfully!', 'superdocs' )
        ] );
    }
}
