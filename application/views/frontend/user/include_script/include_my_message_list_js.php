<script>
    $(document).ready(function () {
        msgUrserData = ''; // this is selected user data for chat ============//

        setInterval(function () {
            if (msgUrserData != '') {
                get_chat_details(msgUrserData);
            }
        }, 5000);

        $('body').on('click', '#message_details_to_listing', function () {
            msgUrserData = '';
            $(".message_details_parent_content").hide();
            $(".message_listing_parent_content").slideDown();
        });

        // ==========  Click on left chat username and get message ============//
        $('body').on('click', '.user_list_in_msg_left', function () {
            var thisId = $(this).attr('id');
            $('body').find(".user_message_chat").html('');
            get_chat_details(thisId);
        });

        // ==========  Click on message list view details btn and get message ============//
        $('body').on('click', '.view_msg_details', function () {
            var thisId = $(this).attr('id');
            var thisIdArr = thisId.split('###');
            $('body').find(".user_message_chat").html('');
            $(".message_listing_parent_content").hide();
            $(".message_details_parent_content").slideDown();

            get_chat_details(thisIdArr[1]);
        });

        $('body').on('keyup', '.search_user_for_chat', function (e) {
            var userName = $(".search_user_for_chat").val();
            if (e.keyCode === 13) {
                e.preventDefault(); // Ensure it is only this code that rusn

                search_user_for_chat(userName);

            } else {
                if (userName == '') {
                    search_user_for_chat(userName);
                }

            }
        });


        $('body').on('click', '.chat_message_send', function () {
            var chat_text = $(".chat_message_text").val();
            if (chat_text.trim() == '') {
                toaster_msg('danger', '<i class="fa fa-exclamation"></i>', "Message can't be blank");
                return false;
            }
            $.ajax({
                url: '<?php echo base_url("message/ajax_send_message_chat"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'msgUrserData': msgUrserData, "chat_text": chat_text},
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $(".chat_message_text").val('');
                        $('body').find(".user_message_chat").append(response.content);
                        $('body').find("#" + msgUrserData + " .usr-info .msg").html(chat_text.substring(0, 10));
                        search_user_for_chat('');
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }
//                    alert(msgUrserData);
                }
            });
        });

        $('body').on('click', '.include_my_message_list .page-link', function () {
            $('body').find(".include_my_message_list .fa-spinner").show();
            var thisId = $(this).attr('id');
            var pageId = thisId.split('_')[0];
            $.ajax({
                url: '<?php echo base_url("user/ajax_my_message_list?pg="); ?>' + pageId,
                type: 'post',
                dataType: 'json',
                data: '',
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find(".include_my_message_list").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });


        });

    });

    function get_chat_details(thisId) {
        $(".user_list_in_msg_left").removeClass('active');
        $("#" + thisId).addClass('active');

        var user_name = $("#" + thisId + " .usr-info .name").html();
        var user_img_src = $("#" + thisId + " img").attr('src');
        $("#msg_chat_head #msg_chat_head_profile_name").html(user_name);
        $("#msg_chat_head .img-profile img").attr('src', user_img_src);

        $.ajax({
            url: '<?php echo base_url("message/ajax_get_message_chat"); ?>',
            type: 'post',
            dataType: 'json',
            data: {'thisId': thisId},
            async: false,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    msgUrserData = thisId;
                    $('body').find(".user_message_chat").html(response.data);
                    $(".user_message_chat").scrollTop($('.user_message_chat')[0].scrollHeight);
                } else {
                    toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                }
//                    alert(msgUrserData);
            }
        });
    }


    function search_user_for_chat(userName) {

        $.ajax({
            url: '<?php echo base_url("message/ajax_search_user_for_chat"); ?>',
            type: 'post',
            dataType: 'json',
            data: {'userName': userName},
            async: false,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    $('body').find(".include_my_message_details_user_list").html(response.data);
                } else {
                    toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                }
            }
        });
    }

</script>