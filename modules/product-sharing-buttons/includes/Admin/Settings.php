<?php


namespace Springdevs\SocialShare\Admin;


/**
 * Class Settings
 * @package Springdevs\SocialShare\Admin
 */
class Settings
{

    public function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    public function admin_menu()
    {
        $hook = add_menu_page(__('Share Buttons', 'sdevs_wea'), __('Share Buttons', 'sdevs_wea'), 'manage_options', 'sdevs-share-buttons', array($this, 'settings_content'), 'dashicons-share', 80);
        add_action('load-' . $hook, [$this, 'init_hooks']);
    }

    public function init_hooks()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('psb-admin-style');
    }

    public function settings_content()
    {
        include 'views/settings.php';
    }
}
