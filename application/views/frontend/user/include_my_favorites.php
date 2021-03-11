<div class="orders-container">


    <div class="content_right">

        <div class="product_area">
            <div class="product_list">
                <?php
                if (count($la_myFavorites) == 0) {
                    echo "No product available!";
                }

                $noProductImg = UPLOADPATH . 'products/no_product.png';
                foreach ($la_myFavorites as $lo_product) {
                    $image = UPLOADDIR . 'products/product/thumb/' . $lo_product->filename;
                    if (!file_exists($image) || ($lo_product->filename == '')) {
                        $image = $noProductImg;
                    } else {
                        $image = UPLOADPATH . 'products/product/thumb/' . $lo_product->filename;
                    }

                    $proUrl = base_url("products/details/$lo_product->product_id/" . name_to_url($lo_product->product_name));
                    ?>
                    <div class="item" id="productTr_<?php echo $lo_product->product_id; ?>">
                        <div class="edit_opt">
                            <img src="../assets/frontend/images/closeicon2.png" alt="" class="delete_product_my_favorites" id="product_<?php echo $lo_product->product_id; ?>"/>
                        </div>
                        <div class="ofc-item-box">
                            <img src="<?= $image; ?>" alt="product" />
                        </div>
                        <h4>                     
                            <a href="<?php echo $proUrl ?>" target="_blank">
                                <?php echo $lo_product->product_name; ?> 
                            </a>
                        </h4>

                    </div>
                <?php }
                ?>
            </div>
        </div>

    </div>


    <?php
//    echo $li_myFavorites_count ;
//    echo ITEM_MY_FAVORITES ;
    ?>

    <?php
    if ($li_myFavorites_count > ITEM_MY_FAVORITES) {
        $totalPage = (($li_myFavorites_count % ITEM_MY_FAVORITES) == 0) ? intval($li_myFavorites_count / ITEM_MY_FAVORITES) : (intval($li_myFavorites_count / ITEM_MY_FAVORITES) + 1);
        $url = base_url("products/list//" . "?pg=");
        ?>
        <div class="pager_content">
            <ul class="pagination justify-content-center">
                <?php
                if ($currentPage > 1) {
                    ?>
                    <li class="page-item prev">
                        <a class="page-link" id="<?= ($currentPage - 1) ?>_myFavorites_pre" >
                            <img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
                        </a>
                    </li>
                    <?php
                }

                for ($i = 1; $i <= $totalPage; $i++) {
                    $activetab = ($currentPage == $i) ? "activetab" : "";
                    ?>
                    <li class="page-item <?= $activetab ?>"><a class="page-link" id="<?= $i ?>_myFavorites" ><?= $i; ?></a></li>
                    <?php
                }

                if ($currentPage < $totalPage) {
                    ?>
                    <li class="page-item next">
                        <a class="page-link" id="<?= $currentPage + 1 ?>_myFavorites_next">
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

