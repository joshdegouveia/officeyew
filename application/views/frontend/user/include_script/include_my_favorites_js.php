<script>
    $(document).ready(function () {
        $('body').on('click', '.include_my_favorites .page-link', function () {
            $('body').find(".include_my_favorites .fa-spinner").show();
            var thisId = $(this).attr('id');
            var pageId = thisId.split('_')[0];
            $.ajax({
                url: '<?php echo base_url("user/ajax_my_favorites?pg="); ?>' + pageId,
                type: 'post',
                dataType: 'json',
                data: '',
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find(".include_my_favorites").html(response.data);
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
        $('body').on('click', '.delete_product_my_favorites', function () {
            var thisId = $(this).attr('id');
            var proId = thisId.split('_')[1];

            $.confirm({
                title: 'Remove product',
                content: 'Remove product from my favorites?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    cancel: {
                        text: 'CANCEL',
                        btnClass: 'btn-gray'
                    },
                    confirm: {
                        text: 'REMOVE',
                        btnClass: 'btn-red',
                        action: function () {

                            $.ajax({
                                url: '<?php echo base_url("products/add_favorite/"); ?>' + proId,
                                type: 'post',
                                dataType: 'json',
                                data: '',

                                async: false,
                                success: function (response) {
                                    console.log(response);
                                    if (response.success) {
                                        if (response.flag == 'remove') {
                                            $("#productTr_" + proId).remove();
                                        }
                                        toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                                    } else {
                                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                                    }

                                }
                            });
                        }
                    }
                }
            });


        });


    });
</script>