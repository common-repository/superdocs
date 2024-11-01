<?php

namespace SuperDocs\App\Http\Controllers;

use SuperDocs\Bootstrap\View;
use WP_REST_Request;

class SearchController
{
    public function get( WP_REST_Request $wpRestRequest )
    {
        $metaQuery = [
            [
                'key'     => 'superdocs_product',
                'compare' => 'NOT EXISTS'
            ],
            [
                'key'     => 'superdocs_category',
                'compare' => 'NOT EXISTS'
            ]
        ];

        $productId = $wpRestRequest->get_param( 'product' );

        if ( !'0' == $productId ) {
            $metaQuery[] = [
                'key'   => 'productId',
                'value' => $productId
            ];
        }

        $docs = get_posts( [
            'post_type'      => superdocs_post_type(),
            'posts_per_page' => 100,
            's'              => sanitize_text_field( $wpRestRequest->get_param( 's' ) ),
            'meta_query'     => $metaQuery
        ] );

        return View::send( 'frontend/search', [
            'docs'           => $docs,
            'not_found_text' => $wpRestRequest->get_param( 'not_found_text' )
        ] );
    }
}
