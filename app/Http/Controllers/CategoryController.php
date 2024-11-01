<?php

namespace SuperDocs\App\Http\Controllers;

use DoatKolom\Ui\Utils\Common;
use SuperDocs\Bootstrap\View;
use WP_REST_Request;

class CategoryController
{
    public function get( WP_REST_Request $wpRestRequest )
    {
        View::send( 'admin/pages/category/order-page', ['productId' => $wpRestRequest->get_param( 'productId' )] );
    }

    public function create_page( WP_REST_Request $wpRestRequest )
    {
        View::send( 'admin/pages/category/create', ['productId' => $wpRestRequest->get_param( 'productId' )] );
    }

    public function edit_page( WP_REST_Request $wpRestRequest )
    {
        View::send( 'admin/pages/category/edit', ['productId' => $wpRestRequest->get_param( 'productId' ), 'categoryPostId' => $wpRestRequest->get_param( 'categoryPostId' )] );
    }

    public function delete_page( WP_REST_Request $wpRestRequest )
    {
        View::send( 'admin/pages/category/delete', ['productId' => $wpRestRequest->get_param( 'productId' ), 'categoryPostId' => $wpRestRequest->get_param( 'categoryPostId' )] );
    }

    public function update( WP_REST_Request $wpRestRequest )
    {
        wp_update_post( [
            'ID'         => $wpRestRequest->get_param( 'categoryPostId' ),
            'post_title' => $wpRestRequest->get_param( 'categoryName' )
        ] );

        wp_send_json( [
            'data'    => [
                'categoryName' => $wpRestRequest->get_param( 'categoryName' )
            ],
            'message' => esc_html__( 'Category updated successfully!', 'superdocs' )
        ] );
    }

    public function delete( WP_REST_Request $wpRestRequest )
    {
        wp_delete_post( $wpRestRequest->get_param( 'categoryPostId' ), true );

        if ( $wpRestRequest->has_param( 'docs' ) ) {
            foreach ( $wpRestRequest->get_param( 'docs' ) as $docId ) {
                wp_delete_post( $docId, true );
            }
        }

        self::removeCategoryFormCategories( $wpRestRequest->get_param( 'productId' ), $wpRestRequest->get_param( 'categoryPostId' ) );

        wp_send_json( [
            'message' => esc_html__( 'Category deleted successfully!', 'superdocs' )
        ] );
    }

    public static function removeCategoryFormCategories( $productId, $categoryPostId )
    {
        $categoriesSortList = superdocs_get_post_meta_unserialize( $productId, 'categories' );
        $key                = array_search( $categoryPostId, array_column( $categoriesSortList, 'categoryPostId' ) );

        if ( is_int( $key ) ) {
            unset( $categoriesSortList[$key] );
            $categoriesSortList = array_values( $categoriesSortList );
            update_post_meta( $productId, 'categories', serialize( $categoriesSortList ) );
        }
    }

    public static function removeProductFormCategories( $docsId, $categoryPostId, $productId )
    {
        $categoriesSortList = superdocs_get_post_meta_unserialize( $productId, 'categories' );
        $categoryKey        = array_search( $categoryPostId, array_column( $categoriesSortList, 'categoryPostId' ) );
        if ( is_int( $categoryKey ) && !empty( $categoriesSortList[$categoryKey]['docs'] ) ) {
            $docKey = array_search( $docsId, $categoriesSortList[$categoryKey]['docs'] );
            if ( is_int( $docKey ) ) {
                unset( $categoriesSortList[$categoryKey]['docs'][$docKey] );
                $categoriesSortList[$categoryKey]['docs'] = array_values( $categoriesSortList[$categoryKey]['docs'] );
                update_post_meta( $productId, 'categories', serialize( $categoriesSortList ) );
            }
        }
    }

    public function order( WP_REST_Request $wpRestRequest )
    {
        update_post_meta( $wpRestRequest->get_param( 'productId' ), 'categories', serialize( $wpRestRequest->get_param( 'categories' ) ) );

        $draggedDocs = $wpRestRequest->get_param( 'draggedDocs' );

        if ( !empty( $draggedDocs ) ) {
            if ( $draggedDocs['categoryPostId'] == 0 ) {
                delete_post_meta( $draggedDocs['docId'], 'categoryId' );
            } else {
                update_post_meta( $draggedDocs['docId'], 'categoryId', $draggedDocs['categoryPostId'] );
            }
        }

        wp_send_json( [
            'message' => esc_html__( 'Order complete successfully!', 'superdocs' )
        ] );
    }

    public function create( WP_REST_Request $wpRestRequest )
    {
        $categoryPost = wp_insert_post( [
            'post_type'      => superdocs_post_type(),
            'post_title'     => $wpRestRequest->get_param( 'categoryName' ),
            'post_parent'    => $wpRestRequest->get_param( 'productId' ),
            'post_status'    => 'publish',
            'post_mime_type' => 'category'
        ] );

        add_post_meta( $categoryPost, 'superdocs_category', true );
        add_post_meta( $categoryPost, 'productId', $wpRestRequest->get_param( 'productId' ) );

        $categoriesSortList = superdocs_get_post_meta_unserialize( $wpRestRequest->get_param( 'productId' ), 'categories' );

        if ( empty( $categoriesSortList ) ) {
            $categoriesSortList = [
                ['categoryPostId' => 0],
                ['categoryPostId' => $categoryPost]
            ];
        } else {
            $categoriesSortList[] = ['categoryPostId' => $categoryPost];
        }

        $productId = $wpRestRequest->get_param( 'productId' );
        update_post_meta( $productId, 'categories', serialize( $categoriesSortList ) );

        wp_send_json( [
            'message' => esc_html__( 'Category created successfully!', 'superdocs' ),
            'title'   => $wpRestRequest->get_param( 'categoryName' ),
            'head'    => self::getDocHeadContent( 'superdocs_category_action_' . $productId, $categoryPost ),
            'content' => '<div class="px-6 py-4 grid gap-3 grid-cols-1 superdocs_product_content_' . $wpRestRequest->get_param( 'productId' ) . ' ui-sortable" data-category="' . $categoryPost . '">',
            'icon'    => Common::moveIcon()
        ] );
    }

    public static function getDocHeadContent( $categoryActionKey, $categoryId )
    {
        return '<div x-data="' . $categoryActionKey . '">
            <button type="button" x-on:click="showCategoryEditAlert($data)" class="rounded-md text-xs px-4 py-0.5 shadow text-neutral-50 !bg-amber-400" data-categorypostid="' . $categoryId . '">
                ' . esc_html__( 'Edit', 'superdocs' ) . '
            </button>
            <button type="button" x-on:click="showCategoryDeleteAlert($data)" class="rounded-md text-xs px-4 py-0.5 mr-7 shadow text-neutral-50 !bg-danger hover:bg-danger-hover" data-categorypostid="' . $categoryId . '">
            ' . esc_html__( 'Delete', 'superdocs' ) . '
            </button>
        </div>';
    }
}
