<div class="change_password">

    <form id="basicBootstrapForm " class="form-horizontal change_password_form">

        <div class="form-group">
            <div class="row">

                <div class="col-md-12">
                    <input type="password" value="" class="form-control" name="current_password" placeholder="Current Password"/>
                </div>

            </div>
            <div class="clearfix"></div>
            <br>

            <div class="row">

                <div class="col-md-12">
                    <input type="password" value="" class="form-control" name="new_password" placeholder="New Password" />
                </div>

            </div>
            <div class="clearfix"></div>
            <br>

            <div class="row">

                <div class="col-md-12">
                    <input type="password" value="" class="form-control" name="confirm_password" placeholder="Confirm Password"/>
                </div>

            </div>
        </div>       

        <div class="submitBtn"><button type = "button" id="change_password_submit_btm" class = "btn btn-default">Save</button></div>
    </form>

</div>
<script>
    $(document).ready(function () {


        $('body').on('click', '#change_password_submit_btm', function () {
            $.ajax({
                url: '<?php echo base_url('/user/changePassword'); ?>',
                type: 'post',
                dataType: 'json',
                data: $(".change_password_form").serialize(),

                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $(".change_password_form input").val('');
                        toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });

    });
</script>