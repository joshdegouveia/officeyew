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

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <?php $this->load->view('frontend/flash_message.php'); ?>
                            <input type="text" class="form-control" name="email" value="" placeholder="Email"
                                   data-fv-notempty="true"
                                   data-fv-notempty-message="The email address is required"/>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <a href="<?php echo base_url('sign-in'); ?>">Login</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                </div>       

                <div class="submitBtn"><button type = "submit" class = "btn btn-default">Submit</button></div>
            </form>
        </div>

    </div>
</section>
<!-- Content end -->