<?php
/* Template Name: Personalize T-Shirt */
get_header(); 
?>
<main class="bg-[#161D0D]">
<div class="max-w-screen-lg mx-auto sm:px-6 flex flex-col gap-6 p-4">

    <h1 class="text-center my-8 text-4xl md:text-5xl font-extrabold text-[#FEFAE0] transition-all duration-300 hover:scale-110 hover:text-[#D58F3E]">شخصی‌سازی تی‌شرت</h1>

    <!-- باکس‌های انتخاب -->
    <div class="flex flex-col md:flex-row gap-4 md:gap-6 justify-between">

        <!-- مدل -->
        <div class="flex flex-col flex-1 text-[#EDE0D4]">
            <label class="mb-1 font-semibold">مدل تی‌شرت</label>
            <select id="product-model" class="border rounded px-3 py-2 bg-[#A15F13] text-[#EDE0D4]">
                <option value="ساده">ساده</option>
                <option value="باکسی">باکسی</option>
                <option value="لانگ">لانگ</option>
                <option value="پولو">پولو</option>
                <option value="یقه زیپ">یقه زیپ</option>
            </select>
        </div>

        <!-- سایز -->
        <div class="flex flex-col flex-1">
            <label class="mb-1 font-semibold text-[#EDE0D4]">سایز</label>
            <select id="product-size" class="border rounded px-3 py-2 bg-[#A15F13] text-[#EDE0D4]">
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
            </select>
        </div>

        <!-- رنگ -->
        <div class="flex flex-col flex-1">
            <label class="mb-1 font-semibold text-[#EDE0D4]">رنگ</label>
            <input type="color" id="product-color" class="w-24 h-10 border rounded">
        </div>

        <!-- آپلود طرح -->
        <div class="flex flex-col flex-1">
            <label class="mb-1 font-semibold text-[#EDE0D4]">آپلود طرح</label>
            <input type="file" id="product-image" name="product_image" accept="image/*" class="border rounded px-3 py-2 bg-[#A15F13] text-[#EDE0D4]">
        </div>

        <!-- توضیحات -->
        <div class="flex flex-col flex-1">
            <label class="mb-1 font-semibold text-[#EDE0D4]">توضیحات</label>
            <textarea id="product-desc" class="border rounded px-3 py-2 bg-[#A15F13] text-[#EDE0D4]" rows="2" placeholder="سایز و مکان طرح را توصیف کنید"></textarea>
        </div>

    </div>

    <!-- کانتینر مدل سه‌بعدی -->
    <div class="relative w-fit h-fit md:h-fit border rounded overflow-hidden mt-4 touch-none mx-auto">
        <?php echo do_shortcode('[3d_viewer id="395"]'); ?>
        <img id="overlay-image" src="" class="absolute cursor-move touch-pan-x touch-pan-y" style="top:50%; left:50%; transform:translate(-50%, -50%); width:160px; display:none;">
    </div>

    <!-- ثبت سفارش -->
    <div class="text-center mt-4">
      <button id="add-to-cart" type="button" class="p-2 bg-[#A15F13] text-[#EDE0D4] py-2 rounded hover:bg-[#EDE0D4] hover:text-[#A15F13] transition ">افزودن به سبد خرید</button>
    </div>
</div>
</main>

<script>
// آپلود و درگ اند دراپ و ریسایز عکس به روش اورلی
document.addEventListener("DOMContentLoaded", function(){

    const overlay = document.getElementById('overlay-image');
    const imageInput = document.getElementById('product-image');
    let isDragging = false;
    let offset = {x:0, y:0};
    let lastTouchDist = null;

    imageInput.addEventListener('change', function(e){
        const file = e.target.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(event){
                overlay.src = event.target.result;
                overlay.style.display = 'block';
                overlay.style.width = '160px';
                overlay.style.height = 'auto';
                overlay.style.top = '50%';
                overlay.style.left = '50%';
                overlay.style.transform = 'translate(-50%, -50%)';
            }
            reader.readAsDataURL(file);
        }
    });

    overlay.addEventListener('mousedown', function(e){
        isDragging = true;
        offset = {x: e.clientX - overlay.offsetLeft, y: e.clientY - overlay.offsetTop};
    });
    window.addEventListener('mousemove', function(e){
        if(isDragging){
            overlay.style.left = (e.clientX - offset.x) + 'px';
            overlay.style.top = (e.clientY - offset.y) + 'px';
            overlay.style.transform = 'none';
        }
    });
    window.addEventListener('mouseup', function(){ isDragging = false; });

    overlay.addEventListener('wheel', function(e){
        e.preventDefault();
        let currentWidth = overlay.offsetWidth;
        let newWidth = e.deltaY < 0 ? currentWidth * 1.1 : currentWidth * 0.9;
        overlay.style.width = newWidth + 'px';
    });

    overlay.addEventListener('touchstart', function(e){
        if(e.touches.length === 1){
            isDragging = true;
            offset = {x: e.touches[0].clientX - overlay.offsetLeft, y: e.touches[0].clientY - overlay.offsetTop};
        } else if(e.touches.length === 2){
            isDragging = false;
            const dx = e.touches[0].clientX - e.touches[1].clientX;
            const dy = e.touches[0].clientY - e.touches[1].clientY;
            lastTouchDist = Math.sqrt(dx*dx + dy*dy);
        }
    });
    overlay.addEventListener('touchmove', function(e){
        e.preventDefault();
        if(e.touches.length === 1 && isDragging){
            overlay.style.left = (e.touches[0].clientX - offset.x) + 'px';
            overlay.style.top = (e.touches[0].clientY - offset.y) + 'px';
            overlay.style.transform = 'none';
        } else if(e.touches.length === 2 && lastTouchDist){
            const dx = e.touches[0].clientX - e.touches[1].clientX;
            const dy = e.touches[0].clientY - e.touches[1].clientY;
            const dist = Math.sqrt(dx*dx + dy*dy);
            const scale = dist / lastTouchDist;
            overlay.style.width = (overlay.offsetWidth * scale) + 'px';
            lastTouchDist = dist;
        }
    });
    overlay.addEventListener('touchend', function(e){ 
        isDragging = false; 
        if(e.touches.length < 2) lastTouchDist = null;
    });
// ارسال به سبد خرید
    document.getElementById('add-to-cart').addEventListener('click', function(){
        const model = document.getElementById('product-model').value;
        const size = document.getElementById('product-size').value;
        const color = document.getElementById('product-color').value;
        const desc = document.getElementById('product-desc').value;

        

        const formData = new FormData();
        formData.append('action', 'add_custom_tshirt_to_cart');
        formData.append('model', model);
        formData.append('size', size);
        formData.append('color', color);
        formData.append('desc', desc);
        formData.append('image', imageInput.files[0]); 

        fetch("<?php echo esc_url(admin_url('admin-ajax.php')); ?>", {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                alert("به سبد خرید اضافه شد!");
            }else{
                alert("خطا در افزودن به سبد خرید");
            }
        });
    });

});
</script>
<?php get_footer(); ?>
