<?php

namespace SuperDocs\App\AdminPages;

use DoatKolom\Ui\Components\Modal;
use DoatKolom\Ui\Components\Notification;
use SuperDocs\Bootstrap\Application;
use SuperDocs\Bootstrap\View;
use WP_Query;

class Doc
{
    public function boot()
    {
        $docs_post_type = superdocs_post_type();

        add_action( 'restrict_manage_posts', [$this, 'filter'] );
        add_filter( "views_edit-{$docs_post_type}", [$this, 'post_counter'] );
        add_filter( 'pre_get_posts', [$this, 'pre_get_posts'] );
        add_filter( "manage_edit-{$docs_post_type}_columns", [$this, 'custom_column'] );
        add_action( "manage_{$docs_post_type}_posts_custom_column", [$this, 'custom_column_value'], 10, 2 );
        add_action( 'quick_edit_custom_box', [$this, 'quick_edit_box'], 10, 3 );
        add_action( 'admin_footer', [$this, 'admin_footer'] );
        add_action( 'admin_enqueue_scripts', [$this, 'wp_enqueue_scripts'] );
    }

    public function wp_enqueue_scripts()
    {
        wp_enqueue_script( 'superdocs-docs', Application::$instance->get_root_url() . '/resources/js/docs.js', [], time() );
    }

    public function filter()
    {
        global $wpdb;
        $products            = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}posts WHERE post_type = %s AND post_status = 'publish' AND post_mime_type = 'product'", superdocs_post_type() ) );
        $selected_product_id = isset( $_GET['filter-by-product'] ) ? intval( $_GET['filter-by-product'] ) : 0; //phpcs:ignore WordPress.Security.NonceVerification.Recommended
        View::render( 'admin/pages/docs/cpt-filter', compact( 'selected_product_id', 'products' ) );
    }

    public function pre_get_posts( WP_Query $query )
    {
        if ( !empty( $_GET['filter-by-product'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $query->set( 'post_parent', intval( $_GET['filter-by-product'] ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended
        }

        $query->set( 'meta_query', [
            [
            'key'     => 'superdocs_product',
            'compare' => 'NOT EXISTS'
            ],
            [
            'key'     => 'superdocs_category',
            'compare' => 'NOT EXISTS'
            ]
        ] );
        return $query;
    }

    public function custom_column( array $columns ): array
    {
        $array = [
            'cb'       => $columns['cb'],
            'title'    => $columns['title'],
            'product'  => esc_html__( 'Product', 'superdocs' ),
            'template' => esc_html__( 'Template', 'superdocs' )
        ];
        return array_merge( $array, $columns );
    }

    public function custom_column_value( $column, $post_id )
    {
        switch ( $column ) {
            case 'product':
                $product = get_post( get_post_meta($post_id, 'productId', true) );
                if ($product && $product->ID != $post_id ) {
                    echo "<div class='superdocs-product' data-product='" . wp_json_encode( ['id' => $product->ID, 'title' => $product->post_title] ) . "'>";
                    wp_commander_render($product->post_title);
                    echo "</div>";
                }
                break;

            case 'template':
                $template_id   = get_post_meta( $post_id, 'superdocs-template', true );
                if(0 == $template_id) {
                    echo "<div class='superdocs-template' data-template='" . wp_json_encode( ['id' => '0', 'title' => esc_html__( 'Product Default', 'superdocs' )] ) . "'>";
                    esc_html_e( 'Product Default', 'superdocs' );
                    echo "</div>";
                } else {
                    $template_post = get_post( $template_id );
                    if ($template_post && $post_id != $template_post->ID ) {
                        echo "<div class='superdocs-template' data-template='" . wp_json_encode( ['id' => $template_post->ID, 'title' => $template_post->post_title] ) . "'>";
                        wp_commander_render($template_post->post_title);
                        echo "</div>";
                    }
                }
        }
    }

    public function quick_edit_box( string $column_name )
    {
        if ( 'product' === $column_name ) {
            global $wpdb;
            $products  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}posts WHERE post_type = %s AND post_status = 'publish' AND post_mime_type = 'product'", superdocs_post_type() ) );
            $templates = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}posts WHERE post_type = %s AND post_status = 'publish'", superdocs_template_post_type() ) );
            View::render( 'admin/pages/docs/quick-view', compact( 'products', 'templates' ) );
        }
    }

    public function post_counter( array $views )
    {
        $counts      = superdocs_count( Application::$config['post_types']['docs'], 'superdocs-doc', 'doc' );
        $all         = $counts->publish + $counts->future + $counts->draft + $counts->pending + $counts->private + $counts->trash;
        $counts->all = $all;
        foreach ( $views as $key => $view ) {
            $view_part   = explode( '<span class="count">', $view );
            $final_view  = $view_part[0] . '<span class="count">(' . $counts->$key . ')</span></a>';
            $views[$key] = $final_view;
        }
        return $views;
    }

    public function admin_footer()
    {
        ?>
            <div class="superdocs doatkolom-ui">
                <?php 
                    $drawer = new Modal;
                    $drawer->render();
                    $notification = new Notification;
                    $notification->render();
                ?>
            </div>
        <?php
        View::render( 'admin/pages/docs/footer' );
    }
}
