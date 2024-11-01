<?php

namespace SuperDocs\App\Providers;

use WpCommander\Contracts\ServiceProvider;
use SuperDocs\App\Widgets\Breadcrumb;
use SuperDocs\App\Widgets\NavCategories;
use SuperDocs\App\Widgets\ContentArea;
use SuperDocs\App\Widgets\DocPrint;
use SuperDocs\App\Widgets\Search;
use SuperDocs\App\Widgets\NextPrev;
use SuperDocs\App\Widgets\TableOfContent;

class ElementorWidgetServicerProvider extends ServiceProvider
{
    public function boot()
    {
        add_action( 'elementor/init', [$this, 'action_elementor_init'] );
    }

    public function action_elementor_init()
    {
        add_action( 'elementor/widgets/register', [$this, 'action_register_widget'] );
        add_action( 'elementor/frontend/before_enqueue_scripts', [$this, 'action_after_enqueue_scripts'] );
        add_action( 'elementor/elements/categories_registered', [$this, 'action_categories_register'] );
    }

    public function action_categories_register($elements_manager)
    {
        $elements_manager->add_category(
            'superdocs', [
                'title'  => 'SuperDocs',
                'icon' => 'fa fa-plug'
            ]
        );
    }

    /**
     * Before frontend enqueue scripts.
     *
     * Fires before Elementor frontend scripts are enqueued.
     *
     * @since 1.0.0
     */
    public function action_after_enqueue_scripts()
    {
        wp_enqueue_script( 'superdocs-elementor-script', $this->application->get_root_url() . 'assets/js/widgets.js', ['jquery', 'elementor-frontend'], superdocs_version() );
        wp_enqueue_style( 'superdocs-elementor-style', $this->application->get_root_url() . 'assets/css/widgets.css', [], superdocs_version() );
    }

    /**
     * After widgets registered.
     *
     * Fires after Elementor widgets are registered.
     *
     * @since 1.0.0
     */
    public function action_register_widget( $widgets_manager )
    {
        foreach ( $this->widgets() as $widget ) {
            $widgets_manager->register( new $widget );
        }
    }

    public function widgets()
    {
        return [
            ContentArea::class,
            NavCategories::class,
            TableOfContent::class,
            Breadcrumb::class,
            DocPrint::class,
            Search::class,
            NextPrev::class
        ];
    }
}
