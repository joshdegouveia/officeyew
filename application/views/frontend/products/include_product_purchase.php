<div class="main-container web-view" id="send_purchase_request_form_content" style="display: none">
    <div class="acc_content tabcontent collapse"  id="account">
        <h3><i class="fa fa-paper-plane"></i> Send purchase request <span id="edit_profile_icon_btn"></span> </h3>

        <div class="regd col-md-12">
            <form id="send_purchase_request_form " class="form-horizontal send_purchase_request_form" method="post">

                <div class="form-group row">
                    <input type="text" class="form-control" id="name" name = "name" value="<?php echo $user['first_name'] . " " . $user['last_name']; ?>" placeholder="Enter Name*"/>
                </div>


                <div class="form-group row">
                    <input type="text" value="<?php echo $user['phone']; ?>" id="phone" class="form-control" name="phone" placeholder="Enter Phone*"/>
                </div>

                <div class="form-group row">
                    <input type="text" id="address" class="form-control" value="<?php echo $user['address']; ?>" name="address" placeholder="Enter your address...*"/>
                </div>


                <div class="form-group row">
                    <textarea id="message" class="form-control" name="message" placeholder="Enter a message...* " rows="5"></textarea>
                </div>


                <div class="submitBtn">
                    <button type = "button" class = "btn btn-default" id="send_purchase_request_form_btn">Send request</button>
                    <!--<span><a href="<?php // echo base_url('user/profile/purchase-requests')     ?>" id="go_purchase_requests" style="background: white; float: right">Go Purchase Requests <i class="fa fa-arrow-right"></i>-->
                    <!--</a></span>-->
                </div>
            </form>
        </div>


        <div class="clearfix"></div>
    </div>
</div>

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
//                        $("#go_purchase_requests").show();
                        toaster_msg('success', '<i class="fa fa-check"></i>', 'Purchase request has been successfully submitted.');
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });

    });
</script>
