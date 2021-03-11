
 <div class="content_right job_posting_dashboard">
        <!-- card box start -->
		<?php
			if (count($applied_details) == 0) {
		?>
			<p class="no_data_found">No Jobs applied!</p>
		<?php
		}else{
			foreach($applied_details as $la_jobData){
		?>
        <div class="inner_cont_blog">
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
			<p><span>Location: </span><strong class="technology_requirement"><?= $la_jobData->preferred_location ;?></strong></p>
			<p><span>Travel Required: </span><strong class="construction_involved"><?= $la_jobData->travel_required ;?></strong></p>
        </div>
		<?php
			}
		}
		?>
    </div>