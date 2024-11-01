<?php

namespace SuperDocs\App\Http\Controllers;

use SuperDocs\Bootstrap\View;
use WP_REST_Request;

class SettingsController
{
    public function general( WP_REST_Request $wpRestRequest )
    {
        update_option('superdocs-general-settings', serialize($wpRestRequest->get_param('settings')));
        wp_send_json([
            'message' => esc_html__('Settings saved successfully!', 'superdocs')
        ]);
    }

    public function general_page()
    {
        return View::send( 'admin/pages/settings/general' );
    }
}
