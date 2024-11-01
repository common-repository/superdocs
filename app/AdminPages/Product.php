<?php

namespace SuperDocs\App\AdminPages;

use DoatKolom\Ui\Components\Modal;
use DoatKolom\Ui\Components\Notification;
use SuperDocs\Bootstrap\Application;
use SuperDocs\Bootstrap\Utils;
use SuperDocs\Bootstrap\View;
use WP_Query;

class Product
{
    public function boot()
    {
        $docs_post_type = superdocs_post_type();
        add_filter( 'pre_get_posts', [$this, 'pre_get_posts'] );
        add_filter( "views_edit-{$docs_post_type}", [$this, 'post_counter'] );
        add_action( 'admin_footer', [$this, 'admin_footer'] );
        add_filter( "manage_edit-{$docs_post_type}_columns", [$this, 'custom_column'] );
        add_action( "manage_{$docs_post_type}_posts_custom_column", [$this, 'custom_column_value'], 10, 2 );
        add_action( 'quick_edit_custom_box', [$this, 'quick_edit_box'], 10, 3 );
    }

    public function quick_edit_box( string $column_name )
    {
        if ( 'template' === $column_name ) {
            global $wpdb;
            $templates = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}posts WHERE post_type = %s AND post_status = 'publish'", superdocs_template_post_type() ) );
            View::render( 'admin/pages/products/quick-view', compact( 'templates' ) );
        }
    }

    public function custom_column( array $columns ): array
    {
        $array = [
            'cb'       => $columns['cb'],
            'title'    => $columns['title'],
            'template' => esc_html__( 'Template', 'superdocs' )
        ];
        return array_merge( $array, $columns );
    }

    public function custom_column_value( $column, $post_id )
    {
        switch ( $column ) {
            case 'template':
                $template_id   = get_post_meta( $post_id, 'superdocs-template', true );
                $template_post = get_post( $template_id );
                if ($template_post && $post_id != $template_post->ID ) {
                    echo "<div class='superdocs-template' data-template='" . wp_json_encode( ['id' => $template_post->ID, 'title' => $template_post->post_title] ) . "'>";
                    wp_commander_render($template_post->post_title);
                    echo "</div>";
                }
                break;
        }
    }

    public function post_counter( array $views )
    {
        $counts      = superdocs_count( Application::$config['post_types']['docs'], 'superdocs-product', 'product' );
        $all         = $counts->publish + $counts->future + $counts->draft + $counts->pending + $counts->private + $counts->trash;
        $counts->all = $all;
        foreach ( $views as $key => $view ) {
            $view_part   = explode( '<span class="count">', $view );
            $final_view  = $view_part[0] . '<span class="count">(' . $counts->$key . ')</span></a>';
            $views[$key] = $final_view;
        }
        return $views;
    }

    public function pre_get_posts( WP_Query $query ): WP_Query
    {
        $query->set( 'meta_query', [[
            'key'     => 'superdocs_product',
            'compare' => 'EXISTS'
        ]] );
        return $query;
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
        View::render( 'admin/pages/products/footer' );
    }
}
