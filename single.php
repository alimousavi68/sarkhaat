<?php
//header
get_header();
?>
<div class="container mt-4">
    <div class="row mx-0">
        <?php get_template_part('template-parts/content/content-single'); ?>



        <!-- sidebar  -->
        <div class="col-xl-7 col-md-24 col-sm-24 ps-0 pe-xl-2 pe-0 pe-sm-0 i8-sticky border-end sl-sidebar">
            <?php dynamic_sidebar('sl-sidebar'); ?>
        </div>

    </div>
</div>
<!-- <script >
document.addEventListener("DOMContentLoaded", function() {
    var inputBox = document.getElementById("comment");
    var pElement = document.getElementById("commenter-info");

    inputBox.addEventListener("click", function() {
        if (pElement.style.display === "none") {
            pElement.style.display = "flex";
        } else {
            pElement.style.display = "none";
        }
    });
});
</script> -->

<?php
//footer
get_footer();
?>