<?php
/**
 * Header Template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="bg-[#1E2824] shadow-md">
<div class="max-w-screen-lg mx-auto sm:px-6">
  <div class="container mx-auto px-4 py-3 flex items-center justify-between">
    
    <!-- لوگو-->
<div class="size-12 md:size-16">
    <?php if (function_exists("the_custom_logo")) {
        the_custom_logo();
    } ?>
</div>
    
<!-- عنوان سایت -->
 <div class="text-center flex-grow"> <h1 class="text-2xl md:text-3xl font-semibold text-[#EDE0D4]"> آریو </h1> </div>

   <!-- منو -->
<nav class="flex space-x-2 md:space-x-8 text-[#EDE0D4]">
    <?php wp_nav_menu([
        "theme_location" => 'Header',
        "menu_class" => "main-nav flex grow gap-3 md:gap-8",
        "container" => false
    ]); ?>
</nav>
    
  </div></div>
</header>
</div>
