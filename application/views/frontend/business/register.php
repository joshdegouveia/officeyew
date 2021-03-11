<div class="main-content business-register">
  <section class="min-vh-100 d-flex align-items-center">
    <div class="bg-img-holder top-0 right-0 col-lg-6 col-xl-8 zindex-100 d-none d-lg-block" data-bg-size="cover" data-bg-position="center">
      <img alt="Image placeholder" src="<?php echo $logo; ?>">
    </div>
    <div class="container-fluid py-5">
      <div class="row align-items-center">
        <div class="col-sm-7 col-lg-6 col-xl-4 mx-auto ml-lg-0">
          <?php if ($this->session->flashdata('msg_error')) { ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
          </div>
          <?php } else if ($this->session->flashdata('msg_success')) { ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
          </div>
          <?php } ?>
          <div class="px-4 px-lg-6">
            <div>
              <div class="mb-5 text-center">
                <h6 class="h3">Create Business account</h6>
                <p class="text-muted mb-0">Enlarge your brand here.</p>
              </div>
              <span class="clearfix"></span>
              <form role="form" method="post" action="" id="register_form">
                <div class="form-group">
                  <label class="form-control-label">First Name</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" value="<?php echo set_value('first_name');?>" class="form-control" name="first_name" id="first_name" placeholder="John" required>
                  </div>
                  <p><?php echo form_error('first_name');?></p>
                </div>
                <div class="form-group">
                  <label class="form-control-label">Last Name</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" value="<?php echo set_value('last_name');?>" class="form-control" name="last_name" id="last_name" placeholder="Doe" required>
                  </div>
                  <p><?php echo form_error('last_name');?></p>
                </div>
                <div class="form-group">
                  <label class="form-control-label">Email address</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" value="<?php echo set_value('email');?>" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                  </div>
                  <p><?php echo form_error('email');?></p>
                </div>
                <div class="form-group">
                  <label class="form-control-label">Phone Number</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" value="<?php echo set_value('phone');?>" class="form-control" name="phone" id="phone" placeholder="9876543210" required>
                  </div>
                  <p><?php echo form_error('phone');?></p>
                </div>
                <div class="form-group mb-4">
                  <label class="form-control-label">Password</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password" id="password" placeholder="********" required>
                    <div class="input-group-append">
                      <span class="input-group-text pwdsh">
                        <i class="fa fa-eye"></i>
                      </span>
                    </div>
                  </div>
                  <p><?php echo form_error('password');?></p>
                </div>
                <div class="my-4">
                  <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="check-terms" name="terms" required>
                    <label class="custom-control-label" for="check-terms">I agree to the <a href="<?php echo base_url('terms-condition'); ?>" target="_blank">terms and conditions</a></label>
                  </div>
                  <p><?php echo form_error('terms');?></p>
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="check-privacy" name="privacy" required>
                    <label class="custom-control-label" for="check-privacy">I agree to the <a href="<?php echo base_url('privacy-policy'); ?>" target="_blank">privacy policy</a></label>
                  </div>
                  <p><?php echo form_error('privacy');?></p>
                </div>
                <div class="mt-4">
                <button type="submit" class="btn btn-block btn-primary">Create my account</button></div>
              </form>
              <div class="mt-4 text-center"><small>Already have an acocunt?</small>
                <a href="<?php echo base_url('business'); ?>" class="small font-weight-bold">Sign in</a>
              </div>
              <div class="text-center">
                <a href="<?php echo base_url(); ?>" class="small font-weight-bold">Back to Home Page</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>