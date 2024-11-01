<?php

namespace Springdevs\SocialShare\Frontend;

/**
 * Class Product
 * @package Springdevs\SocialShare\Frontend
 */
class Product
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        $position = get_option('psb_buttons_visible_position', 'default');
        if ($position === 'default') {
            add_action('woocommerce_share', [$this, 'social_share_template']);
        } elseif ($position === 'after_product_image') {
            add_action('woocommerce_product_thumbnails', [$this, 'social_share_template']);
        } elseif ($position === 'after_product_title') {
            add_action('woocommerce_single_product_summary', [$this, 'social_share_template'], 7);
        } elseif ($position === 'before_product_title') {
            add_action('woocommerce_single_product_summary', [$this, 'social_share_template'], 1);
        } elseif ($position === 'after_short_desc') {
            add_action('woocommerce_single_product_summary', [$this, 'social_share_template'], 22);
        } elseif ($position === 'after_add_to_cart_button') {
            add_action('woocommerce_after_add_to_cart_button', [$this, 'social_share_template']);
        } elseif ($position === 'inside_description') {
            add_action('woocommerce_after_single_product_summary', [$this, 'social_share_template']);
        }
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('psb-font-awesome');
        wp_enqueue_style('psb-front-style');
    }

    public function social_share_template()
    {
        $social_buttons = $this->social_buttons();
        include_once SDEVS_SOCIAL_SHARE_PATH . '/templates/' . get_option('psb_button_design', 3) . '.php';
    }

    public function social_buttons()
    {
        global $product;
        $buttons = [];
        $social_buttons = get_option('psb_social_buttons', []);
        foreach ($social_buttons as $social_button) {
            if ($social_button === 'facebook') {
                $buttons[] = [
                    'class' => 'fb',
                    'label' => 'Facebook',
                    'icon' => 'fa-facebook',
                    'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink()
                ];
            } elseif ($social_button === 'twitter') {
                $buttons[] = [
                    'class' => 'tw',
                    'label' => 'Twitter',
                    'icon' => 'fa-twitter',
                    'url' => 'https://twitter.com/intent/tweet?url=' . get_the_permalink() . '&text=' . get_the_title()
                ];
            } elseif ($social_button === 'pinterest') {
                $buttons[] = [
                    'class' => 'pinterest',
                    'label' => 'Pinterest',
                    'icon' => 'fa-pinterest-p',
                    'url' => 'https://pinterest.com/pin/create/button/?url=' . get_the_permalink() . '&media=' . wp_get_attachment_url($product->get_image_id()) . '&description=' . get_the_title()
                ];
            } elseif ($social_button === 'email') {
                $buttons[] = [
                    'class' => 'email',
                    'label' => 'Email',
                    'icon' => 'fa-envelope',
                    'url' => 'mailto:info@example.com?&subject=&cc=&bcc=&body=' . get_the_permalink() . ' ' . get_the_title()
                ];
            } elseif ($social_button === 'instagram') {
                $buttons[] = [
                    'class' => 'insta',
                    'label' => 'Instagram',
                    'icon' => 'fa-instagram',
                    'url' => ''
                ];
            } elseif ($social_button === 'linkedin') {
                $buttons[] = [
                    'class' => 'in',
                    'label' => 'Linked In',
                    'icon' => 'fa-linkedin',
                    'url' => 'https://www.linkedin.com/shareArticle?mini=true&url=' . get_the_permalink()
                ];
            } elseif ($social_button === 'reddit') {
                $buttons[] = [
                    'class' => 'reddit',
                    'label' => 'Reddit',
                    'icon' => 'fa-reddit',
                    'url' => 'https://www.reddit.com/submit?url=' . get_the_permalink() . '&title=' . get_the_title()
                ];
            } elseif ($social_button === 'tumblr') {
                $buttons[] = [
                    'class' => 'tumblr',
                    'label' => 'Tumblr',
                    'icon' => 'fa-tumblr',
                    'url' => 'http://www.tumblr.com/share/link?url=' . get_the_permalink()
                ];
            } elseif ($social_button === 'whatsapp') {
                $buttons[] = [
                    'class' => 'whatsapp',
                    'label' => 'WhatsApp',
                    'icon' => 'fa-whatsapp',
                    'url' => 'https://wa.me/?text=' . get_the_permalink()
                ];
            } elseif ($social_button === 'skype') {
                $buttons[] = [
                    'class' => 'skype',
                    'label' => 'Skype',
                    'icon' => 'fa-skype',
                    'url' => 'https://web.skype.com/share?url=' . get_the_permalink()
                ];
            } elseif ($social_button === 'telegram') {
                $buttons[] = [
                    'class' => 'telegram',
                    'label' => 'Telegram',
                    'icon' => 'fa-telegram',
                    'url' => 'https://telegram.me/share/url?url=' . get_the_permalink() . '&text=' . get_the_title()
                ];
            }
        }
        return $buttons;
    }
}
