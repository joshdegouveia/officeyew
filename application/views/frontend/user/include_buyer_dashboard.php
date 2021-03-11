<div class="orders-container include_my_product_inner">
    <i class="fa fa-spinner fa-spin fa-3x" style="display: none;"></i>

    <div class="content_right">

        <div class="product_area">
            <div class="product_list">
                <?php
                if (count($la_searchProduct) == 0) {
                    echo "<p class='no_record'>No product found!</p>";
                }
                $noProductImg = UPLOADPATH . 'products/no_product.png';
                foreach ($la_searchProduct as $lo_product) {
                    $image = UPLOADDIR . 'products/product/thumb/' . $lo_product->filename;
                    if (!file_exists($image) || ($lo_product->filename == '')) {
                        $image = $noProductImg;
                    } else {
                        $image = UPLOADPATH . 'products/product/thumb/' . $lo_product->filename;
                    }
                    ?>

                    <div class="item">
                        <a class="display_block" href="<?php echo base_url("products/details/$lo_product->id/" . name_to_url($lo_product->name)); ?>" target="_blank"> 
                            <div class="ofc-item-box">
                                <img src="<?php echo $image ?>" alt="<?php echo $lo_product->name ?>" />
                            </div>
                            <h4>
                                <?php echo $lo_product->name ?>

                            </h4>
                        </a>
                    </div>

                <?php }
                ?>


            </div>
        </div>

    </div>
    <!--  -->



    <?php
    if ($li_searchProduct_count > ITEM_PRODACT) {
        $totalPage = (($li_searchProduct_count % ITEM_PRODACT) == 0) ? intval($li_searchProduct_count / ITEM_PRODACT) : (intval($li_searchProduct_count / ITEM_PRODACT) + 1);
        $url = base_url("products/list//" . "?pg=");
        ?>
        <div class="pager_content">
            <ul class="pagination justify-content-center">
                <?php
                if ($currentPage > 1) {
                    ?>
                    <li class="page-item prev">
                        <a class="page-link" id="<?= ($currentPage - 1) ?>_myDashboardSearchProduct_pre" >
                            <img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
                        </a>
                    </li>
                    <?php
                }

                for ($i = 1; $i <= $totalPage; $i++) {
                    $activetab = ($currentPage == $i) ? "activetab" : "";
                    ?>
                    <li class="page-item <?= $activetab ?>"><a class="page-link" id="<?= $i ?>_myDashboardSearchProduct" ><?= $i; ?></a></li>
                    <?php
                }

                if ($currentPage < $totalPage) {
                    ?>
                    <li class="page-item next">
                        <a class="page-link" id="<?= $currentPage + 1 ?>_myDashboardSearchProduct_next">
                            <img src="<?= UPLOADPATH . "../frontend/images/next.png" ?>" alt="Next" />
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php
    }
    ?>
</div>

