<div class="main-content setting-page">
  <!-- Header (account) -->
  <section class="header-account-page bg-primary d-flex align-items-end" data-offset-top="#header-main">
    <!-- Header container -->
    <div class="container pt-4 pt-lg-0">
      <div class="row">
        <div class=" col-lg-12">
          <!-- Salute + Small stats -->
          <?php 
            $data['user'] = $user;
            $this->load->view('frontend/layout/account_heaer', $data); 
          ?>
          <!-- Account navigation -->
          <div class="d-flex">
            <a href="<?php echo base_url('user/settings'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">Setting</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="slice">
    <div class="container">
      <div class="row row-grid">
        <div class="col-lg-12 order-lg-2">
          <?php if ($this->session->flashdata('msg_error')) { ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
          </div>
          <?php } else if ($this->session->flashdata('msg_success')) { ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
          </div>
          <?php } else { ?>
          <div class="alert alert-dismissible" role="alert" style="display: none;">
            <strong></strong>
          </div>
          <?php } ?>

          <form method="post" id="user_setting_form">
            <!-- Password -->
            <div class="actions-toolbar py-2 mb-4">
              <h5 class="mb-1">Change password</h5>
              <p class="text-sm text-muted mb-0">Keep your information up-to-date for seamless communication from us.</p>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Old password</label>
                  <input class="form-control" type="password" name="old_password" id="old_password">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">New password</label>
                  <input class="form-control" type="password" name="password" id="password">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Confirm password</label>
                  <input class="form-control" type="password" name="cpassword" id="cpassword">
                </div>
              </div>
            </div>
            <div class="mt-4">
              <button type="submit" class="btn btn-sm btn-primary">Update password</button>
            </div>
          </form>
          <!-- Username -->
          <div class="mt-5 pt-5 delimiter-top">
            <div class="actions-toolbar py-2 mb-4">
              <h5 class="mb-1">Change email</h5>
              <p class="text-sm text-muted mb-0">Keep your information up-to-date for seamless communication from us.</p>
            </div>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-change-email">Change email</button>
            <!-- Modal -->
            <div class="modal fade" id="modal-change-email" tabindex="-1" role="dialog" aria-labelledby="modal-change-email" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <form method="post" id="user_setting_email_form">
                  <div class="modal-content">
                    <div class="modal-header">
                      <div class="modal-title d-flex align-items-center" id="modal-title-change-email">
                        <div>
                          <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                            <i class="fas fa-user"></i>
                          </div>
                        </div>
                        <div>
                          <h6 class="mb-0">Change email</h6>
                        </div>
                      </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="alert alert-danger alert-dismissible" role="alert" style="display: none;">
                        <strong></strong>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="form-control-label">Old email</label>
                            <input class="form-control" type="text" name="old_email" id="old_email">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="form-control-label">New email</label>
                            <input class="form-control" type="text" name="new_email" id="new_email">
                          </div>
                        </div>
                      </div>
                      <div class="px-5 pt-4 mt-4 delimiter-top text-center">
                        <p class="text-muted text-sm">You will receive an email where you will be asked to confirm this action in order to be completed.</p>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-secondary">Change my email</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <?php /* ?>
          <!-- Delete -->
          <div class="mt-5 pt-5 delimiter-top">
            <div class="actions-toolbar py-2 mb-4">
              <h5 class="mb-1">Delete account</h5>
              <p class="text-sm text-muted mb-0">Deleting your account is ireversible and can affect past activites.</p>
            </div>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-account">Delete account</button>
            <!-- Modal -->
            <div class="modal modal-danger fade" id="modal-delete-account" tabindex="-1" role="dialog" aria-labelledby="modal-delete-account" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <form class="form-danger">
                  <div class="modal-content">
                    <div class="modal-body">
                      <div class="text-center">
                        <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
                        <h5 class="text-white mt-4">Should we stop now?</h5>
                        <p class="text-sm text-sm">All your data will be erased. You will no longer be billed, and your username will be available to anyone.</p>
                      </div>
                      <div class="form-group">
                        <label class="form-control-label text-white">You email or username</label>
                        <input class="form-control" type="text">
                      </div>
                      <div class="form-group">
                        <label class="form-control-label text-white">To verify, type <span class="font-italic">delete my account</span> below</label>
                        <input class="form-control" type="text">
                      </div>
                      <div class="form-group">
                        <label class="form-control-label text-white">Your password</label>
                        <input class="form-control" type="password">
                      </div>
                      <div class="mt-4">
                        <button type="button" class="btn btn-block btn-sm btn-white text-danger">Delete my account</button>
                        <button type="button" class="btn btn-block btn-sm btn-link text-light mt-4" data-dismiss="modal">Not this time</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <?php */ ?>

        </div>
        <?php /* ?>
        <div class="col-lg-3 order-lg-1">
          <?php $this->load->view('frontend/user/profile-left-panel'); ?>
        </div><?php */ ?>
      </div>
    </div>
  </section>
</div>