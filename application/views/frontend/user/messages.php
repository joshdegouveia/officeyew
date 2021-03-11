<div class="main-content messages-page">
  <!-- Headder (pricing-charts) -->
  <section class="header-account-page bg-primary d-flex align-items-end" data-offset-top="#header-main">
    <!-- Header container -->
    <div class="container pt-4 pt-lg-0">
      <div class="row">
        <div class=" col-lg-12">
          <!-- Account navigation -->
          <div class="d-flex">
            <a href="<?php echo base_url('user/messages'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">Messages</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- <section class="slice bg-primary" data-offset-top="#header-main"> -->
  <section class="slice">
    <div class="container">
      <div class="row row-grid">
        <div class="col-lg-8 order-lg-2 bg-white">
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
          <div class="mesgs bg-white shadaw border-radius">
            <div class="msg_history">
              <?php if (empty($messages)) { ?>
              No users for messaging.
              <?php } ?>
              <?php /* ?>
              <div class="incoming_msg">
                <div class="msg_img">
                  <img src="https://localhost/booking-management/assets/upload/user/profile/thumb/profile_1574243305_7.png" alt="sunil">
                </div>
                <div class="received_msg msg-txtcmn btm-left-shape">
                  <p>Please keep in touch</p>
                  <span class="rm-time"> 11:01 AM</span>
                </div>
              </div>
              <div class="outgoing_msg">
                <div class="sent_msg msg-txtcmn btm-right-shape">
                  <p>There are many variations of passages of Lorem </p>
                  <span class="rm-time"> 11:01 AM</span>
                </div>
                <div class="msg_img">
                  <img src="https://localhost/booking-management/assets/upload/user/profile/thumb/profile_1574243305_7.png" alt="sunil">
                </div>
              </div>
              <div class="incoming_msg">
                <div class="msg_img">
                  <img src="https://localhost/booking-management/assets/upload/user/profile/thumb/profile_1574243305_7.png" alt="sunil">
                </div>
                <div class="received_msg msg-txtcmn btm-left-shape">
                  <p>when an unknown printer took a galley of type...</p>
                  <span class="rm-time"> 11:01 AM</span>
                </div>
              </div>
              <div class="outgoing_msg">
                <div class="sent_msg msg-txtcmn btm-right-shape">
                  <p>Ok Thanks for your sharing</p>
                  <span class="rm-time"> 11:01 AM</span>
                </div>
                <div class="msg_img">
                  <img src="https://localhost/booking-management/assets/upload/user/profile/thumb/profile_1574243305_7.png" alt="sunil">
                </div>
              </div>
              <?php */ ?>
            </div>
            <?php if (!empty($messages)) { ?>
            <div class="padding-15 chat-box">
              <form method="post" enctype="multipart/form-data" id="chat_form">
                <textarea name="message" id="message" class="form-control custm-text-area" placeholder="Write your message"></textarea>
                <div class="chat-btn-grup text-right">
                  <input type="file" name="ufile[]" id="ufile" style="display: none;" multiple>
                  <span class="marr15p clear" style="display: none;"><a href="javascript:void(0)"><i class="fa fa-recycle" aria-hidden="true"></i> Clear</a></span>
                  <span class="marr15p file-ico"><img src="<?php echo FILEPATH . 'img/backgrounds/img-blank-ico.png' ?>"></span>
                  <button type="button" class="btn-cmn gradient btnsnd submit">Send</button>
                </div>
              </form>
            </div>
            <?php } ?>
          </div>
        </div>
        <div class="col-lg-4 order-lg-1">
          <div class="card">
            <div class="card-header py-3">
              <span class="h6">Message list</span>
            </div>
            <div class="list-group list-group-sm list-group-flush list-panel">
              <?php
              if (!empty($messages)) {
                $first = true;
                foreach ($messages as $value) {
                  if ($user['id'] == $value->id) {
                    continue;
                  }
                  $image = FILEPATH . 'img/default/profile-pic-blank.png';
                  if (!empty($value->filename)) {
                    $image = UPLOADPATH . 'user/profile/thumb/' . $value->filename;
                  }
                  $active_class = '';
                  $user_type = $value->type;
                  if ($first) {
                    $first = false;
                    $active_class = 'active_chat';
                  }
                  if ($value->type == B2B) {
                    $user_type = 'Brand';
                  }
              ?>
              <div class="chat_list <?php echo $active_class; ?>">
                <div class="chat_people" data-muid="mu-<?php echo $value->id; ?>">
                  <div class="chat_img">
                    <img src="<?php echo $image; ?>">
                  </div>
                  <div class="chat_ib">
                    <h5><?php echo ucwords($value->first_name . ' ' . $value->last_name); ?></h5>
                    <p><?php echo ucfirst($user_type); ?></p>
                  </div>
                </div>
              </div>
              <?php
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>