<?php

namespace Springdevs\SocialShare;

use Springdevs\SocialShare\Admin\Forms;
use Springdevs\SocialShare\Admin\Settings;

/**
 * The admin class
 */
class Admin
{

    /**
     * Initialize the class
     */
    public function __construct()
    {
        $this->dispatch_actions();
        new Forms();
        new Settings();
    }

    /**
     * Dispatch and bind actions
     *
     * @return void
     */
    public function dispatch_actions()
    {
    }
}
