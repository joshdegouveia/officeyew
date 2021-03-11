<script>
    $(document).ready(function () {
        purchase_requests_data = '';

        $('body').on('click', '.view_purchase_details_btn', function () {
            var thisId = $(this).attr('id');
            $.ajax({
                url: '<?php echo base_url("products/ajax_purchase_requests_details"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'puchase_details': thisId},
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        purchase_requests_data = thisId;

                        $('body').find("#viewPurchaseRequestModal .inner_cont_blog .submitted_name").html(response.data.submitted_name);
                        $('body').find("#viewPurchaseRequestModal .inner_cont_blog .submitted_phone").html(response.data.submitted_phone);
                        $('body').find("#viewPurchaseRequestModal .inner_cont_blog .submitted_address").html(response.data.submitted_address);
                        $('body').find("#viewPurchaseRequestModal .inner_cont_blog .created_on").html(response.data.created_on);
                        $('body').find("#viewPurchaseRequestModal .inner_cont_blog .product_name").html(response.data.product_name);
                        $('body').find("#viewPurchaseRequestModal .inner_cont_blog .regular_price").html("<?= CURRENCY ?>" + response.data.regular_price);
                        $('body').find("#viewPurchaseRequestModal .inner_cont_blog .message").html(response.data.message);

                        $('body').find("#viewPurchaseRequestModal .go_message_from_purchase_details").attr('id', response.msg_id_for_chat);

                        if (response.data.status == 'pending') {
                            $('body').find("#viewPurchaseRequestModal .purchase_request_message_content").hide();
                            $('body').find("#viewPurchaseRequestModal .purchase_request_update_content").show();
                        } else {
                            $('body').find("#viewPurchaseRequestModal .purchase_request_update_content").hide();
                            $('body').find("#viewPurchaseRequestModal .purchase_request_message_content").show();
                        }
                        $("#viewPurchaseRequestModal").modal('show');
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });



        $('body').on('click', '.purchase_request_status', function () {
            var thisId = $(this).attr('id'); // new status===
            $.ajax({
                url: '<?php echo base_url("products/ajax_purchase_requests_status_update"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'purchase_requests_data': purchase_requests_data, 'new_status': thisId},
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find("#row_" + purchase_requests_data + " .purchase_status").html(response.data);
                        $('body').find("#viewPurchaseRequestModal .purchase_request_update_content").hide();
                        $('body').find("#viewPurchaseRequestModal .purchase_request_message_content").show();
//                        $("#viewPurchaseRequestModal").modal('hide');
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });

        });


        $('body').on('click', '.go_message_from_purchase_details', function () {
            var thisId = $(this).attr('id');
            var thisIdArr = thisId.split('###');
            $('body').find(".user_message_chat").html('');
            $(".message_listing_parent_content").hide();
            $(".message_details_parent_content").slideDown();

            $(".messages_tab").click();

            $("#viewPurchaseRequestModal").modal('hide');

            get_chat_details(thisIdArr[1]);
        });



        $('body').on('click', '.include_purchase_requests .page-link', function () {
            $('body').find(".include_purchase_requests .fa-spinner").show();
            var thisId = $(this).attr('id');
            var pageId = thisId.split('_')[0];
            $.ajax({
                url: '<?php echo base_url("user/ajax_purchase_requests?pg="); ?>' + pageId,
                type: 'post',
                dataType: 'json',
                data: '',
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find(".include_purchase_requests").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });


        });


    });
</script>