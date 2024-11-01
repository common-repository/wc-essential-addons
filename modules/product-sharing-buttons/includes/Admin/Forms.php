<?php

namespace Springdevs\SocialShare\Admin;

/**
 * Form Handler
 *
 * Class Forms
 * @package SpringDevs\SMS\Admin
 */
class Forms
{
    public function __construct()
    {
        add_action("admin_init", [$this, 'handling_form']);
    }

    public function handling_form()
    {
        $this->settings_form();
    }

    public function settings_form()
    {
        if (isset($_POST['display_product_share_button']) && isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'psb_settings_form')) {

            $display_product_share_button = sanitize_text_field($_POST['display_product_share_button']);
            $buttons_visible_position = sanitize_text_field($_POST['buttons_visible_position']);
            $button_design = sanitize_text_field($_POST['button_design']);

            update_option('psb_display_product_share_button', $display_product_share_button);
            update_option('psb_buttons_visible_position', $buttons_visible_position);
            update_option('psb_button_design', $button_design);

            if (is_array($_POST['social_buttons'])) {
                update_option('psb_social_buttons', $_POST['social_buttons']);
            }

            add_action('admin_notices', function (): void {
                $class = 'notice notice-success';
                $message = __('Settings saved !!', 'sdevs_wea');
                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
            });
        }
    }
}
