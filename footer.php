<?php
//footer
?>
<!-- footer -->
<footer id="footer" class="mt-3 border-top">
  <div class="container py-3">
    <div class="row ">
      <div class="d-flex flex-column col-xl-5 col-md-5 col-sm-24 justify-content-lg-start align-items-xl-start justify-content-center align-items-center">
        <?php
        dynamic_sidebar('fr-sidebar');
        ?>

      </div>
      <div class="col-14 col-xl-14 col-lg-14 col-md-14 d-flex flex-row  gap-3">
        <?php
        dynamic_sidebar('fc-sidebar');
        ?>
      </div>
      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-24 d-flex justify-content-lg-end justify-content-center ">
        <?php
        dynamic_sidebar('fl-sidebar');
        ?>
      </div>
    </div>
  </div>

  <!-- footer menu -->
  <div class="row">
    <div class="col-24 bottom-menu ">
      <div class="container d-flex justify-content-center justify-content-between p-1 align-items-center">
        <span class="d-flex f13">تمامی حقوق مادی و معنوی این وبسایت متعلق به پایگاه خبری تحلیلی رصد روز می باشد و هرگونه کپی برداری با ذکر منبع بلامانع است.</span>
        <div class="d-flex">
          <div class="col-auto d-none d-xl-flex d-lg-flex d-md-flex justify-content-center gap-2 social-links justify-content-center align-items-center">
            <span class="f13">طراحی و تولید: <a href="https://ihasht.ir/" class="text-white" title="هشت بهشت" alt="Website designer: Hasht Behesht professional website design site" target="_blank">هشت بهشت</a> </span>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- End - footer menu -->
</footer>
<?php wp_footer(); ?>
<!-- footer -->
<script>
  // darkmode
  const darkModeSwitch = document.querySelector(".dark-mode-switch");

  // بررسی وضعیت دارک مود از LocalStorage
  const isDarkMode = localStorage.getItem("darkMode") === "true";

  // تنظیم وضعیت اولیه بر اساس وضعیت ذخیره شده
  document.body.classList.toggle("dark-mode", isDarkMode);
  darkModeSwitch.classList.toggle("active", isDarkMode);

  darkModeSwitch.addEventListener("click", () => {
    const isActive = darkModeSwitch.classList.toggle("active");
    document.body.classList.toggle("dark-mode", isActive);

    // ذخیره وضعیت دارک مود در LocalStorage
    localStorage.setItem("darkMode", isActive);
  });
</script>
</body>

</html>