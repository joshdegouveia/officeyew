<?php
$product_name = $short_description = $description = $tags = $regular_price = $sale_price = $sku = $stock = $product_id = '';
$status = 1;
$categories = $images = array();
$company_logo = FILEPATH . 'img/default/no-image.png';

if (!empty($product)) {
  $product_id = $product->id;
  $product_name = $product->name;
  $short_description = $product->short_description;
  $description = $product->description;
  $tags = $product->tags;
  $regular_price = $product->regular_price;
  $sale_price = $product->sale_price;
  $sku = $product->sku;
  $status = $product->status;
  $stock = $product->stock;
  foreach ($user_categories as $value) {
    $categories[] = $value->category_id;
  }
}
?>
<div class="main-content product-add-page" data-product="product-info<?php echo $product_id; ?>">
  <!-- Headder (pricing-charts) -->
  <section class="slice pb-250 bg-primary" data-offset-top="#header-main">
    <div class="container">
      <div class="row row-grid">
        <div class="col-lg-9 order-lg-2 bg-white">
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
          <form id="product_add_form" method="post" enctype="multipart/form-data">
            <div class="actions-toolbar py-2 mb-4 frm-borderb">
              <div class="delimiter-top text-right">
                <button type="submit" class="btn btn-sm btn-primary submit">Save changes</button>
                <a href="<?php echo base_url('business/products'); ?>" class="btn btn-info btn-sm">Cancel</a>
              </div>
            </div>
            <div class="form-attr-group tab-information">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-control-label">Product Name</label>
                    <input class="form-control" type="text" name="name" id="name" placeholder="Enter product name" value="<?php echo $product_name; ?>" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-control-label">SKU</label>
                    <input class="form-control" type="text" name="sku" id="sku" placeholder="Enter product sku" value="<?php echo $sku; ?>" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-control-label">Enable</label>
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" name="status" id="status" <?php echo ($status == 0) ? '' : 'checked="checked"'; ?>>
                      <label class="custom-control-label" for="status"></label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-control-label">Short Description</label>
                    <textarea name="short_description" id="short_description" class="form-control wysihtml" placeholder="Enter short description" rows="3"><?php echo $short_description; ?></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-control-label">Description</label>
                    <textarea name="description" id="description" class="form-control wysihtml" placeholder="Enter description" rows="3"><?php echo $description; ?></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-control-label">Tags</label>
                    <textarea name="tags" id="tags" class="form-control" placeholder="Enter tags" rows="2"><?php echo $tags; ?></textarea>
                  </div>
                  <div class="delimiter-top">
                    <p class="text-muted text-sm">Tags help to search your product by other users. You can use multiple tags separates by comma(eg tag1, tag2).</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-attr-group tab-prices" style="display: none;">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-control-label">Regular Price</label>
                    <input class="form-control" type="number" step="0.01" name="regular_price" id="regular_price" placeholder="Enter regular price" value="<?php echo $regular_price; ?>" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-control-label">Sale Price</label>
                    <input class="form-control" type="number" step="0.01" name="sale_price" id="sale_price" placeholder="Enter sale price" value="<?php echo $sale_price; ?>" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-attr-group tab-association" style="display: none;">
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label class="form-control-label">Categories</label>
                    <select class="form-control" name="categories[]" id="categories" multiple size="4" required>
                      <?php
                      if (!empty($product_categories)) {
                        foreach ($product_categories as $value) {
                          $selected = (in_array($value->id, $categories)) ? 'selected="selected"' : '';
                      ?>
                      <option value="<?php echo $value->id; ?>" <?php echo $selected; ?>><?php echo $value->name; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="ext-link">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_add_category"> <i class="fa fa-plus" aria-hidden="true"></i> Add category</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-attr-group tab-images" style="display: none;">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Add Images</label>
                    <input class="form-control" type="file" name="images[]" id="images" multiple accept="image/x-png,image/gif,image/jpeg">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Add Cover Image</label>
                    <input class="form-control" type="file" name="primary_image" id="primary_image" accept="image/x-png,image/gif,image/jpeg">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label class="form-control-label">Please add images and cover photo extension with .jpeg, .png, .gif.</label>
                  </div>
                </div>
              </div>
              <?php if (!empty($product_images)) { ?>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <?php
                    foreach ($product_images as $value) {
                      if ($value->cover == 'yes') {
                    ?>
                    <div class="product-image cover" data-im="im-<?php echo $value->id; ?>">
                      <img src="<?php echo UPLOADPATH . 'products/' . $value->image; ?>" title="Cover Image">
                    </div>
                    <?php } else { ?>
                    <div class="product-image" data-im="im-<?php echo $value->id; ?>">
                      <div class="cover-image" title="Set cover image">Set Cover</div>
                      <img src="<?php echo UPLOADPATH . 'products/' . $value->image; ?>">
                      <div class="rm-image" title="Remove image">X</div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
            <div class="form-attr-group tab-quantities" style="display: none;">
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label class="form-control-label">In stock</label>
                    <select class="form-control" name="stock" id="stock">
                      <option value="yes" <?php echo ($stock != 'no') ? 'selected="selected"' : ''; ?>>Yes</option>
                      <option value="no" <?php echo ($stock == 'no') ? 'selected="selected"' : ''; ?>>No</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-3 order-lg-1">
          <div class="card">
            <div class="card-header py-3">
              <span class="h6">Attributes</span>
            </div>
            <div class="list-group list-group-sm list-group-flush list-panel">
              <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex justify-content-between active" data-target="information">
                <div>
                  <i class="fa fa-info-circle mr-2" aria-hidden="true"></i>
                  <span>Information</span>
                </div>
              </a>
              <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex justify-content-between" data-target="prices">
                <div>
                  <i class="fas fa-cc-stripe mr-2" aria-hidden="true"></i>
                  <span>Prices</span>
                </div>
              </a>
              <!-- <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex justify-content-between" data-target="seo">
                <div>
                  <i class="fa fa-book mr-2" aria-hidden="true"></i>
                  <span>SEO</span>
                </div>
              </a> -->
              <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex justify-content-between" data-target="association">
                <div>
                  <i class="fa fa-link mr-2" aria-hidden="true"></i>
                  <span>Association</span>
                </div>
              </a>
              <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex justify-content-between" data-target="images">
                <div>
                  <i class="fa fa-file-image mr-2" aria-hidden="true"></i>
                  <span>Images</span>
                </div>
              </a>
              <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex justify-content-between" data-target="quantities">
                <div>
                  <i class="fa fa-folder-open mr-2" aria-hidden="true"></i>
                  <span>Quantities</span>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="modal_add_category" tabindex="-1" role="dialog" aria-labelledby="modal-change-email" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form method="post" id="add_product_category" style="width: 100%;" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-email">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa fa-link"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Add Category</h6>
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
            <div class="col-sm-12">
              <div class="form-group">
                <label class="form-control-label">Category Name</label>
                <input class="form-control" type="text" name="new_category" id="new_category" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label class="form-control-label">Category Image</label>
                <input class="form-control" type="file" name="file" id="file" accept="image/x-png,image/gif,image/jpeg">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary submit">Add Category</button>
        </div>
      </div>
    </form>
  </div>
</div>