<?php
/* Template Name: سوالات متداول */

get_header(); 
?>

<main class="min-h-screen p-6 md:p-12" style="background-color:#161D0D;">
  <div class="max-w-3xl mx-auto text-center">
   <h1 class="text-3xl font-bold mb-8 text-[#FEFAE0] transition-transform duration-300 hover:scale-110 hover:text-[#D58F3E]">
      سوالات متداول
    </h1>
    <p class="mb-8" style="color:#FEFAE0;"> در این بخش به پر تکرارترین سوالات کاربران پاسخ داده شده.
      شاید سوال شما هم باشه!
    </p>
    

    <!-- شروع بخش سوالات -->
    <div class="space-y-4 text-right">
      <?php 
      $faqs = [
        ["question" => "لباس‌ها چه مدت زمانی برای تولید و ارسال نیاز دارند؟", "answer" => "زمان تولید و ارسال بسته به نوع سفارش متفاوت است؛ معمولاً سفارش‌های شخصی‌سازی شده بین ۵ تا ۱۰ روز کاری آماده و ارسال می‌شوند."],
        ["question" => "چگونه می‌توانم سفارش خود را پیگیری کنم؟", "answer" => "پس از ثبت سفارش، لینک پیگیری برای شما ارسال می‌شود تا وضعیت سفارش و زمان تحویل را مشاهده کنید."],
        ["question" => "آیا امکان بازگشت یا تعویض لباس وجود دارد؟", "answer" => "بله، در صورتی که لباس دارای مشکل کیفیتی باشد یا با سفارش شما مطابقت نداشته باشد، می‌توانید درخواست تعویض یا بازگشت کالا دهید."],
        ["question" => "چطور می‌توانم بهترین سبک لباس متناسب با شخصیت خود را انتخاب کنم؟", "answer" => "کارشناسان آریو با راهنمایی شما و پیشنهاد ترکیب‌های مدرن، کمک می‌کنند تا لباسی انتخاب کنید که هم شخصیتتان را نشان دهد و هم مطابق ترند روز باشد."],
        ["question" => " آیا می‌توانم قبل از خرید، نمونه پارچه و رنگ‌ها را ببینم؟", "answer" => "بله، فروشگاه آریو امکان مشاهده نمونه پارچه و رنگ‌های واقعی را فراهم کرده تا قبل از نهایی کردن سفارش، انتخابی دقیق داشته باشید."],
        ["question" => "چگونه می‌توانم سفارش گروهی یا هدیه ویژه را ثبت کنم؟", "answer" => "برای سفارش‌های گروهی یا هدیه، کافی است با تیم پشتیبانی آریو تماس بگیرید تا طراحی اختصاصی و ارسال ویژه برای شما فراهم شود."]
      ];

      foreach ($faqs as $faq): 
      ?>
      <div class="bg-white/10 shadow-md rounded-2xl p-5">
        <button class="flex justify-between items-center w-full text-lg font-medium faq-toggle" style="color:#F5F5F5;">
          <?php echo $faq['question']; ?>
          <span class="text-[#BC6C25] font-bold text-xl">+</span>
        </button>
        <p class="mt-3 hidden faq-answer" style="color:#F5F5F5;">
          <?php echo $faq['answer']; ?>
        </p>
      </div>
      <?php endforeach; ?>
    </div>
    <!-- پایان بخش سوالات -->

</main>

<!-- JS برای باز و بسته کردن جواب‌ها -->
<script>
document.querySelectorAll('.faq-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
        const answer = btn.nextElementSibling; // <p> جواب
        answer.classList.toggle('hidden'); // باز یا بسته کردن جواب
    });
});
</script>


<?php get_footer(); ?>
