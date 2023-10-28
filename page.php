<?php
//header
get_header();
?>
<div class="container mt-4">
    <div class="row mx-0">
        <?php get_template_part('template-parts/content/content-page'); ?>

        
        <!-- sidebar  -->
        <div class="col-xl-7 col-md-24 col-sm-24 ps-0 pt-4 pt-xl-0 pt-md-4 pt-sm-4 pe-xl-3 pe-0 pe-sm-0 i8-sticky">
                <?php dynamic_sidebar('al-sidebar'); ?>
        </div>

    </div>
</div>
<?php
//footer
get_footer();
?>