 
<script>
    $(document).ready(function () {


        $('body').on('keyup', '.designer_installer_name', function (e) {
            var searchVal = $(".designer_installer_name").val();
            e.preventDefault(); // Ensure it is only this code that rusn
            if (searchVal == '') {
                $(".user_id").val('');
            }

            $.ajax({
                url: '<?php echo base_url("user/designer_installer_autocomplete_search"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'searchVal': searchVal, 'type': "<?php echo $userType ?>"},
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find(".user_autocomplete_list").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });

        $('body').on('click', '.auto_user_name', function (e) { // == Auto complete search ====
            var thisName = $(this).html();
            var locName = thisName.replace(/<b>|<\/b>/gi, function (x) {
                return '';
            });
            $(".user_id").val($(this).attr('id'));
            $(".designer_installer_name").val(locName);
            $('body').find(".user_autocomplete_list").html('');
            console.log(locName);
        });




        $('body').on('keyup', '.location_autocomplete_search_input', function (e) {
            var searchVal = $(".location_autocomplete_search_input").val();
            e.preventDefault(); // Ensure it is only this code that rusn
            if (searchVal == '') {
                $(".location_autocomplete_id").val('');
            }

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
            var locName = thisName.replace(/<b>|<\/b>/gi, function (x) {
                return '';
            });
            $(".location_autocomplete_id").val($(this).attr('id'));
            $(".location_autocomplete_search_input").val(locName);
            $('body').find(".location_autocomplete_list").html('');
            console.log(locName);
        });



    });
</script>