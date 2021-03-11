<!-- Office Furniture Categories start-->
<?php // print_r($categories);?>
<?php if (count($la_productList) > 0) {
    ?>
    <section class="ofc-hold-wrap">
        <div class="container">
            <div class="cmn-header mrtb-15 homePrdt">
                <h2>Product Deals </h2>
                <h4>Near You</h4>
                <!--<h2>Our Latest</h2>-->
                <!--<h4>Products</h4>-->
            </div>

            <div class="product_area">
                <div class="product_list">
                    <?php
                    $noImage = UPLOADPATH . 'products/no_product.png';
                    foreach ($la_productList as $k => $la_product) {
                        if ($la_product->filename != '' && (file_exists(UPLOADDIR . 'products/product/thumb/' . $la_product->filename))) {
                            $image = UPLOADPATH . 'products/product/thumb/' . $la_product->filename;
                        } else {
                            $image = $noImage;
                        }

                        $proUrl = "products/details/$la_product->id/" . name_to_url($la_product->name);
                        ?>

                        <div class="item">
                            <a href="<?php echo base_url($proUrl); ?>">
                                <div class="ofc-item-box">
                                    <img src="<?php echo $image; ?>" alt="<?= $la_product->name ?>" />
                                </div>
                                <h4>
                                    <?php
                                    echo $la_product->name;

                                    if ($la_product->is_boost == 1) {
                                        ?>
                                        <input type="hidden" value="boost">
                                    <?php }
                                    ?>

                                </h4>
                            </a>
                        </div>
                        <?php
                    }
                    ?>


                </div>
            </div>

        </div>
    </section>
<?php } ?>
<!-- Office Furniture Categories end-->
<section class="container text-center twoBnr">
    <img src="<?php echo base_url(); ?>assets/frontend/images/google-ad.png" alt="">
    <img src="<?php echo base_url(); ?>assets/frontend/images/google-ad.png" alt="">
</section>
<div class="spaCer"></div>
