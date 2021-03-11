<?php
$company_name = $company_address = $about_company = '';
$company_logo = FILEPATH . 'img/default/no-image.png';

if (!empty($company)) {
  $company_name = $company->company_name;
  $company_address = $company->company_address;
  $about_company = $company->about_company;
  $company_logo = (!empty($company->company_logo)) ? UPLOADPATH . 'business/logo/thumb/' . $company->company_logo : $company_logo;
}
?>
<div class="main-content b2b-product-page">
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
            <a href="<?php echo base_url('seller/businessvouchers'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">Business Vouchers</span>
            </a>
            <?php //$this->load->view('frontend/seller/header_menu'); ?>
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
                  <th>Voucher</th>
                  <th>Image</th>
                  <th>Quantity</th>
                  <th>Sale Price</th>
                  <th>Start Date</th>
                  <th>Expiry Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(!empty($content)) {
                  $i = 1 ;
                  foreach($content as $row) {
                    $image = FILEPATH . 'img/default/no-image.png';
                    if (!empty($row->filename)) {
                      $image = UPLOADPATH . 'vouchers/' . $row->filename;
                    }
                ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $row->name; ?></td>
                  <td><img src="<?php echo $image; ?>"></td>
                  <td><?php echo $row->quantity; ?></td>
                  <td><?php echo $row->sale_price; ?></td>
                  <td><?php echo $row->start_date; ?></td>
                  <td><?php echo $row->expiry_date; ?></td>
                  <td>
                    <?php if ($row->status == 1) { ?>
                    <a href="<?php echo base_url('seller/changestat'); ?>?tp=bvouchers&cid=<?php echo $row->id ; ?>&stat=1">
                      <button type="button" class="btn btn-info btn-sm" style="background-color: #2D9669;"> Active</button>
                    </a>
                    <?php } else { ?>
                    <a href="<?php echo base_url('seller/changestat'); ?>?tp=bvouchers&cid=<?php echo $row->id ; ?>&stat=0">
                      <button type="button" class="btn btn-info btn-sm" style="background-color: #FF370A;"> Deactive</button>
                    </a>
                    <?php } ?>
                    <a href="<?php echo base_url('seller/editbusinessvoucher/' . $row->id); ?>">
                      <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
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