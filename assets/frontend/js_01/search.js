$(document).ready(function() {
    var scountries, sstates, scities;
    var sel_country = '';
    var sel_state = '';
    var sel_city = '';

    $.ajax({
        url: base_url + 'assets/frontend/js/country.json',
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(response) {
            countries = response;
            var options = '';
            var selected = '';
            var sel_option = '';
            options += '<option value="">-- Select --</option>';
            for (var i = 0; i < response.countries.length; i++) {
                selected = (response.countries[i].id == sel_option) ? 'selected="selected"' : '';
                options += '<option value="' + response.countries[i].id + '" ' + selected + '>' + response.countries[i].name + '</option>';
            }
            $('#omnisearch #scountry').html(options);
        }
    });
    $('#omnisearch #scountry').on('change', function() {
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
                    options += '<option value="">-- Select --</option>';
                    for (var i = 0; i < response.states.length; i++) {
                        if (response.states[i].country_id == val) {
                            selected = (response.states[i].id == sel_state) ? 'selected="selected"' : '';
                            options += '<option value="' + response.states[i].id + '" ' + selected + '>' + response.states[i].name + '</option>';
                        }
                    }
                    $('#omnisearch #sstate').html(options);
                }
            });
        } else {
            var options = '';
            var selected = '';
            options += '<option value="">-- Select --</option>';
            for (var i = 0; i < states.states.length; i++) {
                if (states.states[i].country_id == val) {
                    selected = (states.states[i].id == sel_option) ? 'selected="selected"' : '';
                    options += '<option value="' + states.states[i].id + '" ' + selected + '>' + states.states[i].name + '</option>';
                }
            }
            $('#omnisearch #sstate').html(options);
        }
    });
    $('#omnisearch #sstate').on('change', function() {
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
                        options += '<option value="">-- Select --</option>';
                        for (var i = 0; i < response.data.length; i++) {
                            selected = (response.data[i].id == sel_city) ? 'selected="selected"' : '';
                            options += '<option value="' + response.data[i].id + '" ' + selected + '>' + response.data[i].name + '</option>';
                        }
                        $('#omnisearch #scity').html(options);
                    }
                }
            }
        });
    });

    $('#omnisearch .adv-search a').on('click', function() {
        $('#omnisearch .product-sug-list').hide();
        $('#omnisearch .adv-search-container').toggle();
    });

    $('#src_txt').on('keyup', function(e) {
        if ($('#src_txt').val() == '') {
            $("#omnisearch .product-sug-list ul").html('');
            $('#omnisearch .product-sug-list').hide();
        }
    });
    
    $('#src_txt').autocomplete({
        source: function(req, res) {
            // alert(req.term);
            $('#omnisearch .product-sug-list').hide();
            $.ajax({
                url: base_url + 'search/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: { 'term': req.term, 'action': 'get_product' },
                async: false,
                success: function (response) {
                    if (response.success) {
                        if (response.data != '') {
                            $("#omnisearch .product-sug-list ul").html(response.data);
                            $('#omnisearch .adv-search-container').hide();
                            $('#omnisearch .product-sug-list').show();
                        }
                    } else {
                        console.log(response.msg);
                    }
                }
            });
        }
    });

    $('#omnisearch .adv-search-container .submit button').on('click', function() {
        $('#omnisearch #scountry').next('span').find('.select2-selection--single').css('border', 'none');
        /*$('#omnisearch #sstate').next('span').find('.select2-selection--single').css('border', 'none');
        $('#omnisearch #scity').next('span').find('.select2-selection--single').css('border', 'none');*/
        if ($('#omnisearch .omnisearch-form #src_txt').val().trim() == '') {
            $('#omnisearch .omnisearch-form #src_txt').focus();
            return false;
        } else if ($('#omnisearch #scountry').val() == '') {
            $('#omnisearch #scountry').next('span').find('.select2-selection--single').css('border', '1px solid red');
            return false;
        } /*else if ($('#omnisearch #sstate').val() == '' || $('#omnisearch #sstate').val() == null) {
            $('#omnisearch #sstate').next('span').find('.select2-selection--single').css('border', '1px solid red');
            return false;
        } else if ($('#omnisearch #scity').val() == '' || $('#omnisearch #scity').val() == null) {
            $('#omnisearch #scity').next('span').find('.select2-selection--single').css('border', '1px solid red');
            return false;
        }*/
        var country = $('#omnisearch #scountry').val();
        var state = ($('#omnisearch #sstate').val() != '' && $('#omnisearch #sstate').val() != null) ? $('#omnisearch #sstate').val() : '';
        var city = ($('#omnisearch #scity').val() != '' && $('#omnisearch #scity').val() != null) ? $('#omnisearch #scity').val() : '';

        var loc = base_url + 'search/products?k=' + $('#omnisearch .omnisearch-form #src_txt').val().trim();
        var adv = country + ',' + state + ',' + city;
        adv = btoa(adv);
        window.location.href = loc + '&a=' + adv;
    });
});