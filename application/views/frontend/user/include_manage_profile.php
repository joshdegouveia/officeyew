<style>

	.chkboxInline .custom-control {
		display: inline-flex;
		margin: 0 0 15px 0;
		align-items: center;
		padding-left: 30px;
		width: 30% !important;
	}
</style>
<?php
//print_r($la_userBusenessServiceData);
?>
<div class="regd col-md-12">

	<div class="profile-image-dashboard">
		<form id="" class="profile_image_upload_form" enctype="multipart/form-data" action="<?php echo base_url('/user/profile_image_upload'); ?>" method="post">
			<?php
			$path = BASE_URL . 'assets/upload/user/profile/no_img.png' . $user_detail->filename;
			if ($user_detail->filename != '') {
				$path = BASE_URL . 'assets/upload/user/profile/' . $user_detail->filename;
			}
			?>
			<img src="<?php echo $path ?>" class="profile_image_on_profile" style="width: 200px;" alt="Profile Img">
			<input type="file" name="profile_image" id="profile_image_upload" accept="image/*" style="display: none">

		</form>
	</div>


	<form id="edit_profile_form " class="form-horizontal edit_profile_form" method="post" action="<?php echo base_url('/user/profileDataUpdate'); ?>">

		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<input type="text" class="form-control edit_input" id="first_name" name = "first_name" value="<?php echo $user_detail->first_name; ?>" placeholder="First name"/>
				</div>

				<div class="col-md-6">
					<input type="text" class="form-control edit_input" id="last_name" name = "last_name" value="<?php echo $user_detail->last_name; ?>" placeholder="Last name"/>
				</div>
			</div>
		</div>
		<?php if (in_array($user['type'], ['candidate'])) { ?>
		<?php $profile_heading = (isset($candidateDetailsData->profile_heading)) ? $candidateDetailsData->profile_heading : ""; ?>
		<div class="form-group">
			<div class="row">
				<div class="col-md-12">
					<input type="text" class="form-control edit_input" id="profile_heading" name ="profile_heading" value="<?php echo $profile_heading; ?>" placeholder="Profile Heading"/>
				</div>
			</div>
		</div>
		<?php }?>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<input type="text" class="form-control" id="email" value="<?php echo $user_detail->email; ?>" placeholder="Email" readonly=""/>
				</div>
				<div class="col-md-6">
					<input type="text" value="<?php echo $user_detail->phone; ?>" id="phone" class="form-control edit_input" name="phone" placeholder="Phone"/>
				</div>
			</div>
		</div>

		<!-- <?php if (in_array($user['type'], ['seller', 'installer', 'designer'])) {
		?>
		<div class="form-group">
		<div class="row">
		<div class="col-md-6">
		<input type="text" value="<?php echo $user_detail->stripe_secret_key; ?>"  class="form-control edit_input" id="stripe_secret_key" name="stripe_secret_key" title="Strip secret key" placeholder="Strip secret key"/>
		</div>
		<div class="col-md-6">
		<input type="text" value="<?php echo $user_detail->stripe_publish_key; ?>" id="stripe_publish_key" class="form-control edit_input" name="stripe_publish_key" title="Stripe publish key" placeholder="Stripe publish key"/>
		</div>
		</div>
		</div>
		<?php
		}
		?>   !-->

		<div class="form-group">
			<div class="row">
				<div class="col-md-12">
					<textarea id="address" class="form-control edit_input" name="address" placeholder="Enter your address..."><?php echo $user_detail->address; ?></textarea>
				</div>
			</div>
		</div>


		<?php
		if (in_array($user['type'], ['installer', 'designer'])) {
			$company_name = (isset($businessData->company_name)) ? $businessData->company_name : "";
			$years_of_experience = (isset($businessData->years_of_experience)) ? $businessData->years_of_experience : "";
			$company_address = (isset($businessData->company_address)) ? $businessData->company_address : "";
			$insured = (isset($businessData->insured)) ? $businessData->insured : "No";
			$license_and_bonded = (isset($businessData->license_and_bonded)) ? $businessData->license_and_bonded : "No";
		?>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<input type="text" value="<?php echo $company_name; ?>"  class="form-control edit_input" id="company_name" name="company_name" title="Business Name" placeholder="Business Name"/>
				</div>
				<div class="col-md-6">
					<b>Year of Experience:</b>
					<select name="years_of_experience" class="years_of_experience">
						<option value="">Select</option>
						<option value="0" <?php echo ($years_of_experience == 0) ? "selected" : "" ?>>No Experience</option>
						<?php
						for ($i = 1; $i <= 10; $i++) { ?>
						<option value="<?= $i ?>" <?php echo ($years_of_experience == $i) ? "selected" : "" ?>><?= $i ?> Years</option>
						<?php } ?>
						<option value="11" <?php echo ($years_of_experience == 11) ? "selected" : "" ?>>10+ Years</option>
					</select>
				</div>
			</div>
		</div>



		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<b>Insured : &nbsp; &nbsp; </b>
					<input type="radio" name="insured" value="Yes" <?php echo ($insured == 'Yes') ? "checked" : "" ?> class="form-control edit_radio insured" title="Yes" style="height: 20px !important;"/>
					<span>Yes</span>
					<input type="radio" name="insured" value="No" <?php echo ($insured == 'No') ? "checked" : "" ?>  class="form-control edit_radio insured" title="No"  style="height: 20px !important;"/>
					<span>No</span>
				</div>
				<div class="col-md-6">
					<b>License and Bonded : &nbsp; &nbsp; </b>
					<input type="radio" name="license_and_bonded" value="Yes" <?php echo ($license_and_bonded == 'Yes') ? "checked" : "" ?>  class="form-control edit_radio license_and_bonded" title="Yes" style="height: 20px !important;" />
					<span>Yes</span>
					<input type="radio" name="license_and_bonded" value="No" <?php echo ($license_and_bonded == 'No') ? "checked" : "" ?>  class="form-control edit_radio license_and_bonded" title="No"  style="height: 20px !important;"/>
					<span>No</span>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-md-12">
					<textarea id="company_address" class="form-control edit_input company_address" name="company_address" placeholder="Enter Business Address..."><?php echo $company_address; ?></textarea>
				</div>
			</div>
		</div>


		<div class="form-group">
			<div class="row">
				<div class="col-md-12">
					<input type="text" value=""  class="form-control edit_input profile_city_location" id="profile_city_location" name="profile_city_location" title="Business location cities" placeholder="Enter business location cities" autocomplete="off"/>
					<div class="profile_city_location_auto_content"></div>
					<div class="selected_profile_city_location_content">

						<?php
						if (count($la_userLocationData) > 0) { ?>
						<i>
							<b>Business location : </b></i>
						<?php
						foreach ($la_userLocationData as $location) {
						?>
						<span class="selected_location_span" title="<?= $location->COUNTRY ?>">
							<input type="hidden" class="selected_location_input" name="location_id[]" value="<?= $location->city_id ?>" readonly="">
							<?= $location->CITY ?>
							<i class="fa fa-times remove_selected_location"></i>
						</span>
						<?php
					}
				}
						?>
					</div>
				</div>
			</div>
		</div>


		<div class="form-group">
			<div class="row">
				<div class="col-md-12">
					<input type="text" value=""  class="form-control edit_input business_services" id="business_services " name="business_services" title="Business Services " placeholder="Enter Business Services "/>
					<div class="business_installation_services_auto_content"></div>
					<div class="selected_business_services_content">
						<i>
							<b> <?php echo (($user['type'] == 'installer')?'Installation Services':'Interior Design Specialty'); ?>  : </b></i>
						<div class="form-group chkboxInline " style="margin-top:10px">
							<?php
							$userServiceNow = array();
							foreach ($la_userBusenessServiceData as $data) {
								array_push($userServiceNow,$data->services_id);
							}
							//print_r($userServiceNow);
							foreach ($all_business_service as $k => $services) {
							?>
							<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input service_checkbox" name="services_id[]" data-id="<?= $services->services ?>" value="<?= $services->services_id ?>"  id="customCheckBox<?= $services->services_id ?>"
								<?php echo (in_array($services->services_id,$userServiceNow)? "checked" : "") ?> >
								<label class="custom-control-label " for="customCheckBox<?= $services->services_id ?>" style="font-size:12px" ><?= ucfirst($services->services) ?> </label>
							</label>
							<?php
						}
							?>
							<?php
							$service_info = '';
							$service_id = '';
							foreach ($la_userBusenessServiceData as $service) {
								if ($service->service_info != '' ) {
									$service_info = $service->service_info;
									$service_id = $service->services_id;
								}

							}
							if ($service_info != '' ) {
							?>
							<div class="input-group show_other" id="something_<?= $service_id ?>" style="margin-top:10px;">
								<input type="text" value=" <?= $service_info ?>" class="form-control edit_input" autocomplete="off" readonly placeholder="Explain Business Service" name="other_service" title="Explain Business Service" aria-label="Recipient's username" aria-describedby="basic-addon2">
								<div class="input-group-append">
									<span class="input-group-text" id="basic-addon2">
										<i class="fa fa-times remove_selected_other_service" id="<?= $service_id ?>"></i></span>
								</div>
							</div>
							<?php
						}
							?>
						</div>


					</div>
					<div class="showing_div">
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	if (in_array($user['type'], ['candidate'])) {
		$skills = (isset($candidateDetailsData->candidate_skills)) ? $candidateDetailsData->candidate_skills : "";
		$experience = (isset($candidateDetailsData->candidate_experience)) ? $candidateDetailsData->candidate_experience : "";
		$location = (isset($candidateDetailsData->candidate_location)) ? $candidateDetailsData->candidate_location : "";
		$timeFrame = (isset($candidateDetailsData->candidate_timeframe)) ? $candidateDetailsData->candidate_timeframe : "";
		$designation = (isset($candidateDetailsData->candidate_designation)) ? $candidateDetailsData->candidate_designation : "";
		$candidateTravel = (isset($candidateDetailsData->candidate_travel)) ? $candidateDetailsData->candidate_travel : "";
		$applyasAnonymous = (isset($candidateDetailsData->apply_as_anonymous)) ? $candidateDetailsData->apply_as_anonymous : "";

		?>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<input type="text" class="form-control edit_input" id="skills" name = "skills" value="<?php echo $skills; ?>" placeholder="Skills"/>
				</div>

				<div class="col-md-6">
					<select name="years_of_experience" class="years_of_experience form-control">
						<option value="">Experience</option>
						<?php
						for ($i = 1; $i <= 10; $i++) { ?>
						<option value="<?= $i ?>"  <?php
						if ($i == $experience)
							echo 'selected="selected"'; ?>><?= $i ?> Years</option>
						<?php } ?>
						<option value="11">10+ Years</option>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6" class="candi_location">
					<!--<input type="text" class="form-control edit_input" id="location" name = "location" value="<?php echo $location;?>" placeholder="Location"/>-->
					<input type="text" class="form-control edit_input location_autocomplete_search_candlocation_input" name="" placeholder="Search city name" onkeyup="javascript:keyupp(this.value);">

					<div class="location_autocomplete_list candidate_ul_wrapper"></div>
					<div class="selected_location_autocomplete_candidate jobs_autocomplete">
						<?php $loc_arr = $this->db->select('*')->from('candidate_city')->where(array('user_id'=>$_SESSION['user_data']['id']))->get()->result_array(); ?>
						<?php
						if (count($loc_arr)>0) { ?>
						<?php
						for ($i=0;$i<count($loc_arr);$i++) { ?>
						<?php $city_d= $this->db->select('*')->from('location_cities')->where(array('ID'=>$loc_arr[$i]['location_id']))->get()->result_array(); ?>
						<span class="selected_location_span" id="<?php echo $loc_arr[$i]['location_id']; ?>">
							<input type="hidden" class="selected_location_input" name="location_id[]" value="<?php echo $loc_arr[$i]['location_id']; ?>" readonly=""><?php echo $city_d[0]['CITY']; ?>
							<i class="fa fa-times remove_selected_location"></i>
						</span>
						<?php } ?>
						<?php } ?>
					</div>
				</div>


				<div class="col-md-6">
					<input type="text" class="form-control edit_input" id="avl_time_frame" name = "avl_time_frame" value="<?php echo $timeFrame; ?>" placeholder="Availability Time-Frame"/>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-12">
					<b style="margin-bottom:15px">Designation:</b>

					<div class="form-group chkboxInline mt-3">
						<label class="custom-control custom-checkbox">
							<input type="radio" class="custom-control-input designation edit_radio" name="designation" value="Executive"  id="customCheckBox" <?php echo ($designation == 'Executive') ? "checked" : "" ?> >
							<label class="custom-control-label" for="customCheckBox"style="margin-top:5px;font-size:15px">Executive</label>
						</label>
						<label class="custom-control custom-checkbox">
							<input type="radio" class="custom-control-input designation edit_radio" name="designation" value="Accounting"  id="customCheckBox" <?php echo ($designation == 'Accounting') ? "checked" : "" ?>>
							<label class="custom-control-label" for="customCheckBox"style="margin-top:5px;font-size:15px">Accounting</label>
						</label>
						<label class="custom-control custom-checkbox">
							<input type="radio" class="custom-control-input designation edit_radio" name="designation" value="Sales Management"  id="customCheckBox" <?php echo ($designation == 'Sales Management') ? "checked" : "" ?>>
							<label class="custom-control-label" for="customCheckBox"style="margin-top:5px;font-size:15px">Sales Management</label>
						</label>
						<label class="custom-control custom-checkbox">
							<input type="radio" class="custom-control-input designation edit_radio" name="designation" value="Inside Sales"  id="customCheckBox" <?php echo ($designation == 'Inside Sales') ? "checked" : "" ?>>
							<label class="custom-control-label" for="customCheckBox"style="margin-top:5px;font-size:15px">Inside Sales</label>
						</label>
						<label class="custom-control custom-checkbox">
							<input type="radio" class="custom-control-input designation edit_radio" name="designation" value="Administration"  id="customCheckBox" <?php echo ($designation == 'Administration') ? "checked" : "" ?>>
							<label class="custom-control-label" for="customCheckBox"style="margin-top:5px;font-size:15px"> Administration</label>
						</label>
						<label class="custom-control custom-checkbox">
							<input type="radio" class="custom-control-input designation edit_radio" name="designation" value="Marketing"  id="customCheckBox" <?php echo ($designation == 'Marketing') ? "checked" : "" ?>>
							<label class="custom-control-label" for="customCheckBox"style="margin-top:5px;font-size:15px">Marketing</label>
						</label>
						<label class="custom-control custom-checkbox">
							<input type="radio" class="custom-control-input designation edit_radio" name="designation" value="Service"  id="customCheckBox" <?php echo ($designation == 'Service') ? "checked" : "" ?>>
							<label class="custom-control-label" for="customCheckBox"style="margin-top:5px;font-size:15px">Service</label>
						</label>
						<label class="custom-control custom-checkbox">
							<input type="radio" class="custom-control-input designation edit_radio" name="designation" value="Designer"  id="customCheckBox" <?php echo ($designation == 'Designer') ? "checked" : "" ?>>
							<label class="custom-control-label" for="customCheckBox"style="margin-top:5px;font-size:15px">Designer</label>
						</label>
						<label class="custom-control custom-checkbox">
							<input type="radio" class="custom-control-input designation edit_radio" name="designation" value="Installer"  id="customCheckBox" <?php echo ($designation == 'Installer') ? "checked" : "" ?>>
							<label class="custom-control-label" for="customCheckBox"style="margin-top:5px;font-size:15px">Installer</label>
						</label>
						<label class="custom-control custom-checkbox">
							<input type="radio" class="custom-control-input designation edit_radio" name="designation" value="Other"  id="customCheckBox" <?php echo ($designation == 'Other') ? "checked" : "" ?>>
							<label class="custom-control-label" for="customCheckBox" style="margin-top:5px;font-size:15px">Other</label>
						</label>
					</div>
				</div>

			</div>
		</div>
		<div class="form-group" style="margin-bottom:20px !important;">
			<div class="row">
				<div class="col-md-6">
					<b>Travel: &nbsp; &nbsp; </b>
					<input type="radio" name="travel" value="Yes"  class="form-control edit_radio travel" title="Yes" style="height: 20px !important;" <?php echo ($candidateTravel == 'Yes') ? "checked" : "" ?>/>
					<span>Yes</span>
					<input type="radio" name="travel" value="No"   class="form-control edit_radio travel" title="No"  style="height: 20px !important;" <?php echo ($candidateTravel == 'No') ? "checked" : "" ?>/>
					<span>No</span>
				</div>
				<input type="hidden" name="apply_anonymous" value="Yes">
				<!--<div class="col-md-6">
					<b>Apply as anonymous : &nbsp; &nbsp; </b>
					<input type="radio" name="apply_anonymous" value="Yes"   class="form-control edit_radio apply_anonymous" title="Yes" style="height: 20px !important;" <?php echo ($applyasAnonymous == 'Yes') ? "checked" : "" ?>/>
					<span >Yes</span>
					<input type="radio" name="apply_anonymous" value="No"   class="form-control edit_radio apply_anonymous" title="No"  style="height: 20px !important;" <?php echo ($applyasAnonymous == 'No') ? "checked" : "" ?>/>
					<span>No</span>
				</div>-->
			</div>
		</div>
		<?php
	}
		?>
		<h4>Select User Type:</h4>
		<?php
		$userDataNow = array();
		foreach ($user_type_now as $data) {
			array_push($userDataNow,$data->name);
		}
		?>
		<div class="form-group chkboxInline ">
			<?php
			foreach ($la_groups as $k => $group) {
			?>
			<label class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" name="user_type[]" value="<?= $group->id ?>"  id="customCheckBox<?= ++$k ?>" <?php echo (in_array($group->name, $userDataNow) ? "checked" : "") ?>>
				<label class="custom-control-label" for="customCheckBox<?= $k ?>" ><?= ucfirst($group->name) ?> </label>
			</label>
			<?php
		}
			?>
		</div>


		<div class="submitBtn">
			<button type = "button" class = "btn btn-default" id="cancel_profile_submit_btn">Cancel</button>
			<button type = "button" class = "btn btn-default" id="edit_profile_submit_btn">Submit</button>
			<!--<button type ="submit" class = "btn btn-default" id="edit_profile_submit_btn">Submit</button>-->

		</div>
	</form>
</div>
<script>
	function keyupp(val)
	{
		var searchVal = $(".location_autocomplete_search_candlocation_input").val();
		$.ajax({
			url: '<?php echo base_url("user/location_autocomplete_search"); ?>',
			type: 'post',
			dataType: 'json',
			data: {'searchVal': searchVal},
			async: false,
			success: function (response) {
				if (response.success) {
					$('body').find(".location_autocomplete_list").show();
					$('body').find(".location_autocomplete_list").html(response.data);

				} else {
					toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
				}
			}
		});
	}
	$('body').on('click', '.auto_location_city_name', function () {
		var thisId = $(this).attr('id');
		var thisVal = $(this).html();

		var cityName = thisVal.replace('<b>', '');
		cityName = cityName.replace('</b>', '', );
		//alert(cityName);
		var len = $('.selected_location_autocomplete_candidate').find("#"+thisId).length;
		if (len ==0) {
			var appendText = '<span class="selected_location_span" id="'+thisId+'">\n\<input type="hidden" class="selected_location_input" name="location_id[]" value="' + thisId + '" readonly="">' + cityName + '\<i class="fa fa-times remove_selected_location"></i>\n\</span>';
			$(".selected_location_autocomplete_candidate").append(appendText);
		}
		$(".location_autocomplete_search_candlocation_input").val('');
		$('body').find(".location_autocomplete_list").hide();

	});
	$('body').on('click', '.remove_selected_location', function () {
		$(this).closest('.selected_location_span').remove();
	});

</script>
<style>
	.candidate_ul_wrapper ul{
		margin-top:50px;
	}
</style>