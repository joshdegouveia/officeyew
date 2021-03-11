<section class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3">
            <div class="left-container">
                <?php
                if ($product->filename != '') {
                    $image = UPLOADPATH . 'products/product/thumb/' . $product->filename;
                } else {
                    $image = UPLOADPATH . 'products/no_product.jpg';
                }
                $sellerId = $product->user_id;
                ?>
                <img src="<?php echo $image; ?>" style="width: 100%;">
                <ul>
                    <li><span>Name: <?= $product->name ?></span></li>
                    <li><span>Price: <?= $product->regular_price ?></span></li>
                    <li><span>Seller: <?= $product->first_name . " " . $product->last_name ?></span></li>
                </ul>


            </div>
        </div>

        <div class="col-lg-9 col-xs-12 col-sm-12 col-md-9">
            <div class="main-container web-view">
                <div class="acc_set">
                    <div class="acc_content tabcontent collapse"  id="account">
                        <h4><i class="fa fa-paper-plane"></i> Send purchase request <span id="edit_profile_icon_btn"></span> </h4>

                        <div class="regd col-md-12">
                            <form id="send_purchase_request_form " class="form-horizontal send_purchase_request_form" method="post">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="name" name = "name" value="<?php echo $user['first_name'] . " " . $user['last_name']; ?>" placeholder="Enter Name"/>
                                        </div>

                                        <div class="col-md-6">
                                            <input type="text" value="<?php echo $user['phone']; ?>" id="phone" class="form-control" name="phone" placeholder="Enter Phone"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="text" id="address" class="form-control" value="<?php echo $user['address']; ?>" name="address" placeholder="Enter your address..."/>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea id="message" class="form-control" name="message" placeholder="Enter a message... " rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>                 


                                <div class="submitBtn">
                                    <button type = "button" class = "btn btn-default" id="send_purchase_request_form_btn">Send request</button>
                                    <span><a href="<?php echo base_url('user/profile/purchase-requests') ?>" id="go_purchase_requests" style="background: white; float: right">Go Purchase Requests <i class="fa fa-arrow-right"></i>
                                            <!--<button type = "button" class = "btn btn-default" id="send_purchase_request_form_btn"></button>-->
                                        </a></span>
                                </div>
                            </form>
                        </div>


                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- dashboard end -->


<script>
    $(document).ready(function () {
        $('body').on('click', '#send_purchase_request_form_btn', function () {
            $.ajax({
                url: '<?php echo base_url("products/send_purchase_request/$productId/$product->regular_price/$sellerId"); ?>',
                type: 'post',
                dataType: 'json',
                data: $(".send_purchase_request_form").serialize(),

                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $("#message").val('');
                        $("#go_purchase_requests").show();
                        toaster_msg('success', '<i class="fa fa-check"></i>', 'Purchase request has been successfully submitted.');
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });

    });
</script>
