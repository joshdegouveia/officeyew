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
.advancesearch{
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
        <!-- card box start -->
		<?php
			if (count($posted_jobs) == 0) {
		?>
		<p class="no_data_found">No Jobs Posted Yet</p>
		<?php
		}else{
			foreach ($posted_jobs as $jobsData) {
				
				$city_data_s= $this->db->select('*')->from('job_city')->where(array('user_id'=>$_SESSION['user_data']['id'],'job_id'=>$jobsData->id))->get()->result_array();
				$location_name = '';
				if (count($city_data_s)>0) {
					for ($i=0;$i<count($city_data_s);$i++) {
						$city_dd= $this->db->select('*')->from('location_cities')->where(array('ID'=>$city_data_s[$i]['location_id']))->get()->result_array();
						$location_name .= $city_dd[0]['CITY'].', ';
					}
					$location_name = rtrim($location_name, ',');
				}
			
		?>
        <div class="inner_cont_blog">
            <div class="my_job_header">
                <h2><?= $jobsData->job_title?></h2>
                <h4 class="mt-2" style="color:#9d9da6"><?= $jobsData->job_description?> </h4>
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
			<p><span>Location: </span><strong class="technology_requirement"><?php echo $location_name ;?></strong></p>
			<p style="display: none;"><span>Travel Required: </span><strong class="construction_involved"><?= $jobsData->travel_required ;?></strong></p>
			<p>
			<button type="button" class="btn btn-edit" onclick="javascript:show_edit_jobs(<?php echo $jobsData->id;?>);">Edit Jobs</button>
			</p>
        
        <!-- Modal HTML -->
			<div id="myModal_<?php echo $jobsData->id;?>" class="modal fade edit_jobfrm_modal" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Edit Job</h5>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<div class="modal-body">
							    <form action="#" method="post" id="edit_frm_<?php echo $jobsData->id;?>">
							        <input type="hidden" name="job_id" value="<?php echo $jobsData->id;?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Job Title" value="<?= $jobsData->job_title?>">
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" name="long_description" id="long_description" placeholder="Job description"><?= $jobsData->job_description?></textarea>
                    </div>
					   <span style="font-size:16px !important;color:#a4a4a4;"> Salary range</span>
					  <div class="inp_row3 col-md-12 ">
						 <div class="form-group col-md-6" style="padding:0;margin:3px">
							<input type="text" class="form-control" name="minsal" id="minsal" placeholder="Minimum" value="<?= $jobsData->min_salary?>">
						</div>
						<div class="form-group col-md-6" style="padding:0;margin:3px">
							<input type="text" class="form-control" name="maxsal" id="maxsal" placeholder="Maximum" value="<?= $jobsData->max_salary?>">
						</div>
                    </div>
					 <div class="form-group">
                        <input type="text" class="form-control" name="educationlevel" id="educationlevel" placeholder="Education Level" value="<?= $jobsData->educational_level?>">
                    </div>
					<div class="form-group">
                   		<select name="years_of_experience" class="years_of_experience form-control">
                            <option value="">Years Of Experience</option>
                                                           <?php for ($i = 1; $i <= 10; $i++) { ?>
                                <option value="<?= $i ?>" <?php if($jobsData->experience==$i){?>selected="selected"<?php }?>><?= $i ?> Years</option>
                            <?php } ?> 
                               
                            <option value="11">10+ Years</option> 
                        </select>
                    </div>
					 <!--<div class="form-group">
                        <input type="text" class="form-control" name="location" id="location" placeholder="Location" value="<?= $jobsData->preferred_location?>">
                    </div>-->
                    <div class="form-group">
									<input type="text" class="form-control" name="" placeholder="Search city name" id="autocomplete_search_text_<?php echo $jobsData->id; ?>" onkeyup="javascript:autocity_search(<?php echo $jobsData->id; ?>);">
									<div id="location_autocomplete_list_<?php echo $jobsData->id; ?>"></div>
                    </div>
							<div id="selected_location_autocomplete_<?php echo $jobsData->id; ?>" class="jobs_autocomplete">
					<?php
						$city_data= $this->db->select('*')->from('job_city')->where(array('user_id'=>$_SESSION['user_data']['id'],'job_id'=>$jobsData->id))->get()->result_array();
									if (count($city_data)>0) {
										for ($i=0;$i<count($city_data);$i++) {
											$city_d= $this->db->select('*')->from('location_cities')->where(array('ID'=>$city_data[$i]['location_id']))->get()->result_array();
						?>
									<span class="selected_location_span" id="<?php echo $city_data[$i]['city_id']; ?>">
										<input type="hidden" class="selected_location_input" name="location_id[]" value="<?php echo $city_d[0]['ID']; ?>" readonly=""><?php echo $city_d[0]['CITY']; ?>
										<i class="fa fa-times" style="display:block;!important;" onclick="javascript:remove_city('<?php echo $jobsData->id; ?>','<?php echo $city_data[$i]['city_id']; ?>');"></i>
									</span>
						<?php					
										}
						}
					?>
                    </div>
					<div class="form-group">
                   		<select name="designation" class="designation form-control">
                            <option value="">Designation</option>
                            <option value="Executive" <?php if($jobsData->designation=='Executive'){?>selected="selected"<?php }?>>Executive</option>
							<option value="Accounting" <?php if($jobsData->designation=='Accounting'){?>selected="selected"<?php }?>>Accounting</option> 
							<option value="Sales Management" <?php if($jobsData->designation=='>Sales Management'){?>selected="selected"<?php }?>>Sales Management</option> 
							<option value="Inside Sales" <?php if($jobsData->designation=='Inside Sales'){?>selected="selected"<?php }?>>Inside Sales</option> 
							<option value="Administration" <?php if($jobsData->designation=='Administration'){?>selected="selected"<?php }?>>Administration</option> 
							<option value="Marketing" <?php if($jobsData->designation=='Marketing'){?>selected="selected"<?php }?>>Marketing</option> 
							<option value="Service" <?php if($jobsData->designation=='Service'){?>selected="selected"<?php }?>>Service</option> 
							<option value="Designer" <?php if($jobsData->designation=='Designer'){?>selected="selected"<?php }?>>Designer</option> 
							<option value="Installer" <?php if($jobsData->designation=='Installer'){?>selected="selected"<?php }?>>Installer</option> 
							<option value="Other" <?php if($jobsData->designation=='Other'){?>selected="selected"<?php }?>>Other</option>
                        </select>
                    </div>
					<div class="form-group">
                        <input type="text" class="form-control" name="avl_time_frame" id="avl_time_frame" placeholder="Availability Time-Frame" value="<?=$jobsData->avl_time_frame?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="travelreq" id="travelreq" placeholder="Travel Required" value="<?= $jobsData->travel_required?>">
                    </div>
                    
                    <div class="inp_row3 col-md-12">
                        <span class="col-md-6" style="font-size:16px !important"> Post Anonymous</span>
                      	<div class="form-group chkboxInline col-md-6">
							<label class="custom-control custom-checkbox">
								<input type="radio" class="custom-control-input" name="postanonymous" value="Yes" id="customCheckBox" <?php if(($jobsData->post_anonymous=='Yes')||($jobsData->post_anonymous=='No')){?>checked=""<?php }?>>
								<label class="custom-control-label" for="customCheckBox" style="margin-top:5px;font-size:15px">Yes</label>
							</label>
							<label class="custom-control custom-checkbox">
								<input type="radio" class="custom-control-input" name="postanonymous" value="No" id="customCheckBox" <?php if($jobsData->post_anonymous=='No'){?>checked=""<?php }?>>
								<label class="custom-control-label" for="customCheckBox" style="margin-top:5px;font-size:15px">No</label>
							</label>
						</div>
                    </div>

                    
                </div></form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-edit" onclick="javascript:edit_form_submit('edit_frm_<?php echo $jobsData->id;?>')">Save</button>
							<!--<button type="button" class="btn btn-primary" onclick="javascript:edit_form_submit2('edit_frm_<?php echo $jobsData->id;?>');">Save</button>-->
						</div>
					</div>
				</div>
			</div>
        
        
        </div>
		<?php
			}
		}
		?>
		
		
<?php
	$li_job_count = count($posted_jobs_count);
	$ITEM_PRODACT = 2;
    if ($li_job_count > $ITEM_PRODACT) {
        $totalPage = (($li_job_count % $ITEM_PRODACT) == 0) ? intval($li_job_count / $ITEM_PRODACT) : (intval($li_job_count / $ITEM_PRODACT) + 1);
        $url = base_url("products/list//" . "?pg=");
        ?>
        <div class="pager_content">
            <ul class="pagination justify-content-center">
                <?php
                if ($currentPage > 1) {
                    ?>
                    <li class="page-item prev">
                        <a class="page-link" id="<?= ($currentPage - 1) ?>_myJob_pre" >
                            <img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
                        </a>
                    </li>
                    <?php
                }

                for ($i = 1; $i <= $totalPage; $i++) {
                    $activetab = ($currentPage == $i) ? "activetab" : "";
                    ?>
                    <li class="page-item <?= $activetab ?>"><a class="page-link" id="<?= $i ?>_myJob" ><?= $i; ?></a></li>
                    <?php
                }

                if ($currentPage < $totalPage) {
                    ?>
                    <li class="page-item next">
                        <a class="page-link" id="<?= $currentPage + 1 ?>_myJob_next">
                            <img src="<?= UPLOADPATH . "../frontend/images/next.png" ?>" alt="Next" />
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php
    }
    ?>




    </div>
    <script>
    function show_edit_jobs(jobid){
        $("#myModal_"+jobid).modal('show');
    }
    function edit_form_submit(formid){
        //alert(formid);
        //jQuery("#"+formid).submit();
        $.ajax({
                url: '<?php echo base_url("user/update_job_details/"); ?>',
                type: 'post',
                dataType: 'json',
                data: $("#"+formid).serialize(),

                async: false,
                success: function (response) {
					console.log(response);
                    if (response.success) {
                        addImgCount = 1;
                        $('body').find(".edit_jobfrm_modal").modal('hide');
                       
                        toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                        setTimeout(function(){location.href="<?php echo base_url("user/profile/"); ?>"} , 1000);   
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });


            //e.preventDefault();
            
            return false;
        
        
        
        
        
        
        
        
    }
	function edit_form_submit2(formid){
        //alert(formid);
        jQuery("#"+formid).submit();
        
        
        
        
        
        
        
        
        
    }
    
		function autocity_search(job_id){
			var txt = 'autocomplete_search_text_'+job_id;
			var location_autocomplete_list= 'location_autocomplete_list_'+job_id;
			var searchVal = $("#"+txt).val();
			$.ajax({
				url: '<?php echo base_url("user/location_autocomplete_search2"); ?>',
				type: 'post',
				dataType: 'json',
				data: {'searchVal': searchVal,'job_id':job_id},
				async: false,
				success: function (response) {
					console.log(response);
					if (response.success) {
						$('body').find("#"+location_autocomplete_list).show();
						$('body').find("#"+location_autocomplete_list).html(response.data);

					} else {
						toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
					}

				}
			});
			
		}
		function select_city(job_id,city_id)
		{
			var selector = jQuery('#location_autocomplete_list_'+job_id+" ul #"+city_id);
			var thisId = selector.attr('id');
			var thisVal = selector.html();
			
			var cityName = thisVal.replace('<b>', '');
			cityName = cityName.replace('</b>', '', );
			var appendText = '<span class="selected_location_span" id="'+thisId+'">\n\
                    <input type="hidden" class="selected_location_input" name="location_id[]" value="' + thisId + '" readonly="">' + cityName + '\
                    <i class="fa fa-times remove_selected_location"></i>\n\
                    </span>';
					//alert("#selected_location_autocomplete_"+job_id);
					if ($("#selected_location_autocomplete_"+job_id+" #"+thisId).length==0) {
						$("#selected_location_autocomplete_"+job_id).append(appendText);
					}
					$("#autocomplete_search_text_"+job_id).val('');
					$('body').find('#location_autocomplete_list_'+job_id).hide();
			
			
		}
		function remove_city(job_id,span_id){
			//alert(job_id);
			//alert(span_id);
			var div_id = "selected_location_autocomplete_"+job_id;
			jQuery("#"+div_id+" #"+span_id).remove();
		}
</script>
<script>
	$('body').on('click', '.job_posting_dashboard .page-link', function () {
			var sort_by = 'latest';
            //$('body').find(".job_posting_dashboard .fa-spinner").show();
            var thisId = $(this).attr('id');
            var pageId = thisId.split('_')[0];
            carrentPage = pageId;
            ajax_my_jobs(pageId, sort_by);

        });
    function ajax_my_jobs(pageId, sort_by = '') {
        $.ajax({
            url: '<?php echo base_url("user/ajax_my_jobs?pg="); ?>' + pageId,
            type: 'post',
            dataType: 'json',
            data: {'sort_by': sort_by},
            async: false,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    $('body').find(".job_posting_dashboard").html(response.data);
                } else {
                    toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                }

            }
        });

    }
</script>