<?php

namespace SuperDocs\App\Providers;

use SuperDocs\Bootstrap\Utils;
use WpCommander\Contracts\ServiceProvider;

class CptServiceProvider extends ServiceProvider
{
    public function boot()
    {
        add_action( 'init', [$this, 'init'] );
    }

    public function init()
    {
        register_post_type( superdocs_post_type(), $this->docs_cpt_args() );
        register_post_type( superdocs_template_post_type(), $this->layout_cpt_args() );
        register_taxonomy( superdocs_sidebar_taxonomy(), [superdocs_post_type()], [
            'label'             => __( 'Categories', 'superdocs' ),
            'hierarchical'      => false,
            'public'            => false,
            'show_admin_column' => false,
            'show_in_menu'      => false,
            'show_in_nav_menus' => false
        ] );
        flush_rewrite_rules();
    }

    public function docs_cpt_args()
    {
        $label         = esc_html__( 'All Docs', 'superdocs' );
        $singular_name = esc_html__( 'Doc', 'superdocs' );

        if ( is_admin() ) {
            if ( Utils::is_admin_page( 'edit', ['post_type' => superdocs_post_type(), 'product' => 'true'] ) ) {
                $label         = esc_html__( 'Products', 'superdocs' );
                $singular_name = esc_html__( 'Product', 'superdocs' );
            } elseif (
                Utils::is_admin_page( 'post', ['product' => 'true'] ) ||
                ( isset( $_GET['post'] ) && get_post_mime_type( sanitize_text_field( wp_unslash( $_GET['post'] ) ) ) === 'product' ) //phpcs:ignore WordPress.Security.NonceVerification.Recommended
            ) {
                $label         = esc_html__( 'Products', 'superdocs' );
                $singular_name = esc_html__( 'Product', 'superdocs' );
            } elseif ( Utils::is_admin_page( 'post-new', ['product' => 'true'] ) ) {
                $label         = esc_html__( 'Products', 'superdocs' );
                $singular_name = esc_html__( 'Product', 'superdocs' );
            }
        }

        $labels = [
            'singular_name'         => $singular_name,
            'archives'              => esc_html__( 'Item Archives', 'superdocs' ),
            'attributes'            => esc_html__( 'Item Attributes', 'superdocs' ),
            'all_items'             => esc_html__( 'All Items', 'superdocs' ),
            'add_new_item'          => esc_html__( 'Add New Item', 'superdocs' ),
            'add_new'               => esc_html__( 'Add New', 'superdocs' ),
            'new_item'              => esc_html__( 'New Item', 'superdocs' ),
            'edit_item'             => esc_html__( 'Edit Item', 'superdocs' ),
            'update_item'           => esc_html__( 'Update Item', 'superdocs' ),
            'view_item'             => esc_html__( 'View Item', 'superdocs' ),
            'view_items'            => esc_html__( 'View Items', 'superdocs' ),
            'search_items'          => esc_html__( 'Search Item', 'superdocs' ),
            'not_found'             => esc_html__( 'Not found', 'superdocs' ),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'superdocs' ),
            'featured_image'        => esc_html__( 'Featured Image', 'superdocs' ),
            'set_featured_image'    => esc_html__( 'Set featured image', 'superdocs' ),
            'remove_featured_image' => esc_html__( 'Remove featured image', 'superdocs' ),
            'use_featured_image'    => esc_html__( 'Use as featured image', 'superdocs' ),
            'insert_into_item'      => esc_html__( 'Insert into item', 'superdocs' ),
            'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'superdocs' ),
            'items_list'            => esc_html__( 'Items list', 'superdocs' ),
            'items_list_navigation' => esc_html__( 'Items list navigation', 'superdocs' ),
            'filter_items_list'     => esc_html__( 'Filter items list', 'superdocs' )
        ];

        $general_settings = superdocs_general_settings();

        if ( empty( $general_settings['single_docs_slug']['value'] ) ) {
            $slug = 'docs';
        } else {
            $slug = $general_settings['single_docs_slug']['value'];
        }

        return [
            'label'               => $label,
            'labels'              => $labels,
            'rewrite'             => ['slug' => $slug],
            'supports'            => ['title', 'editor', 'Category', 'elementor'],
            'taxonomies'          => [superdocs_sidebar_taxonomy()],
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'menu_position'       => 5,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => false,
            'hierarchical'        => true,
            'exclude_from_search' => false,
            'show_in_rest'        => true,
            'publicly_queryable'  => true,
            'capability_type'     => 'page'
        ];
    }
    public function layout_cpt_args()
    {
        return [
            'label'               => esc_html__( 'Templates', 'superdocs' ),
            'description'         => esc_html__( '', 'superdocs' ),
            'supports'            => ['title', 'editor', 'Category', 'elementor'],
            'taxonomies'          => [],
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'menu_position'       => 5,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'hierarchical'        => false,
            'exclude_from_search' => false,
            'show_in_rest'        => true,
            'publicly_queryable'  => true,
            'capability_type'     => 'post'
        ];
    }
}
