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
	}
.advancesearchsssss{
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

}
 </style>
 
 <div class="content_right job_posting_dashboard mt-4">
 		<?php
			if (count($find_resume) == 0) {
		?>
			<p class="no_data_found">No user available!</p>
		<?php
			}else{
			foreach($find_resume as $usersData){
			$resumePath = '#';
			if ($usersData->candidate_resume) {
				$path = BASE_URL . 'assets/upload/user/resume/' . $usersData->candidate_resume;
			} else {
				$path = $resumePath;
			}

		?>
        <!-- card box start -->
	<?php //echo $_SESSION['resume_download_permission'].':'.$_SESSION['subscription_id']; ?>
        <div class="inner_cont_blog">
            <div class="my_job_header ">
                <h2><?= $usersData->first_name . " " . $usersData->last_name ?></h2>
                <?php if($_SESSION['resume_download_permission']==1){?>
			<!--<a href="<?php echo $path ?>" target="_blank" class = "  btn btn-default  advancesearchsssss" style="float:right;margin-top:-40px" onclick="javascript:download_resume();"><?php echo $usersData->candidate_resume != ''?'Download Resume':'Resume Not Uploaded' ?></a>-->
			<a href="javascript:void(0);" class = "btn btn-default  advancesearchsssss" style="float:right;margin-top:-40px" onclick="javascript:download_resume('<?php echo $path ?>');"><?php echo $usersData->candidate_resume != ''?'Download Resume':'Resume Not Uploaded' ?></a>
				<?php }else{?>
				<a href="javascript:void(0);" class = "btn btn-default  advancesearchsssss" style="float:right;margin-top:-40px" onclick="javascript:error_resume();"><?php echo $usersData->candidate_resume != ''?'Download Resume':'Resume Not Uploaded' ?></a>
				
				<?php } ?>
                <h4 class="mt-2" style="color:#9d9da6">Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium neque
                    commodi veritatis suscipit eaque architecto vel quae est libero
                    accusantium.veritatis suscipit eaque architecto </h4>
			</div>
			<p><span>Experience: </span><strong class="request_type"><?= $usersData->candidate_experience;?> Years</strong>
			</p>
			<p><span>Availability Time-Frame: </span><strong class="project_scope"><?= $usersData->candidate_timeframe;?></strong></p>
			<p><span> Designation: </span><strong class="acheive_space"><?= $usersData->candidate_designation;?></strong>
			</p>
			<p><span>Skills Required: </span><strong class="style_preference"><?= $usersData->candidate_skills;?></strong></p>
			<p><span>Preferred Location: </span><strong class="technology_requirement"><?= $usersData->candidate_location;?></strong></p>
			<p><span>Travel Required: </span><strong class="construction_involved"><?= $usersData->candidate_travel;?></strong></p>
        </div>
		<?php
			}
		}
		?>

    </div>
    
    
    <!-- Modal -->
<div id="error_download_jobs" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Error!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
	  <p>To view or download a candidates resume please reference the Subscription & Charges page under the menu.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    <script>
    function error_resume(){
	$('#error_download_jobs').modal('show');
	}
	function download_resume(pdf_url){
		//alert('pp');
		$.ajax({
			url: '<?php echo base_url("user/download_resume"); ?>',
			type: 'post',
			data: {"subscription_id": "<?php echo $_SESSION['subscription_id']?>","max_resume_no":"<?php echo $_SESSION['max_resume_no']?>","job_category":"<?php echo $_SESSION['job_category']?>","max_valid_upto":"<?php echo $_SESSION['max_valid_upto']?>"},
			success: function (response) {
				console.log(response);
				if (response == 'success') {
					//window.location.href=pdf_url;
					window.open(
					pdf_url,
					'_blank' // <- This is what makes it open in a new window.
					);
				} else {
					toaster_msg('danger', '<i class="fa fa-exclamation">You have cross download limit</i>', response.msg);
				}

			}
		});
	}
    </script>