 <style>
 .submitBtntttt {
    width: 100%;
    text-align: center;
 
}
 	.search {
    background: -webkit-linear-gradient(#cc008e, #99008f);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
   font-size: 16px;
    font-weight: 600;
    border: 1px solid #760091;
    border-radius: 10px;
    padding: 5px 20px !important;
	margin-top:20px;
	}
.advancesearchsss{
	color: #fff !important;
    background: rgb(221, 0, 141);
    background: -moz-linear-gradient(top, rgba(221, 0, 141, 1) 0%, rgba(137, 0, 144, 1) 100%);
    background: -webkit-linear-gradient(top, rgba(221, 0, 141, 1) 0%, rgba(137, 0, 144, 1) 100%);
    background: linear-gradient(to bottom, rgba(221, 0, 141, 1) 0%, rgba(137, 0, 144, 1) 100%);
	font-size: 16px;
    font-weight: 600;
    border: 1px solid #760091;
    border-radius: 10px;
    padding: 5px 20px !important;
	margin-top:20px;
}
 </style>

 
 <div class="content_right job_posting_dashboard mt-4">
        <!-- card box start -->
		<div class="inner_cont_blog">
		<form class="form-inline"  action="<?php echo base_url("user/candidate_dashboard_employer_job_search"); ?>" method="get">
			<div class="row">
				<div class="form-group col-md-2" style="padding:0 !important;font-size:14px !important;color:#000000;margin-top:5px !important">
					<b >Searching For :</b> 
				</div>
				<div class="form-group col-md-5" >
					<select class="form-control select2 select_categories_dropdown" name="designation">
						<option value="">Select Designation Type</option>
						<option value="Excecutive" <?php echo  ($ls_type == 'Excecutive') ? "selected" : "" ?>>Executive</option>
						<option value="Accounting" <?php echo ($ls_type == 'Accounting') ? "selected" : "" ?>>Accounting</option>
						<option value="Sales Management" <?php echo ($ls_type == 'Sales Management') ? "selected" : "" ?>>Sales Management</option>
						<option value="Inside Sales" <?php echo ($ls_type == 'Inside Sales') ? "selected" : ""?>>Inside Sales</option>
						<option value="Administration" <?php echo ($ls_type == 'Administration') ? "selected" : ""?>>Administration</option>
						<option value="Marketing" <?php echo ($ls_type == 'Marketing') ? "selected" : ""?>>Marketing</option>
						<option value="Service" <?php echo ($ls_type == 'Service') ? "selected" : ""?>>Service</option>
						<option value="Designer" <?php echo ($ls_type == 'Designer') ? "selected" : "" ?>>Designer</option>
						<option value="Installer" <?php echo ($ls_type == 'Installer') ? "selected" : "" ?>>Installer</option>
						<option value="Other" <?php echo ($ls_type == 'Other') ? "selected" : "" ?>>Other</option>
					</select>
				</div>
				<div class="form-group col-md-1" style="padding:0 !important;font-size:14px !important;color:#000000;margin-top:5px !important;text-align:center">
					<b style="">At</b> 
				</div>
				<div class="form-group col-md-4" >
					<input type="text" class="form-control location_autocomplete_search_input" name="location" value="<?= $ls_location ?>" placeholder="Search city name" autocomplete="off">
					<input type="hidden" class=" location_autocomplete_id" name="location_id" value="<?= $location_id ?>">
					<div class="form-group  col-12">
                        <div class="location_autocomplete_list" ></div>
					</div> 
					</select> 
				</div>
			</div>
			<div class="submitBtntttt">
				<button type = "button" class = "  advancesearchsss btn btn-default " data-toggle="modal" data-target="#advancejobsearch">Advanced Search</button>
				<button type = "submit" class = " search btn btn-default">Search</button>
			</div>
		</form>
        </div>
		<?php
			if (count($candidate_jobData) == 0) {
		?>
			<p class="no_data_found">No Jobs available!</p>
		<?php
		}else{
			foreach($candidate_jobData as $jobsData){
		?>
        <div class="inner_cont_blog">
            <div class="my_job_header">
                <h2><?= $jobsData->job_title?></h2>
                <h4 class="mt-2" style="color:#9d9da6"><?= $jobsData->job_description?></h4>
			</div>
			<p><span>Experience Required: </span><strong class="request_type"><?= $jobsData->experience ;?> Years</strong>
			</p>
			<p><span>Salary : </span><strong class="planning_needed">$<?= $jobsData->min_salary ;?> - $<?= $jobsData->max_salary ;?> Per
					Month</strong>
			</p>
			<p><span>Availability Time-Frame: </span><strong class="project_scope"> <?= $jobsData->avl_time_frame ;?></strong></p>
			<p><span> Designation: </span><strong class="acheive_space"><?= $jobsData->designation ;?></strong>
			</p>
			<p><span>Skills Required: </span><strong class="style_preference"><?= $jobsData->designation ;?></strong></p>
			<p><span>Location: </span><strong class="technology_requirement"><?= $jobsData->preferred_location ;?></strong></p>
			<p><span>Travel Required: </span><strong class="construction_involved"><?= $jobsData->travel_required ;?></strong></p>
        </div>
		<?php
			}
		}
		?>
    </div>

<script>
    $(document).ready(function () {

        $('body').on('keyup', '.location_autocomplete_search_input', function (e) {
            var searchVal = $(".location_autocomplete_search_input").val();
            e.preventDefault(); // Ensure it is only this code that rusn

            $.ajax({
                url: '<?php echo base_url("user/location_autocomplete_search"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'searchVal': searchVal},
                async: false,
                success: function (response) {
                    if (response.success) {
                        $('body').find(".location_autocomplete_list").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });


        });

        $('body').on('click', '.auto_location_city_name', function (e) { // == Auto complete search ====
            var thisName = $(this).html();
            var locName = thisName.replace('<b>', '');
            locName = locName.replace('</b>', '', );
            $(".location_autocomplete_id").val($(this).attr('id'));
            $(".location_autocomplete_search_input").val(locName);
            $('body').find(".location_autocomplete_list").html('');
            console.log(locName);
        });



    });
</script>