<!-- Banner start -->
<section class="banner-hold-wrapper bg2">
    <section class="seahching-hold-wrap prod_search padd-tb60">
        <div class="container">
            <form class="form-inline"  action="<?php echo base_url("products/search"); ?>" method="get">
                <div class="form-group sm-width-100">
                    <label class="search-label">Searching for:</label>
                </div>
                <div class="form-group col-4 sm-width-45">
<!--                    <select class="form-control selectpicker" data-style="btn-primary">
                        <option selected>Select</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>-->
                    <select class="form-control select2 select_categories_dropdown" name="category">
                        <option value="">Select Category</option>
                        <?php if (count($categories) > 0) { ?>
                            <?php foreach ($categories as $cat) { ?>
                                <option value="<?php echo $cat->id; ?>" <?= ($catId == $cat->id) ? "selected" : "" ?>><?php echo $cat->name; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="at-label">at</label>
                </div>
                <div class="form-group col-4 sm-width-45">

                    <div class="form-group">
                        <input type="text" class="form-control location_autocomplete_search_input" name="location" value="<?= $ls_location ?>" placeholder="Search city name"   autocomplete="off">
                        <input type="hidden" class=" location_autocomplete_id" name="location_id" value="<?= $location_id ?>">
                    </div>
                    <div class="form-group clearfix">
                        <div class="location_autocomplete_list" style="background: white; z-index: 999;"></div>
                    </div> 

<!--                    <select class="form-control select2 select_location_dropdown" name="location">
        <option value="">Select location</option>
                    <?php if (count($locations) > 0) { ?>
                        <?php
                        foreach ($locations as $location) {
                            if ($location->city == '')
                                continue;
                            ?>
                                                <option value="<?php echo $location->city; ?>" <?= ($ls_location == $location->city) ? "selected" : "" ?>><?php echo $location->city; ?></option>
                        <?php } ?>
                    <?php } ?>
    </select>-->
                </div>
                <div class="form-group sm-width-100">
                    <button type="submit" class="btn btn-search">Search</button>
                </div>
            </form>
        </div>
    </section>
</section>
<!-- Banner End -->
<!-- Office Furniture Categories start-->
<section class="ofc-hold-wrap">
    <div class="container">
        <div class="cmn-header mrtb-15">
            <h2>Search Result</h2>
        </div>
        <div class="product_area">
            <div class="product_list">
                <?php
                if (count($la_productList) == 0) {
                    echo "No product available!";
                } else {
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
//            echo $currentPage;
//            echo $search_url;
            $url = "$search_url&pg=";
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

<script>
    $(document).ready(function () {

        $('body').on('keyup', '.location_autocomplete_search_input', function (e) {
            var searchVal = $(".location_autocomplete_search_input").val();
            e.preventDefault(); // Ensure it is only this code that rusn

            $.ajax({
                url: '<?php echo base_url("user/location_autocomplete_search"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'searchVal': searchVal},
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find(".location_autocomplete_list").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });


        });

        $('body').on('click', '.auto_location_city_name', function (e) { // == Auto complete search ====
            var thisName = $(this).html();
            var locName = thisName.replace('<b>', '');
            locName = locName.replace('</b>', '', );
            $(".location_autocomplete_id").val($(this).attr('id'));
            $(".location_autocomplete_search_input").val(locName);
            $('body').find(".location_autocomplete_list").html('');
            console.log(locName);
        });



    });
</script>
