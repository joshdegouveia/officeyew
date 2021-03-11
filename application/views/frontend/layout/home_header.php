<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="format-detection" content="telephone=no">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">

    <meta name="author" content="">

    <!-- google login unic cliend id -->

    <meta name="google-signin-client_id" content="489909094019-h9oibrrkm2d6ckiv3t5da13gjlum5gck.apps.googleusercontent.com">

    

    <link rel="icon" href="<?php echo FILEPATH; ?>imgs/favicon.ico" type="image/gif" sizes="16x16">

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/frontend/imgs/favicon.ico" type="image/x-icon">

    <title>Welcome to <?php echo SITE_NAME; ?></title>

    <!-- Bootstrap CSS-->

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/bootstrap.css" rel="stylesheet" type="text/css">

    <!--custom css -->

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/custom-style.css" rel="stylesheet" type="text/css">

    <!-- Media queries CSS -->

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/media-queries.css" rel="stylesheet" type="text/css">

    <link href="<?php echo base_url(); ?>assets/frontend/css/bootstrap-datepicker.min.css" rel="stylesheet" media="screen">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/libs/select2/dist/css/select2.min.css" id="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/purpose.css" id="stylesheet">

    <!--Google login js api -->

    <script src="https://apis.google.com/js/platform.js" async defer></script>

  </head>



  <body>

    <!-- Start of Header -->

<?php

$social_links = array('fb' => 'javascript:void(0)', 'twit' => 'javascript:void(0)', 'insta' => 'javascript:void(0)', 'link' => 'javascript:void(0)');

$social_links_arr = getSocialLinks();

  if (!empty($social_links_arr)) {

    foreach ($social_links_arr as $value) {

      switch ($value->type) {

          case 'facebook':

              $social_links['fb'] = $value->value;

              break;

          case 'insta':

              $social_links['insta'] = $value->value;

              break;

          case 'tweet':

              $social_links['twit'] = $value->value;

              break;

          case 'linkedin':

              $social_links['link'] = $value->value;

              break;

      }

  }

}

?>

    <header class="header-wrapper">

        <div class="container flex-header">

            <div class="social-box">

                <a href="<?php echo $social_links['fb']; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>

                <a href="<?php echo $social_links['twit']; ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>

                <a href="<?php echo $social_links['insta']; ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>

                <a href="<?php echo $social_links['link']; ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>

            </div>

            <nav class="navbar navbar-expand-lg nav-box">

              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

              </button>



              <div class="collapse navbar-collapse" id="navbarContent">

                <ul class="navbar-nav mr-auto">

                  <li class="nav-item">

                    <a class="nav-link" href="<?php  echo base_url('about-us')?>">About</a>

                  </li>

                  <li class="nav-item">

                    <a class="nav-link" href="<?php  echo base_url('browse')?>">Browse</a>

                  </li>

                  <li class="nav-item">

                    <?php   

                      if(isset($_SESSION['user_data']) && $_SESSION['user_data']!='')

                      {

                        echo '<a class="nav-link" href="'.base_url('user').'">Get Started</a>'; 

                      }

                      else{ 

                        echo '<a class="nav-link" href="'.base_url('registration').'">Get Started</a>'; 

                      }

                    ?>

                  </li>

                </ul>

              </div>

            </nav>

            <div class="rightnav-box">

              <?php

              if(isset($_SESSION['user_data']) && $_SESSION['user_data']!='')

              {

                echo '<a href="'.base_url('user/profile_info').'" class="my_profile" >My Profile</a>'; 

                echo '<a href="'.base_url().'user/logout" class="btn-login lgOut" title="Logout"><span>Logout</span></a>'; 

              }

              else{

                echo '<a href="'.base_url().'" class="btn-login"><span>Login</span></a>';  

              }

              //print_r($_SESSION['user_data']); 

              ?>

              <a href="#" class="btn-cart"><span><i class="badge">2</i></span></a>

            </div>

        </div>

    </header>

    <!-- End of Header -->  