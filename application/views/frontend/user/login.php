<!-- Office Furniture Categories start-->
<section class="ofc-hold-wrap">
    <div class="container">

        <?php $user_type = explode(',', set_value('user_type')); ?>
        <div class="regd">
            <!--<h2><?= $title ?></h2>-->
            <form id="basicBootstrapForm" class="form-horizontal"
                  data-fv-framework="bootstrap"
                  data-fv-icon-valid="glyphicon glyphicon-ok"
                  data-fv-icon-invalid="glyphicon glyphicon-remove"
                  data-fv-icon-validating="glyphicon glyphicon-refresh" method="post" action="">
                      <?php $this->load->view('frontend/flash_message.php'); ?>



                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="email" value="<?php echo set_value('email'); ?>" placeholder="Email"
                                   data-fv-notempty="true"
                                   data-fv-notempty-message="The email address is required"

                                   data-fv-emailaddress="true"
                                   data-fv-emailaddress-message="The input is not a valid email address" />
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <input type="password" value="<?php echo set_value('password'); ?>" class="form-control" name="password" placeholder="Password"
                                   data-fv-notempty="true"
                                   data-fv-notempty-message="The password is required"

                                   data-fv-different="true"
                                   data-fv-different-field="username"
                                   data-fv-different-message="The password cannot be the same as username" />
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-7"></div>
                        <div class="col-md-5">
                            <a href="<?php echo base_url('forgot-password'); ?>">Forgot password</a>
                        </div>
                    </div>
                </div>       

                <div class="submitBtn"><button type = "submit" class = "btn btn-default">Login</button></div>
            </form>
        </div>

    </div>
</section>
<!-- Content end -->