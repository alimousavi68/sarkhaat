<?php
//header
get_header();
?>
<div class="container">
    <div class="top-section container d-flex flex-column my-4 gap-4 px-2">
        <?php
        // // todo: if top main is active
        get_template_part('template-parts/top_section'); ?>
    </div>
    <div class="home-main-box border-top border-bottom py-3 ">
        <?php
        // // Main box
        get_template_part('template-parts/home-main-box');
        ?>
    </div>
    <div class="page-bottom-sidebar py-3">
            <?php
            dynamic_sidebar('hf-sidebar');
            ?>
    </div>
</div>
<?php
// //footer
get_footer();
?>