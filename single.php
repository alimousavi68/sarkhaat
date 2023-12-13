<?php
//header
get_header();
?>
<div class="container px-0">
    <div class="row mx-0">
        <?php
        $video_url = get_post_meta(get_the_ID(), 'hasht-video-link', true);
        // تشخیص نوع فایل ویدیو
        $file_extension = pathinfo($video_url, PATHINFO_EXTENSION);
        $is_video = in_array($file_extension, array('mp4', 'webm', 'ogg'));
        // اگر URL یک فایل ویدیویی است
        if ($is_video):
            get_template_part('template-parts/content/content-single-video');
        else:
            get_template_part('template-parts/content/content-single');
        endif;
        ?>

        <!-- sidebar  -->
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-24 ps-0 pe-xl-2 pe-0 pe-sm-0 i8-sticky sl-sidebar">
            <?php dynamic_sidebar('sl-sidebar'); ?>
        </div>

    </div>
</div>

<?php
//footer
get_footer();
?>