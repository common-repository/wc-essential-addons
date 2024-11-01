<?php

namespace SpringDevs\Cfc;

use SpringDevs\Cfc\Frontend\Checkout;
use SpringDevs\Cfc\Frontend\Order;
use SpringDevs\Cfc\Illuminate\Email;

/**
 * Frontend handler class
 */
class Frontend
{
    /**
     * Frontend constructor.
     */
    public function __construct()
    {
        new Checkout();
        new Order();
        new Email();
    }
}
