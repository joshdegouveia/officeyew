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
            $('.overlay').show();
            $('#profile_image_form').submit();
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
                data: { 'action': 'get_cities', 'val': val },
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
                                obj.addClass('active');
                                obj.after(response.data);
                            } else {
                                obj.html('Requested');
                                obj.removeClass('endorse').addClass('endorsereq');
                            }
                        } else if (action == 'bunendorse') {
                            obj.closest('.follow-inner-wrap').find('.active').removeClass('endorsereq').addClass('endorse');
                            obj.closest('.follow-inner-wrap').find('.active').removeClass('active');
                            obj.closest('.dropdown-content').remove();
                        }
                    }
                }
            });
        });

        $(document).on('click', '.public-profile-page .follow-wrap .post-links-wrap .procat, .public-profile-page .follow-wrap .post-links-wrap .post', function() {
            $('.public-profile-page .follow-wrap .post-links-wrap a').removeClass('active');
            if ($(this).hasClass('post')) {
                $('.public-profile-page .procat-list').empty().hide();
                $('.public-profile-page .post-list').show();
                $(this).addClass('active');
            } else {
                $(this).addClass('active');
                var pid = $('.public-profile-page').attr('data-cm');
                $.ajax({
                    url: base_url + 'user/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'action': 'get_product_cat',
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

    // if (typeof $('.alert').html() != 'undefined') {
    //     setTimeout(function() {
    //         $('.alert').hide();
    //     }, 5000);
    // }

    if (typeof CKEDITOR != 'undefined') {
        CKEDITOR.editorConfig = function (config) {
          config.extraPlugins = 'confighelper';
          config.allowedContent = true;
        };
        $('.wysihtml').each(function() {
          CKEDITOR.replace(this, {
            format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div'
          });
        });
    }

    $('.menu-topr a.sign-out').on('click', function() {
        window.location.href = base_url + 'user/logout';
    });
     
});
////////////////koustav 09-12-2019////////////////////
function addseller(uid)
{
    if (confirm('Are you sure you want to become a Reseller?')) {
        window.location.href = base_url + 'user/becameSeller?uid='+uid;
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