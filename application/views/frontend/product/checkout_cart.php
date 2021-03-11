<?php
//pre($products);
$cart_toal= 0;
//print_r($_COOKIE['cart_item_ids']);
?>
<div class="main-content checkout-page">
    <!-- Header (account) -->
    <header class="header-account-page bg-primary d-flex align-items-end">
      <!-- Header container -->
      <div class="container">
        <div class="row">
          <div class=" col-lg-12">
            <!-- Salute + Small stats -->
            <?php 
            if(!empty($user)){
                $data['user'] = $user;
                $this->load->view('frontend/layout/account_heaer', $data); 
            }
            ?>
            <!-- Account navigation -->
            <?php 
              $this->load->view('frontend/layout/cart_menu'); 
            ?>
            <!---====== --->
          </div>
        </div>
      </div>
    </header>
    <section class="slice slice-lg">
      <div class="container">
        <!-- Shopping cart table -->
        <div class="table-responsive">
          <table class="table table-cards align-items-center">
            <thead>
              <tr>
                <th scope="col" class="sort" data-sort="product">Product</th>
                <th scope="col" class="sort" data-sort="price">Price</th>
                <!-- <th scope="col" class="sort" data-sort="size">Size</th> -->
                <th scope="col">Quantity</th>
                <th scope="col" class="sort" data-sort="total">Total</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody class="list">
            <?php
            if(!empty($products))
            {
              foreach($products as $product)
              {
                $image = ($product->image !='' ) ? UPLOADPATH.'products/' .$product->image : '';
                $total = $product->quantity * $product->stock_price;
                $cart_toal = $cart_toal + $total;
            ?>
       
              <tr>
                <th scope="row">
                  <div class="media align-items-center">
                    <img alt="Image placeholder" src="<?php echo $image; ?>" class="" style="width: 80px;">
                    <div class="media-body pl-3">
                      <div class="lh-100">
                        <span class="text-dark font-weight-bold mb-0"><?php echo $product->name; ?></span>
                      </div>
                      <!-- <span class="font-weight-bold text-muted">Size: 42</span> -->
                    </div>
                  </div>
                </th>
                <td class="price">
                  <?php echo $product->currency.$product->stock_price; ?>
                </td>
                <!-- <td>
                  <span class="badge badge-dot mr-4">
                    <i class="bg-"></i>
                    <span class="status">42</span>
                  </span>
                </td> -->
                <td>
                  <input type="number" min="1" class="form-control form-control-sm text-center" style="width: 80px;" value="<?php echo $product->quantity; ?>">
                  <input type="hidden" name="total"  value="<?php echo $total; ?>">
                </td>
                <td class="total">
                <?php echo $product->currency.$total; ?>
                </td>
                <td class="text-right">
                  <!-- Actions -->
                  <div class="actions ml-3">
                    <!-- <a href="#" class="action-item mr-2" data-toggle="tooltip" title="Quick view">
                      <i class="fas fa-external-link-alt"></i>
                    </a> -->
                    <a href="javascript:void(0)" onClick="deletcartSingleitem(<?php echo $product->cid; ?>)"  class="action-item mr-2" data-toggle="tooltip" title="Move to trash">
                      <i class="fas fa-times"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php 
              }
            } 
            ?>
            </tbody>
          </table>
        </div>
        <!-- Cart information -->
        <div class="card mt-5 bg-secondary">
          <div class="card-body">
            <div class="row justify-content-between align-items-center">
              <div class="col-md-4 order-md-2 mb-4 mb-md-0">
                <div class="d-flex align-items-center justify-content-md-end">
                  <span class="h6 text-muted d-inline-block mr-3 mb-0">Total value:</span>
                  <span class="h4 mb-0"><?php echo '$'.$cart_toal;?></span>
                </div>
              </div>
              <div class="col-md-4 order-md-1">
                <a href="<?php echo base_url('products/customer_details')?>" type="button" class="btn btn-animated btn-primary btn-animated-y">
                  <span class="btn-inner--visible">Next step</span>
                  <span class="btn-inner--hidden">
                    <i class="fas fa-shopping-cart"></i>
                  </span>
          </a>
                <a href="<?php echo base_url('products');?>" class="btn btn-link text-sm text-dark font-weight-bold">Return to shop</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>