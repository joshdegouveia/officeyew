<!-- Banner start -->
<section class="banner-hold-wrapper bg2">
    <section class="seahching-hold-wrap prod_search padd-tb60 details_bg">
        <div class="container">

        </div>
    </section>
</section>
<!-- Banner End -->
<?php
$noProductImg = UPLOADPATH . 'products/no_product.png';
?>
<?php
//$image = UPLOADDIR . '/products/product/thumb/' . $product->filename;
//if (!file_exists($image)) {
//    $image = $noProductImg;
//}
//echo $image
?>
<!-- Office Furniture Categories start-->
<section class="product_details_info">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="product_details_area">
                    <div class="product_cont_left">
                        <div class="bradcam_details">
                            <?php if ($catId != '' && $catName != '') {
                                ?>
                                <span><a href="<?php echo base_url("products/categories") ?>"> Office Furniture</a></span>
                                <span class="activePage"><a href="<?php echo base_url("products/list/$catId/" . name_to_url($catName)) ?>"> <?php echo url_to_name($catName); ?></a></span>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="product_lft_cont">
                            <?php
                            $image = UPLOADDIR . 'products/product/' . $product->filename;
                            $imageThumb = UPLOADDIR . 'products/product/thumb/' . $product->filename;
                            if (!file_exists($image) || ($product->filename == '')) {
                                $image = $noProductImg;
                                $imageThumb = $noProductImg;
                            } else {
                                $image = UPLOADPATH . 'products/product/' . $product->filename;
                                $imageThumb = UPLOADPATH . 'products/product/thumb/' . $product->filename;
                            }
                            ?>

                            <div class="prod_slider">
                                <div id="sync1" class="owl-carousel owl-theme">
                                    <div class="item">
                                        <img src="<?php echo $image; ?>" alt="<?= $product->name ?>" />
                                    </div>
                                    <?php
                                    foreach ($la_proMoreImg as $la_proImg) {
                                        $moreImage = UPLOADDIR . 'products/product/' . $la_proImg->image;
                                        if (!file_exists($moreImage) || ($la_proImg->image == '')) {
                                            $moreImage = $noProductImg;
                                        } else {
                                            $moreImage = UPLOADPATH . 'products/product/' . $la_proImg->image;
                                        }
                                        ?>

                                        <div class="item">
                                            <img src="<?= $moreImage ?>" alt="<?= $la_proImg->caption ?>" title="<?= $la_proImg->caption ?>"/>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>

                                <div id="sync2" class="owl-carousel owl-theme">
                                    <div class="item">
                                        <img src="<?php echo $imageThumb; ?>" alt="<?= $product->name ?>" />
                                    </div>
                                    <?php
                                    foreach ($la_proMoreImg as $la_proImg) {
                                        $moreImage = UPLOADDIR . 'products/product/thumb/' . $la_proImg->image;
                                        if (!file_exists($moreImage) || ($la_proImg->image == '')) {
                                            $moreImage = $noProductImg;
                                        } else {
                                            $moreImage = UPLOADPATH . 'products/product/thumb/' . $la_proImg->image;
                                        }
                                        ?>

                                        <div class="item">
                                            <img src="<?= $moreImage ?>" alt="<?= $la_proImg->caption ?>" title="<?= $la_proImg->caption ?>"/>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="product_des">
                                <h3><?php echo $product->name; ?></h3>
                                <h4>Price: <span><?php echo CURRENCY . $product->regular_price; ?></span></h4>
<!--                                <div class="prodect_des_info">
                                    <h5>Overview:</h5>
                                    <p><?php echo $product->short_description; ?></p>
                                </div>-->
                                <div class="prodect_des_info">
                                    <h5>Description:</h5>
                                    <p><?php echo $product->long_description; ?></p>
                                </div>
                                <div class="prodect_des_info">
                                    <ul>
                                        <li>Seller Name: <span><?php echo $product->first_name . " " . $product->last_name ?></span></li>
                                        <li>Category: <span><?php echo str_replace(',', ', ', $product->category) ?></span></li>
                                        <li>Manufacture Name: <span><?php echo $product->original_manufacture_name ?></span></li>
                                        <li>Originally Manufacture Year: <span><?php echo $product->year_manufactured ?></span></li>
                                        <li>Warranty: <span><?php echo $product->warranty ?></span></li>
                                        <li>Product Condition: <span><?php echo $product->products_condition ?></span></li>
                                        <li>Notable Defects: <span><?php echo $product->notable_defects ?></span></li>
                                    </ul>
                                </div>
                                <div class="prodect_des_info noborder">
                                    <h5>Seller Review</h5>
                                    <div class="seller_Review">
                                        <?php
                                        if (count($la_sellerReview) == 0) {
                                            echo "No review!";
                                        }
                                        $path = BASE_URL . 'assets/upload/user/profile/no_img.png';
                                        foreach ($la_sellerReview as $row) {
                                            if ($row->filename != '') {
                                                $path = BASE_URL . 'assets/upload/user/profile/' . $row->filename;
                                            }
                                            ?>
                                            <div class="seller_inp_row">
                                                <div class="seller_pic">
                                                    <img src="<?= $path ?>" alt="<?php echo $row->first_name . " " . $row->last_name ?>" />
                                                </div>
                                                <div class="seller_des">
                                                    <h6>
                                                        <?php echo $row->first_name . " " . $row->last_name ?>
                                                        <span class="btn btn-<?php echo get_rating_btn_color($row->rating) ?> btn-sm"><?php echo number_format($row->rating) ?> <i class="fa fa-star"></i></span>
                                                    </h6>
                                                    <p><?php echo $row->review ?></p>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="product_cont_right">
                        <div class="purchase_request">
                            <?php
                            if (isset($my_favorites->my_favorites_id)) {
                                ?>
                                <a href="javascript::void(0)" id="favorite_button_product_details" class="def_btn3 active_favorite_btn"><i class="fa fa-heart"></i> Favorite</a>
                            <?php } else {
                                ?>
                                <a href="javascript::void(0)" id="favorite_button_product_details" class="def_btn3"><i class="fa fa-heart-o"></i> Favorite</a>    
                                <?php
                            }
                            ?>
                            <a href="javascript::void(0)" class="sell-btn purchase_request_on_product_details">Purchase Request</a>
                        </div>

                        <div class="inp_form_details">
                            <?php
                            if ((isset($user['id']) && ($user['id'] != '')) && (in_array('buyer', $user['user_types']))) {
                                ?>

                                <?php $this->load->view('frontend/products/include_product_purchase.php'); ?>

                                <?php
                            }
                            ?>

                        </div>


                        <div class="inp_form_details">
                            <?php
                            if (empty($user['id']) || (!in_array('buyer', $user['user_types']))) {
                                ?>
                                <div class="form-group">
                                    <div class="submitBtn"><button type="submit" class="btn btn-default message_to_seller_form_btn" title="Please login as a buyer">Message Seller</button></div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <form id=" " class="form-horizontal message_to_seller_form" method="post">
                                    <div class="form-details">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="subject" placeholder="Full Name*" />
                                        </div>

                                        <div class="form-group">
                                            <textarea class="form-control" name="message" placeholder="Message*"></textarea>

                                        </div>

                                        <div class="form-group">
                                            <div class="submitBtn"><button type="button" class="btn btn-default message_to_seller_form_btn">Message Seller</button></div>
                                        </div>
                                    </div>
                                </form>

                                <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>



<!--<div class="submitBtn" ><a href="<?php // echo base_url("products/product-purchase/$productId/" . name_to_url($productName))                      ?>"><button type="button" id="" class = "btn btn-default">Send purchase request</button></a></div>-->



<script>
    $(document).ready(function () {
        $('body').on('click', '#favorite_button_product_details', function () {
            $.ajax({
                url: '<?php echo base_url("products/add_favorite/$productId"); ?>',
                type: 'post',
                dataType: 'json',
                data: '',

                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $("#favorite_button_product_details").html(response.text);
                        if (response.flag == 'add') {
                            $("#favorite_button_product_details").addClass('active_favorite_btn');
                        } else {
                            $("#favorite_button_product_details").removeClass('active_favorite_btn');
                        }
                        toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });


        $('body').on('click', '.purchase_request_on_product_details', function () {
            $.ajax({
                url: '<?php echo base_url("products/purchase_request_on_product_details"); ?>',
                type: 'post',
                dataType: 'json',
                data: '',

                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $(".message_to_seller_form").slideToggle();
                        $("#send_purchase_request_form_content").slideToggle();
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i> ', response.msg);
                    }

                }
            });
        });


        $('body').on('click', '.message_to_seller_form_btn', function () {
            $.ajax({
                url: '<?php echo base_url("products/message_to_seller/$productId/$sellerId"); ?>',
                type: 'post',
                dataType: 'json',
                data: $(".message_to_seller_form").serialize(),

                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $(".message_to_seller_form input, .message_to_seller_form textarea").val('');
//                        
                        toaster_msg('success', '<i class="fa fa-check"></i> ', response.msg);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });
    });
</script>



<script>
    $(document).ready(function () {
        var sync1 = $("#sync1");
        var sync2 = $("#sync2");
        var slidesPerPage = 4; //globaly define number of elements per page
        var syncedSecondary = true;

        sync1.owlCarousel({
            items: 1,
            slideSpeed: 2000,
            nav: true,
            autoplay: false,
            dots: true,
            loop: true,
            responsiveRefreshRate: 200,
            navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>', '<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
        }).on('changed.owl.carousel', syncPosition);

        sync2
                .on('initialized.owl.carousel', function () {
                    sync2.find(".owl-item").eq(0).addClass("current");
                })
                .owlCarousel({
                    items: slidesPerPage,
                    dots: true,
                    nav: true,
                    smartSpeed: 200,
                    slideSpeed: 500,
                    slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
                    responsiveRefreshRate: 100
                }).on('changed.owl.carousel', syncPosition2);

        function syncPosition(el) {
            //if you set loop to false, you have to restore this next line
            //var current = el.item.index;

            //if you disable loop you have to comment this block
            var count = el.item.count - 1;
            var current = Math.round(el.item.index - (el.item.count / 2) - .5);

            if (current < 0) {
                current = count;
            }
            if (current > count) {
                current = 0;
            }

            //end block

            sync2
                    .find(".owl-item")
                    .removeClass("current")
                    .eq(current)
                    .addClass("current");
            var onscreen = sync2.find('.owl-item.active').length - 1;
            var start = sync2.find('.owl-item.active').first().index();
            var end = sync2.find('.owl-item.active').last().index();

            if (current > end) {
                sync2.data('owl.carousel').to(current, 100, true);
            }
            if (current < start) {
                sync2.data('owl.carousel').to(current - onscreen, 100, true);
            }
        }

        function syncPosition2(el) {
            if (syncedSecondary) {
                var number = el.item.index;
                sync1.data('owl.carousel').to(number, 100, true);
            }
        }

        sync2.on("click", ".owl-item", function (e) {
            e.preventDefault();
            var number = $(this).index();
            sync1.data('owl.carousel').to(number, 300, true);
        });


    });
</script>
