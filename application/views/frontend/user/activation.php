<!-- Office Furniture Categories start-->
<section class="ofc-hold-wrap">
    <div class="container">

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
                            <input type="password" value="" class="form-control" name="password" placeholder="Password"
                                   data-fv-notempty="true"
                                   data-fv-notempty-message="The password is required"/>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <input type="password" value="" class="form-control" name="confirm_password" placeholder="Confirm Password"
                                   data-fv-notempty="true"
                                   data-fv-notempty-message="The confirm password is required"/>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                </div>       

                <div class="submitBtn"><button type = "submit" class = "btn btn-default">Submit</button></div>
            </form>
        </div>

    </div>
</section>
<!-- Content end -->