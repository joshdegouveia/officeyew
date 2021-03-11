$(document).ready(function() {
    ////Add to wishlist//////
    $('.add_wish').on('click', function() {
        var u_id = $(this).attr('user_id');
        var p_id = $(this).attr('product_id');
        var wish_check = $(this).attr('wish_check');
        var obj = $(this);
        var all_data = ''
        if (wish_check == '') {
            all_data = {
                u_id: u_id,
                p_id: p_id,
                action: "add"
            };
        }else if (wish_check == 'l'){
            if(confirm('Please login first.')){
                window.location.href = base_url + 'login/signin';
            }
            //window.location.href = base_url + 'products/cart/'
        }
        else {
            all_data = {
                u_id: u_id,
                p_id: p_id,
                action: "del"
            };
        }
        $.ajax({
            type: "POST",
            url: base_url + "products/ajax_wishlist",
            dataType: 'json',
            data: all_data,
            success: function(res) {
                console.log(res);
                if (res.success) {
                    if (res.wish_id == '') {
                        obj.css('color', '#a2acbb');
                        obj.attr('wish_check', '');
                    } else {
                        obj.css('color', 'red');
                        obj.attr('wish_check', 'y');
                    }
                }

            }
        });
    });

    ///Add to My stock///
    $('.my_stock').on('click', function() {
        var pid = $(this).attr('product_id');
        var sellerid = $(this).attr('sellerid');
        var b2bid = $(this).attr('b2bid');
        var obj = $(this);
        var data_array = '';
        if (sellerid != '' && pid != '') {
            data_array = {
                sellerid: sellerid,
                pid: pid,
                b2bid: b2bid,
                action: "add"
            };
            $.ajax({
                type: "POST",
                url: base_url + "products/ajaxAddStock",
                dataType: 'json',
                data: data_array,
                success: function(res) {
                    console.log(res);
                    if (res.success) {
                        obj.attr('product_id', '');
                        obj.attr('sellerid', '');
                        obj.attr('b2bid', '');
                        obj.html('Product added to stock');
                    }

                }
            });
        }
    });

    if (typeof $('.cart-shipping-page').html() != 'undefined') {
        $('.voucher-btn').on('click', function() {
            $(this).hide();
            $('.voucher-add').show();
            $('.voucher-add #voucher_code').focus();
        });
        $('.voucher-add #voucher_cancel').click(function() {
            $('.voucher-add #voucher_code').val('');
            $('.voucher-add').hide();
            $('.voucher-btn').show();
        });
        $('.voucher-add #voucher_apply').click(function() {
            if ($('.voucher-add #voucher_code').val().trim() == '') {
                alert('Please enter voucher code');
                return false;
            }
            $.ajax({
                url: base_url + 'products/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    'action': 'voucher_add',
                    'vc': $('.voucher-add #voucher_code').val().trim()
                },
                async: false,
                success: function(response) {
                    if (response.success) {
                        if (response.data != '') {
                            $('.voucher-container').html(response.data);
                        }
                    } else if (response.msg != '') {
                        alert(response.msg);
                    }
                }
            });
        });
    }

    if ($('#country').val() != 'undefined' && $('#state').val() != 'undefined' && $('#city').val() != 'undefined') {
        var countries, states, cities;
        var sel_country = ($('#country').attr('data-country') != '') ? $('#country').attr('data-country') : '101';
        var sel_state = ($('#state').attr('data-state') != '') ? $('#state').attr('data-state') : '41';
        var sel_city = ($('#city').attr('data-city') != '') ? $('#city').attr('data-city') : '5583';

        $.ajax({
            url: base_url + 'assets/frontend/js/country.json',
            type: 'get',
            dataType: 'json',
            async: false,
            success: function(response) {
                countries = response;
                var options = '';
                var selected = '';
                var sel_option = ($('#country').attr('data-country') != '') ? $('#country').attr('data-country') : '101';
                options += '<option value="">-- Select --</option>';
                for (var i = 0; i < response.countries.length; i++) {
                    selected = (response.countries[i].id == sel_option) ? 'selected="selected"' : '';
                    options += '<option value="' + response.countries[i].id + '" ' + selected + '>' + response.countries[i].name + '</option>';
                }
                $('#country').html(options);
            }
        });
        $('#country').on('change', function() {
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
                        $('#state').html(options);
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
                $('#state').html(options);
            }
        });
        $('#state').on('change', function() {
            var val = $(this).val();
            var sel_option = '';
            $.ajax({
                url: base_url + 'products/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
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
                            $('#city').html(options);
                        }
                    }
                }
            });
        });

        if (sel_country != '') {
            $('#country').trigger('change');
        }
        if (sel_state != '') {
            $('#state').trigger('change');
        }
    }
});
///add to cart..////
function addTocart() {
    var loc = $(location).attr('href');
    var pid = loc.substr(loc.lastIndexOf('/') + 1);

    if (isNaN(pid)) {
        pid = btoa(pid);
    }

    if (pid != '') {
        data_array = {
            pid: pid,
            action: "add"
        };
        $.ajax({
            type: "POST",
            url: base_url + "products/ajaxCart",
            dataType: 'json',
            data: data_array,
            success: function(res) {
                console.log(res);
                if (res.success) {
                    $('.adcrt').attr('disabled', 'disabled');
                    $('.adcrt .btn-inner--text').html('Added to Cart');
                }

            }
        });
    }
}

function deletcartSingleitem(cid) {
    if (cid != '') {
        data_array = {
            cid: cid,
            action: "delete"
        };
        $.ajax({
            type: "POST",
            url: base_url + "products/deletsingleItem",
            dataType: 'json',
            data: data_array,
            success: function(res) {
                console.log(res);
                if (res.success) {
                    window.location.href = base_url + 'products/cart/'
                        // $('.adcrt').attr('disabled','disabled');
                        // $('.adcrt .btn-inner--text').html('Added to Cart');
                }

            }
        });
    }
}