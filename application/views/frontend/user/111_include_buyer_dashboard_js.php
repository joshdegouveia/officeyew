<script>
    $(document).ready(function () {

        $('body').on('keyup', '.buyer_dashboard_search_product_input', function (e) {
            var proName = $(".buyer_dashboard_search_product_input").val();

            if (proName != '') {
                search_dashboard_product_autocomplete(proName);
            }

            if (e.keyCode === 13) {
                e.preventDefault(); // Ensure it is only this code that rusn
                search_dashboard_product(proName);
            } else {
                if (proName == '') {
                    search_dashboard_product(proName);
                }
            }
        });

        $('body').on('click', '.auto_pro_name', function (e) { // == Auto complete search ====
            var thisName = $(this).html();
            var pName = thisName.replace('<b>', '');
            pName = pName.replace('</b>', '', );
            $(".buyer_dashboard_search_product_input").val(pName);
            console.log(pName);
            search_dashboard_product(pName);
        });


        $('body').on('click', '.search_buyer_product_in_dashboard .page-link', function () {
            $('body').find(".search_buyer_product_in_dashboard .fa-spinner").show();
            var thisId = $(this).attr('id');
            var pageId = thisId.split('_')[0];
            var proName = $(".buyer_dashboard_search_product_input").val();

            search_dashboard_product(proName, pageId);
        });

    });



    function search_dashboard_product_autocomplete(proName = '') {
        $.ajax({
            url: '<?php echo base_url("products/ajax_buyer_dashboard_search_product_autocomplete"); ?>',
            type: 'post',
            dataType: 'json',
            data: {'proName': proName},
            async: false,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    $('body').find(".search_product_name_autocomplete_list").html(response.data);
                } else {
                    toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                }
            }
        });
    }


    function search_dashboard_product(proName = '', pageId = '') {
        $.ajax({
            url: '<?php echo base_url("products/ajax_buyer_dashboard_search_product?pg="); ?>' + pageId,
            type: 'post',
            dataType: 'json',
            data: {'proName': proName},
            async: false,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    $('body').find(".search_product_name_autocomplete_list").html('');
                    $('body').find(".search_buyer_product_in_dashboard").html(response.data);
                } else {
                    toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                }
            }
        });
    }

</script>