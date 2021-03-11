<div class="main-content">   
   <!-- Products -->
    <section class="slice slice-lg delimiter-bottom bg-primary" id="sct-products">
      <!--for menue backgroung color -->
     
    </section>
    <section class="slice slice-lg delimiter-bottom" id="sct-products">
      <div class="container">
        <div class="row">
          <?php
          if(!empty($products)) { 
            foreach($products as $product) {
              $image = FILEPATH . 'img/default/no-image.png';
              if (!empty($product->image) && file_exists(UPLOADDIR . 'products/' . $product->image)) {
                $image = UPLOADPATH . 'products/' . $product->image;
              }

              $link = base_url('products/detail/' . urlencode(base64_encode($product->id)));
          ?>
          <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="card card-product">
              <div class="card-image">
                <a href="<?php echo $link; ?>">
                  <img alt="Image placeholder" src="<?php echo $image; ?>" class="img-center img-fluid">
                </a>
              </div>
              <div class="card-body text-center pt-0">
                <h6><a href="<?php echo $link; ?>"><?php echo $product->name?></a></h6>
                <p class="text-sm">
                <?php echo $product->short_description?>
                </p>
                <span class="card-price">$<?php echo $product->sale_price?></span>
              </div>
              <div class="actions card-product-actions" data-animation-in="slideInLeft" data-animation-out="slideOutLeft">
                <button type="button" class="action-item" data-toggle="tooltip" data-original-title="Add to cart">
                  <i class="fas fa-shopping-bag"></i>
                </button>
              </div>
            </div>
          </div>
          <?php 
            }
          ?>
        </div>
        <!-- Load more -->
        <!-- <div class="mt-4 text-center">
          <a href="" class="btn btn-sm btn-white rounded-pill shadow hover-translate-y-n3">See all products</a>
        </div> -->
          <?php }else{
            echo '<strong style="color:red">No product found</strong>';
          } ?>
      </div>
    </section>
</div>  
<script>

</script>
