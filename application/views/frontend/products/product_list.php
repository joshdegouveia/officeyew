<!-- Office Furniture Categories start-->
<section class="ofc-hold-wrap">
    <div class="container">
        <!--        <div class="cmn-header mrtb-15">
                    <h2>Search Result</h2>
                </div>-->
        <div class="product_area">
            <div class="product_list">
                <?php
                if (count($la_productList) == 0) {
                    ?>
                <p class="no_data_found">No product available!</p>
                <?php
                } else {
                    $no_product = UPLOADPATH . 'products/no_product.png';
                    foreach ($la_productList as $k => $la_product) {
                        if (($la_product->filename != '') && (file_exists(UPLOADDIR . 'products/product/thumb/' . $la_product->filename))) {
                            $image = UPLOADPATH . 'products/product/thumb/' . $la_product->filename;
                        } else {
                            $image = $no_product;
                        }

                        if ($catId != '' && ($catName != '')) {
                            $proUrl = "products/detail/$la_product->id/" . name_to_url($la_product->name) . "/$catId/" . name_to_url($catName);
                        } else {
                            $proUrl = "products/details/$la_product->id/" . name_to_url($la_product->name);
                        }
                        ?>

                        <div class="item">
                            <a href="<?php echo base_url($proUrl); ?>" target="_blank">
                                <div class="ofc-item-box">
                                    <img src="<?php echo $image; ?>" alt="<?= $la_product->name ?>" />
                                </div>
                                <h4><?= $la_product->name ?></h4>
                            </a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <?php
        if ($li_item > ITEM_PRODACT_LG) {
            $totalPage = (($li_item % ITEM_PRODACT_LG) == 0) ? intval($li_item / ITEM_PRODACT_LG) : (intval($li_item / ITEM_PRODACT_LG) + 1);
            if ($catId != '') {
                $url = base_url("products/list/$catId/" . name_to_url($catName) . "?pg=");
            } else {
                $url = base_url("products/list-all?pg=");
            }

            if (isset($search_url) && ($search_url != '')) {
                $url = "$search_url&pg="; // this url use for search by location and category
            }
            ?>
            <div class="pager_content">
                <ul class="pagination justify-content-center">
                    <?php
                    if ($currentPage > 1) {
                        ?>
                        <li class="page-item prev">
                            <a class="page-link" href="<?php echo $url . ($currentPage - 1) ?>">
                                <img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
                            </a>
                        </li>
                        <?php
                    }

                    for ($i = 1; $i <= $totalPage; $i++) {
                        if ($currentPage == $i) {
                            ?>
                            <li class="page-item activetab"><a class="page-link" href="#"><?= $i; ?></a></li>
                            <?php
                        } else {
                            ?>
                            <li class="page-item"><a class="page-link" href="<?php echo $url . $i ?>"><?= $i; ?></a></li>
                            <?php
                        }
                    }

                    if ($currentPage < $totalPage) {
                        ?>
                        <li class="page-item next">
                            <a class="page-link" href="<?php echo $url . ($currentPage + 1) ?>">
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
</section>

<?php $this->load->view('frontend/products/include_script/include_search_product_script.php'); ?> 
