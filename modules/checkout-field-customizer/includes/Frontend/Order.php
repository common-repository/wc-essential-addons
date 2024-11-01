<?php


namespace SpringDevs\Cfc\Frontend;


/**
 *
 * Class Order
 *
 * @package SpringDevs\Cfc\Frontend
 *
 */
class Order
{
    public function __construct()
    {
        add_action('woocommerce_order_details_after_order_table', [$this, 'display_custom_field_data']);
    }

    public function display_custom_field_data($order)
    {
        $billing_fields = get_option('cfc_billing_fields', []);
        $shipping_fields = get_option('cfc_shipping_fields', []);
        $order_fields = get_option('cfc_order_fields', []);

        $billing_details = [];

        foreach ($billing_fields as $billing_field) {
            if ($billing_field['from'] == 'custom' && $billing_field['status'] == 'enable' && $billing_field['display_in_order'] == 'yes') {
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
            if ($shipping_field['from'] == 'custom' && $shipping_field['status'] == 'enable' && $shipping_field['display_in_order'] == 'yes') {
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
            if ($order_field['from'] == 'custom' && $order_field['status'] == 'enable' && $order_field['display_in_order'] == 'yes') {
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
            <h2 class="woocommerce-order-details__title"><?php _e('Billing Details', 'sdevs_wea'); ?></h2>
            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
                <tfoot>
                <?php foreach ($billing_details as $billing_detail): ?>
                    <tr class="woocommerce-table__line-item order_item">
                        <th class="woocommerce-table__product-name product-name">
                            <?php _e($billing_detail['label'], 'sdevs_wea'); ?>
                        </th>
                        <td class="woocommerce-table__product-total product-total"><?php echo $billing_detail['value']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tfoot>
            </table>
            <?php
        }

        if (count($shipping_details) > 0) {
            ?>
            <h2 class="woocommerce-order-details__title"><?php _e('Shipping Details', 'sdevs_wea'); ?></h2>
            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
                <tfoot>
                <?php foreach ($shipping_details as $shipping_detail): ?>
                    <tr class="woocommerce-table__line-item order_item">
                        <th class="woocommerce-table__product-name product-name">
                            <?php _e($shipping_detail['label'], 'sdevs_wea'); ?>
                        </th>
                        <td class="woocommerce-table__product-total product-total"><?php echo $shipping_detail['value']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tfoot>
            </table>
            <?php
        }

        if (count($order_details) > 0) {
            ?>
            <h2 class="woocommerce-order-details__title"><?php _e('Order Details', 'sdevs_wea'); ?></h2>
            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
                <tfoot>
                <?php foreach ($order_details as $order_detail): ?>
                    <tr class="woocommerce-table__line-item order_item">
                        <th class="woocommerce-table__product-name product-name">
                            <?php _e($order_detail['label'], 'sdevs_wea'); ?>
                        </th>
                        <td class="woocommerce-table__product-total product-total"><?php echo $order_detail['value']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tfoot>
            </table>
            <?php
        }
    }
}
