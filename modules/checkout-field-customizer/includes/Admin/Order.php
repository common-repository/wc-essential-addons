<?php


namespace SpringDevs\Cfc\Admin;


class Order
{
    public function __construct()
    {
        add_action('woocommerce_admin_order_data_after_order_details', [$this, 'display_custom_order_details']);
    }

    public function display_custom_order_details($order)
    {
        $billing_fields = get_option('cfc_billing_fields', []);
        $shipping_fields = get_option('cfc_shipping_fields', []);
        $order_fields = get_option('cfc_order_fields', []);

        $billing_details = [];

        foreach ($billing_fields as $billing_field) {
            if ($billing_field['from'] == 'custom' && $billing_field['status'] == 'enable') {
                $order_meta = get_post_meta($order->get_id(), $billing_field['key'], true);
                if ($order_meta) {
                    array_push($billing_details, [
                        'label' => $billing_field['label'],
                        'value' => $order_meta
                    ]);
                }
            }
        }

        $shipping_details = [];

        foreach ($shipping_fields as $shipping_field) {
            if ($shipping_field['from'] == 'custom' && $shipping_field['status'] == 'enable') {
                $order_meta = get_post_meta($order->get_id(), $shipping_field['key'], true);
                if ($order_meta) {
                    array_push($shipping_details, [
                        'label' => $shipping_field['label'],
                        'value' => $order_meta
                    ]);
                }
            }
        }

        $order_details = [];

        foreach ($order_fields as $order_field) {
            if ($order_field['from'] == 'custom' && $order_field['status'] == 'enable') {
                $order_meta = get_post_meta($order->get_id(), $order_field['key'], true);
                if ($order_meta) {
                    array_push($order_details, [
                        'label' => $order_field['label'],
                        'value' => $order_meta
                    ]);
                }
            }
        }

        if (count($billing_details) > 0) {
            ?>
            <div class="order_data_column" style="margin-right: 20px;">
                <h3><?php _e('Billing Details', 'sdevs_wea'); ?></h3>
                <?php foreach ($billing_details as $billing_detail): ?>
                    <p><strong><?php _e($billing_detail['label'], 'sdevs_wea'); ?>
                            : </strong><?php echo $billing_detail['value']; ?></p>
                <?php endforeach; ?>
            </div>
            <?php
        }

        if (count($shipping_details) > 0) {
            ?>
            <div class="order_data_column" style="margin-right: 20px;">
                <h3><?php _e('Shipping Details', 'sdevs_wea'); ?></h3>
                <?php foreach ($shipping_details as $shipping_detail): ?>
                    <p><strong><?php _e($shipping_detail['label'], 'sdevs_wea'); ?>
                            : </strong><?php echo $shipping_detail['value']; ?></p>
                <?php endforeach; ?>
            </div>
            <?php
        }

        if (count($order_details) > 0) {
            ?>
            <div class="order_data_column">
                <h3><?php _e('Order Details', 'sdevs_wea'); ?></h3>
                <?php foreach ($order_details as $order_detail): ?>
                    <p><strong><?php _e($order_detail['label'], 'sdevs_wea'); ?>
                            : </strong><?php echo $order_detail['value']; ?></p>
                <?php endforeach; ?>
            </div>
            <?php
        }
    }
}
