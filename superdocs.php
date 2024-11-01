<?php

/**
 * Plugin Name:       SuperDocs
 * Plugin URI:        http://wordpress.org/plugins/superdocs/
 * Description:       The Knowledge Base WordPress Plugin is an easy-to-use tool for creating a comprehensive knowledge base With its intuitive and user-friendly interface, this plugin helps you quickly and efficiently create a powerful knowledge base for your website
 * Version:           1.0.3-beta1
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Tested up to:      6.2
 * Author:            DoatKolom
 * Author URI:        http://doatkolom.com
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       superdocs
 * Domain Path:       /languages
 */

use SuperDocs\Bootstrap\Application;

require_once __DIR__ . '/vendor/autoload.php';

class SuperDocs
{
    public static function boot()
    {
        $app = Application::instance();

        /**
         * Fires once activated plugins have loaded.
         */
        add_action( 'plugins_loaded', function () use ( $app ): void {
            $app->boot( __DIR__, __FILE__);
        } );
    }
}

SuperDocs::boot();