<?php
$header_image = base_url('assets/frontend/img/backgrounds/img-8.jpg');
$bottom_image = base_url('assets/frontend/img/backgrounds/img-7.jpg');
if (!empty($content->attached)) {
  $attached = unserialize($content->attached);
  if (array_key_exists('header_image', $attached)) {
    $header_image = UPLOADPATH . 'pages/' . $attached['header_image'];
  }
  if (array_key_exists('bottom_image', $attached)) {
    $bottom_image = UPLOADPATH . 'pages/' . $attached['bottom_image'];
  }
}
?>
<div class="main-content aboutus">
  <!-- Cover (v1) -->
  <section class="spotlight bg-cover bg-size--cover" data-spotlight="fullscreen" style="background-image: url('<?php echo $header_image; ?>');">
    <span class="mask bg-gradient-primary opacity-9"></span>
    <div class="spotlight-holder pt-9 pb-6 py-lg-0">
      <div class="container d-flex align-items-center px-0">
        <div class="col">
          <div class="row row-grid align-item-center">
            <div class="col-lg-7">
              <div class="py-5">
                <h1 class="text-white mb-4"><?php echo $content->sub_description; ?></h1>
                <!-- <h1 class="text-white mb-4">Contact us whether you need a website, mobile app or marketing services.</h1>
                <p class="lead text-white lh-180">Being a small team we nurtured the passion for details, which most of the time make the difference. We pride ourselves on our commitment to excellence, as well as our ability to deliver for our partners.</p>
                <a href="https://www.youtube.com/watch?v=mqpwDJpI3Rc" data-fancybox class="btn btn-white btn-icon-only shadow btn-zoom--hover mt-4">
                  <span class="btn-inner--icon"><i class="fas fa-play"></i></span>
                </a> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Features (v29) -->
  <section class="slice slice-lg bg-dark bg-cover bg-size--cover second-sec" style="background-image: url('<?php echo $bottom_image; ?>');">
    <span class="mask bg-dark opacity-7"></span>
    <div class="container">
      <div class="row row-grid">
        <div class="col-lg-6">
          <?php echo $content->body; ?>
          <!-- <h4 class="text-white mb-4">Our story</h4>
          <p class="lead text-white lh-180 mb-4">She exposed painted fifteen are noisier mistake led waiting. Surprise not wandered speedily husbands although yet end. Are court tiled cease young built fat one man taken. We highest ye friends is exposed equally in. Ignorant had too strictly followed.</p>
          <p class="lead text-white lh-180">Form face evening above years for i fruitful us creature void days. Upon upon fruitful us fill earth was set tree above.</p> -->
        </div>
      </div>
    </div>
  </section>
</div>