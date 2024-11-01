<?php


namespace SpringDevs\Cfc\Frontend;


/**
 *
 * Class Checkout
 *
 * @package SpringDevs\Cfc\Frontend
 *
 */

class Checkout
{

    public function __construct()
    {
        add_filter('woocommerce_checkout_fields', [$this, 'change_checkout_fields']);
        add_action('woocommerce_checkout_update_order_meta', [$this, "save_checkout_data"]);
    }

    /**
     *
     * Filter Checkout Fields
     *
     * @param $fields
     * @return mixed
     */
    public function change_checkout_fields($fields)
    {
        $billing_fields = get_option('cfc_billing_fields', []);
        $shipping_fields = get_option('cfc_shipping_fields', []);
        $order_fields = get_option('cfc_order_fields', []);

        $all_billing_fields = [];
        $all_shipping_fields = [];
        $all_order_fields = [];

        foreach ($billing_fields as $billing_field) {
            if ($billing_field['status'] === 'enable') {
                $options = [];

                if (isset($billing_field['options']) && is_array($billing_field['options'])) {
                    foreach ($billing_field['options'] as $billing_option) {
                        $options[$billing_option['option_value']] = $billing_option['option_label'];
                    }
                }

                $all_billing_fields[$billing_field['key']] = [
                    'type' => $billing_field['type'],
                    'label' => $billing_field['label'],
                    'required' => $billing_field['required'] == 'yes',
                    'type' => $billing_field['type'],
                    'placeholder' => isset($billing_field['placeholder']) ? $billing_field['placeholder'] : null,
                    'default' => isset($billing_field['value']) ? $billing_field['value'] : null,
                    'options' => $options,
                    'class' => is_array($billing_field['class']) ? $billing_field['class'] : explode(',', $billing_field['class']),
                ];
            }
        }

        foreach ($shipping_fields as $shipping_field) {
            if ($shipping_field['status'] === 'enable') {
                $options = [];

                if (isset($shipping_field['options']) && is_array($shipping_field['options'])) {
                    foreach ($shipping_field['options'] as $shipping_option) {
                        $options[$shipping_option['option_value']] = $shipping_option['option_label'];
                    }
                }

                $all_shipping_fields[$shipping_field['key']] = [
                    'type' => $shipping_field['type'],
                    'label' => $shipping_field['label'],
                    'required' => $shipping_field['required'] == 'yes',
                    'type' => $shipping_field['type'],
                    'placeholder' => isset($shipping_field['placeholder']) ? $shipping_field['placeholder'] : null,
                    'default' => isset($shipping_field['value']) ? $shipping_field['value'] : null,
                    'options' => $options,
                    'class' => is_array($shipping_field['class']) ? $shipping_field['class'] : explode(',', $shipping_field['class']),
                ];
            }
        }

        foreach ($order_fields as $order_field) {
            if ($order_field['status'] === 'enable') {
                $options = [];

                if (isset($order_field['options']) && is_array($order_field['options'])) {
                    foreach ($order_field['options'] as $order_option) {
                        $options[$order_option['option_value']] = $order_option['option_label'];
                    }
                }

                $all_order_fields[$order_field['key']] = [
                    'type' => $order_field['type'],
                    'label' => $order_field['label'],
                    'required' => $order_field['required'] == 'yes',
                    'type' => $order_field['type'],
                    'placeholder' => isset($order_field['placeholder']) ? $order_field['placeholder'] : null,
                    'default' => isset($order_field['value']) ? $order_field['value'] : null,
                    'options' => $options,
                    'class' => is_array($order_field['class']) ? $order_field['class'] : explode(',', $order_field['class']),
                ];
            }
        }

        $fields['billing'] = $all_billing_fields;
        $fields['shipping'] = $all_shipping_fields;
        $fields['order'] = $all_order_fields;
        return $fields;
    }


    /**
     * @param $order_id
     */
    public function save_checkout_data($order_id)
    {
        $billing_fields = get_option('cfc_billing_fields', []);
        $shipping_fields = get_option('cfc_shipping_fields', []);
        $order_fields = get_option('cfc_order_fields', []);

        foreach ($billing_fields as $billing_field) {
            if($billing_field['status'] != 'enable' && $billing_field['from'] != 'custom') continue;
            $field_key = $billing_field['key'];
            $field_value = isset($_POST[$field_key]) ? $_POST[$field_key] : null;

//            Sanitize field value
            if ($field_value != null) {
                if ($billing_field['type'] != 'email') {
                    $field_value = sanitize_text_field($field_value);
                } else {
                    $field_value = sanitize_email($field_value);
                }
            }

//            save data
            update_post_meta($order_id, $field_key, $field_value);
        }


        foreach ($shipping_fields as $shipping_field) {
            if($shipping_field['status'] != 'enable' && $shipping_field['from'] != 'custom') continue;
            $field_key = $shipping_field['key'];
            $field_value = isset($_POST[$field_key]) ? $_POST[$field_key] : null;

//            Sanitize field value
            if ($field_value != null) {
                if ($shipping_field['type'] != 'email') {
                    $field_value = sanitize_text_field($field_value);
                } else {
                    $field_value = sanitize_email($field_value);
                }
            }

//            save data
            update_post_meta($order_id, $field_key, $field_value);
        }


        foreach ($order_fields as $order_field) {
            if($order_field['status'] != 'enable' && $order_field['from'] != 'custom') continue;
            $field_key = $order_field['key'];
            $field_value = isset($_POST[$field_key]) ? $_POST[$field_key] : null;

//            Sanitize field value
            if ($field_value != null) {
                if ($order_field['type'] != 'email') {
                    $field_value = sanitize_text_field($field_value);
                } else {
                    $field_value = sanitize_email($field_value);
                }
            }

//            save data
            update_post_meta($order_id, $field_key, $field_value);
        }

    }

}
