<?php
/*
Module Name: Product Sharing Buttons
*/

// don't call the file directly
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Sdevs_social_share class
 *
 * @class Sdevs_social_share The class that holds the entire Sdevs_social_share plugin
 */
final class Sdevs_social_share
{
    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0.0';

    /**
     * Holds various class instances
     *
     * @var array
     */
    private $container = [];

    /**
     * Constructor for the Sdevs_social_share class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    private function __construct()
    {
        $this->define_constants();

        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    /**
     * Initializes the Sdevs_social_share() class
     *
     * Checks for an existing Sdevs_social_share() instance
     * and if it doesn't find one, creates it.
     *
     * @return Sdevs_social_share|bool
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new Sdevs_social_share();
        }

        return $instance;
    }

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __get($prop)
    {
        if (array_key_exists($prop, $this->container)) {
            return $this->container[$prop];
        }

        return $this->{$prop};
    }

    /**
     * Magic isset to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __isset($prop)
    {
        return isset($this->{$prop}) || isset($this->container[$prop]);
    }

    /**
     * Define the constants
     *
     * @return void
     */
    public function define_constants()
    {
        define('SDEVS_SOCIAL_SHARE_VERSION', self::version);
        define('SDEVS_SOCIAL_SHARE_FILE', __FILE__);
        define('SDEVS_SOCIAL_SHARE_PATH', dirname(SDEVS_SOCIAL_SHARE_FILE));
        define('SDEVS_SOCIAL_SHARE_INCLUDES', SDEVS_SOCIAL_SHARE_PATH . '/includes');
        define('SDEVS_SOCIAL_SHARE_URL', plugins_url('', SDEVS_SOCIAL_SHARE_FILE));
        define('SDEVS_SOCIAL_SHARE_ASSETS', SDEVS_SOCIAL_SHARE_URL . '/assets');
    }

    /**
     * Load the plugin after all plugis are loaded
     *
     * @return void
     */
    public function init_plugin()
    {
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Include the required files
     *
     * @return void
     */
    public function includes()
    {
        if ($this->is_request('admin')) {
            $this->container['admin'] = new Springdevs\SocialShare\Admin();
        }

        if ($this->is_request('frontend')) {
            $this->container['frontend'] = new Springdevs\SocialShare\Frontend();
        }

        if ($this->is_request('ajax')) {
            // require_once SDEVS_SOCIAL_SHARE_INCLUDES . '/class-ajax.php';
        }
    }

    /**
     * Initialize the hooks
     *
     * @return void
     */
    public function init_hooks()
    {
        add_action('init', [$this, 'init_classes']);
    }

    /**
     * Instantiate the required classes
     *
     * @return void
     */
    public function init_classes()
    {
        if ($this->is_request('ajax')) {
            // $this->container['ajax'] =  new Springdevs\SocialShare\Ajax();
        }

        $this->container['api']    = new Springdevs\SocialShare\Api();
        $this->container['assets'] = new Springdevs\SocialShare\Assets();
    }

    /**
     * What type of request is this?
     *
     * @param string $type admin, ajax, cron or frontend.
     *
     * @return bool
     */
    private function is_request($type)
    {
        switch ($type) {
            case 'admin':
                return is_admin();

            case 'ajax':
                return defined('DOING_AJAX');

            case 'rest':
                return defined('REST_REQUEST');

            case 'cron':
                return defined('DOING_CRON');

            case 'frontend':
                return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
        }
    }
} // Sdevs_social_share

/**
 * Initialize the main plugin
 *
 * @return \Sdevs_social_share|bool
 */
function sdevs_social_share()
{
    return Sdevs_social_share::init();
}

/**
 *  kick-off the plugin
 */
sdevs_social_share();
