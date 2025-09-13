<?php
/* Template Name: cartsample */
defined('ABSPATH') || exit;
get_header();
?>

<div class="bg-[#161D0D] min-h-screen text-white">
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-center text-3xl md:text-4xl font-extrabold mb-8 text-[#FEFAE0] transition-all duration-300 hover:scale-110 hover:text-[#A15F13]">سبد خرید شما</h1>

        <?php if (WC()->cart->is_empty()) : ?>
            <div class="text-center p-8">
                <p class="text-lg text-[#EDE0D4]">سبد خرید شما خالی است 😢</p>
                <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="inline-block mt-5 bg-[#A15F13] text-[#EDE0D4] hover:bg-[#EDE0D4] hover:text-[#A15F13] px-6 py-3 rounded-lg shadow-md transition">
                    رفتن به فروشگاه
                </a>
            </div>
        <?php else : ?>
            <form id="dynamic-cart-form" method="post" action="<?php echo esc_url(wc_get_cart_url()); ?>" class="space-y-6">
                <div class="flex flex-wrap justify-center gap-8">
                    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                        $_product   = $cart_item['data'];
                        if (!$_product || !$_product->exists()) continue;

                        $product_name = $_product->get_name();
                        $thumbnail = $_product->get_image('woocommerce_thumbnail', ['class' => 'rounded-full w-40 h-40 mx-auto shadow-md border-4 border-[#1F2D1F]']);
                        $product_price = WC()->cart->get_product_price($_product);
                        $product_subtotal = WC()->cart->get_product_subtotal($_product, $cart_item['quantity']);

                        // بررسی محصول سفارشی
                        $is_custom_product = isset($cart_item['custom_data']); 

                        // تعیین سایز و رنگ برای هر نوع محصول
                        if ($is_custom_product) {
                            $custom_size  = $cart_item['custom_size'] ?? '';
                            $custom_color = $cart_item['custom_color'] ?? '';
                        } else {
                            // محصولات ساده ووکامرس: مقدار انتخاب شده توسط کاربر
                            $custom_size  = $cart_item['attributes']['سایز'] ?? '';
                            $custom_color = $cart_item['attributes']['رنگ'] ?? '';
                        }

                        // نگاشت رنگ انگلیسی به فارسی
                        $color_map = [
                            'blue'  => 'آبی',
                            'black' => 'مشکی',
                            'white' => 'سفید',
                            'brown' => 'قهوه‌ای',
                            'gray'  => 'طوسی'
                        ];
                        if ($custom_color && isset($color_map[$custom_color])) {
                            $custom_color = $color_map[$custom_color];
                        }
                    ?>
                        <div class="bg-[#1F2D1F] rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 flex flex-col items-center text-center w-72">
                            <div class="mb-4">
                                <?php 
                                $custom_image = $cart_item['custom_data']['تصویر'] ?? '';
                                if ($custom_image) {
                                    echo '<img src="' . esc_url($custom_image) . '" class="rounded-full w-40 h-40 mx-auto shadow-md border-4 border-[#1F2D1F]">';
                                } else {
                                    echo $thumbnail;
                                }
                                ?>
                            </div>

                            <h3 class="text-xl font-bold text-white"><?php echo esc_html($product_name); ?></h3>
                            <p class="text-lg font-semibold text-white mt-2"><?php echo $product_price; ?></p>

                            <?php if ($custom_size): ?>
                                <p class="text-sm mt-1"><strong>سایز:</strong> <?php echo esc_html($custom_size); ?></p>
                            <?php endif; ?>
                            <?php if ($custom_color): ?>
                                <p class="text-sm mt-1"><strong>رنگ:</strong> <?php echo esc_html($custom_color); ?></p>
                            <?php endif; ?>

                            <?php if ($is_custom_product) :
                                foreach ($cart_item['custom_data'] as $key => $value) :
                                    if (in_array($key, ['سایز','رنگ','تصویر'])) continue;
                            ?>
                                    <p class="text-sm mt-1"><strong><?php echo esc_html($key); ?>:</strong> <?php echo esc_html($value); ?></p>
                            <?php endforeach; endif; ?>

                            <div class="flex items-center justify-center mt-4 bg-[#253822] px-3 py-1 rounded-full shadow-md gap-3">
                                <button type="button" class="decrease-qty bg-[#A15F13] text-[#EDE0D4] transition hover:bg-[#EDE0D4] hover:text-[#A15F13] rounded-lg text-lg font-bold px-2">−</button>
                                <input type="number"
                                       name="cart[<?php echo $cart_item_key; ?>][qty]"
                                       value="<?php echo esc_attr($cart_item['quantity']); ?>"
                                       min="0"
                                       class="text-center w-12 bg-transparent border-none text-white text-lg font-bold focus:outline-none">
                                <button type="button" class="increase-qty bg-[#A15F13] text-[#EDE0D4] transition hover:bg-[#EDE0D4] hover:text-[#A15F13] rounded-lg text-lg font-bold px-2">+</button>
                            </div>

                            <p class="mt-3 text-gray-300">جمع: <?php echo $product_subtotal; ?></p>
                            <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>"
                               class="mt-4 w-10 h-10 flex items-center justify-center rounded-full bg-orange-700 text-white text-xl hover:bg-[#EDE0D4] hover:text-orange-700 transition">
                                &times;
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="flex justify-center mt-8">
                    <button type="submit" class="bg-[#A15F13] text-[#EDE0D4] hover:bg-[#EDE0D4] hover:text-[#A15F13] px-8 py-3 rounded-lg shadow-md transition text-lg font-bold"
                            name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>">
                        بروزرسانی سبد خرید
                    </button>
                    <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                </div>
            </form>

            <div class="cart-collaterals mt-10 bg-[#1F2D1F] rounded-xl p-6 shadow-md max-w-xl mx-auto text-center">
                <h2 class="text-2xl font-bold mb-4">جمع کل:</h2>
                <div class="text-lg font-semibold mb-6">
                    <?php wc_cart_totals_subtotal_html(); ?>
                </div>
                <div class="wc-proceed-to-checkout">
                    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>"
                       class="bg-[#A15F13] text-[#EDE0D4] hover:bg-[#EDE0D4] hover:text-[#A15F13] px-8 py-3 rounded-lg shadow-md transition text-lg font-bold">
                        رفتن به صفحه پرداخت
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
input[type=number] { -moz-appearance: textfield; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.increase-qty').forEach(function(btn){
        btn.addEventListener('click', function(){
            let input = btn.parentElement.querySelector('input[type=number]');
            input.value = parseInt(input.value) + 1;
        });
    });
    document.querySelectorAll('.decrease-qty').forEach(function(btn){
        btn.addEventListener('click', function(){
            let input = btn.parentElement.querySelector('input[type=number]');
            if(parseInt(input.value) > 0) input.value = parseInt(input.value) - 1;
        });
    });
});
</script>

<?php get_footer(); ?>
