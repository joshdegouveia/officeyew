<?php
//pre($_COOKIE['shipping_address_id']);
if((isset($_SESSION['cart']) && !in_array('customer',$_SESSION['cart'])) || (!isset($_SESSION['cart'])))
{
  redirect(base_url('products/customer_details'), 'refresh');
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
if (!empty($form_data)) {
  $fname = $form_data['f_name'];
  $lname = $form_data['l_name'];
  $address = $form_data['address'];
  $country = $form_data['country'];
  $state = $form_data['state'];
  $city = $form_data['city'];
  $postcode = $form_data['postcode'];
  $phone = $form_data['phone'];
  $email = @$form_data['email'];
}

?>
<div class="main-content cart-shipping-page">
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
    <section class="slice">
      <div class="container">
        <div class="row row-grid">
          <div class="col-lg-8">
            <form name="shipping" id="shipping" action="" method="post" >
              <!-- Title -->
              <!-- <div class="actions-toolbar py-2 mb-4">
                <h5 class="mb-1">Saved addresses</h5>
                <p class="text-sm text-muted mb-0">Use one of your saved addresses for fast checkout.</p>
              </div> -->
              <!-- Table of addresses -->
              <!-- <div class="table-responsive">
                <table class="table table-cards align-items-center">
                  <tbody class="list">
                    <tr>
                      <th scope="row">
                        <div class="custom-control custom-checkbox">
                          <input type="radio" class="custom-control-input" name="radio-address" id="tbl-addresses-check-1" checked>
                          <label class="custom-control-label" for="tbl-addresses-check-1"></label>
                        </div>
                      </th>
                      <td>
                        <span class="font-weight-600 text-dark">Address 1</span><span class="badge badge-pill badge-soft-info ml-2">Primary</span></td>
                      <td>
                        <p class="mb-0 text-muted text-limit text-sm">1333 Deerfield, State College PA, 16803</p>
                      </td>
                      <td>
                        <div class="actions">
                          <div class="dropdown">
                            <a class="action-item" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item" href="#"><i class="fas fa-edit text-muted"></i>Edit address</a>
                              <a class="dropdown-item" href="#"><i class="fas fa-trash-alt text-danger"></i>Move to trash</a>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr class="table-divider"></tr>
                    <tr>
                      <th scope="row">
                        <div class="custom-control custom-checkbox">
                          <input type="radio" class="custom-control-input" name="radio-address" id="tbl-addresses-check-2">
                          <label class="custom-control-label" for="tbl-addresses-check-2"></label>
                        </div>
                      </th>
                      <td>
                        <span class="font-weight-600 text-dark">Address 2</span></td>
                      <td>
                        <p class="mb-0 text-muted text-limit text-sm">2047 Main Street, State Chicago CH, 20067</p>
                      </td>
                      <td>
                        <div class="actions">
                          <div class="dropdown">
                            <a class="action-item" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item" href="#"><i class="fas fa-edit text-muted"></i>Edit address</a>
                              <a class="dropdown-item" href="#"><i class="fas fa-trash-alt text-danger"></i>Move to trash</a>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr class="table-divider"></tr>
                    <tr>
                      <th scope="row">
                        <div class="custom-control custom-checkbox">
                          <input type="radio" class="custom-control-input" name="radio-address" id="tbl-addresses-check-3">
                          <label class="custom-control-label" for="tbl-addresses-check-3"></label>
                        </div>
                      </th>
                      <td>
                        <span class="font-weight-600 text-dark">Address 3</span></td>
                      <td>
                        <p class="mb-0 text-muted text-limit text-sm">5078 Third Street, State New York NY, 33006</p>
                      </td>
                      <td>
                        <div class="actions">
                          <div class="dropdown">
                            <a class="action-item" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item" href="#"><i class="fas fa-edit text-muted"></i>Edit address</a>
                              <a class="dropdown-item" href="#"><i class="fas fa-trash-alt text-danger"></i>Move to trash</a>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div> -->
              <div class="mt-5">
                <!-- Title -->
                <div class="actions-toolbar py-2 mb-4">
                  <h5 class="mb-1">Add new address</h5>
                  <p class="text-sm text-muted mb-0">Fill in your address info for upcoming orders or payments.</p>
                </div>
                <!-- New address form -->
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
              </div>
              <!-- <div class="mt-5"> -->
                <!-- Title -->
                <!-- <div class="actions-toolbar py-2 mb-4">
                  <h5 class="mb-1">Shipping method</h5>
                  <p class="text-sm text-muted mb-0">Fill in your address info for upcoming orders or payments.</p>
                </div> -->
                <!-- Shipping method options -->
                <!-- <div class="row row-grid mt-4">
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-8">
                            <div class="custom-control custom-checkbox">
                              <input type="radio" name="shipping-method" class="custom-control-input" id="shipping-standard">
                              <label class="custom-control-label text-dark font-weight-bold" for="shipping-standard">Standard Delivery</label>
                            </div>
                          </div>
                          <div class="col-4 text-right">
                            <span class="h6">Free</span>
                          </div>
                        </div>
                        <p class="text-muted text-sm mt-3 mb-0">Estimated 10-20 days shipping. Lorem Ipsum is simply dummy text of the printing and typesetting.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-8">
                            <div class="custom-control custom-checkbox">
                              <input type="radio" name="shipping-method" class="custom-control-input" id="shipping-fast">
                              <label class="custom-control-label text-dark font-weight-bold" for="shipping-fast">Fast Delivery</label>
                            </div>
                          </div>
                          <div class="col-4 text-right">
                            <span class="h6">$25 USD</span>
                          </div>
                        </div>
                        <p class="text-muted text-sm mt-3 mb-0">Estimated 3-5 days shipping. Lorem Ipsum is simply dummy text of the printing and typesetting.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->
              <div class="card mt-5 bg-secondary">
                <div class="card-body">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-md-6 order-md-2 mb-4 mb-md-0">
                      <div class="d-flex align-items-center justify-content-md-end text-center text-left voucher-container">
                        <button type="button" class="btn btn-success form-control-sm voucher-btn" style="padding:.5rem 1.25rem;">Add Voucher</button>
                        <div class="voucher-add" style="display: none;">
                          <input type="text" name="voucher_code" id="voucher_code">
                          <input type="button" id="voucher_apply" value="Apply">
                          <input type="button" id="voucher_cancel" value="Cancel">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 order-md-2 mb-4 mb-md-0">
                      <div class="text-right">
                        <a href="<?php echo base_url('products');?>" class="btn btn-link text-sm text-dark font-weight-bold">Return to shop</a>
                        <input type="submit" name="submit" class="btn btn-sm btn-success" value="Next step" />
                      </div>
                    </div>
                  </div>
                </div>
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