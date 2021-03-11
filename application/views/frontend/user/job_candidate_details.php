 <!-- candidate details start -->
<?php

$resumePath = '#';
if ($la_userData != '') {
	if ($la_userData->candidate_resume) {
		$path = BASE_URL . 'assets/upload/user/resume/' . $la_userData->candidate_resume;
	} else {
		$path = $resumePath;
	}
}
$iddd = $la_userData->id;

?>
<section class="candidate_details_wrapper">
	<div class="container">
		<div class="row custom_dtls">
			<div class="col-md-6 col-sm-12  ">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="#">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">Library</li>
				</ol>
			</div>
			<div class="col-md-6 col-sm-12  search_button_cotent">
				<?php
				if (isset($favorite_list[0])) {
				?>
				<a name="" id="fav_candidate" class="btn btn-p-outline mr-1" href="#" role="button">Remove From Favorite</a>
				<?php
			} else {
				?>
				<a name="" id="fav_candidate" class="btn btn-p-outline mr-1" href="#" role="button">Add To Favorite</a>
				<?php
			}
			
			?>
			<?php if($loggedId == 0){ ?> 
			<a name="" id="" class="btn btn-gradient" href="javascript:void(0);" onclick="javascript:error_resume();" role="button ">Download Resume</a>
			<?php }else{ ?>
			<?php if ($la_userData == '') { ?>
				<a name="" id="" class="btn btn-gradient" href="javascript:void(0);" onclick="javascript:error_resume_2();" role="button ">Resume Not Uploaded</a>
			<?php }else{ ?>
			<?php if($_SESSION['resume_download_permission']==1){?>
				<a name="" id="" class="btn btn-gradient" href="javascript:void(0);" onclick="javascript:download_resume('<?php echo $path ?>');" role="button ">Download Resume</a>
			<?php }else{?>
				<a name="" id="" class="btn btn-gradient" href="javascript:void(0);" onclick="javascript:error_resume_3();" role="button ">Download Resume</a>
			<?php } ?>
			<?php } ?>
			<?php } ?>
			<?php 
			/*if ($la_userData != '') {
				if ($loggedId != 0) {
				?>
				<a name="" id="" class="btn btn-gradient" href="<?php echo $path ?>" role="button ">Download Resume</a>
				<?php
			} else {*/
				?>
				<!--<a name="" id="downloademployer" class="btn btn-gradient" href="javascript:void(0);" onclick="javascript:error_resume();">Download Resume</a>-->
				<?php
			//}
				?>
				<?php
			/*} else {
				if ($loggedId != 0) {
					*/
				?>
				<!--<a name="" id="" class="btn btn-gradient" href="#" role="button ">Resume Not Uploaded</a>-->
				<?php
				//}else{
			?>
				<!--<a name="" id="" class="btn btn-gradient" href="javascript:void(0);" onclick="javascript:error_resume();" role="button ">Download Resume</a>-->
			<?php
			/*		
				}
			}
			*/
				?>
			

				<!--<a name="" id="" class="btn btn-gradient" href="<?php echo $path?>" target="_blank" role="button "><?php echo $la_userData->candidate_resume != ''?'Download Resume':'Resume Not Uploaded'?></a>-->
				<a name="" style="cursor:pointer" class="btn btn-p-outline ml-1" href="#" role="button"  data-toggle="modal" data-target="#addjobs">Message</a>
			</div>
		</div>
		<!-- end brad cum -->

		<div class="row">
			<div class="col-md-12 custom_details_context">
				
				<h2>
				<?php if((count($user_subscription)>0)){?>
				<?= $la_userData != '' ? $la_userData->first_name:'----'; ?> <?php echo $la_userData != '' ? $la_userData->last_name:'----' ; ?>
				<?php }else{ ?>
				<?php echo $la_userData->profile_heading;?>
				<?php }?>
				</h2>
				
				<h4>Looking for a job in <?php echo (($la_userData != '')?$la_userData->candidate_skills:'-----' ); ?></h4>
			</div>

			<!--<div class="col-md-12 custom_details_context">
			<h3>Overview:</h3>
			<P>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
			labore et dolore magna aliqua. Quis ipsum
			suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
			</div>-->

			<div class="col-md-12 custom_details_context">
				<h3>Skills:</h3>
				<P> <?php echo (($la_userData != '')?$la_userData->candidate_skills:'----'); ?> </p>
			</div>

			<div class="col-md-12 custom_details_context">
				<h3>Position Interested In:</h3>
				<P><?php echo (($la_userData != '')?$la_userData->candidate_designation:'----'); ?></p>
			</div>

			<div class="col-md-12 custom_details_context">
				<h3>Experiences:</h3>
				<P><?php echo (($la_userData= '')?$la_userData->candidate_experience:'----'); ?> <!--<?php echo (($la_userData->candidate_experience != '')?$la_userData->candidate_experience > 1 ? 'Years': 'Year':'----');?>!--></p>
			</div>
			<!--<div class="col-md-12 custom_details_context">
			<h3>Full time / Part time Position:</h3>
			<P>Full time</p>
			</div>-->
			<div class="col-md-12 custom_details_context">
				<h3>Availability:</h3>
				<P>Immediate <?php echo $la_userData != '' ? $la_userData->candidate_timeframe: 'Immediate'; ?></p>
			</div>
			<div class="col-md-12 custom_details_context">
				<h3>Able to Travel:</h3>
				<P><?php echo $la_userData != ''?$la_userData->candidate_travel:'----'; ?></p>
			</div>
			<div class="col-md-12 custom_details_context">
				<h3>Location:</h3>
				<P>

					<?php

					$loc_arr = $this->db->select('*')->from('candidate_city')->where(array('user_id'=>$iddd))->get()->result_array();
					if (count($loc_arr)>0) {
						$city_str = '';
						for ($i=0;$i<count($loc_arr);$i++) {
							$city_d= $this->db->select('*')->from('location_cities')->where(array('ID'=>$loc_arr[$i]['location_id']))->get()->result_array();
							$city_str .=$city_d[0]['CITY'].', ';


						}
						echo rtrim($city_str, ", ");
					}
					?>
				</p>
			</div>
			<!--<div class="col-md-12 custom_details_context">
			<h3>Education:</h3>
			<P>Bachelor Degree</p>
			</div>
			<div class="col-md-12 custom_details_context">
			<h3>Education:</h3>
			<P>Bachelor Degree</p>
			</div>
			<div class="col-md-12 custom_details_context">
			<h3>Job Location Preference:</h3>
			<P>New York</p>
			</div>-->
		</div>
	</div>
</section>

<div class="modal fade" id="addjobs" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Message <?= $la_userData != ''?$la_userData->first_name:''; ?></h5>
				<img class="close closeicon2" data-dismiss="modal" aria-label="Close" src="../../assets/frontend/images/closeicon.png" alt="" />
			</div>
			<form id="upload_jobs_form" method="post" action=""   >
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control" name="subject" id="subject"  placeholder="Full Name" />
					</div>

					<div class="form-group">
						<textarea   class="form-control" name="message" id="message" placeholder="Message"></textarea>
					</div>
					<div class="def_btn_cap">
						<?php
						if ($la_userData != '') {
						?>
						<button type="submit" class="message_to_candidate_form_btn btn btn-p-outline mr-3" style="width:300px !important;font-size:16px !important" id="">Message Candidate</button>
						<?php
					}
						?>
					</div>
				</div>
			</form>
			<!-- <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary">Save changes</button>
			</div> -->
		</div>
	</div>
</div>
<!-- candidate details end -->
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
				<p>Please login or register then go to Subscription and Charges to access a resume.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="error_download_jobs_2" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Error!!</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>

			</div>
			<div class="modal-body">
				<p>Resume not uploaded.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="error_download_jobs_3" class="modal fade" role="dialog">
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
function error_resume()
{
$('#error_download_jobs').modal('show');
}
function error_resume_2()
{
$('#error_download_jobs_2').modal('show');
}
function error_resume_3(){
	$('#error_download_jobs_3').modal('show');
}

</script>
<?php if ($loggedId != 0) { ?>
<script>
	function download_resume(pdf_url)
	{
		$.ajax({
			url: '<?php echo base_url("user/download_resume"); ?>',
			type: 'post',
			data: {"subscription_id": "<?php echo $_SESSION['subscription_id']?>","max_resume_no":"<?php echo $_SESSION['max_resume_no']?>","job_category":"<?php echo $_SESSION['job_category']?>","max_valid_upto":"<?php echo $_SESSION['max_valid_upto']?>"},
			success: function (response) {
				console.log(response);
				if (response == 'success') {
					window.open(
					pdf_url,
					'_blank' // <- This is what makes it open in a new window.
					);
				} else {
					console.log(response);
					toaster_msg('danger', '<i class="fa fa-exclamation">You have cross download limit</i>', response.msg);
					//toaster_msg('danger', '<i class="fa fa-exclamation">'+response+'</i>', response.msg);
				}

			}
		});
	}
</script>
<?php } ?>
<script>
	
	$(document).ready(function () {
		$('body').on('click', '#fav_candidate', function () {
			$.ajax({
				url: '<?php echo base_url("user/fav_candidate/$iddd");?>',
				type: 'post',
				dataType: 'json',
				data: '',

				async: false,
				success: function (response) {
					if (response.success) {
						$("#fav_candidate").html(response.text);
						if (response.flag == 'add') {
							$("#fav_candidate").addClass('active_favorite_btn');
						} else {
							$("#fav_candidate").removeClass('active_favorite_btn');
						}
						toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
					} else {
						toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
					}

				}
			});
		});
		$('body').on('click', '#downloademployer', function () {
			toaster_msg('danger', '<i class="fa fa-exclamation"></i>', 'Please Login To Download Resume');
		});
		$('body').on('click', '.message_to_candidate_form_btn', function () {
			$.ajax({
				url: '<?php echo base_url("user/message_to_candidate/$iddd");?>',
				type: 'post',
				dataType: 'json',
				data: $("#upload_jobs_form").serialize(),

				async: false,
				success: function (response) {
					if (response.success) {
						//$('body').find("#addjobs").modal('hide');
						toaster_msg('success', '<i class="fa fa-check"></i> ', response.msg);

					} else {
						toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
					}

				}
			});
		});
	})
</script>