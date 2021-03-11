<?php
$name = $code = $total_use = $description = $percentage = $flat_rate = $id = $start_date = $expiry_date = $discount_type = '';
$status = 1;
if (!empty($voucher)) {
  $id = $voucher->id;
  $name = $voucher->name;
  $code = $voucher->code;
  $description = $voucher->description;
  $percentage = $voucher->percentage;
  $flat_rate = $voucher->flat_rate;
  $total_use = $voucher->total_use;
  $status = $voucher->status;
  $discount_type = $voucher->discount_type;
  $start_date = ($voucher->start_date != '0000-00-00') ? $voucher->start_date : '';
  $expiry_date = ($voucher->expiry_date != '0000-00-00') ? $voucher->expiry_date : '';
}
?>
<div class="main-content voucher-add-page" data-product="voucher-info<?php echo $id; ?>">
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
                <a href="<?php echo base_url('seller/vouchers'); ?>" class="btn btn-info btn-sm">Cancel</a>
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
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label">Description</label>
                  <textarea name="description" id="description" class="form-control wysihtml" placeholder="description" rows="3"><?php echo $description; ?></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Voucher Code</label>
                  <input class="form-control" type="text" name="code" id="code" placeholder="Voucher code" value="<?php echo $code; ?>" required>
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
                  <label class="form-control-label">Total Use By Customer</label>
                  <input class="form-control" type="number" name="total_use" id="total_use" placeholder="Total use" value="<?php echo $total_use; ?>" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Discount Rate</label>
                  <div class="discount-type">
                    <label><input class="" type="radio" name="discount_for" value="percentage" <?php echo (empty($flat_rate)) ? 'checked="checked"' : ''; ?>> Percentage</label>
                    <label><input class="" type="radio" name="discount_for" value="flat_rate" <?php echo (!empty($flat_rate)) ? 'checked="checked"' : ''; ?>> Flat Rate</label>
                  </div>
                  <?php if (!empty($percentage)) { ?>
                  <input class="form-control" type="number" step="0.01" name="discount_price" id="discount_price" placeholder="Enter discount percentage" value="<?php echo $percentage; ?>" required>
                  <?php } else { ?>
                  <input class="form-control" type="number" step="0.01" name="discount_price" id="discount_price" placeholder="Enter discount percentage" value="<?php echo $percentage; ?>" required>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Start Date</label>
                  <input type="text" name="start_date" id="start_date" class="form-control" data-toggle="date" placeholder="Select start date" value="<?php echo $start_date; ?>" required autocomplete="off">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Expiry Date</label>
                  <input type="text" name="expiry_date" id="expiry_date" class="form-control" data-toggle="date" placeholder="Select expiry date" value="<?php echo $expiry_date; ?>" required autocomplete="off">
                </div>
              </div>
            </div>
            <?php /* ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label">Discount Products</label>
                  <div class="discount-for">
                    <label><input class="" type="radio" name="discount_product" value="all" <?php echo ($discount_type != 'product' && $discount_type != 'category') ? 'checked="checked"' : ''; ?>> All Products</label>
                    <label><input class="" type="radio" name="discount_product" value="category" <?php echo ($discount_type == 'category') ? 'checked="checked"' : ''; ?>> By Category</label>
                    <label><input class="" type="radio" name="discount_product" value="product" <?php echo ($discount_type == 'product') ? 'checked="checked"' : ''; ?>> By Product</label>
                  </div>
                  <div class="discount-by-category" style="<?php echo ($discount_type != 'category') ? 'display: none;' : ''; ?>">
                    <select class="form-control" name="by_category[]" id="by_category" multiple size="4">
                    <?php
                    if (!empty($product_categories)) {
                      foreach ($product_categories as $value) {
                        $selected = (in_array($value->id, $user_categories)) ? 'selected="selected"' : '';
                    ?>
                    <option value="<?php echo $value->id; ?>" <?php echo $selected; ?>><?php echo $value->name; ?></option>
                    <?php                        
                      }
                    }
                    ?>
                    </select>
                  </div>
                  <div class="discount-by-product" style="<?php echo ($discount_type != 'product') ? 'display: none;' : ''; ?>">
                    <div class="head">Select Products</div>
                    <div class="discount-by-product-item">
                      <?php
                      if (!empty($products)) {
                        foreach ($products as $value) {
                          $selected = (in_array($value->id, $user_products)) ? 'checked="checked"' : '';
                      ?>
                      <div class="item" title="<?php echo $value->name; ?>">
                        <label><input type="checkbox" name="product_items[]" value="<?php echo $value->id; ?>" <?php echo $selected; ?>> <?php echo $value->name; ?></label>
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
            <?php */ ?>
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