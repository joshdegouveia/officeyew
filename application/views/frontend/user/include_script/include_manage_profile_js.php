
<script>
    $(document).ready(function () {
        $(".profile_image_on_profile").click(function () {
            $("#profile_image_upload").click();
        });


        $('body').on('change', '#profile_image_upload', function () {
            $.ajax({
                url: '<?php echo base_url('/user/profile_image_upload'); ?>',
                type: 'post',
                dataType: 'json',
                data: $(".profile_image_upload_form").submit(),

                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {

                        toaster_msg('success', '<i class="fa fa-check"></i>', 'Profile data has been successfully updated.');
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });


// =================== resume upload =================//

 $('body').on('click', '#upload_resume_btn', function () {
	$.ajax({
		    url: '<?php echo base_url('/user/profile_resume_upload'); ?>',
			type: 'post',
			dataType: 'json',
			data: $(".profile_resume_upload_form").submit(),
			async: false,
			success: function (response) {
			console.log(response);
			if (response.success) {

				toaster_msg('success', '<i class="fa fa-check"></i>', 'Resume has been successfully update.');
			} else {
				toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
			}
		  }
	})
 });

// =================== Stripe Document upload =================//

	$('body').on('click', '#identity_document_submit_btm', function () {
			var fd = new FormData();
			var frontFile = $('#front-file')[0].files;
			var backFile = $('#back-file')[0].files;
			if(frontFile.length > 0 ){
				fd.append('frontFile',frontFile[0]);
			}
			if(backFile.length > 0 ){
				fd.append('backFile',backFile[0]);
			}
			$.ajax({
				url: '<?php echo base_url('/user/stripe_document_upload'); ?>',
				type: 'post',
				dataType: 'json',
				data: fd,
				async: false,
				contentType: false,
				processData: false,
				success: function (response) {
				if (response.success) {
					toaster_msg('success', '<i class="fa fa-check"></i>', 'Document successfully uploaded.');
				} else {
					toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
				}
			  }
		})
	 });

	$('body').on('click', '#bank_details_submit_btm', function () {
		       $.ajax({
                url: '<?php echo base_url('/user/bankDataUpdate'); ?>',
                type: 'post',
                dataType: 'json',
                data: $(".upload_bank_details_form").serialize(),

                async: false,
                success: function (response) {
                    if (response.success) {
                        toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
	});


//===================   Change Profile Details ==================//
        $(".edit_profile_form input, .edit_profile_form textarea, .edit_profile_form radio").prop('readonly', true);
        $("#cancel_profile_submit_btn, #edit_profile_submit_btn").hide();
        $("#profile_city_location, .remove_selected_location").hide();
        $(".business_services, .remove_selected_service").hide();

        $('body').on('click', '#edit_profile_icon_btn', function () {
            $(".edit_profile_form .edit_input").prop('readonly', false);
//            $(".edit_profile_form #first_name, .edit_profile_form #last_name, .edit_profile_form #phone").prop('readonly', false);
//            $(".edit_profile_form textarea").prop('readonly', false);
            $("#cancel_profile_submit_btn").show();
            $("#edit_profile_submit_btn").show();
            $("#edit_profile_icon_btn").hide();
            $("#profile_city_location, .remove_selected_location, .business_services, .remove_selected_service").show();
        });

        $('body').on('click', '#cancel_profile_submit_btn', function () {
            $(".edit_profile_form .edit_input").prop('readonly', true);

            $("#cancel_profile_submit_btn, #edit_profile_submit_btn").hide();
            $("#edit_profile_icon_btn").show();
            $("#profile_city_location, .remove_selected_location").hide();
            $(".business_services, .remove_selected_service").hide();
        });

        $('body').on('click', '#edit_profile_submit_btn', function () {
            $.ajax({
                url: '<?php echo base_url('/user/profileDataUpdate'); ?>',
                type: 'post',
                dataType: 'json',
                data: $(".edit_profile_form").serialize(),

                async: false,
                success: function (response) {
                    if (response.success) {
                        $("#heaser_user_name").html(response.data.first_name);
                        $(".edit_profile_form input").prop('readonly', true);
                        $(".edit_profile_form textarea").prop('readonly', true);
                        $("#cancel_profile_submit_btn , #edit_profile_submit_btn").hide();
                        $("#edit_profile_icon_btn").show();
                        $("#profile_city_location, .remove_selected_location").hide();
                        $(".business_services, .remove_selected_service").hide();
                        toaster_msg('success', '<i class="fa fa-check"></i>', 'Profile data has been successfully updated.');
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });

		


        $('body').find(".profile_city_location_auto_content").hide();
        $('body').on('keyup', '.profile_city_location', function (e) {
            var searchVal = $(".profile_city_location").val();
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
                        $('body').find(".profile_city_location_auto_content").show();
                        $('body').find(".profile_city_location_auto_content").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });

        $('body').on('click', '.profile_city_location_auto_content .auto_location_city_name', function () {
            var thisId = $(this).attr('id');
            var thisVal = $(this).html();

            var cityName = thisVal.replace('<b>', '');
            cityName = cityName.replace('</b>', '', );
            var appendText = '<span class="selected_location_span">\n\
                    <input type="hidden" class="selected_location_input" name="location_id[]" value="' + thisId + '" readonly="">' + cityName + '\
                    <i class="fa fa-times remove_selected_location"></i>\n\
                    </span>';
            $(".selected_profile_city_location_content").append(appendText);
            $(".profile_city_location").val('');
            $('body').find(".profile_city_location_auto_content").hide();
        });

        $('body').on('click', '.selected_profile_city_location_content .remove_selected_location', function () {
            $(this).closest('.selected_location_span').remove();
        });





        $('body').find(".business_installation_services_auto_content").hide();
        $('body').on('keyup', '.business_services', function (e) {
            var searchVal = $(".business_services").val();
            e.preventDefault(); // Ensure it is only this code that rusn

            $.ajax({
                url: '<?php echo base_url("user/business_services_autocomplete_search"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'searchVal': searchVal},
                async: false,
                success: function (response) {
					console.log(response);
                    if (response.success) {
                        $('body').find(".business_installation_services_auto_content").show();
                        $('body').find(".business_installation_services_auto_content").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });
        
        
        $('body').on('click', '.business_installation_services_auto_content .auto_location_service_name', function (e) {
            var thisId = $(this).attr('id');
            var thisVal = $(this).html();
			var appendText = '';
            var serviceName = thisVal.replace('<b>', '');
            serviceName = serviceName.replace('</b>', '', );
			if(serviceName == 'All the above'){
				var searchVal = '';
				e.preventDefault();
				$.ajax({
                url: '<?php echo base_url("user/business_services_all_select"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'searchVal': searchVal},
                async: false,
                success: function (response) {
					appendText = response.data;
                }
            });

			}else{
			if(serviceName == 'Other: Explain'){
				appendText = '<input type="hidden" class="selected_services_input something_' + thisId + '" name="services_id[]" value="' + thisId + '" readonly="">' ; 
				var showingText = '<div class=" input-group show_other" id="something_' + thisId + '"  style="margin-top:10px;"><input type="text" value="" class="form-control edit_input" autocomplete="off"  placeholder="Enter Business Services" name="other_service" title="Explain Business Service"  aria-describedby="basic-addon2"><div class="input-group-append"><span class="input-group-text" id="basic-addon2"><i class="fa fa-times remove_selected_other_service" id="'+thisId+'"></i></span></div></div>';

				$(".showing_div").append(showingText);
				
			}else{
				appendText = '<span class="selected_service_span"><input type="hidden" class="selected_services_input something_' + thisId + '" name="services_id[]" value="' + thisId + '" readonly="">' + serviceName + '<i class="fa fa-times remove_selected_service"></i></span>';
			}
			}
			
            $(".selected_business_services_content").append(appendText);
            $(".business_services").val('');
            $('body').find(".business_installation_services_auto_content").hide();
        });

        $('body').on('click', '.selected_business_services_content .remove_selected_service', function () {
			var thisId = $('selected_service_input').val();
            $(this).closest('.selected_service_span').remove();
			 //$(this).closest('.show_other').hide();
        });

		$('body').on('click', '.remove_selected_other_service', function () {
			var id =  $(this).attr('id');
			$('#something_'+id).remove();
			$('#customCheckBox'+id).attr('checked', false); // Unchecks it
		
			  //$(this).closest('.show_other').remove();
		})

		$('body').on('click', '.service_checkbox', function () {
			var thisId = $(this).val();
			var serviceName = $(this).attr('data-id');
			if ($(this).is(':checked')) {
			if(serviceName == 'Other: Explain'){
				var showingText = '<div class=" input-group show_other" id="something_' + thisId + '"  style="margin-top:10px;"><input type="text" value="" class="form-control edit_input" autocomplete="off"  placeholder="Enter Business Services" name="other_service" title="Explain Business Service"  aria-describedby="basic-addon2"><div class="input-group-append"><span class="input-group-text" id="basic-addon2"><i class="fa fa-times remove_selected_other_service" id="'+thisId+'"></i></span></div></div>';
				$(".showing_div").append(showingText);
				}
			}
			else{
				if(serviceName == 'Other: Explain'){
					$('#something_'+ thisId).remove();
				}
			}
		
		});

    });
</script>
