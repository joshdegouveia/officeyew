<div class="main-content follower-list-page">
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
            <a href="<?php echo base_url('user/followlist'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">Follower List</span>
            </a>
            <?php /*if ($user['type'] == B2B) { ?>
            <?php $this->load->view('frontend/business/header_menu'); ?>
            <?php } else if ($user['type'] == SELLER) { ?>
            <?php $this->load->view('frontend/seller/header_menu'); ?>
            <?php }*/ ?>
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
          <div class="actions-toolbar py-2 mb-4">
            <div class="actions-search" id="actions-search">
              <div class="input-group input-group-merge input-group-flush">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" id="list_search" class="form-control form-control-flush" placeholder="Type and hit enter ..." title="Enter to search">
                <div class="input-group-append">
                  <a href="#" class="input-group-text bg-transparent" data-action="search-close" data-target="#actions-search"><i class="reset fas fa-sync"></i><i class="fas fa-times"></i></a>
                </div>
              </div>
            </div>
            <div class="row justify-content-between align-items-center">
              <div class="col">
                <h5 class="mb-1"><?php echo $title; ?></h5>
                <!-- <p class="text-sm text-muted mb-0 d-none d-md-block">Add you credit card for faster checkout process.</p> -->
              </div>
              <div class="col text-right">
                <div class="actions">
                  <a href="#" class="action-item mr-2" data-action="search-open" data-target="#actions-search"><i class="fas fa-search"></i></a>
                </div>
              </div>
            </div>
          </div>

            <?php
            if(!empty($follow)) {
              foreach($follow as $row) {
                $image = FILEPATH . 'img/default/no-image.png';
            ?>
            <div class="card mb-3">
              <div class="card-body py-3">
                <div class="row flex-column flex-md-row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                    <?php
                    if (!empty($row->filename) && file_exists(UPLOADDIR . 'user/profile/' . $row->filename)) {
                      $image = UPLOADPATH . 'user/profile/' . $row->filename;
                    ?>
                    <a href="<?php echo $image; ?>" class="" data-fancybox>
                      <div class="profile-image-post" style="background-image: url('<?php echo $image; ?>');"></div>
                    </a>
                    <?php } else { ?>
                    <a href="javascript:void(0)" class="avatar rounded-circle">
                      <img alt="Image placeholder" src="<?php echo $image; ?>" class="">
                    </a>
                    <?php } ?>
                  </div>
                  <div class="col ml-md-n2 text-center text-md-left">
                    <a href="<?php echo base_url('user/profile/' . $row->id); ?>" target="_blank" class="h6 text-sm mb-0 name"><?php echo ucwords($row->first_name . ' ' . $row->last_name); ?></a>
                    <p class="card-text text-sm text-muted mb-0">
                      <!-- Working remotely from Starbucks -->
                    </p>
                    <?php /* ?>
                    <div>
                      <span class="text-success">●</span>
                      <small>Online</small>
                    </div><?php */ ?>
                  </div>
                  <hr class="divider divider-fade my-3 d-md-none" />
                  <div class="col-12 col-md-auto d-flex justify-content-between align-items-center">
                    <?php if ($row->block == 1) { ?>
                    <a href="<?php echo base_url('user/changestat'); ?>?tp=followbu&cid=<?php echo $row->id ; ?>&stat=1">
                      <button type="button" class="btn btn-danger btn-sm"> Unblock</button>
                    </a>
                    <?php } else { ?>
                    <a href="<?php echo base_url('user/changestat'); ?>?tp=followbu&cid=<?php echo $row->id ; ?>&stat=0">
                      <button type="button" class="btn btn-info btn-sm"> Block</button>
                    </a>
                    <?php } ?>
                    <?php /* ?>
                    <button type="button" class="btn btn-sm btn-secondary">Add</button>
                    <!-- Dropdown -->
                    <div class="dropdown ml-2">
                      <a href="#" class="action-item" role="button" data-toggle="dropdown" aria-haspopup="true" data-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a href="#!" class="dropdown-item">
                          Action
                        </a>
                        <a href="#!" class="dropdown-item">
                          Another action
                        </a>
                        <a href="#!" class="dropdown-item">
                          Something else here
                        </a>
                      </div>
                    </div><?php */ ?>
                  </div>
                </div>
              </div>
            </div>

            <?php
              }
            } else {
            ?>
            No list found.
            <?php
            }
            ?>
        </div>
        <?php /* ?>
        <div class="col-lg-3 order-lg-1">
          <?php $this->load->view('frontend/user/profile-left-panel'); ?>
        </div><?php */ ?>
      </div>
    </div>
  </section>
</div>