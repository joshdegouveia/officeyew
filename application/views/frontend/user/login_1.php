    <div class="container-fluid">
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
                <h6 class="h3">Login</h6>
                <p class="text-muted mb-0">Sign in to your reseller account to continue.</p>
              </div>
              <span class="clearfix"></span>
              <form role="form" method="post" id="login_form">
                <div class="form-group">
                  <label class="form-control-label">Email address</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                  </div>
                  <p><?php echo form_error('email');?></p>
                </div>
                <div class="form-group mb-4">
                  <div class="d-flex align-items-center justify-content-between">
                    <div>
                      <label class="form-control-label">Password</label>
                    </div>
                    <div class="mb-2">
                      <a href="<?php echo base_url('login/forgotpass'); ?>" class="small text-muted text-underline--dashed border-primary">Lost password?</a>
                    </div>
                  </div>
                  <div class="input-group input-group-merge pwdsh">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="fas fa-eye"></i>
                      </span>
                    </div>
                    <p><?php echo form_error('password');?></p>
                  </div>
                </div>
                <div class="mt-4">
                <button type="submit" class="btn btn-block btn-primary">Sign in</button></div>
              </form>
              <div class="mt-4 text-center"><small>Not registered?</small>
                <a href="<?php echo base_url('login/register'); ?>" class="small font-weight-bold">Create account</a></div>
              </div>
              <div class="text-center">
                <a href="<?php echo base_url(); ?>" class="small font-weight-bold">Back to Home Page</a></div>
              </div>
            </div>
          </div>
        </div>
