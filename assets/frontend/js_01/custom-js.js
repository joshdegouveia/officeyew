if ('serviceWorker' in navigator) {
    window.addEventListener('load', ()=> {
        navigator.serviceWorker.register('sw.js')
            .then((registration)=>console.log("Ready.", registration.scope))
            .catch((err)=>console.log("Err...", err));
    });
}
$(document).ready(function() {
    
    if (typeof $('form .pwdsh i').html() != 'undefined') {
        $('form .pwdsh i').on('click', function() {
            if ($(this).hasClass('fa-eye-slash')) {
                $('#password').attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                $('#password').attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });
    }

    if (typeof $('.aboutus').html() != 'undefined') {
        var chg = $('.aboutus .second-sec .container').outerHeight() / 2;
        var mhg = $('.aboutus .second-sec .mask').outerHeight();
        $('.aboutus .second-sec .container').css('height', (chg + mhg));
    }

    if (typeof $('.faq').html() != 'undefined') {
        var fhg = $('.faq .faq-items:last').outerHeight();
        var phg = $('.faq .py-4:last').outerHeight();
        var tot = (fhg * 2) + phg;
        $('.faq .faq-items:last').css('height', tot);
        // alert(fhg);
    }

    if (typeof $('.account-page').html() != 'undefined') {
        $('.account-page #profile_image_form #ufile').on('change', function() {
            setTimeout(function() {
                $('.light-modal .light-modal-footer div:eq(0)').attr('onclick', 'closeModal();closeAccountProfileImage();')
                $('.light-modal .light-modal-footer div:eq(2)').attr('onclick', 'cropzeeCreateImage(`ufile`);accountProfileImage();')
            }, 1000);
            // $('.overlay').show();
            // $('#profile_image_form').submit();
        });
        var countries, states, cities;
        var sel_country = $('#profile_form #country').attr('data-country');
        var sel_state = $('#profile_form #state').attr('data-state');
        var sel_city = $('#profile_form #city').attr('data-city');

        $.ajax({
            url: base_url + 'assets/frontend/js/country.json',
            type: 'get',
            dataType: 'json',
            async: false,
            success: function(response) {
                countries = response;
                var options = '';
                var selected = '';
                var sel_option = $('#profile_form #country').attr('data-country');
                options += '<option value="">-- Select --</option>';
                for (var i = 0; i < response.countries.length; i++) {
                    selected = (response.countries[i].id == sel_option) ? 'selected="selected"' : '';
                    options += '<option value="' + response.countries[i].id + '" ' + selected + '>' + response.countries[i].name + '</option>';
                }
                $('#profile_form #country').html(options);
            }
        });
        $('#profile_form #country').on('change', function() {
            var val = $(this).val();
            var sel_option = '';
            if (typeof states == 'undefined') {
                $.ajax({
                    url: base_url + 'assets/frontend/js/states.json',
                    type: 'get',
                    dataType: 'json',
                    async: false,
                    success: function(response) {
                        states = response;
                        var options = '';
                        for (var i = 0; i < response.states.length; i++) {
                            if (response.states[i].country_id == val) {
                                selected = (response.states[i].id == sel_state) ? 'selected="selected"' : '';
                                options += '<option value="' + response.states[i].id + '" ' + selected + '>' + response.states[i].name + '</option>';
                            }
                        }
                        $('#profile_form #state').html(options);
                    }
                });
            } else {
                var options = '';
                var selected = '';
                for (var i = 0; i < states.states.length; i++) {
                    if (states.states[i].country_id == val) {
                        selected = (states.states[i].id == sel_option) ? 'selected="selected"' : '';
                        options += '<option value="' + states.states[i].id + '" ' + selected + '>' + states.states[i].name + '</option>';
                    }
                }
                $('#profile_form #state').html(options);
            }
        });
        $('#profile_form #state').on('change', function() {
            var val = $(this).val();
            var sel_option = '';
            $.ajax({
                url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': 'get_cities',
                    'val': val
                },
                async: false,
                success: function(response) {
                    if (response.success) {
                        if (response.data != '') {
                            var options = '';
                            var selected = '';
                            for (var i = 0; i < response.data.length; i++) {
                                selected = (response.data[i].id == sel_city) ? 'selected="selected"' : '';
                                options += '<option value="' + response.data[i].id + '" ' + selected + '>' + response.data[i].name + '</option>';
                            }
                            $('#profile_form #city').html(options);
                        }
                    }
                }
            });
        });

        if (sel_country != '') {
            $('#profile_form #country').trigger('change');
        }
        if (sel_state != '') {
            $('#profile_form #state').trigger('change');
        }

        $("#ufile").cropzee();

        $(document).on('click', '.light-modal', function() {
            return false;
        });
    }

    if (typeof $('.setting-page').html() != 'undefined') {
        $('button[data-toggle="modal"]').on('click', function() {
            $('.alert strong').empty();
            $('.alert').hide();
        });
        $('.setting-page #user_setting_form').on('submit', function() {
            if ($('#old_password').val() == '') {
                setAlert('danger', 'Please enter old password.');
                $('#old_password').focus();
                return false;
            } else if ($('#password').val() == '') {
                setAlert('danger', 'Please enter new password.');
                $('#password').focus();
                return false;
            } else if ($('#password').val().length < 6) {
                setAlert('danger', 'Password required minimum 6 character long.');
                $('#password').focus();
                return false;
            } else if ($('#cpassword').val() == '') {
                setAlert('danger', 'Please enter confirm password.');
                $('#cpassword').focus();
                return false;
            } else if ($('#password').val() != $('#cpassword').val()) {
                $('#password').focus();
                setAlert('danger', 'New password and confirm password does not match.');
                return false;
            }
            $('.overlay').show();
        });
        $('.setting-page #user_setting_email_form').on('submit', function() {
            var oemail = $('#old_email').val().trim();
            var nemail = $('#new_email').val().trim();
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            $('#modal-change-email .alert strong').empty();
            $('#modal-change-email .alert').hide();

            if (oemail == '') {
                $('#modal-change-email .alert strong').html('Please enter old email.');
                $('#modal-change-email .alert').show();
                $('#old_email').focus();
                return false;
            } else if (!reg.test(oemail)) {
                $('#modal-change-email .alert strong').html('Please enter valid email.');
                $('#modal-change-email .alert').show();
                $('#old_email').focus();
                return false;
            } else if (nemail == '') {
                $('#modal-change-email .alert strong').html('Please enter new email.');
                $('#modal-change-email .alert').show();
                $('#new_email').focus();
                return false;
            } else if (!reg.test(nemail)) {
                $('#modal-change-email .alert strong').html('Please enter valid email.');
                $('#modal-change-email .alert').show();
                $('#new_email').focus();
                return false;
            }
            $('#modal-change-email').modal('toggle');
            $('.overlay').show();
        });
    }

    if (typeof $('#list_table').html() != 'undefined') {
        $('#list_table').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false
        });
    }

    if (typeof $('.b2b-product-page').html() != 'undefined') {
        $('a.rm-row').on('click', function() {
            if (!confirm('Do you want to delete this CMS page?')) {
                return false;
            }
        });
    };

    if (typeof $('.product-add-page').html() != 'undefined') {
        $('.product-add-page #product_add_form button.submit').on('click', function() {
            var ret = true;
            $("#product_add_form .form-control[required]").each(function() {
                if ($(this).val() == '') {
                    setAlert('danger', 'Please fillup the required fields.');
                    ret = false;
                    return false;
                }
            });
            if (!ret) {
                return false;
            }
            $('.overlay').show();
        });
        $('.product-add-page .list-panel a').on('click', function() {
            var val = $(this).attr('data-target');
            $('.product-add-page .list-panel a').removeClass('active');
            $(this).addClass('active');
            $('#product_add_form .form-attr-group').hide();
            $('#product_add_form .tab-' + val).show();
        });
        $('#add_product_category button.submit').on('click', function() {
            var val = $('#add_product_category #new_category').val().toLowerCase().trim();
            var matches = false;

            if (val == '') {
                $('#modal_add_category .alert strong').html('Please enter category name.');
                $('#modal_add_category .alert').show();
                $('#add_product_category #new_category').focus();
                return false;
            }

            $('#product_add_form #categories option').each(function() {
                if ($(this).text().toLowerCase() == val) {
                    matches = true;
                    return false;
                }
            });

            if (matches) {
                $('#modal_add_category .alert strong').html(val + ' already exist in category list.');
                $('#modal_add_category .alert').show();
                return false;
            }

            $('#modal_add_category').modal('toggle');
            $('.overlay').show();
            var formdata = new FormData($('#add_product_category')[0]);
            formdata.append('action', 'category_add');

            $.ajax({
                url: base_url + 'business/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: formdata,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('.overlay').hide();
                    if (response.success) {
                        $('#product_add_form #categories').append('<option value="' + response.cid + '">' + val + '</option>');
                        setAlert('success', response.message);
                    } else {
                        setAlert('danger', response.message);
                    }
                }
            });
        });

        $(document).on('click', '#product_add_form .product-image .rm-image', function() {
            if (confirm('Are you sure you want to remove this image?')) {
                var id = $(this).parent().attr('data-im');
                var obj = $(this);
                $('.overlay').show();
                $.ajax({
                    url: base_url + 'business/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'action': 'product_image_remove',
                        'val': id,
                    },
                    async: false,
                    success: function(response) {
                        $('.overlay').hide();
                        if (response.success) {
                            obj.parent().remove();
                            setAlert('success', response.message);
                        } else {
                            setAlert('danger', response.message);
                        }
                    }
                });
            }
        });

        $(document).on('click', '#product_add_form .product-image .cover-image', function() {
            var id = $(this).parent().attr('data-im');
            var pid = $('.product-add-page').attr('data-product');
            var obj = $(this);
            $('.overlay').show();
            $.ajax({
                url: base_url + 'business/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': 'product_image_cover',
                    'val': id,
                    'pid': pid,
                },
                async: false,
                success: function(response) {
                    $('.overlay').hide();
                    if (response.success) {
                        $('#product_add_form .product-image.cover').prepend('<div class="cover-image" title="Set cover image">Set Cover</div>').append('<div class="rm-image" title="Remove image">X</div>');
                        $('#product_add_form .product-image.cover img').removeAttr('title');
                        $('#product_add_form .product-image.cover').removeClass('cover');
                        obj.parent().find('.rm-image').remove();
                        obj.parent().find('img').attr('title', 'Cover Image');
                        obj.parent().addClass('cover');
                        obj.remove();
                        setAlert('success', response.message);
                    } else {
                        setAlert('danger', response.message);
                    }
                }
            });
        });
    }

    if (typeof $('.b2b-voucher-page').html() != 'undefined') {
        $('#list_table a.rm-data').on('click', function() {
            if (!confirm('Are you sure you want to remove this voucher?')) {
                return false;
            }
        });
    };

    if (typeof $('.voucher-add-page').html() != 'undefined') {
        $('#voucher_add_form .discount-type input').on('click', function() {
            var plch = 'Enter discount flat rate';
            if ($(this).val() == 'percentage') {
                plch = 'Enter discount percentage';
            }
            $('#discount_price').val('').attr('placeholder', plch).focus();
        });
        $('#voucher_add_form .voucher-discount-type input').on('click', function() {
            var plch = 'Enter discount flat rate';
            if ($(this).val() == 'percentage') {
                plch = 'Enter discount percentage';
            }
            $('#voucher_discount_price').val('').attr('placeholder', plch).focus();
        });
        $('#voucher_add_form .discount-for input[type=radio]').on('click', function() {
            if ($(this).val() == 'all') {
                $('#voucher_add_form .discount-by-category, #voucher_add_form .discount-by-product').hide();
            } else if ($(this).val() == 'category') {
                $('#voucher_add_form .discount-by-product').hide();
                $('#voucher_add_form .discount-by-category').show();
            } else {
                $('#voucher_add_form .discount-by-category').hide();
                $('#voucher_add_form .discount-by-product').show();
            }
        });
    }

    if (typeof $('.b2b-loyalty-page').html() != 'undefined') {
        $('#list_table a.rm-data').on('click', function() {
            if (!confirm('Are you sure you want to remove this loyalty discount?')) {
                return false;
            }
        });
    };

    if (typeof $('.loyalty-add-page').html() != 'undefined') {
        $('#loyalty_add_form .discount-type input').on('click', function() {
            var plch = 'Enter discount flat rate';
            if ($(this).val() == 'percentage') {
                plch = 'Enter discount percentage';
            }
            $('#discount_price').val('').attr('placeholder', plch).focus();
        });
        $('#loyalty_add_form .discount-for input[type=radio]').on('click', function() {
            if ($(this).val() == 'all') {
                $('#loyalty_add_form .discount-by-category, #loyalty_add_form .discount-by-product').hide();
            } else if ($(this).val() == 'category') {
                $('#loyalty_add_form .discount-by-product').hide();
                $('#loyalty_add_form .discount-by-category').show();
            } else {
                $('#loyalty_add_form .discount-by-category').hide();
                $('#loyalty_add_form .discount-by-product').show();
            }
        });
    }

    if (typeof $('.public-profile-page').html() != 'undefined') {
        $('#wall_post_form #fileo').on('click', function() {
            $('#wall_post_form #file').trigger('click');
        });
        $('#wall_post_form #file').on('change', function() {
            $('#wall_post_form #file_clear').show();
        });
        $('#wall_post_form #file_clear').on('click', function() {
            $('#wall_post_form #file').val('');
            $(this).hide();
        });

        $('#wall_post_form .post-submit .submit').on('click', function() {
            $('.alert').hide();
            if ($('#wall_post_form #post').val().trim() == '' && $('#wall_post_form #file').val() == '') {
                setAlert('danger', 'Please write something to submit.');
                return false;
            }
            $('.overlay').show();
            $('#wall_post_form').submit();
        });

        $('.public-profile-page .lks').on('click', function() {
            var action = 'post_like';
            if ($(this).hasClass('like')) {
                action = 'post_ulike';
            }
            var pid = $(this).closest('.posts').attr('data-post');
            var obj = $(this);
            var tot_likes = parseInt($(this).find('span').html());
            $.ajax({
                url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': action,
                    'pid': pid,
                },
                async: false,
                success: function(response) {
                    if (response.success) {
                        if (action == 'post_like') {
                            tot_likes++;
                            obj.addClass('like');
                            obj.find('span').html(tot_likes + ' likes');
                        } else {
                            tot_likes = (tot_likes > 0) ? --tot_likes : tot_likes;
                            obj.removeClass('like');
                            obj.find('span').html(tot_likes + ' likes');
                        }
                    }
                }
            });
        });

        $('.public-profile-page .cmt').on('click', function() {
            var pid = $(this).closest('.posts').attr('data-post');
            var parent = $(this).closest('.posts');
            parent.find('.comment-action').show();
            parent.find('.post-comments .sh-cmt').show();
            parent.find('.comment-action .comment-area').focus();
            $.ajax({
                url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': 'get_comment',
                    'pid': pid,
                },
                async: false,
                success: function(response) {
                    if (response.success) {
                        if (response.data != '') {
                            parent.find('.post-comment-content').remove();
                            parent.find('.post-comments').prepend(response.data);
                        }
                    }
                }
            });
        });

        $('.post-comments .sh-cmt').on('click', function() {
            $(this).hide();
            $(this).closest('.posts').find('.comment-action').hide();
            $(this).closest('.posts').find('.post-comment-content').remove();
        });

        $('.public-profile-page .comment-action .submit').on('click', function() {
            var pid = $(this).closest('.posts').attr('data-post');
            var parent = $(this).closest('.posts');
            var comment = parent.find('.comment-area').val();
            $.ajax({
                url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': 'post_comment',
                    'pid': pid,
                    'comment': comment,
                },
                async: false,
                success: function(response) {
                    if (response.success) {
                        if (response.data != '') {
                            parent.find('.comment-action').before(response.data);
                            parent.find('.cmt').addClass('comment');
                            parent.find('.comment-area').val('');
                        }
                    }
                }
            });
        });

        $(document).on('click', '.public-profile-page .follow-wrap .follow, .public-profile-page .follow-wrap .unfollow', function() {
            var pid = $('.public-profile-page').attr('data-cm');
            var obj = $(this);
            var action = 'bfollow';
            if ($(this).hasClass('unfollow')) {
                action = 'bunfollow';
            }
            $.ajax({
                url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': action,
                    'pid': pid,
                },
                async: false,
                success: function(response) {
                    if (response.success) {
                        if (action == 'bfollow' && response.data != '') {
                            obj.addClass('active');
                            obj.after(response.data);
                        } else if (action == 'bunfollow') {
                            obj.closest('.follow-inner-wrap').find('.active').removeClass('active');
                            obj.closest('.dropdown-content').remove();
                        }
                    }
                }
            });
        });

        $(document).on('click', '.public-profile-page .follow-wrap .endorse, .public-profile-page .follow-wrap .unendorse', function() {
            var pid = $('.public-profile-page').attr('data-cm');
            var obj = $(this);
            var action = 'bendorse';
            if ($(this).hasClass('unendorse')) {
                action = 'bunendorse';
            }
            $.ajax({
                url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': action,
                    'pid': pid,
                },
                async: false,
                success: function(response) {
                    if (response.success) {
                        if (action == 'bendorse') {
                            if (response.endorse && response.data != '') {
                                obj.addClass('active').html('Endorsing');
                                obj.after(response.data);
                            } else {
                                obj.html('Requested');
                                obj.removeClass('endorse').addClass('endorsereq');
                            }
                        } else if (action == 'bunendorse') {
                            obj.closest('.follow-inner-wrap').find('.active').removeClass('endorsereq').addClass('endorse').html('Endorse');
                            obj.closest('.follow-inner-wrap').find('.active').removeClass('active');
                            obj.closest('.dropdown-content').remove();
                        }
                    }
                }
            });
        });

        $(document).on('click', '.res-action .procat, .res-action .post, .res-action .voucher', function() {
            $('.public-profile-page .res-action a').removeClass('active');
            if ($(this).hasClass('post')) {
                $('.public-profile-page .procat-list').empty().hide();
                $('.public-profile-page .post-list').show();
                $(this).addClass('active');
            } else {
                $(this).addClass('active');
                var pid = $('.public-profile-page').attr('data-cm');
                var action = 'get_product_cat';
                if ($(this).hasClass('voucher')) {
                    action = 'get_business_vouchers';
                }
                $.ajax({
                    url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'action': action,
                        'pid': pid,
                    },
                    async: false,
                    success: function(response) {
                        if (response.success) {
                            if (response.data != '') {
                                $('.public-profile-page .post-list').hide();
                                $('.public-profile-page .procat-list').html(response.data).show();
                            }
                        }
                    }
                });
            }
        });

        $('.public-profile-page .rvw').on('click', function() {
            var pid = $(this).closest('.posts').attr('data-post');
            var parent = $(this).closest('.posts');

            if (parent.find('.post-review').is(':visible')) {
                parent.find('.post-review').hide();
                return false;
            }

            $.ajax({
                url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': 'get_review',
                    'pid': pid,
                },
                async: false,
                success: function(response) {
                    if (response.success) {
                        parent.find('.post-review').show();
                        if (response.data != '') {
                            parent.find('.post-review .post-reivew-list').remove();
                            parent.find('.post-review span.review i:lt(' + response.review + ')').addClass('voted');
                            parent.find('.post-review span.review').addClass('reviewed').removeClass('review');
                            parent.find('.post-review').append(response.data);
                        }
                    }
                }
            });
        });

        $(document).on('mouseover', '.public-profile-page .post-review span.review i', function() {
            var rev = $(this).index() + 1;
            var parent = $(this).closest('.posts');
            parent.find('.post-review span.review i:lt(' + rev + ')').addClass('voted');
        });
        $(document).on('mouseout', '.public-profile-page .post-review span.review i', function() {
            var parent = $(this).closest('.posts');
            parent.find('.post-review span.review i').removeClass('voted');
        });

        $(document).on('click', '.public-profile-page .post-review span.review i', function() {
            var rev = $(this).index() + 1;
            var pid = $(this).closest('.posts').attr('data-post');
            var parent = $(this).closest('.posts');
            $.ajax({
                url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': 'set_review',
                    'pid': pid,
                    'review': rev,
                },
                async: false,
                success: function(response) {
                    if (response.success) {
                        parent.find('.post-review span.review i:lt(' + rev + ')').addClass('voted');
                        parent.find('.post-review span.review').addClass('reviewed').removeClass('review');
                    }
                }
            });
        });
    }

    if (typeof $('.b2b-endorse-page').html() != 'undefined') {
        $('#list_table a.rm-data').on('click', function() {
            if (!confirm('Are you sure you want to remove this user from endorse?')) {
                return false;
            }
        });
    };

    if (typeof $('.seller-voucher-page').html() != 'undefined') {
        var voucher_id = 0;
        $('#list_table a.rm-data').on('click', function() {
            if (!confirm('Are you sure you want to remove this voucher?')) {
                return false;
            }
        });
        $('#list_table .send-mail').on('click', function() {
            voucher_id = $(this).attr('data-cid');
        });
        $(document).on('click', '#modal_send_mail button.preview-complete', function() {
            $('#modal_send_mail .preview-area .content').html('');
            $('#modal_send_mail .preview-area').hide();
            $('#send_voucher').show();
        });
        $('#send_voucher button.preview, #send_voucher button.submit').on('click', function() {
            $('#send_voucher .alert strong').html('');
            $('#send_voucher .alert').hide();
            if (voucher_id == 0) {
                $('#modal_send_mail').modal('toggle');
                return false;
            }

            if ($('#send_voucher #template').val() == '') {
                $('#send_voucher .alert strong').html('Please select template').show();
                $('#send_voucher .alert').show();
                return false;
            }

            if (typeof $('#send_voucher .customer-wrapper input:checked').val() == 'undefined') {
                $('#send_voucher .alert strong').html('Please select customers');
                $('#send_voucher .alert').show();
                return false;
            }

            var formdata = new FormData($('#send_voucher')[0]);
            formdata.append('vid', voucher_id);
            var is_preview = false;
            if ($(this).hasClass('preview')) {
                formdata.append('action', 'voucherpreview');
                is_preview = true;
            } else {
                formdata.append('action', 'vouchersend');
                if (!confirm('Are you sure you want to send voucher to customers?')) {
                    return false;
                }
            }
            $('overlay').show();
            $.ajax({
                url: base_url + 'seller/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: formdata,
                async: false,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    $('.overlay').hide();
                    if (response.success) {
                        if (is_preview) {
                            if (response.data != '') {
                                $('#send_voucher').hide();
                                $('#modal_send_mail .preview-area .content').html(response.data);
                                $('#modal_send_mail .preview-area').show();
                            }
                        } else {
                            setAlert('success', response.msg);
                            $('#modal_send_mail').modal('toggle');
                        }
                    } else {
                        $('#send_voucher .alert strong').html(response.message);
                        $('#send_voucher .alert').show();
                    }
                }
            });
        });
    };

    if (typeof $('.messages-page').html() != 'undefined') {
        setTimeout(function() {
            if (typeof $('.list-panel .chat_list.active_chat .chat_people').html() != 'undefined') {
                $('.list-panel .chat_list.active_chat .chat_people').trigger('click');
            }
        }, 2000);
        $('#chat_form .file-ico').on('click', function() {
            $('#ufile').trigger('click');
        });
        $('#chat_form #ufile').on('change', function() {
            $('#chat_form #ufile').trigger('click');
            $('#chat_form .clear').show();
        });
        $('#chat_form .clear').on('click', function() {
            $('#chat_form #ufile').val('');
            $('#chat_form .clear').hide();
        });
        $('#chat_form button.submit').on('click', function() {
            if ($('#message').val().trim() == '' && $('#ufile').val() == '') {
                $('#message').focus();
                return false;
            }

            var uid = $('.list-panel .chat_list.active_chat .chat_people').attr('data-muid');
            var formdata = new FormData($('#chat_form')[0]);
            formdata.append('action', 'message_post');
            formdata.append('muid', uid);
            $.ajax({
                url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: formdata,
                async: false,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.success) {
                        if (response.data != '') {
                            $('#chat_form #message').val('');
                            $('#chat_form #ufile').val('');
                            $('.mesgs .msg_history').append(response.data);
                            var top = $('.mesgs .msg_history')[0].scrollHeight;
                            $('.mesgs .msg_history').animate({
                                scrollTop: top + 'px'
                            }, 500);
                        }
                    }
                }
            });
        });
        $('.list-panel .chat_list .chat_people').on('click', function() {
            $('.list-panel .chat_list').removeClass('active_chat');
            $(this).parent().addClass('active_chat');
            var uid = $(this).attr('data-muid');
            $.ajax({
                url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': 'message_get',
                    'muid': uid
                },
                async: false,
                success: function(response) {
                    $('.mesgs .msg_history').html('');
                    if (response.success) {
                        if (response.data != '') {
                            var data = response.data.replace(/{{user_image}}/g, $('.list-panel .chat_list.active_chat .chat_img img').attr('src'));
                            $('.mesgs .msg_history').html(data);
                            var top = $('.mesgs .msg_history').height();
                            $('.mesgs .msg_history').animate({
                                scrollTop: top + 'px'
                            }, 500);
                        }
                    }
                }
            });
        });
        $(document).on('click', '.mesgs .msg_history button.download', function() {
            var file = $(this).attr('data-file');
            var ofile = $(this).attr('data-ofile');
            window.location.href = base_url + 'user/downloadfile/' + file + '/' + ofile;
        });
        $(document).on('click', '.msg_history .fa-ellipsis-v', function() {
            $(this).closest('.msg').find('.action').toggle();
        });
        $(document).on('click', '.msg_history .action span', function() {
            if (!confirm('Are you sure you want to delete this message?')) {
                return false;
            }
            var action = 'delme';
            var pid = $(this).parent().attr('data-pid');
            var parent = $(this).closest('.msg');
            if ($(this).hasClass('delboth')) {
                action = 'delboth';
            }
            $.ajax({
                url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': action,
                    'pid': pid
                },
                async: false,
                success: function(response) {
                    if (response.success) {
                        parent.remove();
                        setAlert('success', response.msg);
                    }
                }
            });
        });
    }

    if (typeof $('.product-item-page').html() != 'undefined') {
        $('span.review i').on('mouseover', function() {
            var rev = $(this).index() + 1;
            $('span.review i:lt(' + rev + ')').addClass('voted');
        });
        $('span.review i').on('mouseout', function() {
            $('span.review i').removeClass('voted');
        });
        $('span.review i').on('click', function() {
            var rev = $(this).index() + 1;
            var pid = $('.product-item-page').attr('data-pid');
            $.ajax({
                url: base_url + 'products/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': 'set_review',
                    'pid': pid,
                    'review': rev,
                },
                async: false,
                success: function(response) {
                    if (response.success) {
                        $('span.review i:lt(' + rev + ')').addClass('voted');
                        $('span.review').addClass('reviewed').removeClass('review');
                    }
                }
            });
        });
    }

    if (typeof $('.single-product-page').html() != 'undefined') {
        $('span.review i').on('mouseover', function() {
            var rev = $(this).index() + 1;
            $('span.review i:lt(' + rev + ')').addClass('voted');
        });
        $('span.review i').on('mouseout', function() {
            $('span.review i').removeClass('voted');
        });
        $('span.review i').on('click', function() {
            var rev = $(this).index() + 1;
            var pid = $('.single-product-page').attr('data-pid');
            $.ajax({
                url: base_url + 'products/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': 'set_review',
                    'pid': pid,
                    'review': rev,
                },
                async: false,
                success: function(response) {
                    if (response.success) {
                        $('span.review i:lt(' + rev + ')').addClass('voted');
                        $('span.review').addClass('reviewed').removeClass('review');
                    }
                }
            });
        });
        $('#comment_submit').click(function() {
            $('.comment-review .alert').hide();
            var comment = $('#comment').val().trim();
            if (comment == '') {
                $('.comment-review .alert').removeClass('alert-success alert-danger').addClass('alert-danger').html('Please enter comment').show();
                return false;
            }
            var pid = $('.single-product-page').attr('data-pid');
            $.ajax({
                url: base_url + 'products/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': 'set_review_comment',
                    'pid': pid,
                    'review': comment,
                },
                async: false,
                success: function(response) {
                    if (response.success) {
                        $('#comment').val('');
                        $('.comment-review .alert').removeClass('alert-success alert-danger').addClass('alert-success').html(response.msg).show();
                    } else if (response.msg != '') {
                        setTimeout(function() {
                            $('.comment-review .alert').removeClass('alert-success alert-danger').addClass('alert-danger').html(response.msg).show();
                        }, 8000);
                    }
                }
            });
        });
    }

    if (typeof $('.middle-header').html() != 'undefined') {
        $.ajax({
            url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
            type: 'post',
            dataType: 'json',
            data: {
                'action': 'get_head_rate',
            },
            async: false,
            success: function(response) {
                if (response.success) {
                    $('.middle-header .product-rate').html(response.data.products + '%');
                    $('.middle-header .sale-rate').html(response.data.sales + '%');
                    $('.middle-header .follow-rate').html(response.data.followers + '%');
                    if (response.data.products < 1) {
                        $('.middle-header .product-rate').next().removeClass('fa-angle-up text-success').addClass('fa-angle-down text-danger');
                    }
                    if (response.data.sales < 1) {
                        $('.middle-header .sale-rate').next().removeClass('fa-angle-up text-success').addClass('fa-angle-down text-danger');
                    }
                    if (response.data.followers < 1) {
                        $('.middle-header .follow-rate').next().removeClass('fa-angle-up text-success').addClass('fa-angle-down text-danger');
                    }
                }
            }
        });
    }

    if (typeof $('.dashboard-page').html() != 'undefined') {
        $.ajax({
            url: base_url + 'report/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
            type: 'post',
            dataType: 'json',
            data: {
                action: 'get_cstm_graph_dashboard',
            },
            async: false,
            success: function(response) {
                if (response.success) {
                    // if (response.content1 != '') {
                        var dp1 = [];
                        var is_empty = true;
                        $(response.content1).each(function(i, v) {
                            is_empty = false;
                            var total_unit = (v.total_unit != 'undefined') ? v.total_unit : ((v.total_price != 'undefined') ? v.total_price : 0);
                            var dt = new Date(v.modified_date);
                            dp1.push({
                                x: dt,
                                y: parseInt(total_unit)
                            });
                        });

                        $('.gr1 .header .title').html('Product Report');
                        $('.gr1 .graph-container .gr-title').html('Total Products');
                        if (is_empty) {
                            // dp1 = [{x: new Date(Date.now()), y: 0}];
                            dp1 = [
                                {x: '', y: -3},
                                {x: '', y: -2},
                                {x: '', y: -1},
                                {x: '', y: 0},
                                {x: '', y: 1},
                                {x: '', y: 2},
                                {x: '', y: 3}
                            ];
                        }
                        getGraph(dp1, response.type1, 'graph1');
                    // if (response.content1 == '') {
                    //     $('#graph1').parent().css('height', $('#graph1').height());
                    // }
                    if (typeof response.content2 != 'undefined') {
                        var dp1 = [];
                        $(response.content2).each(function(i, v) {
                            var total_unit = (v.total_unit != 'undefined') ? v.total_unit : ((v.total_price != 'undefined') ? v.total_price : 0);
                            var dt = new Date(v.modified_date);
                            dp1.push({
                                x: dt,
                                y: parseInt(total_unit)
                            });
                        });

                        $('.gr2 .header .title').html(response.name2);
                        $('.gr2 .graph-container .gr-title').html('Total ' + response.type2);
                        $('.gr2').show();
                        getGraph(dp1, response.type2, 'graph2');
                    } else {
                        $('.gr2').remove();
                    }
                }
            }
        });

        $('.act button').on('click', function() {
          if ($(this).attr('class').indexOf('print') != -1) {
              $(this).closest('.header').next('.graph-container').find(('.canvasjs-chart-toolbar > div div:eq(0)')).trigger('click');
          } else if ($(this).attr('class').indexOf('jpg') != -1) {
            $(this).closest('.header').next('.graph-container').find(('.canvasjs-chart-toolbar > div div:eq(1)')).trigger('click');
          } else if ($(this).attr('class').indexOf('png') != -1) {
            $(this).closest('.header').next('.graph-container').find(('.canvasjs-chart-toolbar > div div:eq(2)')).trigger('click');
          }
        });
    }

    if (typeof $('.ml-auto .nav-item .noti').html() != 'undefined') {
        $.ajax({
            url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
            type: 'post',
            dataType: 'json',
            data: { 'action': 'get_user_notification' },
            async: false,
            success: function(response) {
                if (response.success) {
                    if (response.data > 0) {
                        $('.ml-auto .nav-item .noti').html(response.data).show();
                    }
                } else {
                    $('.ml-auto .nav-item .noti').remove();
                }
            }
        });
        $('.ml-auto .nav-item .notifications a').on('click', function() {
            var parent = $(this).closest('.notifications');
            if (parent.find('.dropdown-menu').html() != '') {
                parent.find('.dropdown-menu').toggle();
                parent.find('.dropdown-menu').css('left', '-169px').css('top', '100%').css('transform', 'none');
                return false;
            }
            $.ajax({
                url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: { 'action': 'get_user_notification_list' },
                async: false,
                success: function(response) {
                    if (response.success) {
                        if (response.data != '') {
                            parent.find('.dropdown-menu').html(response.data).show();
                            parent.find('.dropdown-menu').css('display', 'block');
                        }
                    }
                }
            });
        });
    }

    if (typeof $('.voucher-detail-page').html() != 'undefined') {
        $('#voucher_stock').submit(function() {
            $('#voucher_stock #quantity').remove();
            if ($('.buy-voucher #qty').val() < 1) {
                alert('Please select quantity');
                $('.buy-voucher #qty').val('').focus();
                return false;
            }
            $('#voucher_stock').append('<input type="hidden" name="quantity" id="quantity" value="' + $('.buy-voucher #qty').val() + '">');
        });
        $('.buy-voucher #qty').on('click keyup', function() {
            var qty = $(this).val();
            var price = parseInt($(this).attr('data-price'));
            var currency = $(this).attr('data-currency');
            if (qty < 1) {
                $ ('.qty-price .qty-item').html('Qty: 0');
                $('.qty-price .total-price').html('Total: ' + currency + price);
                return false;
            }
            var total = qty * price;
            $ ('.qty-price .qty-item').html('Qty: ' + qty);
            $('.qty-price .total-price').html('Total: ' + currency + total);
        });
    }

    if (typeof $('.vouchers-page').html() != 'undefined') {
        $('.listing-content a.view').on('click', function() {
            $('.voucher-detail').empty().attr('data-pid', '').hide();
            $('.voucher-overlay').hide();
            var output = $(this).closest('.lst').find('.voucher-detail-container').html();
            var pid = $(this).closest('.lst').find('.voucher-detail-container').attr('data-pid');
            $('.voucher-overlay').show();
            $('.voucher-detail').html(output).attr('data-pid', pid).show();
        });
        $(document).on('click', '.voucher-detail .pop-cancel', function() {
            $('.voucher-detail').empty().attr('data-pid', '').hide();
            $('.voucher-overlay').hide();
        });
        $(document).on('click', '.voucher-detail .buy-voucher', function() {
            var pid = $(this).closest('.voucher-detail').attr('data-pid');
            location.href = base_url + 'products/buyvoucher/' + pid;
        });
    }
    
    if (typeof $('.notification-page').html() != 'undefined') {
        $('a.rm-data').on('click', function() {
            if (!confirm('Do you want to delete this notification?')) {
                return false;
            }
        });
        setTimeout(function() {
            if ($('a.unread').html() != 'undefined') {
                $.ajax({
                    url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                    type: 'post',
                    dataType: 'json',
                    data: { 'action': 'update_user_notification' },
                    async: false,
                    success: function(response) {
                        if (response.success) {
                            $('a.unread').removeClass('unread');
                            $('.dropdown-menu .noti').remove();
                        }
                    }
                });
            }
        }, 2000);
    }

    if (typeof $('.product-order-report-page').html() != 'undefined') {
        $('.prod-status').on('click', function() {
            $('.action').hide();
            $('.prod-status').removeAttr('style');
            $(this).attr('style', 'display:none!important;');
            $(this).next().show();
        });
        $('.action .cancel').on('click', function() {
            $('.action').hide();
            $('.prod-status').removeAttr('style');
        });
        $('.action .change').on('click', function() {
            if (!confirm('Are you sure you want to change status this product?')) {
                return false;
            }
            var pid = $(this).closest('.action').attr('data-pid');
            var val = $(this).closest('.action').find('.product-status').val();
            var parent = $(this).closest('.name');
            $.ajax({
                url: base_url + 'report/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: { 'action': 'product_status', 'pid': pid, 'val': val },
                async: false,
                success: function(response) {
                    if (response.success) {
                        setAlert('success', response.msg);
                        parent.find('.prod-status').html(response.data);
                    } else {
                        setAlert('danger', response.msg);
                    }
                    $('.action').hide();
                    $('.prod-status').removeAttr('style');
                }
            });
        });
    }

    if (typeof $('.b2b-voucher-order-page').html() != 'undefined') {
        $('.b2b-voucher-order-page .show-code').on('click', function() {
            $(this).hide();
            $(this).next().show();
        });
        $('.b2b-voucher-order-page .voucher-code').on('click', function() {
            $(this).hide();
            $(this).prev().show();
        });
        $('.b2b-voucher-order-page .show-update').on('click', function() {
            $('.update-container').show();
            $('.action').hide();
            $(this).parent().hide();
            $(this).parent().next().show();
        });
        $('.b2b-voucher-order-page .action .cancel').on('click', function() {
            $(this).closest('.action').hide();
            $(this).closest('.action').prev().show();
        });
        $('.b2b-voucher-order-page .action .change').on('click', function() {
            var pid = $(this).closest('.action').attr('data-pid');
            var parent = $(this).closest('.action');
            var val = parent.find('select').val();
            $.ajax({
                url: base_url + 'business/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: { 'action': 'voucher_update_status', 'pid': pid, 'val': val },
                async: false,
                success: function(response) {
                    if (response.success) {
                        setAlert('success', response.msg);
                        parent.prev().find('span').html(response.data);
                    } else {
                        setAlert('danger', response.msg);
                    }
                    $('.action').hide();
                    $('.update-container').show();
                }
            });
        });
    }
    if (typeof $('.follower-list-page').html() != 'undefined') {
        $('#list_search').on('keyup', function(e) {
            if (e.keyCode == 13) {
                var parent;
                var val = $('#list_search').val().toLowerCase();
                $('.card .name').each(function() {
                    parent = $(this).closest('.card');
                    if ($(this).html().toLowerCase().indexOf(val) != -1) {
                        parent.show();
                    } else {
                        parent.hide();
                    }
                });
            }
        });
        $('.actions-search .reset').on('click', function(e) {
            $('#list_search').val('');
            $('.card').show();
            return false;
        });
    }

    // if (typeof $('.alert').html() != 'undefined') {
    //     setTimeout(function() {
    //         $('.alert').hide();
    //     }, 5000);
    // }

    if (typeof CKEDITOR != 'undefined') {
        CKEDITOR.editorConfig = function(config) {
            config.extraPlugins = 'confighelper';
            config.allowedContent = true;
        };
        $('.wysihtml').each(function() {
            CKEDITOR.replace(this, {
                format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div'
            });
        });
    }

    $(document).click(function(e) {
        if (e.target.className.indexOf('region-sel') != -1) {
            $('.header-glob .region').toggle();
        } else {
            $('.header-glob .region').hide();
        }
        if (e.target.className.indexOf('fa-ellipsis-v') == -1) {
            $('.msg_history .action').hide();
        }
        console.log(e.target.className);
    });

    $('.dropdown-menu a.sign-out').on('click', function() {
        window.location.href = base_url + 'user/logout';
    });

    $('.header-glob .region span').on('click', function() {
        $('.overlay').show();
        window.location.href = base_url + 'login/regionchange/' + $(this).attr('data-val');
    });
});
////////////////koustav 09-12-2019////////////////////
function addseller(uid) {
    if (confirm('Are you sure you want to become a Reseller?')) {
        window.location.href = base_url + 'user/becameSeller?uid=' + uid;
    }
    return false;
}
var timeout;

function setAlert(type, msg, delay) {
    if (typeof $('.alert') != 'undefined') {
        delay = (typeof delay == 'undefined') ? 7000 : delay;
        $('.alert').removeClass('alert-danger alert-success').show();
        $('.alert').addClass('alert-' + type);
        $('.alert strong').html(msg);
        clearTimeout(timeout)
        timeout = setTimeout(function() {
            $('.alert strong').html('');
            $('.alert').hide();
        }, delay);
    }
}

function accountProfileImage () {
    var img = cropzeeGetImage('ufile');
    var pos = $('#ufile').val().lastIndexOf('.');
    var ext = $('#ufile').val().substring(pos + 1);
    $('#profile_image_form').append('<input type="hidden" name="ext" value="' + ext + '">');
    $('#profile_image_form').append('<input type="hidden" name="cimage" value="' + img + '">');
    $('.overlay').show();
    $('#profile_image_form').submit();
}

function closeAccountProfileImage() {
    $('#ufile').val('');
    $('#profile_image_form label span').html('Change avatar');
}