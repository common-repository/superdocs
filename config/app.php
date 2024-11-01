<?php

use SuperDocs\App\Http\Middleware\EnsureIsUserAdmin;
use SuperDocs\App\Providers\Admin\MenuServiceProvider;
use SuperDocs\App\Providers\CptServiceProvider;
use SuperDocs\App\Providers\ElementorWidgetServicerProvider;
use SuperDocs\App\Providers\TemplateServiceProvider;

return [
    /**
     * Plugin Current Version
     */
    'version'         => '1.0.3-beta1',

    /**
     * All post types for this plugin
     */
    'post_types'      => [
        'docs'     => 'superdocs',
        'template' => 'superdocstemplate'
    ],

    /**
     * All taxonomies for this plugin
     */
    'taxonomies'      => [
        'sidebar' => 'superdocs-category'
    ],

    /**
     * Service providers
     */
    'providers'       => [
        CptServiceProvider::class,
        ElementorWidgetServicerProvider::class,
        TemplateServiceProvider::class
    ],

    'admin_providers' => [
        MenuServiceProvider::class
    ],
    /**
     * Plugin Api Namespace
     */
    'namespace'       => 'superdocs',

    'api_versions'    => [],

    'middleware'      => [
        'admin' => EnsureIsUserAdmin::class
    ]
];
