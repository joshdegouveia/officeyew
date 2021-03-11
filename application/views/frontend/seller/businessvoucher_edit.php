<?php
$currency = 'Rs';
$name = $voucher->name;
$code = $voucher->code;
$description = $voucher->description;
$sale_price = $voucher->sale_price;
$percentage = $voucher->percentage;
$flat_rate = $voucher->flat_rate;
$voucher_price = $voucher->voucher_price;
$status = $voucher->status;
$quantity = $voucher->quantity;
$stock_quantity = $voucher->stock_quantity;
$start_date = ($voucher->start_date != '0000-00-00') ? $voucher->start_date : '';
$expiry_date = ($voucher->expiry_date != '0000-00-00') ? $voucher->expiry_date : '';
$image = $voucher->filename;
?>
<div class="main-content business-voucher-edit-page">
  <section class="header-account-page bg-primary d-flex align-items-end" data-offset-top="#header-main">
    <!-- Header container -->
    <div class="container pt-4 pt-lg-0">
      <div class="row">
        <div class=" col-lg-12">
          <!-- Account navigation -->
          <div class="d-flex">
            <a href="<?php echo base_url('seller/editbusinessvoucher/' . $voucher->id); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">Edit <?php echo $title; ?></span>
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
        <div class="col-lg-12 order-lg-2 bg-white">
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
          <form id="voucher_add_form" method="post" enctype="multipart/form-data">
            <div class="actions-toolbar py-2 mb-4 frm-borderb">
              <div class="delimiter-top text-right">
                <button type="submit" class="btn btn-sm btn-primary submit">Save changes</button>
                <a href="<?php echo base_url('seller/businessvouchers'); ?>" class="btn btn-info btn-sm">Cancel</a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Discount Name</label>
                  <input class="form-control" type="text" name="name" id="name" placeholder="Discount name" value="<?php echo $name; ?>" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Voucher Sale Price</label>
                  <input class="form-control" type="number" step="0.01" min="0" name="sale_price" id="sale_price" placeholder="Sale price" value="<?php echo $sale_price; ?>" required>
                  <span>Business sale price <?php echo $currency . ' ' . $voucher_price; ?> (Please set price more than business price for profit.)</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label">Description</label>
                  <textarea name="description" id="description" class="form-control wysihtml" placeholder="description" rows="3"><?php echo $description; ?></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label">Active</label>
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" name="status" id="status" <?php echo ($status == 0) ? '' : 'checked="checked"'; ?>>
                    <label class="custom-control-label" for="status"></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Voucher Code</label>
                  <input class="form-control" type="text" readonly disabled placeholder="Voucher code" value="<?php echo $code; ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Voucher Total Quantity</label>
                  <input class="form-control" type="text" readonly disabled placeholder="Voucher code" value="<?php echo $quantity; ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Voucher Stock Quantity</label>
                  <input class="form-control" type="text" readonly disabled placeholder="Voucher code" value="<?php echo $stock_quantity; ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Start Date</label>
                  <input class="form-control" type="text" readonly disabled placeholder="Voucher code" value="<?php echo $start_date; ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Expiry Date</label>
                  <input class="form-control" type="text" readonly disabled placeholder="Voucher code" value="<?php echo $expiry_date; ?>">
                </div>
              </div>
            </div>
            <?php if (!empty($image)) { ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Image</label>
                  <img src="<?php echo UPLOADPATH . 'vouchers/' . $image; ?>">
                </div>
              </div>
            </div>
            <?php } ?>
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