<!--$productId-->
<script>
    $(document).ready(function () {
        var carrentPage = "<?php echo $currentPage ?>";
        var addImgCount = 1;
        var addOrEdit = 'add';
        var sort_by = 'latest';
        $('body').on('click', '.add_more_image_modal', function () {
            var pro_imgHtml = $("#more_pro_img_content_hide").html();
            pro_imgHtml = pro_imgHtml.replace("pro_img_0", "pro_img_" + addImgCount);
            $(".more_image_append_content").append(pro_imgHtml);
            addImgCount++;
        });

        $('body').on('click', '.addProductOpenModalBtn', function () {
            addImgCount = 1;
            addOrEdit = 'add';
            $("#upload_product_form_btn").html('Add Product');
            $(".more_image_append_content").html('');
            $("#upload_product_form input").val('');
            $("#upload_product_form select").val('');
            $("#upload_product_form file").val('');
            $('#upload_product_form .pro_more_saved_image_content').html('');
            $('#upload_product_form .selected_location_autocomplete').html('');
            $('.boost_product_checkbox_content').hide();
        });

//        $('body').on('submit', '#upload_product_form', function () {
        $('.include_my_product #upload_product_form').submit(function (e) {
//            alert('okk');
            var formdata = new FormData($('#upload_product_form')[0]);
            $.ajax({
                url: '<?php echo base_url("products/upload_product_form/"); ?>',
                type: 'post',
                dataType: 'json',
                data: formdata,

                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        addImgCount = 1;
                        $(".more_image_append_content").html('');
                        $('body').find("#addProduct").modal('hide');
                        if (addOrEdit == 'add') {
                            ajax_my_product(1);
                        } else {
                            ajax_my_product(carrentPage);
                        }

                        toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
//                        window.setTimeout(function () {
//                            window.location.href = "<?php // echo base_url("user/profile/")                                             ?>";
//                                    window.location.href = "<?php // echo base_url("products/details/")                                                          ?>" + response.data.product_id + "/" + response.data.name;
//                        }, 5000);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });


            e.preventDefault();
            return false;
        });


        $('body').on('click', '.edit_product_by_dashboard', function () {
            var thisId = $(this).attr('id');
            var proId = thisId.split('_')[1];
            addOrEdit = 'edit';
            $("#upload_product_form_btn").html('Update');
            $("#upload_product_form input[name='filename']").val('');
            $('#upload_product_form .pro_more_saved_image_content').html('');
            $('#upload_product_form .selected_location_autocomplete').html('');
//            alert(proId);
            $.ajax({
                url: '<?php echo base_url("products/ajax_product_details/"); ?>',
                type: 'post',
                dataType: 'json',
                data: {"proId": proId},
                success: function (response) {
                    console.log(response);
                    if (response.success) {
//                        alert(response.data.boost_product_id);

                        if (response.data.is_boost == 1) {
                            $(".boost_product_checkbox_content").show();
                            $(".boost_product_checkbox").prop("checked", true);
                        } else {
                            $(".boost_product_checkbox").prop("checked", false);

                            if (response.pCheckboost == 'available') {
                                $(".boost_product_checkbox_content").show();

                            } else {
                                $(".boost_product_checkbox_content").hide();
                            }
                        }


                        $('#upload_product_form #productId').val(proId);
                        $('#upload_product_form #category_id').val(response.data.category_id);
                        $('#upload_product_form #name').val(response.data.name);
                        $('#upload_product_form #regular_price').val(response.data.regular_price);
                        $('#upload_product_form #long_description').val(response.data.long_description);
                        $('#upload_product_form #original_manufacture_name').val(response.data.original_manufacture_name);
                        $('#upload_product_form #year_manufactured').val(response.data.year_manufactured);
                        $('#upload_product_form input[name="warranty"][value="' + response.data.warranty + '"]').prop('checked', true);
                        $('#upload_product_form #product_condition_id').val(response.data.product_condition_id);
                        $('#upload_product_form #notable_defect_id').val(response.data.notable_defect_id);

                        $('#upload_product_form .pro_more_saved_image_content').html(response.ls_productImgMap);

                        $('#upload_product_form .selected_location_autocomplete').html(response.ls_proLocation);

                        $('body').find("#addProduct").modal('show');
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });


        });


//        $('body').on('blur', '.location_autocomplete_search_input', function (e) {
//            $('body').find(".location_autocomplete_list").html('');
//        });

        $('body').on('click', '.boost_product_checkbox', function (e) {
            var proId = $('#upload_product_form #productId').val();
            $.ajax({
                url: '<?php echo base_url("products/ajax_add_remove_boost_product"); ?>',
                type: 'post',
                dataType: 'json',
                data: {"proId": proId},
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }
                    carrentPage = 1;
                    ajax_my_product(carrentPage, 'boost');

                }
            });
        });


        $('body').on('change', '.sort_product_in_dashboard', function (e) {
            sort_by = $('.sort_product_in_dashboard').val();
//            sort_by
            ajax_my_product(carrentPage, sort_by);
        });


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
                        $('body').find(".location_autocomplete_list").show();
                        $('body').find(".location_autocomplete_list").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });


        });


        $('body').on('click', '.auto_location_city_name', function () {
            var thisId = $(this).attr('id');
            var thisVal = $(this).html();

            var cityName = thisVal.replace('<b>', '');
            cityName = cityName.replace('</b>', '', );
            var appendText = '<span class="selected_location_span">\n\
                    <input type="hidden" class="selected_location_input" name="location_id[]" value="' + thisId + '" readonly="">' + cityName + '\
                    <i class="fa fa-times remove_selected_location"></i>\n\
                    </span>';
            $(".selected_location_autocomplete").append(appendText);
            $(".location_autocomplete_search_input").val('');
            $('body').find(".location_autocomplete_list").hide();
        });



        $('body').on('click', '.remove_selected_location', function () {
            $(this).closest('.selected_location_span').remove();
        });


        $('body').on('click', '.remove_pro_img_modal', function () {
            var imgId = $(this).closest('.more_image_modal_item').attr('id');

            $.ajax({
                url: '<?php echo base_url("products/remove_pro_img"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'imgId': imgId},
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('#' + imgId).remove();
                        toaster_msg('success', '<i class="fa fa-check"></i>', "Removed successfully");
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });


        $('body').on('click', '.include_my_product .page-link', function () {
            $('body').find(".include_my_product .fa-spinner").show();
            var thisId = $(this).attr('id');
            var pageId = thisId.split('_')[0];
            carrentPage = pageId;
            ajax_my_product(pageId, sort_by);

        });

    });

    function ajax_my_product(pageId, sort_by = '') {
        $.ajax({
            url: '<?php echo base_url("user/ajax_my_product?pg="); ?>' + pageId,
            type: 'post',
            dataType: 'json',
            data: {'sort_by': sort_by},
            async: false,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    $('body').find(".include_my_product_inner").html(response.data);
                } else {
                    toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                }

            }
        });

    }

</script>
