<?php
/*
Module Name: Checkout Field Customizer
*/

// don't call the file directly
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Sdevs_cfc class
 *
 * @class Sdevs_cfc The class that holds the entire Sdevs_cfc plugin
 */
final class Sdevs_cfc
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
     * Constructor for the Sdevs_cfc class
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
     * Initializes the Sdevs_cfc() class
     *
     * Checks for an existing Sdevs_cfc() instance
     * and if it doesn't find one, creates it.
     *
     * @return Sdevs_cfc|bool
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new Sdevs_cfc();
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
        define('CFC_ASSETS_VERSION', self::version);
        define('CFC_ASSETS_FILE', __FILE__);
        define('CFC_ASSETS_PATH', dirname(CFC_ASSETS_FILE));
        define('CFC_ASSETS_INCLUDES', CFC_ASSETS_PATH . '/includes');
        define('CFC_ASSETS_URL', plugins_url('', CFC_ASSETS_FILE));
        define('CFC_ASSETS_ASSETS', CFC_ASSETS_URL . '/assets');
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
            $this->container['admin'] = new SpringDevs\Cfc\Admin();
        }

        if ($this->is_request('frontend')) {
            $this->container['frontend'] = new SpringDevs\Cfc\Frontend();
        }

        if ($this->is_request('ajax')) {
            // require_once CFC_ASSETS_INCLUDES . '/class-ajax.php';
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
            $this->container['ajax'] =  new SpringDevs\Cfc\Ajax();
        }

        $this->container['api']    = new SpringDevs\Cfc\Api();
        $this->container['assets'] = new SpringDevs\Cfc\Assets();
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
} // Sdevs_cfc

/**
 * Initialize the main plugin
 *
 * @return \Sdevs_cfc|bool
 */
function sdevs_cfc()
{
    return Sdevs_cfc::init();
}

/**
 *  kick-off the plugin
 */
sdevs_cfc();
