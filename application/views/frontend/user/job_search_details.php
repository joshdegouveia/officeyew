 <!-- candidate details start -->

    <section class="candidate_details_wrapper">
        <div class="container">
            <div class="row custom_dtls">
                <div class="col-md-6 col-sm-12  ">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Library</li>
                    </ol>
                </div>
                <div class="col-md-6 col-sm-12  search_button_cotent">
					<?php
					if(isset($saved_jobs[0])) {
					?>
						<a name="" id="saveJob" class="btn btn-p-outline mr-3 " href="#" role="button">Remove from Savelist</a>
					<?php
					}else{
					?>
						<a name="" id="saveJob" class="btn btn-p-outline mr-3 " href="#" role="button">Save This Job</a>
					<?php
					}
						if(isset($applied_jobs[0])) {
					?>
						<a name="" class="btn btn-gradient active_favorite_btn" id="apply_button" href="#"  role="button ">Applied</a>
					<?php
					}else{
					?>
						<a name="" class="btn btn-gradient " id="apply_button" href="#"  role="button ">Apply</a>
					<?php
					}
					?>
                </div>
            </div>
            <!-- end brad cum -->
            <?php
		$city_data= $this->db->select('*')->from('job_city')->where(array('job_id'=>$la_jobData->id))->get()->result_array();
		$location_name = '';
		if (count($city_data)>0) {
			for ($i=0;$i<count($city_data);$i++) {
				$city_d= $this->db->select('*')->from('location_cities')->where(array('ID'=>$city_data[$i]['location_id']))->get()->result_array();
				$location_name .= $city_d[0]['CITY'].' ,';
		}
		$location_name = rtrim($location_name, ',');
	    }
	    ?>
            <div class="row  mt-3">
				 <div class="content_right job_posting_dashboard " style="margin-bottom:20px">
					<!-- card box start -->
					<div class="inner_cont_blog" >
						<div class="my_job_header">
							<h2><?= $la_jobData->job_title ;?></h2>
							<h4 class="mt-2" style="color:#9d9da6"><?= $la_jobData->job_description ;?></h4>
						</div>
						<p><span>Experience Required: </span><strong class="request_type"><?= $la_jobData->experience ;?> Years</strong>
						</p>
						<p><span>Salary : </span><strong class="planning_needed">$<?= $la_jobData->min_salary ;?> - $<?= $la_jobData->max_salary ;?> Per
								Month</strong>
						</p>
						<p><span>Availability Time-Frame: </span><strong class="project_scope"> <?= $la_jobData->avl_time_frame ;?></strong></p>
						<p><span> Designation: </span><strong class="acheive_space"><?= $la_jobData->designation ;?></strong>
						</p>
						<p><span>Skills Required: </span><strong class="style_preference"><?= $la_jobData->designation ;?></strong></p>
						<p><span>Location: </span><strong class="technology_requirement"><?= $location_name ;?></strong></p>
						<p><span>Travel Required: </span><strong class="construction_involved"><?= $la_jobData->travel_required ;?></strong></p>
					</div>
					
				</div>
            </div>
        </div>
    </section>
    <!-- candidate details end -->

	<script>
	$(document).ready(function () {
		 $('body').on('click', '#apply_button', function () {
			   $.ajax({
                url: '<?php echo base_url("user/apply_job/$la_jobData->id"); ?>',
                type: 'post',
                dataType: 'json',
                data: '',

                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $("#apply_button").html(response.text);
                        if (response.flag == 'add') {
                            $("#apply_button").addClass('active_favorite_btn');
                        } else {
                            $("#apply_button").removeClass('active_favorite_btn');
                        }
                        toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });

		 })
		$('body').on('click', '#saveJob', function () {
			 $.ajax({
                url: '<?php echo base_url("user/save_job/$la_jobData->id"); ?>',
                type: 'post',
                dataType: 'json',
                data: '',

                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $("#saveJob").html(response.text);
                        if (response.flag == 'add') {
                            $("#saveJob").addClass('active_favorite_btn');
                        } else {
                            $("#saveJob").removeClass('active_favorite_btn');
                        }
                        toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
		})
	})
</script>