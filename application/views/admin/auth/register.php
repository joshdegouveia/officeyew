<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title ;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>


<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Register</b></a>
  </div>
  <div class="alert alert-danger alert-dismissible error_msg" style="display:none;">
      <h4><i class="icon fa fa-ban"></i> Error Message!</h4>
      <span></span>
  </div>
  <?php 
  $message = $this->session->flashdata('message');
  if(isset($message) && $message != '') {?>
  <div class="callout callout-danger">
    <h4>Errors!</h4>
    <?php echo $message; ?>
  </div>
  <?php }?>
  
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <div class="error" style="color: #ff0000;font-weight: bold;margin-bottom10px;"><?php echo validation_errors(); ?></div>

    <form id="register_form" action="<?php echo base_url(); ?>admin/auth/register" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="first_name" class="form-control" placeholder="First name" value="<?php echo set_value('first_name'); ?>" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" name="last_name" class="form-control" placeholder="Last name" value="<?php echo set_value('last_name'); ?>" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo set_value('email'); ?>" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" value="" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" value="" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <a href="<?php echo base_url(); ?>admin/auth/login">Login</a>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!-- /.social-auth-links -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });

    $('#register_form').on('submit', function() {
      $('.error_msg').hide();
      var error = 0 ;
      var errorMsg = '' ;
      var first_name = $('input[name=first_name]').val() ;
      var last_name = $('input[name=last_name]').val() ;
      var email = $('input[name=email]').val() ;
      var password = $('input[name=password]').val() ;
      var confirm_password = $('input[name=confirm_password]').val() ;

      if ($.trim(first_name) == '') {
          error = 1 ;
          errorMsg += '<p>First name should not be blank.</p>' ;
      }
      if ($.trim(last_name) == '') {
          error = 1 ;
          errorMsg += '<p>Last name should not be blank.</p>' ;
      }
      if($.trim(email) == ''){
          error = 1 ;
          errorMsg += '<p>Email should not be blank.</p>' ;
      }
      if(password == ''){
          error = 1 ;
          errorMsg += '<p>Password should not be blank.</p>' ;
      }
      if(confirm_password == ''){
          error = 1 ;
          errorMsg += '<p>Confirm password should not be blank.</p>' ;
      }
      if(confirm_password.length < 8){
          error = 1 ;
          errorMsg += '<p>The Password field must be at least 8 characters in length.</p>' ;
      }
      if(confirm_password != password){
          error = 1 ;
          errorMsg += '<p>Password and confirm password does not match.</p>' ;
      }
      
      if(error){
        $('div.error_msg').find('span').html(errorMsg) ;
        $('div.error_msg').slideDown(500).delay(3000).slideUp(300) ;
        $("html, body").animate({ scrollTop: 0 }, "first");
        return false ;
      }
    }) ;

  });
</script>
</body>


</html>