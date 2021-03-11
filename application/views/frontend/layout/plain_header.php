<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Purpose is a unique and beautiful collection of UI elements that are all flexible and modular. A complete and customizable solution to building the website of your dreams.">
    <meta name="author" content="Webpixels">
    <title><?php echo (isset($title) ? ucwords($title) . ' | ' : '') . SITE_NAME; ?></title>
    <!-- Favicon -->
    <link rel="icon" href="<?php echo FILEPATH; ?>img/default/favicon.ico" type="image/png">
    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/libs/@fortawesome/fontawesome-free/css/all.min.css"><!-- Page CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/libs/swiper/dist/css/swiper.min.css">
    <!-- Purpose CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/libs/select2/dist/css/select2.min.css" id="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/purpose.css" id="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/style.css" id="stylesheet">
    <script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
    var FILEPATH = '<?php echo FILEPATH; ?>';
    var UPLOADPATH = '<?php echo UPLOADPATH; ?>';
    </script>
  </head>
  <body>
    <div class="overlay"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>