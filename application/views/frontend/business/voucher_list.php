<div class="main-content b2b-voucher-page">
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
            <a href="<?php echo base_url('business/products'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">My Products</span>
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
          <?php } ?>
          <div class="table-responsive row-w100p">
            <table id="list_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Image</th>
                  <th>Discount</th>
                  <th>Start Date</th>
                  <th>Expiry Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(!empty($vouchers)) {
                  $i = 1 ;
                  foreach($vouchers as $row) {
                    $discount = ($row->percentage > 0) ? $row->percentage : $row->flat_rate;
                    $image = FILEPATH . 'img/default/no-image.png';
                    if (!empty($row->filename)) {
                      $image = UPLOADPATH . 'vouchers/' . $row->filename;
                    }
                ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $row->name; ?></td>
                  <td><img src="<?php echo $image; ?>"></td>
                  <td><?php echo $discount; ?></td>
                  <td><?php echo $row->start_date; ?></td>
                  <td><?php echo $row->expiry_date; ?></td>
                  <td>
                    <a href="<?php echo base_url('business/editvoucher'); ?>?cid=<?php echo $row->id ; ?>">
                      <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                    </a>
                    <a href="<?php echo base_url('business/delete'); ?>?tp=voucher&cid=<?php echo $row->id ; ?>" class="rm-data">
                      <button type="button" class="btn btn-info btn-sm"><i class="fa fa-remove"></i> Delete</button>
                    </a>
                  </td>
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