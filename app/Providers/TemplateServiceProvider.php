<?php

namespace SuperDocs\App\Providers;

use DoatKolom\Ui\Components\Drawer;
use DoatKolom\Ui\Components\Notification;
use SuperDocs\Bootstrap\Utils;
use WpCommander\Contracts\ServiceProvider;
use SuperDocs\Bootstrap\View;

class TemplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        add_filter( 'template_include', [$this, 'filter_template_include'], 99999 );
        add_action( 'wp_head', [$this, 'action_wp_head'] );
        add_action( 'admin_head', [$this, 'action_wp_head'] );
        add_action( 'admin_footer-edit.php', [$this, 'action_admin_footer'] );
    }

    /**
     * Prints scripts or data after the default footer scripts.
     *
     */
    public function action_admin_footer(): void
    {
        if(Utils::is_admin_page('edit', ['post_type' => superdocs_template_post_type()])) : ?>
            <script>
                jQuery('.page-title-action').removeAttr('href');
            </script>
            <div class="superdocs doatkolom-ui">
                <?php $drawer = new Drawer;
                $drawer->render( ['width' => '700px'] );
                $notification = new Notification;
                $notification->render();
                ?>
            </div>
        <?php
        endif;
    }

    /**
     * Prints scripts or data in the head tag on the front end.
     *
     */
    public function action_wp_head(): void
    {
        $args = [
            'root' => esc_url_raw( rest_url() ),
            'nonce' => wp_create_nonce( 'wp_rest' )
        ];
    ?>
    <script>
        var SuperDocsSettings = <?php wp_commander_render( json_encode( $args ) )?>
    </script>
    <?php
    }

    /**
     * Filters the path of the current template before including it.
     *
     * @param string $template The path of the template to include.
     * @return string The path of the template to include.
     */
    public function filter_template_include( string $template ): string
    {
        if ( is_singular( superdocs_post_type() ) ) {
            global $post;
            if ( 'doc' === $post->post_mime_type ) {
                $template_id = get_post_meta( $post->ID, 'superdocs-template', true );
                $product_id  = $post->post_parent;
                if ( $template_id == '0' ) {
                    $template_id = get_post_meta( $product_id, 'superdocs-template', true );
                }
                $is_template_use_elementor = get_post_meta( $template_id, '_elementor_edit_mode', true ) ?? false;

                if ( $is_template_use_elementor ) {
                    if ( did_action( 'elementor/loaded' ) ) {
                        $elementor_template_module = \Elementor\Plugin::$instance->modules_manager->get_modules( 'page-templates' );
                        $elementor_template_module->set_print_callback( function () use ( $template_id ) {
                            $layout = \Elementor\Plugin::instance()->frontend->get_builder_content( $template_id );
                            ob_start();
                            the_content();
                            $content = ob_get_clean();

                            if(strpos($layout, '{{ SuperDocs Content Area }}')) {
                                wp_commander_render( str_replace( "{{ SuperDocs Content Area }}", $content, $layout ) );
                            } else {
                                wp_commander_render($content);
                            }
                        } );
                        return View::get_path( 'frontend/elementor-header-footer' );
                    }
                }
            }
        }
        return $template;
    }
}
