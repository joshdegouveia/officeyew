<?php

if((isset($_SESSION['cart']) && !in_array('cart',$_SESSION['cart'])) || (!isset($_SESSION['cart'])))
{
  redirect(base_url('products/cart'), 'refresh');
}

$fname = '';
$lname = '';
$address = '';
$country = '';
$state = '';
$city = '';
$postcode = '';
$phone = '';
$email = '';
if(!empty($form_data)) {
  $fname = $form_data['f_name'];
  $lname = $form_data['l_name'];
  $address = $form_data['address'];
  $country = $form_data['country'];
  $state = $form_data['state'];
  $city = $form_data['city'];
  $postcode = $form_data['postcode'];
  $phone = $form_data['phone'];
  $email = $form_data['email'];
}
?>
<div class="main-content checkout-customer-page">
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
          </div>
        </div>
      </div>
    </header>
    <section class="slice slice-lg">
      <div class="container">
        <div class="row row-grid">
          <div class="col-lg-8">
            <form name="customer" id="customer" action="" method="post" >
              <!-- General -->
              <div class="actions-toolbar py-2 mb-4">
                <h5 class="mb-1">Billing information</h5>
                <p class="text-sm text-muted mb-0">Fill the form below so we can send you the order's invoice.</p>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">First name</label>
                    <input name="f_name" class="form-control" type="text" placeholder="Enter your first name" required value="<?php echo $fname; ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Last name</label>
                    <input name="l_name" class="form-control" type="text" placeholder="Also your last name" required value="<?php echo $lname; ?>">
                  </div>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-control-label">Address</label>
                    <input name="address" class="form-control" type="text" placeholder="Address, Number" required value="<?php echo $address; ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Email</label>
                    <input name="email" id="email" class="form-control" type="email" placeholder="Email address" required value="<?php echo $email; ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Country</label>
                    <select name="country" id="country" class="form-control" data-toggle="select" title="Country" data-country="<?php echo $country; ?>" required>
                      <option selected disabled>Select your country</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">State</label>
                    <select name="state" id="state" class="form-control" data-toggle="select" title="State" data-state="<?php echo $state; ?>" required>
                      <option selected disabled>Select your country</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">City</label>
                    <select name="city" id="city" class="form-control" data-toggle="select" title="City" data-city="<?php echo $city; ?>" required>
                      <option selected disabled>Select your city</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Postal code</label>
                    <input name="postcode" class="form-control" type="text" placeholder="Address, Number" required value="<?php echo $postcode; ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Phone</label>
                    <input name="phone" class="form-control" type="text" placeholder="+40-777 245 549" required value="<?php echo $phone; ?>">
                  </div>
                </div>
              </div>
              <div class="mt-4 text-right">
                <a href="<?php echo base_url('products');?>" class="btn btn-link text-sm text-dark font-weight-bold">Return to shop</a>
                <!-- <button type="submit" name="submit" class="btn btn-sm btn-success">Next step</button> -->
                <input type="submit" name="submit" class="btn btn-sm btn-success" value="Next step" />
              </div>
            </form>
          </div>
          <div class="col-lg-4">
            <div data-toggle="sticky" data-sticky-offset="30">
              <div class="card" id="card-summary">
                <div class="card-header py-3">
                  <div class="row align-items-center">
                    <div class="col-6">
                      <span class="h6">Summary</span>
                    </div>
                    <div class="col-6 text-right">
                      <span class="badge badge-pill badge-soft-success"><?php echo count($products); ?> items</span>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <?php
                  if (!empty($products)) {
                    $total = 0;
                    foreach ($products as $value) {
                      $image = FILEPATH . 'img/default/no-image.png';
                      if (!empty($value->image)) {
                        $image = UPLOADPATH . 'products/' . $value->image;
                      }
                      $total += ($value->quantity * $value->stock_price);
                  ?>
                  <div class="row">
                    <div class="col-8">
                      <div class="media align-items-center">
                        <img alt="Image placeholder" class="mr-2" src="<?php echo $image; ?>" style="width: 42px;">
                        <div class="media-body">
                          <div class="text-limit lh-100">
                            <small class="font-weight-bold mb-0"><?php echo $value->name; ?></small>
                          </div>
                          <small class="text-muted"><?php echo $value->quantity . ' x ' . 'Rs' . $value->stock_price; ?></small>
                        </div>
                      </div>
                    </div>
                    <div class="col-4 text-right lh-100">
                      <small class="text-dark">Rs<?php echo ($value->quantity * $value->stock_price); ?></small>
                    </div>
                  </div>
                  <?php
                    }
                  }
                  ?>
                  <?php /* ?>
                  <div class="row mt-3 pt-3 delimiter-top">
                    <div class="col-8">
                      <div class="media align-items-center">
                        <img alt="Image placeholder" class="mr-2" src="../../assets/img/theme/light/product-2.png" style="width: 42px;">
                        <div class="media-body">
                          <div class="text-limit lh-100">
                            <small class="font-weight-bold mb-0">Women running shoes</small>
                          </div>
                          <small class="text-muted">2 x $49.50</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-4 text-right lh-100">
                      <small class="text-dark">$99.00</small>
                    </div>
                  </div>
                  <div class="row mt-3 pt-3 delimiter-top">
                    <div class="col-8">
                      <div class="media align-items-center">
                        <img alt="Image placeholder" class=" mr-2" src="../../assets/img/theme/light/product-3.png" style="width: 42px;">
                        <div class="media-body">
                          <div class="text-limit lh-100">
                            <small class="font-weight-bold mb-0">Women running shoes</small>
                          </div>
                          <small class="text-muted">2 x $99.00</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-4 text-right lh-100">
                      <small class="text-dark">$198.00</small>
                    </div>
                  </div><?php */ ?>
                  <?php /* ?>
                  <!-- Subtotal -->
                  <div class="row mt-3 pt-3 border-top">
                    <div class="col-8 text-right">
                      <small class="font-weight-bold">Subtotal:</small>
                    </div>
                    <div class="col-4 text-right">
                      <span class="text-sm font-weight-bold">Rs<?php echo $total; ?></span>
                    </div>
                  </div>
                  <!-- Shipping -->
                  <div class="row mt-3 pt-3 border-top">
                    <div class="col-8 text-right">
                      <div class="media align-items-center">
                        <i class="fas fa-shipping-fast"></i>
                        <div class="media-body">
                          <div class="text-limit lh-100">
                            <small class="font-weight-bold mb-0">Shipping</small>
                          </div>
                          <small class="text-muted">Fast Delivery</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-4 text-right">
                      <span class="text-sm font-weight-bold">$25.00</span>
                    </div>
                  </div>
                  <?php */ ?>
                  <!-- Subtotal -->
                  <div class="row mt-3 pt-3 border-top">
                    <div class="col-8 text-right">
                      <small class="text-uppercase font-weight-bold">Total:</small>
                    </div>
                    <div class="col-4 text-right">
                      <span class="text-sm font-weight-bold">Rs<?php echo $total; ?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>