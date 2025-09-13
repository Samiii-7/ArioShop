<?php
/**
 * The Template for displaying product archives (shop page)
 *
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

do_action( 'woocommerce_before_main_content' );
?>
<main class="bg-[#0D060F]">
<div class="max-w-screen-lg mx-auto sm:px-6 flex flex-col gap-6 p-4">

  <!-- منو -->
  <div class="relative mt-6">
    <button id="menu-btn" class="flex flex-col justify-between w-8 h-6 focus:outline-none z-50 hover:cursor-pointer relative">
        <span class="block h-1 w-full bg-[#EDE0D4] transition-transform origin-center"></span>
        <span class="block h-1 w-full bg-[#EDE0D4] transition-opacity"></span>
        <span class="block h-1 w-full bg-[#EDE0D4] transition-transform origin-center"></span>
    </button>
<!-- گزینه ها -->
    <div id="menu-items" class="absolute top-full right-0 lg:right-10 opacity-0 pointer-events-none transition-all duration-500 z-40 flex flex-col lg:flex-row gap-2 lg:gap-4 mt-2 lg:mt-0">
        <a href="<?php echo get_permalink( get_page_by_path('faq')->ID ); ?>" class="flex items-center justify-center w-full lg:w-40 h-10 px-4 bg-[#5D3C18] rounded-lg text-[#EDE0D4] text-center hover:bg-[#EDE0D4] hover:text-[#5D3C18] transition">سوالات متداول</a>
        <a href="<?php echo get_permalink( get_page_by_path('contact')->ID ); ?>" class="flex items-center justify-center w-full lg:w-40 h-10 px-4 bg-[#5D3C18] rounded-lg text-[#EDE0D4] text-center hover:bg-[#EDE0D4] hover:text-[#5D3C18] transition">ارتباط با ما</a>
        <a href="<?php echo get_permalink( get_page_by_path('about')->ID ); ?>" class="flex items-center justify-center w-full lg:w-40 h-10 px-4 bg-[#5D3C18] rounded-lg text-[#EDE0D4] text-center hover:bg-[#EDE0D4] hover:text-[#5D3C18] transition">معرفی ما</a>
    </div>
  </div>

  <script>
    const btn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu-items');
    const items = menu.querySelectorAll('a');
    let open = false;

    btn.addEventListener('click', () => {
      open = !open;
      if(open){
        menu.classList.remove('opacity-0','pointer-events-none');
        menu.classList.add('opacity-100','pointer-events-auto');
        items.forEach((item, i) => {
          item.style.transitionDelay = `${i * 100}ms`;
          item.classList.remove('translate-x-6');
          item.classList.add('translate-x-0');
        });
      } else {
        menu.classList.add('opacity-0','pointer-events-none');
        menu.classList.remove('opacity-100','pointer-events-auto');
        items.forEach((item) => {
          item.style.transitionDelay = `0ms`;
          item.classList.remove('translate-x-0');
          item.classList.add('translate-x-6');
        });
      }

      const spans = btn.querySelectorAll('span');
      if(open){
        spans[0].classList.add('rotate-45','translate-y-2');
        spans[1].classList.add('opacity-0');
        spans[2].classList.add('-rotate-45','-translate-y-2');
      } else {
        spans[0].classList.remove('rotate-45','translate-y-2');
        spans[1].classList.remove('opacity-0');
        spans[2].classList.remove('-rotate-45','-translate-y-2');
      }
    });
  </script>

<div class="container mx-auto py-8">
    <div class="swiper shopr2r-product-carousel">
        <div class="swiper-wrapper">
            <?php
            $products = new WP_Query([
                'post_type' => 'product',
                'posts_per_page' => 10,
                'orderby' => 'date',
                'order' => 'ASC',
            ]);

            $color_map = [
                'آبی' => 'blue',
                'مشکی' => 'black',
                'سفید' => 'white',
                'قهوه‌ای' => 'brown',
                'طوسی' => 'gray'
            ];

            if ($products->have_posts()):
                while ($products->have_posts()): $products->the_post();
                    global $product;
                    $price = floatval($product->get_price());
                    $regularPrice = floatval($product->get_regular_price());
                    $offPercent = 0;
                    if ($regularPrice > 0 && $price < $regularPrice) {
                        $offPercent = round(100 * ($regularPrice - $price) / $regularPrice);
                    }

                    $size_attrs = ['size', 'سایز'];
                    $color_attrs = ['color', 'رنگ'];
                    $sizes_arr = [];
                    $colors_arr = [];

                    foreach ($size_attrs as $attr) {
                        $tmp = $product->get_attribute($attr);
                        if ($tmp) {
                            $sizes_arr = preg_split('/[,\|]/', $tmp);
                            $sizes_arr = array_map('trim', $sizes_arr);
                            break;
                        }
                    }

                    foreach ($color_attrs as $attr) {
                        $tmp = $product->get_attribute($attr);
                        if ($tmp) {
                            $colors_arr = preg_split('/[,\|]/', $tmp);
                            $colors_arr = array_map('trim', $colors_arr);
                            break;
                        }
                    }
            ?>

            <!-- کانتینر محصولات -->
            <div class="swiper-slide py-2 w-full">
                <!-- عکس محصول -->
                <div class="bg-[#230000] rounded-lg flex flex-col h-full transition hover:shadow-gray-500 hover:shadow-md">
                    <?php echo $product->get_image('medium', ['class' => 'w-full h-104 object-cover rounded-t-md mb-4']); ?>
                    <!-- نام محصول -->
                    <div class="p-2">
                        <h3 class="text-xl text-[#EDE0D4]"><?php the_title() ?></h3>
                        <!-- قیمت محصول -->
                        <div class="flex flex-wrap gap-2 items-center mb-2">
                            <?php if ($offPercent > 0): ?>
                                <span class="bg-red-600 text-[#EDE0D4] px-1 rounded-md text-xs"><?= number_format($offPercent) ?>%</span>
                            <?php endif; ?>
                            <?php if ($offPercent > 0): ?>
                                <span class="text-[#EDE0D4] line-through text-sm"><?= number_format($regularPrice) ?></span>
                            <?php endif; ?>
                            <span class="font-bold text-sm text-[#EDE0D4]"><?= number_format($price) ?></span>
                            <span class="text-sm text-[#EDE0D4]">ریال</span>
                        </div>
                        <!-- سایزبندی -->
                        <?php if ($sizes_arr): ?>
                        <div class="mb-2">
                            <label class="block text-sm font-semibold mb-1 text-[#EDE0D4]">سایز:</label>
                            <select class="w-full border border-[#EDE0D4] rounded px-2 py-1 text-sm text-[#EDE0D4] bg-[#230000] size-select">
                                <?php foreach ($sizes_arr as $custom_size): ?>
                                    <option class="text-[#EDE0D4]" value="<?= esc_attr($cusrom_size) ?>"><?= esc_html($custom_size) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>
                        <!-- رنگبندی -->
                        <?php if ($colors_arr): ?>
                        <div class="mb-3">
                            <span class="block text-sm font-semibold mb-1 text-[#EDE0D4]">رنگ:</span>
                            <div class="flex gap-2 color-btns">
                                <?php foreach ($colors_arr as $custom_color): 
                                    $color_css = isset($color_map[$custom_color]) ? $color_map[$custom_color] : 'white';
                                ?>
                                    <button type="button" style="background-color: <?= esc_attr($color_css) ?>;" class="w-6 h-6 rounded-full border border-gray-500"></button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <form class="mt-auto add-to-cart-form" action="<?= esc_url( $product->add_to_cart_url() ); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="add-to-cart" value="<?= esc_attr( $product->get_id() ); ?>">
                            <input type="hidden" name="custom_size" class="custom_size_input" value="<?= esc_attr($sizes_arr[0] ?? '') ?>">
                            <input type="hidden" name="custom_color" class="custom_color_input" value="<?= esc_attr($colors_arr[0] ?? '') ?>">
                            <button type="submit" class="w-full bg-[#5D3C18] text-[#EDE0D4] py-2 rounded hover:bg-[#EDE0D4] hover:text-[#5D3C18] transition">افزودن به سبد خرید</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <h1 class="text-2xl text-center mt-12 text-[#EDE0D4]"> آریو، فروشگاهی که خاص بودن، تنها شرط انتخاب شماست! </h1>

    <div class="flex flex-col lg:flex-row mb-12 p-6 text-center">
        <div class="flex flex-col lg:flex-row mb-12 p-6 text-center"> 
        <!-- بخش توضیحات --> 
        <div class="w-full lg:w-7/12 text-gray-700 text-right mb-6 lg:mb-0">
            <p class="text-justify text-[#EDE0D4]">آریو جایی که لباس‌ها فقط برای پوشیدن نیستند، بلکه آمده‌اند تا داستان خلاقیت شما را روایت ‌کنند. در این صفحه شما با شخصی‌سازی لباس، این امکان را دارید که استایل منحصربه‌فرد خود را خلق ‌کنید. امکانات این بخش از انتخاب رنگ و مدل گرفته تا چاپ اسم، لوگو یا جمله‌ای خاص، بدون هیچ‌گونه اشتراکی در اختیار شما قرار خواهد گرفت. با ورود به این بخش در کمترین زمان لباس اختصاصی خودتان را به صورت سه بعدی طراحی و مشاهده کنید. ما این‌جا هستیم تا تجربه‌ای آسان و لذت‌بخش را در محیط آنلاین برای ایجاد پوششی به یاد ماندنی فراهم کنیم!</p> 
        </div>
        <!-- لینک صفحات شخصی سازی -->
        <div class="w-full lg:w-5/12 flex flex-col items-center gap-4 text-[#EDE0D4]">
            <div class="flex gap-4 flex-wrap justify-center">
                <a href="<?php echo get_permalink( get_page_by_path('tshirt')->ID ); ?>" class="h-10 w-20 px-4 py-2 bg-[#5D3C18] rounded transition hover:bg-[#EDE0D4] hover:text-[#5D3C18]">تی‌شرت</a>
                <a href="<?php echo get_permalink( get_page_by_path('hoodie')->ID ); ?>" class="h-10 w-20 px-4 py-2 bg-[#5D3C18] rounded transition hover:bg-[#EDE0D4] hover:text-[#5D3C18]">هودی</a>
            </div>
            <div class="mt-2">
                <a href="<?php echo get_permalink( get_page_by_path('sweatshirt')->ID ); ?>" class="h-10 w-20 px-4 py-2 bg-[#5D3C18] rounded transition hover:bg-[#EDE0D4] hover:text-[#5D3C18]">دورس</a>
            </div>
        </div>
    </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const swiper = new Swiper('.shopr2r-product-carousel', {
        slidesPerView: 3,
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: { 320:{slidesPerView:1},640:{slidesPerView:1},768:{slidesPerView:2},1024:{slidesPerView:3} },
    });

    document.querySelectorAll('.swiper-slide').forEach(slide => {
        const sizeSelect = slide.querySelector('.size-select');
        const colorBtns = slide.querySelectorAll('.color-btns button');
        const sizeInput = slide.querySelector('.custom_size_input');
        const colorInput = slide.querySelector('.custom_color_input');

        if(sizeSelect && sizeInput){
            sizeSelect.addEventListener('change', e => { sizeInput.value = e.target.value; });
        }
        if(colorBtns && colorInput){
            colorBtns.forEach(btn => {
                btn.addEventListener('click', e => {
                    colorInput.value = btn.style.backgroundColor;
                    colorBtns.forEach(b=>b.classList.remove('ring-2','ring-blue-500'));
                    btn.classList.add('ring-2','ring-blue-500');
                });
            });
        }
    });
});
</script>
</main>
<?php
do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );
?>
