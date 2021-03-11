<div class="main-content product-list-all">   
   <!-- Products -->
    <section class="slice slice-lg delimiter-bottom bg-primary" id="sct-products">
      <!--for menue backgroung color -->
     
    </section>
    <section class="slice slice-lg delimiter-bottom" id="sct-products">
      <div class="container">
        <div class="row">
          <?php
          if(!empty($products))
          { 
            foreach($products as $product)
            {
              //print_r($product);
              $link = base_url('products/item/' . urlencode(base64_encode($product->id)));
          ?>
          <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="card card-product">
              <div class="card-image">
                <a href="<?php echo $link; ?>">
                  <img alt="Image placeholder" src="<?php echo base_url().'assets/upload/products/'.$product->image; ?>" class="img-center img-fluid">
                </a>
              </div>
              <div class="card-body text-center pt-0">
                <h6><a href="<?php echo $link; ?>"><?php echo $product->name?></a></h6>
                <p class="text-sm">
                <?php echo $product->short_description?>
                </p>
                <span class="card-price">$<?php echo $product->sale_price?></span>
                <div class="mt-3">
                  <?php
                  if($product->sp_pid == $product->id)
                  {
                    $b2bid = '';
                    $sellerid = '';
                    $product_id = '';
                    $a_text = "Product added to stock";
                  }
                  else{
                    $b2bid = $product->user_id;
                    $sellerid = $user['id'];
                    $product_id = $product->id;
                    $a_text = "Add to My stock";
                  }
                  ?>
                  <a href="javascript:void(0)" class="my_stock" b2bid="<?php echo $b2bid; ?>" sellerid="<?php echo $sellerid; ?>" product_id="<?php echo $product_id; ?>"><?php echo $a_text; ?></a>
                </div>
              </div>
              <div class="actions card-product-actions" data-animation-in="slideInLeft" data-animation-out="slideOutLeft">
                <!-- <button type="button" class="action-item" data-toggle="tooltip" data-original-title="Add to cart">
                  <i class="fas fa-shopping-bag"></i>
                </button> -->
                <?php
                //$wish_ids
                  // $style = (in_array($product->id, $wish_ids))? 'style="color:red"' :'';
                  // $wish = (in_array($product->id, $wish_ids))? 'y' :'';
                  $style = ($product->pw_pid == $product->id)? 'style="color:red"' :'';
                  $wish = ($product->pw_pid == $product->id)? 'y' :'';
                ?>
                <button type="button" <?php echo $style; ?> class="action-item add_wish" wish_check="<?php echo $wish;?>" user_id="<?php echo $user['id']?>" product_id="<?php echo $product->id?>" data-toggle="tooltip" data-original-title="Wishlist">
                  <i class="fas fa-heart"></i>
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
