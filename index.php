<?php
//header
get_header();
?>
<div class="container">
    <div class="hero-box container d-flex flex-column my-4 gap-4 px-2">
        <?php
        // // todo: if top main is active
        get_template_part('template-parts/slider/slider-main2'); ?>
    </div>
    <div class="home-main-box">
        <?php
        // // Main box
        get_template_part('template-parts/home-main-box');
        ?>
    </div>
    <div class="page-bottom-sidebar">
            <?php
            dynamic_sidebar('hf-sidebar');
            ?>
    </div>
</div>
<?php
// //footer
get_footer();
?>