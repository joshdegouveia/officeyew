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
            <a href="<?php echo base_url('seller/products'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">My Products</span>
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
                  <th>Product</th>
                  <th>Image</th>
                  <th>Category</th>
                  <th>Regular Price</th>
                  <th>Sale Price</th>
                  <th>Share</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(!empty($products)) {
                  $i = 1 ;
                  foreach($products as $row) {
                    $image = FILEPATH . 'img/default/no-image.png';
                    $category = (!empty($row->category)) ? substr($row->category, 0, strrpos($row->category, ',')) : '';
                    if (!empty($row->image)) {
                      $image = UPLOADPATH . 'products/' . $row->image;
                    }
                    $product_link = base_url('products/detail/' . $row->stock_id);
                ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $row->name; ?></td>
                  <td><img src="<?php echo $image; ?>" width="60"></td>
                  <td><?php echo $category; ?></td>
                  <td><?php echo $row->regular_price; ?></td>
                  <td><?php echo $row->sale_price; ?></td>
                  <td>
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $product_link; ?>" class="share" title="Share on facebook"><i class="fab fa-facebook"></i></a>
                    <a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $row->name; ?>&url=<?php echo $product_link; ?>" class="share" title="Share on tweeter"><i class="fab fa-twitter"></i></a>
                    <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $product_link; ?>" class="share" title="Share on linkedin"><i class="fab fa-linkedin"></i></a>
                    <a href="whatsapp://send?text=<?php echo $product_link; ?>" class="share" title="Share on whatsapp"><i class="fab fa-whatsapp"></i></a>
                    <!-- <a href="https://wa.me/?text=<?php //echo $product_link; ?>"">WA</a> -->
                  </td>
                  <td>
                    <?php if ($row->status == 1 && $row->seller_status == 1 && $row->seller_regular_price > 0 && $row->seller_sale_price > 0 && $row->seller_stock == 'yes') { ?>
                    <a href="<?php echo $product_link; ?>">
                      <button type="button" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</button>
                    </a>
                    <?php } ?>
                    <a href="<?php echo base_url('seller/editproduct'); ?>?cid=<?php echo $row->id ; ?>">
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