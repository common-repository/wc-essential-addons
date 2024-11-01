<?php

namespace SpringDevs\Cfc;

use SpringDevs\Cfc\Admin\Order;
use SpringDevs\Cfc\Illuminate\Email;

/**
 * The admin class
 */
class Admin {

    /**
     * Initialize the class
     */
    public function __construct() {
        $this->dispatch_actions();
        new Admin\Menu();
        new Order();
        new Email();
    }

    /**
     * Dispatch and bind actions
     *
     * @return void
     */
    public function dispatch_actions() {

    }

}
