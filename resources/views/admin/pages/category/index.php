<?php

use DoatKolom\Ui\Components\Modal;
use DoatKolom\Ui\Components\Notification;
use DoatKolom\Ui\Components\Tab;
use SuperDocs\Bootstrap\Utils;

$tabs = [];
foreach ( $products as $product ) {
    array_push( $tabs, [
        'title'               => $product->post_title,
        'content_api'         => Utils::url_add_params( get_rest_url( null, 'superdocs/category/order' ), ['productId' => $product->ID] ),
        'contentCache'        => true,
        'contentApiOptions'   => [
            'headers' => [
                'X-WP-Nonce' => wp_create_nonce( 'wp_rest' )
            ]
        ],
        'classes'             => [
            'tab_selector' => 'h-14'
        ]
    ] );
}
?>
<div class="superdocs doatkolom-ui">
    <div class="pr-5">
        <div class="rounded overflow-hidden shadow-md bg-white mt-5 pb-7">
            <div class="rounded-xl">
                <div class="min-h-[38rem] p-10">
                    <div class="pb-14">
                        <div class="float-left">
                            <h4 class="text-[20px] font-bold font-primary text-heading mb-9 inline">Product List</h4>
                        </div>
                        <div class="float-left pl-16">
                            <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=' . superdocs_post_type() . '&product=true' ) )?>" 
                                class="cursor-pointer font-semibold rounded-md px-7 py-3 text-white items-center bg-primary hover:bg-primary-hover">
                            + <?php esc_html_e('Add Product', 'superdocs')?>
                            </a>
                        </div>
                    </div>
                    <div>
                        <?php
                        $tab = new Tab;
                        $tab->render( [
                            'init'     => true,
                            'position' => 'left',
                            'classes'  => [
                                'tabpanels' => 'bg-white',
                                'selectedButton' => '!text-primary'
                            ]
                        ], $tabs );
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        $modal = new Modal;
        $modal->start(['af'], []);
        $modal->content();
        $modal->end();
        
        $notification = new Notification;
        $notification->render();
    ?>
</div>
