<!-- Office Furniture Categories start-->
<section class="ofc-hold-wrap">
    <div class="container">

        <?php $user_type = explode(',', set_value('user_type')); ?>
        <div class="regd">
            <!--<h2>Registration</h2>-->
            <form id="basicBootstrapForm" class="form-horizontal"
                  data-fv-framework="bootstrap"
                  data-fv-icon-valid="glyphicon glyphicon-ok"
                  data-fv-icon-invalid="glyphicon glyphicon-remove"
                  data-fv-icon-validating="glyphicon glyphicon-refresh" method="post" action="">
                      <?php $this->load->view('frontend/flash_message.php'); ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name = "first_name" value="<?php //echo set_value('first_name'); ?>" placeholder="First name"
                                   data-fv-row=".col-md-6"
                                   data-fv-notempty="true"
                                   data-fv-notempty-message="The first name is required" />
                            <p><?php echo form_error('first_name'); ?></p>
                        </div>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name = "last_name" value="<?php //echo set_value('last_name'); ?>" placeholder="Last name"
                                   data-fv-row=".col-md-6"
                                   data-fv-notempty="true"
                                   data-fv-notempty-message="The last name is required" />
                            <p><?php echo form_error('last_name'); ?></p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        
                            <!--<input type="text" class="form-control" name="email" value="<?php //echo set_value('email'); ?>" placeholder="Email"
                                   data-fv-notempty="false"
                                   data-fv-notempty-message="The email address is required"

                                   data-fv-emailaddress="true"
                                   data-fv-emailaddress-message="The input is not a valid email address" />-->
                                   
							     <input type="text" class="form-control" name = "email" value="<?php //echo set_value('email'); ?>" placeholder="Email"
                                   data-fv-row=".col-md-6"
                                   data-fv-notempty="true"
                                   data-fv-notempty-message="The email address is required" />
                        </div>
						
                        <div class="col-md-6">
                            <input type="password" value="<?php //echo set_value('password'); ?>" class="form-control" name="password" placeholder="Password"
                                   data-fv-notempty="true"
                                   data-fv-notempty-message="The password is required"

                                   data-fv-different="true"
                                   data-fv-different-field="username"
                                   data-fv-different-message="The password cannot be the same as username" />
                        </div>
                    </div>
                </div>                 
                <h4>Select User Type:</h4>
                


                <div class="form-group chkboxInline ">
                    <?php foreach ($la_groups as $k => $group) {
                        ?>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="user_type[]" value="<?= $group->id ?>"  id="customCheckBox<?= ++$k ?>" <?php //echo (in_array($group->id, $user_type) ? "checked" : "") ?>>
                            <label class="custom-control-label" for="customCheckBox<?= $k ?>"><?= ucfirst($group->name) ?></label>
                        </label>
                        <?php
                    }
                    ?>
                </div><!--
                -->
                <div class="submitBtn"><button type = "submit" class = "btn btn-default">Submit</button></div>
            </form>
        </div>

    </div>
</section>
<!-- Content end -->
<script>// A $( document ).ready() block.
	jQuery( document ).ready(function() {
		//alert($("#basicBootstrapForm :input").length);
		//$("#basicBootstrapForm :input").val('');
	});
	
</script>