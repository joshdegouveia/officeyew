<div class="main-content">
  <section class="min-vh-100 d-flex align-items-center">
    <div class="bg-img-holder top-0 right-0 col-lg-6 col-xl-8 zindex-100 d-none d-lg-block" data-bg-size="cover" data-bg-position="center">
      <img alt="Back Image" src="<?php echo $logo; ?>">
    </div>
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
                <h6 class="h3">Password reset</h6>
                <p class="text-muted mb-0">Enter your email below to proceed.</p>
              </div>
              <span class="clearfix"></span>
              <form role="form" method="post" id="forgotpass_form">
                <div class="form-group">
                  <label class="form-control-label">Email address</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                  </div>
                </div>
                <div class="mt-4">
                <button type="submit" class="btn btn-block btn-primary">Reset password</button></div>
              </form>
              <div class="mt-4 text-center"><small>Not registered?</small>
                <a href="<?php echo base_url('business/register'); ?>" class="small font-weight-bold">Create account</a></div>
              </div>
              <div class="text-center">
                <a href="<?php echo base_url(); ?>" class="small font-weight-bold">Back to Home Page</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>