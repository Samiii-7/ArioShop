<?php
/*
Template Name: ارتباط با ما
*/
get_header();
?>


 <main class="bg-[#161D0D] py-16 px-6 md:px-16 lg:px-32 font-sans">
  <div class="max-w-2xl mx-auto text-center">
    <!-- عنوان اصلی -->
    <h2 class="text-4xl md:text-5xl font-extrabold text-[#FEFAE0] transition-all duration-300 hover:scale-110 hover:text-[#D58F3E]">
      ارتباط با ما
    </h2>

    <!-- متن  -->
    <p class="text-[#CFD9C6]/80 mt-5 text-base leading-relaxed max-w-xl mx-auto">
      ما همیشه آماده پاسخگویی به سوالات، پیشنهادات و درخواست‌های شما هستیم.
      از طریق راه‌های زیر با ما در ارتباط باشید.
    </p>
  </div>

  <!--  اطلاعات تماس -->
  <div class="max-w-lg mx-auto mt-10 space-y-6">
    <!-- آدرس -->
    <div class="flex items-center gap-4 group cursor-pointer">
      <div
        class="w-12 h-12 flex items-center justify-center rounded-full bg-[#D58F3E] text-[#432818] shadow-md transition-all duration-300 group-hover:scale-110 group-hover:bg-[#FFE6A7] group-hover:text-[#6F1D1B]">
        <!-- آیکون مکان -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
          stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z" />
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 22s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z" />
        </svg>
      </div>
      <span class="text-[#cfd9c6] text-lg transition-colors duration-300 group-hover:text-[#FEFAE0]">
        شیراز، بلوار هرمزگان، هرمزگان1، پوشاک آریو
      </span>
    </div>

    <!-- شماره تماس -->
    <div class="flex items-center gap-4 group cursor-pointer">
      <div
        class="w-12 h-12 flex items-center justify-center rounded-full bg-[#D58F3E] text-[#432818] shadow-md transition-all duration-300 group-hover:scale-110 group-hover:bg-[#FFE6A7] group-hover:text-[#6F1D1B]">
        <!-- آیکون تلفن -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
          stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.2 3.59a1 1 0 01-.27 1.06l-1.4 1.4a16.04 16.04 0 006.59 6.59l1.4-1.4a1 1 0 011.06-.27l3.59 1.2a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C10.477 21 3 13.523 3 5z" />
        </svg>
      </div>
      <span class="text-[#cfd9c6] text-lg transition-colors duration-300 group-hover:text-[#FEFAE0]">
        989121234567+
      </span>
    </div>

<!-- شبکه اجتماعی / وبسایت -->
<div class="flex items-center gap-4 group cursor-pointer">
  <div
    class="w-12 h-12 flex items-center justify-center rounded-full bg-[#D58F3E] text-[#432818] shadow-md transition-all duration-300 group-hover:scale-110 group-hover:bg-[#FFE6A7] group-hover:text-[#6F1D1B]">
    <!-- آیکون اینترنت  -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
      stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round"
        d="M12 20h.01M2 8.82a15.978 15.978 0 0119.98 0M5.64 12.14a10.978 10.978 0 0112.72 0M9.17 15.46a5.978 5.978 0 016.66 0" />
    </svg>
  </div>
  <span class="text-[#cfd9c6] text-lg transition-colors duration-300 group-hover:text-[#FEFAE0]">
    r2r.hodecode.ir
  </span>
</div>


<div class="wpforms-container" style="background-color: #abbcabff ; padding:20px; border-radius:8px;">
    <?php echo do_shortcode('[wpforms id="381"]'); ?>
</div>




</main>
<?php get_footer(); ?>