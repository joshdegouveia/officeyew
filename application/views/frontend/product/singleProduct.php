<?php
// echo "<pre>";
// print_r($product);
// exit ();
$uid = (!empty($user)) ? $user['id'] : '';
//$product = $product[0];
$p_image = UPLOADPATH.'products/'.$product->image;
$regular_price = ($product->seller_regular_price == 0) ? $product->regular_price : $product->seller_regular_price;
$sale_price = ($product->seller_sale_price == 0) ? $product->sale_price : $product->seller_sale_price;
$currency = '$';
?>
<div class="main-content single-product-page" data-pid="pid-<?php echo $product->id; ?>">
    <section class="slice slice-lg delimiter-bottom bg-primary" id="sct-products">
      <!--for menue backgroung color -->
     
    </section>
    <section class="py-2 delimiter-bottom">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h6 class="h4"><?php echo $product->b2bcompany; ?></h6>
          </div>
        </div>
      </div>
    </section>
    <section class="slice">
      <div class="container">
        <div class="row row-grid">
          <div class="col-lg-6">
            <div data-toggle="sticky" data-sticky-offset="30">
              <a href="<?php echo $p_image ?>" data-fancybox>
                <img alt="<?php echo $product->name; ?>" src="<?php echo $p_image ?>" class="img-fluid">
              </a>
              <div class="mt-4 text-center">
                <a class="btn btn-primary" href="<?php echo $p_image ?>" data-fancybox>View Photos</a>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="pl-lg-5">
              <!-- Product title -->
              <h5 class="h4"><?php echo $product->name; ?></h5>
              <!-- <h6 class="text-sm">Processor 256GB Storage</h6> -->
              <!-- Rating -->
              <div class="row align-items-center">
                <div class="col-6">
                  <span class="static-rating static-rating-sm d-block"><i class="star fas fa-star voted"></i>
                    <i class="star fas fa-star voted"></i>
                    <i class="star fas fa-star voted"></i>
                    <i class="star fas fa-star voted"></i>
                    <i class="star fas fa-star"></i></span>
                </div>
                <div class="col-6 text-right">
                  <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                      <span class="badge badge-pill badge-soft-info">ID: <?php echo $product->sku;?></span>
                    </li>
                    <li class="list-inline-item">
                      <span class="badge badge-pill badge-soft-success"><?php echo $stock = ($product->stock == 'yes')?'In stock': 'Not in stock'; ?></span>
                    </li>
                  </ul>
                </div>
              </div>
              <!-- Description -->
              <div class="py-4 my-4 border-top border-bottom">
                <h6 class="text-sm">Description:</h6>
                <!-- <p class="text-sm mb-0"> -->
                <?php echo $product->short_description; ?>
                <!-- </p> -->
              </div>
              <dl class="row">
                <?php echo $product->description; ?>  
              </dl>
              <!-- Size -->
                <div class="py-4 my-4 border-top border-bottom">
                    <div class="row align-items-center">
                        <div class="col-sm-6 mb-4 mb-sm-0">
                            <span class="d-block h3 mb-0"><?php echo $currency.$sale_price; ?></span>
                            <?php 
                                if($regular_price != $sale_price)
                                {
                            ?>
                                <span style = "text-decoration:line-through;" class=""><?php echo $currency.$regular_price?></span>
                                <!-- <a href="javascript:void(0)" class="text-sm">Choose a financing option</a> -->
                            <?php } ?>        
                        </div> 
                        <div class="col-sm-6 text-sm-right"> 
                            <!-- Add to cart -->
                            <button type="button" onclick="return addTocart()" class="btn btn-primary btn-icon adcrt">
                                <span class="btn-inner--icon"><i class="fas fa-shopping-bag"></i></span>
                                <span class="btn-inner--text">Add to cart</span>
                            </button>
                        </div>
                    </div>
                </div>
                <?php if (!empty($user)) { ?>
                <div class="row align-items-center py-4 my-4 border-bottom">
                  <div class="col-6 text-left">
                    <ul class="list-inline mb-0">
                      <li class="list-inline-item">
                        <span class="badge badge-pill badge-soft-info">Please give your rating</span>
                      </li>
                    </ul>
                  </div>
                  <div class="col-6">
                    <?php
                    if (!empty($review)) {
                      $tot_review = 5;
                    ?>
                      <span class="static-rating static-rating-sm d-block reviewed">
                        <?php
                        for ($i = 1; $i <= $tot_review; $i++) {
                          if ($i <= $review) {
                        ?>
                        <i class="star fas fa-star voted"></i>
                        <?php } else { ?>
                        <i class="star fas fa-star"></i>
                        <?php } ?>
                        <?php } ?>
                      </span>
                    <?php } else { ?>
                    <span class="static-rating static-rating-sm d-block review">
                      <i class="star fas fa-star"></i>
                      <i class="star fas fa-star"></i>
                      <i class="star fas fa-star"></i>
                      <i class="star fas fa-star"></i>
                      <i class="star fas fa-star"></i>
                    </span>
                    <?php } ?>
                  </div>
                </div>
                <?php } ?>
                <div class="row align-items-center">
                  <div class="col-12 text-left">
                    <ul class="list-inline mb-0">
                      <li class="list-inline-item">
                        <span class="badge badge-pill badge-soft-info">Write your review</span>
                      </li>
                    </ul>
                  </div>
                  <div class="col-12 text-left mt-4 comment-review">
                    <div class="mb-4 alert" style="display: none;">Thanks for submit</div>
                    <textarea class="form-control" id="comment"></textarea>
                    <input type="button" id="comment_submit" class="btn btn-success mt-2" value="Submit">
                  </div>
                </div>
                <?php
                if (!empty($comments)) {
                ?>
                <div class="row align-items-center mt-4">
                  <div class="col-12 text-left">
                    <ul class="comment-list">
                <?php
                  foreach ($comments as $value) {
                    $name = ucwords($value->first_name . ' ' . $value->last_name);
                ?>
                      <li class="list-item mt-1">
                        <span class="badge badge-pill"><?php echo $name; ?></span> <?php echo $value->review; ?>
                      </li>
                <?php } ?>
                    </ul>
                  </div>
                </div>
                <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="slice slice-lg delimiter-top" id="sct-suggested-products">
      <div class="container">
        <?php
        // print_r($products);
        if(!empty($sugest_product))
        { 
        ?>
        <div class="mb-5 text-center">
          <h3 class="h6">Suggested products<i class="fas fa-angle-down text-xs ml-3"></i></h3>
        </div>
        <div class="row">
          <?php
          foreach($sugest_product as $product)
          {
            if($product->stock_id != $product->stock_id)
            {
              $producturl = base_url().'products/detail/'.$product->stock_id;
          //print_r($product);
          ?>
          <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="card card-product">
              <div class="card-image">
                  <a href="<?php echo $producturl; ?>">
                  <img alt="Image placeholder" src="<?php echo base_url().'assets/upload/products/'.$product->image; ?>" class="img-center img-fluid">
                  </a>
              </div>
              <div class="card-body text-center pt-0">
                  <h6><a href="<?php echo $producturl; ?>"><?php echo $product->name?></a></h6>
                  <p class="text-sm">
                  <?php echo $product->short_description?>
                  </p>
                  <span class="card-price">$<?php echo $product->sale_price?></span>
                  <div class="mt-3">
                      <!---color section -->
                  </div>
              </div>
              <div class="actions card-product-actions" data-animation-in="slideInLeft" data-animation-out="slideOutLeft">
                  <button type="button" class="action-item add-cart-btn-ico" data-toggle="tooltip" data-original-title="Add to cart">
                  <i class="fas fa-shopping-bag"></i>
                  </button>
                  <?php
                  //$wish_ids
                  // $style = (in_array($product->id, $wish_ids))? 'style="color:red"' :'';
                  // $wish = (in_array($product->id, $wish_ids))? 'y' :'';
                  $style = ($product->wish_id != '' )? 'style="color:red"' :'';
                  $wish = ($product->wish_id != '')? 'y' :'';
                  ?>
                  <button type="button" <?php echo $style; ?> class="action-item add_wish" wish_check="<?php echo $wish;?>" user_id="<?php echo $user['id']?>" product_id="<?php echo $product->id?>" data-toggle="tooltip" data-original-title="Wishlist">
                      <i class="fas fa-heart"></i>
                  </button>
              </div>
            </div>
          </div>
          <?php 
            }
          }
          ?>
          <!-- 
          <div class="col-lg-3 col-sm-6"> 
            <div class="card card-product">
              <div class="card-image">
                <a href="javascript:void(0)">
                  <img alt="Image placeholder" src="<?php echo FILEPATH; ?>img/theme/light/product-1.png" class="img-center img-fluid">
                </a>
              </div>
              <div class="card-body text-center pt-0">
                <h6><a href="javascript:void(0)">Home Base</a></h6>
                <p class="text-sm">
                  Customize your home experience with this product.
                </p>
                <span class="card-price">$129 USD</span>
                <div class="product-colors mt-3">
                  <a href="javascript:void(0)" style="background-color: #59ad46;" data-toggle="tooltip" data-original-title="Green"></a>
                  <a href="javascript:void(0)" style="background-color: #04050a;" data-toggle="tooltip" data-original-title="Black"></a>
                  <a href="javascript:void(0)" style="background-color: #62aedd;" data-toggle="tooltip" data-original-title="Blueish"></a>
                  <a href="javascript:void(0)" style="background-color: #e84385;" data-toggle="tooltip" data-original-title="Pink"></a>
                </div>
              </div>
              <div class="actions card-product-actions" data-animation-in="slideInLeft" data-animation-out="slideOutLeft">
                <button type="button" class="action-item" data-toggle="tooltip" data-original-title="Add to cart">
                  <i class="fas fa-shopping-bag"></i>
                </button>
                <button type="button" class="action-item" data-toggle="tooltip" data-original-title="Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="card card-product">
              <div class="card-image">
                <a href="javascript:void(0)">
                  <img alt="Image placeholder" src="<?php echo FILEPATH; ?>img/theme/light/product-2.png" class="img-center img-fluid">
                </a>
              </div>
              <div class="card-body text-center pt-0">
                <h6><a href="javascript:void(0)">Home Controller</a></h6>
                <p class="text-sm">
                  Customize your home experience with this product.
                </p>
                <span class="card-price">$49 USD</span>
                <div class="product-colors mt-3">
                  <a href="javascript:void(0)" style="background-color: #59ad46;" data-toggle="tooltip" data-original-title="Green"></a>
                  <a href="javascript:void(0)" style="background-color: #04050a;" data-toggle="tooltip" data-original-title="Black"></a>
                  <a href="javascript:void(0)" style="background-color: #62aedd;" data-toggle="tooltip" data-original-title="Blueish"></a>
                  <a href="javascript:void(0)" style="background-color: #e84385;" data-toggle="tooltip" data-original-title="Pink"></a>
                </div>
              </div>
              <div class="actions card-product-actions" data-animation-in="slideInLeft" data-animation-out="slideOutLeft">
                <button type="button" class="action-item" data-toggle="tooltip" data-original-title="Add to cart">
                  <i class="fas fa-shopping-bag"></i>
                </button>
                <button type="button" class="action-item" data-toggle="tooltip" data-original-title="Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="card card-product">
              <div class="card-image">
                <a href="javascript:void(0)">
                  <img alt="Image placeholder" src="<?php echo FILEPATH; ?>img/theme/light/product-3.png" class="img-center img-fluid">
                </a>
              </div>
              <div class="card-body text-center pt-0">
                <h6><a href="javascript:void(0)">Adapt Earphones</a></h6>
                <p class="text-sm">
                  Customize your home experience with this product.
                </p>
                <span class="card-price">$65 USD</span>
                <div class="product-colors mt-3">
                  <a href="javascript:void(0)" style="background-color: #59ad46;" data-toggle="tooltip" data-original-title="Green"></a>
                  <a href="javascript:void(0)" style="background-color: #04050a;" data-toggle="tooltip" data-original-title="Black"></a>
                  <a href="javascript:void(0)" style="background-color: #62aedd;" data-toggle="tooltip" data-original-title="Blueish"></a>
                  <a href="javascript:void(0)" style="background-color: #e84385;" data-toggle="tooltip" data-original-title="Pink"></a>
                </div>
              </div>
              <div class="actions card-product-actions" data-animation-in="slideInLeft" data-animation-out="slideOutLeft">
                <button type="button" class="action-item" data-toggle="tooltip" data-original-title="Add to cart">
                  <i class="fas fa-shopping-bag"></i>
                </button>
                <button type="button" class="action-item" data-toggle="tooltip" data-original-title="Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="card card-product">
              <div class="card-image">
                <a href="javascript:void(0)">
                  <img alt="Image placeholder" src="<?php echo FILEPATH; ?>img/theme/light/product-4.png" class="img-center img-fluid">
                </a>
              </div>
              <div class="card-body text-center pt-0">
                <h6><a href="javascript:void(0)">Smart Pixel 3</a></h6>
                <p class="text-sm">
                  Customize your home experience with this product.
                </p>
                <span class="card-price">$299 USD</span>
                <div class="product-colors mt-3">
                  <a href="javascript:void(0)" style="background-color: #59ad46;" data-toggle="tooltip" data-original-title="Green"></a>
                  <a href="javascript:void(0)" style="background-color: #04050a;" data-toggle="tooltip" data-original-title="Black"></a>
                  <a href="javascript:void(0)" style="background-color: #62aedd;" data-toggle="tooltip" data-original-title="Blueish"></a>
                  <a href="javascript:void(0)" style="background-color: #e84385;" data-toggle="tooltip" data-original-title="Pink"></a>
                </div>
              </div>
              <div class="actions card-product-actions" data-animation-in="slideInLeft" data-animation-out="slideOutLeft">
                <button type="button" class="action-item" data-toggle="tooltip" data-original-title="Add to cart">
                  <i class="fas fa-shopping-bag"></i>
                </button>
                <button type="button" class="action-item" data-toggle="tooltip" data-original-title="Wishlist">
                  <i class="fas fa-heart"></i>
                </button>
              </div>
            </div>
          </div> -->
        </div>
        <?php } ?> 
      </div>
    </section>
    <!-- <section class="slice slice-xl bg-cover bg-size--cover" style="background-image: url(<?php echo FILEPATH; ?>img/backgrounds/img-15.jpg); background-position: center center;">
      <span class="mask bg-dark opacity-2"></span>
      <div class="container py-6">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-xl-7 text-center">
            <div class="mb-5">
              <h1 class="text-white">Try a new experience</h1>
              <p class="lead text-white mt-2">You get all Bootstrap components fully customized. Besides, you receive another numerous plugins out of the box and ready to use.</p>
            </div>
            <a href="javascript:void(0)" class="btn btn-white btn-icon rounded-pill shadow hover-shadow-lg hover-translate-y-n3">
              <span class="btn-inner--text">Get started</span>
              <span class="btn-inner--icon"><i class="fas fa-angle-right"></i></span>
            </a>
          </div>
        </div>
      </div>
    </section> -->
    <!-- <section class="slice-sm bg-primary">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="px-4 py-3 text-lg-center">
              <h6 class="text-sm text-white text-uppercase ls-1">Free shipping in 48/72H</h6>
              <p class="text-white opacity-7">
                Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod
              </p>
            </div>
          </div>
          <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="px-4 py-3 text-lg-center">
              <h6 class="text-sm text-white text-uppercase ls-1">Free returns</h6>
              <p class="text-white opacity-7">
                Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod
              </p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="px-4 py-3 text-lg-center">
              <h6 class="text-sm text-white text-uppercase ls-1">Secure payment</h6>
              <ul class="list-inline mt-2">
                <li class="list-inline-item">
                  <img alt="Image placeholder" src="<?php echo FILEPATH; ?>img/icons/cards/visa.png" width="30">
                </li>
                <li class="list-inline-item">
                  <img alt="Image placeholder" src="<?php echo FILEPATH; ?>img/icons/cards/mastercard.png" width="30">
                </li>
                <li class="list-inline-item">
                  <img alt="Image placeholder" src="<?php echo FILEPATH; ?>img/icons/cards/maestro.png" width="30">
                </li>
                <li class="list-inline-item">
                  <img alt="Image placeholder" src="<?php echo FILEPATH; ?>img/icons/cards/paypal.png" width="30">
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section> -->
  </div>