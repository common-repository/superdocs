<?php

use SuperDocs\Bootstrap\Application;

function superdocs_count( $type = 'post', $perm = '', $mim_type = false )
{
    global $wpdb;

    if ( !post_type_exists( $type ) ) {
        return new \stdClass;
    }

    $query = "SELECT post_status, COUNT( * ) AS num_posts FROM {$wpdb->posts} WHERE post_type = %s";

    if ( 'readable' === $perm && is_user_logged_in() ) {
        $post_type_object = get_post_type_object( $type );
        if ( !current_user_can( $post_type_object->cap->read_private_posts ) ) {
            $query .= $wpdb->prepare(
                " AND (post_status != 'private' OR ( post_author = %d AND post_status = 'private' ))",
                get_current_user_id()
            );
        }
    }

    $query .= $wpdb->prepare( " AND post_mime_type = %s GROUP BY post_status", $mim_type );

    //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared -- Already prepared
    $results = (array) $wpdb->get_results( $wpdb->prepare( $query, $type ), ARRAY_A );
    $counts  = array_fill_keys( get_post_stati(), 0 );

    foreach ( $results as $row ) {
        $counts[$row['post_status']] = $row['num_posts'];
    }

    return apply_filters( 'wp_count_posts', (object) $counts, $type, $perm );
}

function superdocs_post_type()
{
    return Application::$config['post_types']['docs'];
}

function superdocs_sidebar_taxonomy()
{
    return Application::$config['taxonomies']['sidebar'];
}

function superdocs_template_post_type()
{
    return Application::$config['post_types']['template'];
}

function superdocs_version()
{
    return Application::$config['version'];
}

function superdocs_general_settings()
{
    global $superdocs;

    if ( isset( $superdocs['general_settings'] ) ) {
        return $superdocs['general_settings'];
    }

    $saved_values = superdocs_get_option_unserialize( 'superdocs-general-settings' );

    $inputs = [
        'single_docs_slug'          => [
            'title'    => esc_html__( 'Single Docs Permalink', 'superdocs' ),
            'type'     => 'text',
            'value'    => 'docs',
            'required' => true
        ],
        'toc_supported_heading_tag' => [
            'title'    => esc_html__( 'TOC Supported Heading Tag', 'superdocs' ),
            'type'     => 'checkbox',
            'required' => false,
            'value'    => ['H1', 'H2', 'H3', 'H4', 'H5', 'H6'],
            'options'  => [
                [
                    'title' => 'H1',
                    'value' => 'H1'
                ],
                [
                    'title' => 'H2',
                    'value' => 'H2'
                ],
                [
                    'title' => 'H3',
                    'value' => 'H3'
                ],
                [
                    'title' => 'H4',
                    'value' => 'H4'
                ],
                [
                    'title' => 'H5',
                    'value' => 'H5'
                ],
                [
                    'title' => 'H6',
                    'value' => 'H6'
                ]
            ]
        ]
    ];

    foreach ( $inputs as $name => $input ) {
        if ( isset( $saved_values[$name] ) ) {
            $inputs[$name]['value'] = $saved_values[$name];
        }
    }

    if ( is_array( $superdocs ) ) {
        $superdocs['general_settings'] = $inputs;
    } else {
        $superdocs = [
            'general_settings' => $inputs
        ];
    }

    return $inputs;
}

function superdocs_get_ordered_category_list( $productId )
{
    global $superdocs;

    if ( isset( $superdocs['categories'][$productId] ) ) {
        return $superdocs['categories'][$productId];
    }

    $categories = superdocs_get_post_meta_unserialize( $productId, 'categories' );

    if ( is_array( $superdocs ) ) {
        $superdocs['categories'][$productId] = $categories;
    } else {
        $superdocs = [
            'categories' => [
                $productId => $categories
            ]
        ];
    }

    return $categories;
}

function superdocs_get_option_unserialize( $key )
{
    $value = get_option( $key );

    if ( $value ) {
        return unserialize( $value );
    }
    return [];
}

function superdocs_get_post_meta_unserialize( $post_id, $meta_key )
{
    $value = get_post_meta( $post_id, $meta_key, true );

    if ( $value ) {
        return unserialize( $value );
    }
    return [];
}

function superdocs_get_select2_posts( WP_REST_Request $wpRestRequest, $post_type, $meta_query = []  )
{
    $query_args = [
        'post_type'      => $post_type,
        'post_status'    => 'publish',
        'posts_per_page' => 15,
        'meta_query'     => $meta_query
    ];

    if ( $wpRestRequest->has_param( 'ids' ) ) {
        $ids                    = explode( ',', $wpRestRequest->get_param( 'ids' ) );
        $query_args['post__in'] = $ids;
    } else if ( $wpRestRequest->has_param( 'search' ) ) {
        $query_args['s'] = $wpRestRequest->get_param( 'search' );
    }

    $query   = new \WP_Query( $query_args );
    $results = [];
    foreach ( $query->posts as $template ) {
        array_push( $results, [
            'id'   => $template->ID,
            'text' => $template->post_title
        ] );
    }
    return $results;
}
