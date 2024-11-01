<?php

namespace SuperDocs\App\Providers\Admin;

use WP_Post;
use WpCommander\Contracts\ServiceProvider;
use SuperDocs\App\AdminPages\Doc;
use SuperDocs\App\AdminPages\Product;
use SuperDocs\App\AdminPages\Sidebar;
use SuperDocs\App\Http\Controllers\CategoryController;
use SuperDocs\Bootstrap\Utils;
use SuperDocs\Bootstrap\View;

class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        add_action( 'admin_menu', [$this, 'action_admin_menu'] );
        add_action( 'save_post_' . superdocs_post_type(), [$this, 'save_post'], 10, 3 );

        if ( Utils::is_admin_page( 'edit', ['post_type' => superdocs_post_type(), 'product' => 'true'] ) ) {
            ( new Product )->boot();
        } elseif ( Utils::is_admin_page( 'edit', ['post_type' => superdocs_post_type(), 'product' => '!true'] ) ) {
            ( new Doc )->boot();
        } elseif ( Utils::is_admin_page( 'admin-ajax', ['post_type' => superdocs_post_type()] ) ) {
            check_ajax_referer( 'inlineeditnonce', '_inline_edit' );
            $type = isset( $_REQUEST['post_ID'] ) ? get_post_mime_type( intval( $_REQUEST['post_ID'] ) ) : false;
            if ( 'doc' === $type ) {
                ( new Doc )->boot();
            } elseif ( 'product' === $type ) {
                ( new Product )->boot();
            }
        } elseif ( Utils::is_admin_page( 'admin', ['page' => 'superdocs-categories'] ) ) {
            ( new Sidebar )->boot();
        }
    }

    public function save_post( int $post_ID, WP_Post $post)
    {
        global $wpdb;

        if( !empty($_POST['productId']) ) { //phpcs:ignore WordPress.Security.NonceVerification.Missing
            $oldProductId = get_post_meta( $post_ID, 'productId', true);
            if($oldProductId != $_POST['productId']) { //phpcs:ignore WordPress.Security.NonceVerification.Missing
                $categoryPostId = get_post_meta($post_ID, 'categoryId', true);
                if($categoryPostId) {
                    CategoryController::removeProductFormCategories($post_ID, $categoryPostId, $oldProductId,);
                    delete_post_meta($post_ID, 'categoryId');
                }
            }
            //phpcs:ignore WordPress.Security.NonceVerification.Missing
            $productId = sanitize_text_field( wp_unslash( $_POST['productId'] ) );
            update_post_meta( $post_ID, 'productId',  $productId);

            // $parent_post = get_post($post->post_parent);

            // if($parent_post && $parent_post->post_mime_type !== 'category') {
                $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}posts SET post_parent = %s WHERE ID=%d", $productId, $post_ID ) );
            // }
        }

        //phpcs:ignore WordPress.Security.NonceVerification.Missing
        if ( !empty( $_POST['superdocs-template'] ) ) {
            //phpcs:ignore WordPress.Security.NonceVerification.Missing
            update_post_meta( $post_ID, 'superdocs-template', sanitize_text_field( wp_unslash( $_POST['superdocs-template'] ) ) );
        } else {
            update_post_meta( $post_ID, 'superdocs-template','0' );
        }
    }

    public function action_admin_menu()
    {
        add_menu_page( esc_html__( 'SuperDocs', 'superdocs' ), esc_html__( 'SuperDocs', 'superdocs' ), 'manage_options', 'superdocs-menu', function () {}, 'dashicons-media-document', 5 );
        add_submenu_page( 'superdocs-menu', esc_html__( 'All Docs', 'superdocs' ), esc_html__( 'All Docs', 'superdocs' ), 'manage_options', 'edit.php?post_type=' . superdocs_post_type() );
        add_submenu_page( 'superdocs-menu', esc_html__( 'Products', 'superdocs' ), esc_html__( 'Products', 'superdocs' ), 'manage_options', 'edit.php?product=true&post_type=' . superdocs_post_type() );
        add_submenu_page( 'superdocs-menu', esc_html__( 'Templates', 'superdocs' ), esc_html__( 'Templates', 'superdocs' ), 'manage_options', 'edit.php?post_type=' . superdocs_template_post_type() );
        add_submenu_page( 'superdocs-menu', esc_html__( 'Categories', 'superdocs' ), esc_html__( 'Categories', 'superdocs' ), 'manage_options', 'superdocs-categories', [$this, 'sidebar_category'] );
        add_submenu_page( 'superdocs-menu', esc_html__( 'Settings', 'superdocs' ), esc_html__( 'Settings', 'superdocs' ), 'manage_options', 'superdocs-settings', [$this, 'settings'] );
        remove_submenu_page( 'superdocs-menu', 'superdocs-menu' );
    }

    public function sidebar_category()
    {
        global $wpdb;
        $products  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}posts WHERE post_type = %s AND post_status = 'publish' AND post_mime_type = 'product'", superdocs_post_type() ) );
        View::render( 'admin/pages/category/index', ['products' => $products] );
    }

    public function settings()
    {
        View::render( 'admin/pages/settings/index');   
    }
}
