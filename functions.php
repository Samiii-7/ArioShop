<?php
// WooCommerce hooks
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open'); // لینک نشدن کل کارت محصول
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close');
add_filter('woocommerce_enqueue_styles', '__return_false'); // حذف استایل‌های پیش‌فرض ووکامرس

// Theme setup
function mytheme_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 350,
        'single_image_width'    => 500,
    ));

    register_nav_menus([
        "Header" => "Header Menu"
    ]);
}
add_action('after_setup_theme', 'mytheme_setup');

// Customizer - Social Media Links
add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_section('shopr2r_social_links', [
        'title'    => __('Social Media Links', 'ShopR2R'),
        'priority' => 30,
    ]);

    // Telegram
    $wp_customize->add_setting('shopr2r_telegram', [
        'default'   => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('shopr2r_telegram', [
        'label'   => __('Telegram URL', 'ShopR2R'),
        'section' => 'shopr2r_social_links',
        'type'    => 'url',
    ]);

    // Instagram
    $wp_customize->add_setting('shopr2r_instagram', [
        'default'   => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('shopr2r_instagram', [
        'label'   => __('Instagram URL', 'ShopR2R'),
        'section' => 'shopr2r_social_links',
        'type'    => 'url',
    ]);
});

// Enqueue Styles & Scripts
function shopr2r_enqueue_styles() {
    wp_enqueue_style('shopr2r-style', get_stylesheet_uri());
    wp_enqueue_style('shopr2r-webfont', get_template_directory_uri() . "/assets/fontiran.css");
    wp_enqueue_script('tailwind', "https://cdn.tailwindcss.com", array(), null, true);
}
add_action('wp_enqueue_scripts', 'shopr2r_enqueue_styles');

// Persian numerals
function toPersianNumerals($input) {
    $english = ['0','1','2','3','4','5','6','7','8','9'];
    $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    return str_replace($english, $persian, (string) $input);
}

// Custom meta field helper
function shopr2r_add_custom_field($fieldName, $postType, $title) {
    add_action('add_meta_boxes', function () use ($fieldName, $postType, $title) {
        add_meta_box(
            $fieldName . '_box',
            $title,
            function ($post) use ($fieldName) {
                $value = get_post_meta($post->ID, $fieldName, true);
                wp_nonce_field($fieldName . '_nonce', $fieldName . '_nonce_field');
                echo '<input type="text" style="width:100%" name="' . esc_attr($fieldName) . '" value="' . esc_attr($value) . '">';
            },
            $postType,
            'normal',
            'default'
        );
    });

    add_action('save_post', function ($post_id) use ($fieldName) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!isset($_POST[$fieldName . '_nonce_field'])) return;
        if (!wp_verify_nonce($_POST[$fieldName . '_nonce_field'], $fieldName . '_nonce')) return;
        if (!current_user_can('edit_post', $post_id)) return;

        if (isset($_POST[$fieldName])) {
            $san = sanitize_text_field(wp_unslash($_POST[$fieldName]));
            update_post_meta($post_id, $fieldName, $san);
        } else {
            delete_post_meta($post_id, $fieldName);
        }
    });
}

// Swiper
function shopr2r_enqueue_swiper() {
    wp_enqueue_style('shopr2r-swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', array(), '10.0.0');
    wp_enqueue_script('shopr2r-swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), '10.0.0', true);
}
add_action('wp_enqueue_scripts', 'shopr2r_enqueue_swiper');

                
// Ajax Add to Cart 
add_action('wp_ajax_add_custom_tshirt_to_cart', 'add_custom_product_to_cart');
add_action('wp_ajax_nopriv_add_custom_tshirt_to_cart', 'add_custom_product_to_cart');
add_action('wp_ajax_add_custom_sweatshirt_to_cart', 'add_custom_product_to_cart');
add_action('wp_ajax_nopriv_add_custom_sweatshirt_to_cart', 'add_custom_product_to_cart');
add_action('wp_ajax_add_custom_hoodie_to_cart', 'add_custom_product_to_cart');
add_action('wp_ajax_nopriv_add_custom_hoodie_to_cart', 'add_custom_product_to_cart');

function add_custom_product_to_cart() {
    $action = $_POST['action'] ?? '';
    switch($action){
        case 'add_custom_tshirt_to_cart':
            $product_id = 373; break;
        case 'add_custom_sweatshirt_to_cart':
            $product_id = 379; break;
        case 'add_custom_hoodie_to_cart':
            $product_id = 378; break;
        default:
            wp_send_json(['success'=>false]); exit;
    }

    $model = sanitize_text_field($_POST['model'] ?? '');
    $size  = sanitize_text_field($_POST['size'] ?? '');
    $color = sanitize_text_field($_POST['color'] ?? '');
    $image = esc_url_raw($_POST['image'] ?? '');
    $desc  = sanitize_textarea_field($_POST['desc'] ?? '');

    if (!$model) {
        wp_send_json(['success'=>false]);
        exit;
    }

    $image_url = '';
if (!empty($_FILES['image']['name'])) {
    $uploaded_file = wp_handle_upload($_FILES['image'], ['test_form' => false]);
    if (isset($uploaded_file['url'])) {
        $image_url = $uploaded_file['url'];
    }
}

$cart_item_data = [
    'custom_data' => [
        'مدل' => $model,
        'سایز' => $size,
        'رنگ' => $color,
        'توضیحات' => $desc,
        'تصویر' => $image_url,
    ],
    'custom_size'  => $size,
    'custom_color' => $color,
    'custom_image' => $image_url,
];

    $added = WC()->cart->add_to_cart($product_id, 1, 0, [], $cart_item_data);
    wp_send_json(['success' => $added ? true : false]);
}

// نمایش اطلاعات سفارشی در سبد خرید
add_filter('woocommerce_get_item_data', 'display_custom_product_data', 10, 2);
function display_custom_product_data($item_data, $cart_item){

    //  محصول شخصی‌سازی شده
    if(isset($cart_item['custom_data'])){
        foreach($cart_item['custom_data'] as $key => $value){
            if($key === 'تصویر') continue;
            $item_data[] = [
                'name'  => $key,
                'value' => $value
            ];
        }
    }

    // محصولات ساده ووکامرس
    // if (empty($cart_item['variation']) && isset($cart_item['product_id'])) {
    //     $product = wc_get_product($cart_item['product_id']);
    //     if ($product) {
    //         $attributes = $product->get_attributes();
    //         foreach ($attributes as $key => $attr) {
    //             $label = $attr->get_name();
    //             $value = $cart_item['attributes'][$key] ?? '';

    //             if (stripos($label, 'size') !== false) $label = 'سایز';
    //             if (stripos($label, 'color') !== false) {
    //                 $label = 'رنگ';
    //                 $map = ['blue'=>'آبی','black'=>'مشکی','white'=>'سفید','brown'=>'قهوه‌ای','gray'=>'طوسی'];
    //                 if(isset($map[$value])) $value = $map[$value];
    //             }

    //             if($value) {
    //                 $item_data[] = [
    //                     'name'  => $label,
    //                     'value' => $value
    //                 ];
    //             }
    //         }
    //     }
    // }

    return $item_data;
}
