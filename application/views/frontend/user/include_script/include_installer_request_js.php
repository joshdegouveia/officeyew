<script>
    $(document).ready(function () {
        $('body').on('click', '.installer_Submitted_Request .page-link', function () {
            $('body').find(".installer_Submitted_Request .fa-spinner").show();
            var thisId = $(this).attr('id');
            var pageId = thisId.split('_')[0];
            $.ajax({
                url: '<?php echo base_url("user/ajax_pagination_installer_request?pg="); ?>' + pageId,
                type: 'post',
                dataType: 'json',
                data: '',
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find(".installer_Submitted_Request").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });


        $('body').on('click', '.installer_req_details', function () {
            var thisId = $(this).attr('id');
            var thisIdArr = thisId.split('_');
//            var puchase_details = 
            $.ajax({
                url: '<?php echo base_url("user/ajax_installer_purchase_requests_details"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'puchase_details': thisId, 'flag': 'send'},
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        var requestData = response.data.la_requestData;
//                        console.log(requestData);
                        $('body').find("#viewInstallerRequestModal .inner_cont_blog").html(response.data.ls_reqText);

                        $("#viewInstallerRequestModal").modal('show');
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });


        $('body').on('click', '.include_installer_request_for_me .page-link', function () {
            $('body').find(".include_installer_request_for_me .fa-spinner").show();
            var thisId = $(this).attr('id');
            var pageId = thisId.split('_')[0];
            $.ajax({
                url: '<?php echo base_url("user/ajax_pagination_installer_request_me?pg="); ?>' + pageId,
                type: 'post',
                dataType: 'json',
                data: '',
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find(".include_installer_request_for_me").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });



    });
</script>