<?php

namespace SpringDevs\Cfc\Admin;

/**
 * Admin Pages Handler
 *
 * Class Menu
 * @package SpringDevs\Cfc\Admin
 */
class Menu
{
    /**
     * Menu constructor.
     */
    public function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    /**
     * Register our menu page
     *
     * @return void
     */
    public function admin_menu()
    {
        $menu_slug = 'cfc-admin';
        $capability = 'manage_options';

        $hook = add_submenu_page('woocommerce', __('Checkout Fields', 'sdevs_wea'), __('Checkout Fields', 'sdevs_wea'), $capability, $menu_slug, [$this, 'plugin_page']);

        add_action('load-' . $hook, [$this, 'init_hooks']);
    }

    /**
     * Initialize our hooks for the admin page
     *
     * @return void
     */
    public function init_hooks()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * Load scripts and styles for the app
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style('cfc_style');
        wp_enqueue_script('cfc_script');
        wp_localize_script(
            'cfc_script',
            'cfc_helper_obj',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('cfc_ajax_nonce')
            )
        );
    }

    /**
     * Handles the main page
     *
     * @return void
     */
    public function plugin_page()
    {
        echo '<div class="wrap" id="cfc-vue"><App/></div>';
    }
}
