<div class="main-content b2b-voucher-order-page">
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
            <a href="<?php echo base_url('business/voucherorders'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block"><?php echo $title; ?></span>
            </a>
            <?php //$this->load->view('frontend/business/header_menu'); ?>
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
          <div class="table-responsive row-w100p">
            <table id="list_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Voucher</th>
                  <th>Image</th>
                  <th>Voucher Code</th>
                  <th>Voucher Price</th>
                  <!-- <th>Quantity</th>
                  <th>Total Price</th>
                  <th>Discount</th> -->
                  <th>Seller Name</th>
                  <th>Seller Email</th>
                  <th>Voucher Status</th>
                  <th>Start Date</th>
                  <th>Expiry Date</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(!empty($content)) {
                  $i = 1 ;
                  foreach($content as $row) {
                    $image = FILEPATH . 'img/default/no-image.png';
                ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $row->voucher_name; ?></td>
                  <td><img src="<?php echo $image; ?>"></td>
                  <td>
                    <a href="javascript:void(0)" class="show-code">Show Code</a>
                    <a href="javascript:void(0)" class="voucher-code" style="display: none;"><?php echo $row->code; ?></a>
                  </td>
                  <td><?php echo $row->voucher_price; ?></td>
                  <!-- <td><?php //echo $row->quantity; ?></td>
                  <td><?php //echo $row->total_price_paid; ?></td>
                  <td><?php //echo $row->total_discount; ?></td> -->
                  <td><a href="<?php echo base_url('user/profile/' . $row->user_id); ?>"><?php echo ucwords($row->first_name . ' ' . $row->last_name); ?></a></td>
                  <td><?php echo $row->email; ?></td>
                  <td>
                    <?php if ($row->voucher_status == 'booked' || $row->voucher_status == 'redeemed') { ?>
                    <div class="update-container"><span><?php echo ucwords($row->voucher_status); ?></span>&nbsp;&nbsp;(<a href="javascript:void(0)" class="show-update">Update</a>)</div>
                    <div class="action" data-pid="<?php echo $row->voucher_id; ?>" style="display: none;">
                      <select>
                        <option value="booked">Booked</option>
                        <option value="redeemed">Redeemed</option>
                      </select><br/>
                      <input type="button" class="change" value="Update" title="Update">
                      <a href="javascript:void(0)" class="cancel" title="Cancel"> X </a>
                    </div>
                    <?php } else { ?>
                    <div><?php echo ucwords($row->voucher_status); ?></div>
                    <?php } ?>
                  </td>
                  <td><?php echo $row->start_date; ?></td>
                  <td><?php echo $row->expiry_date; ?></td>
                </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
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