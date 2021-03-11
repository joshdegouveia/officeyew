<!-- Office Furniture Categories start-->
    <section class="ofc-hold-wrap">
        <div class="container">
        <?php if ($this->session->flashdata('msg_error')) { ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
          </div>
          <?php } else if ($this->session->flashdata('msg_success')) { ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
          </div>
          <?php } ?>
            <div class="regd">
                <h2>Registration</h2>
                <form id="basicBootstrapForm" class="form-horizontal"
                data-fv-framework="bootstrap"
                data-fv-icon-valid="glyphicon glyphicon-ok"
                data-fv-icon-invalid="glyphicon glyphicon-remove"
                data-fv-icon-validating="glyphicon glyphicon-refresh" method="post" action="">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                            <input type="text" class="form-control" name = "first_name" value="<?php echo set_value('first_name');?>" placeholder="First name"
                                data-fv-row=".col-md-6"
                                data-fv-notempty="true"
                                data-fv-notempty-message="The first name is required" />
                                <p><?php echo form_error('first_name');?></p>
                            </div>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name = "last_name" value="<?php echo set_value('last_name');?>" placeholder="Last name"
                                    data-fv-row=".col-md-6"
                                    data-fv-notempty="true"
                                    data-fv-notempty-message="The last name is required" />
                                    <p><?php echo form_error('last_name');?></p>
                            </div>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                            <input type="text" class="form-control" name="email" value="<?php echo set_value('email');?>"
                                data-fv-notempty="true"
                                data-fv-notempty-message="The email address is required"

                                data-fv-emailaddress="true"
                                data-fv-emailaddress-message="The input is not a valid email address" />
                            </div>
                            <div class="col-md-6">
                                <input type="password" value="<?php echo set_value('password');?>" class="form-control" name="password"
                                    data-fv-notempty="true"
                                    data-fv-notempty-message="The password is required"

                                    data-fv-different="true"
                                    data-fv-different-field="username"
                                    data-fv-different-message="The password cannot be the same as username" />
                            </div>
                        </div>
                    </div>                 
                    <h4>Select User Type:</h4>
                    <div class="form-group radioField">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="user_type" value="2"
                                        data-fv-notempty="true"
                                        data-fv-notempty-message="The user type is required" /> Buyer
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="user_type" value="1" /> Seller
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="user_type" value="3" /> Installer
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="user_type" value="4" /> Designer
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="user_type" value="5" /> Employer
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="user_type" value="6" /> Candidate
                                </label>
                            </div>
                    </div>
<!--
                    <div class="chkboxInline">
                       <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="customCheckBox1">
                          <label class="custom-control-label" for="customCheckBox1">Buyer</label>
                       </label>
                        <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="customCheckBox2">
                          <label class="custom-control-label" for="customCheckBox2">Seller</label>
                       </label>
                        <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="customCheckBox3">
                          <label class="custom-control-label" for="customCheckBox3">Installer</label>
                       </label>
                        <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="customCheckBox4">
                          <label class="custom-control-label" for="customCheckBox4">Designer</label>
                       </label>
                        <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="customCheckBox5">
                          <label class="custom-control-label" for="customCheckBox5">Employer</label>
                       </label>
                        <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="customCheckBox6">
                          <label class="custom-control-label" for="customCheckBox6">Candidate</label>
                       </label>
                    </div>
-->
                   <div class="submitBtn"><button type = "submit" class = "btn btn-default">Submit</button></div>
                </form>
            </div>
            
        </div>
    </section>
<!-- Content end -->