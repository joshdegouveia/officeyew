<div class="main-content account-page">
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
            <a href="<?php echo base_url('user/account'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">My Profile</span>
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
          <?php } ?>
          <!-- Change avatar -->
          <div class="card bg-gradient-warning hover-shadow-lg">
            <div class="card-body py-3">
              <div class="row row-grid align-items-center">
                <div class="col-lg-8">
                  <div class="media align-items-center">
                    <?php
                    $profile_image = FILEPATH . 'img/default/profile-pic-blank.png';
                    if (!empty($user_detail->filename)) {
                      $profile_image = UPLOADPATH . 'user/profile/' . $user_detail->filename;
                    }
                    ?>
                    <a href="<?php echo $profile_image; ?>" class="mx-auto" data-fancybox>
                      <div class="profile-image" style="background-image: url('<?php echo $profile_image; ?>');"></div>
                      <img src="<?php echo $profile_image; ?>" style="display: none;">
                    </a>
                    <!-- <a href="javascript:void(0)" class="avatar avatar-lg rounded-circle mr-3"> -->
                      <!-- <img alt="profile-image" src="<?php echo $profile_image; ?>"> -->
                    <!-- </a> -->
                    <div class="media-body">
                      <h5 class="text-white mb-0"><?php echo ucwords($user_detail->first_name . ' ' . $user_detail->last_name); ?></h5>
                      <div>
                        <form method="post" enctype="multipart/form-data" id="profile_image_form" action="<?php echo base_url('user/account'); ?>">
                          <label for="input" class="image-previewer" data-cropzee="ufile"></label>
                          <input type="file" name="ufile" id="ufile" class="custom-input-file custom-input-file-link" accept="image/*" />
                          <label for="ufile">
                            <span class="text-white">Change avatar</span>
                          </label>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <div class="col-auto flex-fill mt-4 mt-sm-0 text-sm-right d-none d-lg-block">
                  <a href="javascript:void(0)" class="btn btn-sm btn-white rounded-pill btn-icon shadow">
                    <span class="btn-inner--icon"><i class="fas fa-fire"></i></span>
                    <span class="btn-inner--text">Upgrade to Pro</span>
                  </a>
                </div> -->
              </div>
            </div>
          </div>
          <!-- General information form -->
          <div class="actions-toolbar py-2 mb-4">
            <h5 class="mb-1">General information</h5>
            <p class="text-sm text-muted mb-0">You can help us, by filling your data, create you a much better experience using our website.</p>
          </div>
          <form id="profile_form" method="post" action="<?php echo base_url('user/account'); ?>">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">First name</label>
                  <input class="form-control" type="text" name="first_name" id="first_name" placeholder="Enter your first name" value="<?php echo $user_detail->first_name; ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Last name</label>
                  <input class="form-control" type="text" name="last_name" id="last_name" placeholder="Also your last name" value="<?php echo $user_detail->last_name; ?>" required>
                </div>
              </div>
            </div>
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Birthday</label>
                  <input type="text" name="dob" id="dob" class="form-control" data-toggle="date" placeholder="Select your birth date" value="<?php echo $user_detail->dob; ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Gender</label>
                  <select class="form-control" data-toggle="select" name="gender" id="gender" required>
                    <option value="female" <?php echo ($user_detail->gender == 'female') ? 'selected="selected"' : ''; ?>>Female</option>
                    <option value="male" <?php echo ($user_detail->gender == 'male') ? 'selected="selected"' : ''; ?>>Male</option>
                    <option value="none" <?php echo ($user_detail->gender == 'none') ? 'selected="selected"' : ''; ?>>Rather not say</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Email</label>
                  <input class="form-control" type="email" id="email" placeholder="name@exmaple.com" value="<?php echo $user_detail->email; ?>" disable readonly>
                  <!-- <small class="form-text text-muted mt-2">This is the main email address that we'll send notifications to. <a href="account-notifications.html">Manage you notifications</a> in order to receive only the thing that matter to you most.</small> -->
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Phone</label>
                  <input class="form-control" type="text" name="phone" id="phone" placeholder="+40-777 245 549" value="<?php echo $user_detail->phone; ?>" required>
                </div>
              </div>
            </div>
            <!-- Address -->
            <div class="pt-5 mt-5 delimiter-top">
              <div class="actions-toolbar py-2 mb-4">
                <h5 class="mb-1">Address details</h5>
                <p class="text-sm text-muted mb-0">Fill in your address info for upcoming orders or payments.</p>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="form-control-label">Address</label>
                    <input class="form-control" type="text" placeholder="Enter your home address" name="address" id="address" value="<?php echo $user_detail->address; ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Country</label>
                    <select class="form-control" data-toggle="select" title="Country" data-live-search="true" data-live-search-placeholder="Country" name="country" id="country" data-country="<?php echo $user_detail->country; ?>">
                      <?php
                      /*foreach ($countries as $value) {
                        $selected = ($value['alpha_2_code'] == $user_detail->country) ? 'selected="selected"' : '';
                      ?>
                      <option value="<?php echo $value['alpha_2_code']; ?>" <?php echo $selected; ?>><?php echo $value['en_short_name']; ?></option>
                      <?php }*/ ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">State</label>
                    <select class="form-control" data-toggle="select" title="State" data-live-search="true" data-live-search-placeholder="State" name="state" id="state" data-state="<?php echo $user_detail->state; ?>">
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">City</label>
                    <select class="form-control" data-toggle="select" title="City" data-live-search="true" data-live-search-placeholder="City" name="city" id="city" data-city="<?php echo $user_detail->city; ?>">
                    </select>
                  </div>
                </div>
                <!-- <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">City</label>
                    <input class="form-control" type="text" placeholder="City" name="city" id="city" value="<?php //echo $user_detail->city; ?>">
                  </div>
                </div> -->
              </div>
            </div>
            <?php /* ?>
            <!-- Skills -->
            <div class="pt-5 mt-5 delimiter-top">
              <div class="actions-toolbar py-2 mb-4">
                <h5 class="mb-1">Skills</h5>
                <p class="text-sm text-muted mb-0">Show off you skills using our tags input control.</p>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="sr-only">Skills</label>
                    <input type="text" class="form-control" value="HTML, CSS3, Bootstrap, Photoshop, VueJS" data-toggle="tags" placeholder="Type here..." />
                  </div>
                </div>
              </div>
            </div>
            <!-- Description -->
            <div class="pt-5 mt-5 delimiter-top">
              <div class="actions-toolbar py-2 mb-4">
                <h5 class="mb-1">About me</h5>
                <p class="text-sm text-muted mb-0">Use this field to let others know you better.</p>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <div class="form-group">
                      <label class="form-control-label">Bio</label>
                      <textarea class="form-control" placeholder="Tell us a few words about yourself" rows="3"></textarea>
                      <small class="form-text text-muted mt-2">You can @mention other users and organizations to link to them.</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php */ ?>
            <!-- Save changes buttons -->
            <div class="pt-5 mt-5 delimiter-top text-center">
              <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
              <button type="button" class="btn btn-link text-muted">Cancel</button>
            </div>
          </form>
        </div>
        <?php /* ?>
        <div class="col-lg-3 order-lg-1">
          <?php $this->load->view('frontend/user/profile-left-panel'); ?>
        </div><?php */ ?>
      </div>
    </div>
  </section>
</div>