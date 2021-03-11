<script>
    $(document).ready(function () {
        $('body').on('click', '.include_designer_request_by_me .page-link', function () {
            $('body').find(".include_designer_request_by_me .fa-spinner").show();
            var thisId = $(this).attr('id');
            var pageId = thisId.split('_')[0];
            $.ajax({
                url: '<?php echo base_url("user/ajax_pagination_designer_service_request?pg="); ?>' + pageId,
                type: 'post',
                dataType: 'json',
                data: '',
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find(".include_designer_request_by_me").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });


        $('body').on('click', '.designer_req_details', function () {
            var thisId = $(this).attr('id');
            var thisIdArr = thisId.split('_');
//            var puchase_details = 
            $.ajax({
                url: '<?php echo base_url("user/ajax_designer_purchase_requests_details"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'puchase_details': thisId, 'flag': 'send'},
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        var requestData = response.data.la_requestData;
//                        console.log(requestData);
                        $('body').find("#viewDesignerPurchaseRequestModal .inner_cont_blog .request_type").html(requestData.request_type.toUpperCase());
                        $('body').find("#viewDesignerPurchaseRequestModal .inner_cont_blog .planning_needed").html(requestData.space_planning_needed.toUpperCase());
                        $('body').find("#viewDesignerPurchaseRequestModal .inner_cont_blog .project_scope").html(requestData.project_scope);
                        $('body').find("#viewDesignerPurchaseRequestModal .inner_cont_blog .acheive_space").html(requestData.acheive_space);
                        $('body').find("#viewDesignerPurchaseRequestModal .inner_cont_blog .style_preference").html(requestData.style_preference);
                        $('body').find("#viewDesignerPurchaseRequestModal .inner_cont_blog .technology_requirement").html(requestData.technology_requirement);
                        $('body').find("#viewDesignerPurchaseRequestModal .inner_cont_blog .construction_involved").html(requestData.construction_involved);
                        $('body').find("#viewDesignerPurchaseRequestModal .inner_cont_blog .time_frame").html(requestData.time_frame);
                        $('body').find("#viewDesignerPurchaseRequestModal .inner_cont_blog .message").html(requestData.message);

                        $('body').find("#viewDesignerPurchaseRequestModal .inner_cont_blog .areas_required").html(response.data.ls_areaData);
                        $('body').find("#viewDesignerPurchaseRequestModal .inner_cont_blog .collaboration").html(response.data.ls_reqColaData);
                        $('body').find("#viewDesignerPurchaseRequestModal .inner_cont_blog .selected_designer").html(response.data.ls_reqUserData);

                        if (thisIdArr[0] == 'dRequestForMe') {
                            $('body').find("#viewDesignerPurchaseRequestModal .inner_cont_blog .selected_designer_user").hide();
                        } else {
                            $('body').find("#viewDesignerPurchaseRequestModal .inner_cont_blog .selected_designer_user").show();
                        }

                        $("#viewDesignerPurchaseRequestModal").modal('show');
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });


        $('body').on('click', '.include_designer_request_for_me .page-link', function () {
            $('body').find(".include_designer_request_for_me .fa-spinner").show();
            var thisId = $(this).attr('id');
            var pageId = thisId.split('_')[0];
            $.ajax({
                url: '<?php echo base_url("user/ajax_pagination_designer_request_me?pg="); ?>' + pageId,
                type: 'post',
                dataType: 'json',
                data: '',
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find(".include_designer_request_for_me").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });



    });
</script>