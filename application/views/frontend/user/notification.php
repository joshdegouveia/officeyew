<div class="main-content notification-page">
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
            <a href="<?php echo base_url('user/notification'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block"><?php echo $title; ?></span>
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
          <div class="row-w100p">
                <?php
                if(!empty($content)) {
                  $i = 1 ;
                  foreach($content as $row) {
                    $output = $link = $read = '';
                    switch ($row->type) {
                      case 'follow':
                        $output = 'New follow by ' . ucwords($row->name);
                        $link = base_url('user/followlist');
                        break;
                      case 'endorse':
                        $output = 'New endorsement from ' . ucwords($row->name);
                        $link = base_url('business/endorselist');
                        break;
                      case 'product':
                        $output = 'Product purchase by ' . ucwords($row->name);
                        $link = base_url('report/productorders');
                        break;
                      case 'voucher':
                        $output = 'Voucher purchase by ' . ucwords($row->name);
                        if ($user['type'] == B2B)  {
                          $link = base_url('business/voucherorders');
                        } else {
                          $link = base_url('report/voucherorders');
                        }
                        break;
                      case 'post':
                        $output = 'New post in profile';
                        $link = base_url('user/profile/' . $row->user_by);
                        break;
                    }
                    if ($row->isread == 0) {
                      $read = 'class="unread"';
                    }
                ?>
                <!-- <tr>
                  <td><?php echo $i++; ?></td>
                  <td><a href="<?php echo $link; ?>" target="_blank" <?php echo $read; ?>><?php echo ucwords($row->name); ?></a></td>
                  <td><a href="<?php echo $link; ?>" target="_blank" <?php echo $read; ?>><?php echo $description; ?></a></td>
                  <td>
                    <a href="<?php echo base_url('report/delete'); ?>?tp=notification&cid=<?php echo $row->id ; ?>" class="rm-data">
                      <button type="button" class="btn btn-info btn-sm"><i class="fa fa-remove"></i> Delete</button>
                    </a>
                  </td>
                </tr> -->
                <div class="new-message-box">
                  <div class="new-message-box-alert">
                    <div class="tip-box-alert">
                      <p>
                        <a href="<?php echo $link; ?>" target="_blank"> <?php echo $output; ?></a>
                        <a href="<?php echo base_url('report/delete'); ?>?tp=notification&cid=<?php echo $row->id ; ?>" class="rm-data">
                          <!-- <button type="button" class="btn btn-info btn-sm"><i class="fa fa-remove"></i> Delete</button> -->
                          <i class="fa fa-trash"></i>
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
                <?php
                  }
                }
                ?>
          </div>
        </div>
        <?php /* ?>
        <div class="col-lg-3 order-lg-1">
          <?php $this->load->view('frontend/user/profile-left-panel'); ?>
        </div><?php */ ?>
      </div>
    </div>
  </section>
</div>