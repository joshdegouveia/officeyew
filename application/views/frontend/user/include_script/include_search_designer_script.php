 
<script>
    $(document).ready(function () {

        $('body').on('keyup', '.designer_autocomplete_search_input', function (e) {
            var searchVal = $(".designer_autocomplete_search_input").val();
            e.preventDefault(); // Ensure it is only this code that rusn
            if (searchVal == '') {
                $(".designer_autocomplete_id").val('');
            }

            $.ajax({
                url: '<?php echo base_url("user/designer_autocomplete_search"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'searchVal': searchVal},
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find(".designer_autocomplete_list").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });


        });

        $('body').on('click', '.auto_designer_name', function (e) { // == Auto complete search ====
            var thisName = $(this).html();
            var locName = thisName.replace(/<b>|<\/b>/gi, function (x) {
                return '';
            });
            $(".designer_autocomplete_id").val($(this).attr('id'));
            $(".designer_autocomplete_search_input").val(locName);
            $('body').find(".designer_autocomplete_list").html('');
            console.log(locName);
        });



    });
</script>