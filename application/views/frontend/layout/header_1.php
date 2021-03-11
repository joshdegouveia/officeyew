<!DOCTYPE html>
<html lang="en">




<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if (!empty($meta_data)) { ?>
    <meta name="description" content="<?php echo $meta_data->meta_description; ?>">
    <meta name="key" content="<?php echo $meta_data->meta_key; ?>">
    <?php } ?>
    <title><?php echo (isset($title) ? ucwords($title) . ' | ' : '') . SITE_NAME; ?></title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url(); ?>assets/frontend/images/favicon.ico" type="image/x-icon">
    <!-- Bootstrap CSS-->
    <link href="<?php echo base_url(); ?>assets/frontend/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/frontend/css/global-style.css" rel="stylesheet" type="text/css">
    <!-- Media queries CSS -->
    <link href="<?php echo base_url(); ?>assets/frontend/css/media-queries.css" rel="stylesheet" type="text/css">
    <!-- Carousel CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/css/formValidation.min.css'>

</head>

<body>


    <!-- Header start -->
    <header class="header-hold-wrapper">
        <div class="container">
            <div class="topheader-hold">
                <a class="logo" href="<?php echo base_url(''); ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/logo.png" alt="Logo" title="Logo" class="img-responsive" /></a>
                <div class="right-header-box">
                    <a href="<?php echo base_url('login/signin'); ?>"><i class="fa fa-sign-in" aria-hidden="true"></i> <span>Login</span></a>
                    <a href="<?php echo base_url('login/register'); ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> <span>Sign Up</span></a>
                    <a href="<?php echo base_url('user/profile'); ?>"><i class="fa fa-tachometer" aria-hidden="true"></i> <span>My Dashboard</span></a>
                </div>
            </div>
        </div>
    </header>
    <!-- Header end -->
    <!-- Navigation start -->
    <section class="container">
        <nav class="navbar navbar-expand-lg navbar-light custom-nav">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo base_url(); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="officefurniture.html">Office Furniture</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="installer.html">Installer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="designer.html">Designer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="jobpostings.html">Job Postings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="jobcandidate.html">Job Candidate</a>
                    </li>
                </ul>
            </div>
            <a href="#" class="sell-btn"><i class="fa fa-camera" aria-hidden="true"></i> Sell</a>
        </nav>
    </section>
    <!-- Navigation end -->