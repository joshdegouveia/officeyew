<!-- Office Furniture Categories start-->
<section class="ofc-hold-wrap">
    <div class="container">
        <div class="cmn-header mrtb-15">
            <h2>Office Furniture Categories</h2>
        </div>
        <div class="product_area">
            <div class="product_list">
                <?php
                if (count($categories) == 0) {
                    echo "No category available";
                }

                foreach ($categories as $cat) {
                    ?>
                    <?php
                    $cat_img_src = UPLOADPATH . 'products/product_categories/thumb/' . $cat->filename;
                    ?>
                    <div class="item">
                        <a href="<?php echo base_url("products/list/$cat->id/" . name_to_url($cat->name)) ?>">
                            <div class="ofc-item-box">
                                <img src="<?php echo $cat_img_src; ?>" alt="<?php echo $cat->name; ?>" />
                            </div>
                            <h4><?php echo $cat->name; ?></h4>
                        </a>
                    </div>

<?php } ?>

            </div>
        </div>

        <?php
        if ($li_item > ITEM_PRODACT_CAT) {
            $totalPage = (($li_item % ITEM_PRODACT_CAT) == 0) ? intval($li_item / ITEM_PRODACT_CAT) : (intval($li_item / ITEM_PRODACT_CAT) + 1);
            ?>
            <div class="pager_content">
                <ul class="pagination justify-content-center">
                    <?php
                    if ($currentPage > 1) {
                        ?>
                        <li class="page-item prev">
                            <a class="page-link" href="<?php echo base_url("products/categories?pg=" . ($currentPage - 1)) ?>">
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
                            <li class="page-item"><a class="page-link" href="<?php echo base_url("products/categories?pg=" . $i) ?>"><?= $i; ?></a></li>
                            <?php
                        }
                    }

                    if ($currentPage < $totalPage) {
                        ?>
                        <li class="page-item next">
                            <a class="page-link" href="<?php echo base_url("products/categories?pg=" . ($currentPage + 1)) ?>">
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
