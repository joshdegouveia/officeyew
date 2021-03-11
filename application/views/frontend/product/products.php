<div class="main-content">   
    <!-- Products -->
    <section style="padding-bottom: 0px;" class="slice slice-lg delimiter-bottom bg-primary" id="sct-products">
      <!--for menue backgroung color -->
        <div class="spotlight-holder pt-9 pb-6 py-lg-0">
            <div class="container d-flex align-items-center px-0">
                <div class="col">
                    <div class="row row-grid align-item-center">
                        <div class="col-lg-12">
                            <div class="py-5">
                                <h1 class="text-white mb-4"><?php echo $title; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="slice slice-lg delimiter-bottom" id="sct-products">
      <div class="container">
        <div class="row">
        <?php
        // print_r($products);
        if(!empty($products))
        { 
            foreach($products as $product)
            {
                $producturl = base_url().'products/detail/'.urlencode(base64_encode($product->stock_id));
                $img = FILEPATH . 'img/default/no-image.png';
                if (!empty($product->image) && file_exists(UPLOADDIR . 'products/'. $product->image)) {
                    $img = UPLOADPATH . 'products/' . $product->image;
                }
            //print_r($product);
        ?>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card card-product">
                    <div class="card-image">
                        <a href="<?php echo $producturl; ?>">
                        <img alt="Image placeholder" src="<?php echo $img; ?>" class="img-center img-fluid">
                        </a>
                    </div>
                    <div class="card-body text-center pt-0">
                        <h6><a href="<?php echo $producturl; ?>"><?php echo $product->name?></a></h6>
                        <p class="text-sm">
                        <?php echo $product->short_description?>
                        </p>
                        <span class="card-price">$<?php echo $product->seller_sale_price?></span>
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
                        $style = $wish = '';
                        if(!empty($user)){
                            $style = ($product->wish_id != '' )? 'style="color:red"' :'';
                            $wish = ($product->wish_id != '')? 'y' :'';
                        }
                        else{
                            $wish = 'l';
                        }
                        ?>
                        <button type="button" <?php echo $style; ?> class="action-item add_wish" wish_check="<?php echo $wish;?>" user_id="<?php if(!empty($user)) echo $user['id']?>" product_id="<?php echo $product->id?>" data-toggle="tooltip" data-original-title="Wishlist">
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
        <?php 
        }else{
            echo '<strong style="color:red">No product found</strong>';
        } ?>
      </div>
    </section>
</div>