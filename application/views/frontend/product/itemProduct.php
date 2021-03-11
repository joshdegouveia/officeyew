<?php
$p_image = UPLOADPATH.'products/'.$product->image;
$regular_price = ($product->seller_regular_price == 0) ? $product->regular_price : $product->seller_regular_price;
$sale_price = ($product->seller_sale_price == 0) ? $product->sale_price : $product->seller_sale_price;
?>
<div class="main-content product-item-page" data-pid="pid-<?php echo $product->id; ?>">
  <section class="slice slice-lg delimiter-bottom bg-primary" id="sct-products">
    <!--for menue backgroung color -->
  </section>
  <section class="py-2 delimiter-bottom">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h6 class="mb-0"><?php echo $product->name; ?></h6>
        </div>
        <div class="col-md-6">
          <!-- <nav class="nav justify-content-md-end mb-0">
            <a href="#" class="nav-link text-sm pl-0">Overview</a>
            <a href="#" class="nav-link text-sm">Tech specs</a>
            <a href="#" class="nav-link text-sm pr-0">Setup &amp; Tips</a>
          </nav> -->
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
              <a href="<?php echo $p_image ?>" data-fancybox>View gallery</a>
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
                    <span class="badge badge-pill badge-soft-success"><?php echo $stock = ($product->stock)?'In stock': 'Not in stock'; ?></span>
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
            <div class=" py-4 my-4 border-top border-bottom">
              <div class="row align-items-center">
                <div class="col-sm-6 mb-4 mb-sm-0">
                  <span class="d-block h3 mb-0"><?php echo '$'.$sale_price; ?></span>
                  <?php
                  if($regular_price != $sale_price)
                  {
                  ?>
                  <span style = "text-decoration:line-through;" class=""><?php echo '$'.$regular_price?></span>
                  <!-- <a href="#" class="text-sm">Choose a financing option</a> -->
                  <?php } ?>
                </div>
                <div class="col-sm-6 text-sm-right">
                  <!-- Add to cart -->
                  <button type="button" class="btn btn-primary btn-icon">
                  <span class="btn-inner--icon"><i class="fas fa-shopping-bag"></i></span>
                  <!-- <span class="btn-inner--text">Add to bag</span> -->
                  </button>
                </div>
              </div>
            </div>
            <div class="row align-items-center">
              <div class="col-6 text-left">
                <ul class="list-inline mb-0">
                  <li class="list-inline-item">
                    <span class="badge badge-pill badge-soft-info">Please give your review</span>
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
          </div>
        </div>
      </div>
    </div>
  </section>
</div>