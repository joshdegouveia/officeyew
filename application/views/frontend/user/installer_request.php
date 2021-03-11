<!-- Designer search cont start-->

<section class="designer_search_min-cont installer-request">
    <div class="container">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
			<li class="nav-item" role="presentation" id="role1">
				<a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#Select-Designer" role="tab" aria-controls="pills-profile" aria-selected="false">Select Installer</a>
			</li>
			<li class="nav-item" role="presentation" id="role2">
                <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#Service-Request-Form" role="tab" aria-controls="pills-home" aria-selected="true">Service Request Form</a>
            </li>
           
        </ul>
        <div class="tab-content" id="pills-tabContent">
			<div class="tab-pane fade show active" id="Select-Designer">
				<form action="<?php echo base_url('user/updateInstallerId'); ?>" class="Select-Designer" method="post">
					<div class="select-all">
						<input class="form-check-input" type="checkbox" value="option1">
						<span class="label-after">
							<span class="dot"></span>
						</span>
						<label class="form-check-label" >Select All</label>
					</div>
					<div class="row designer_wrapper installer-req-first-wrapper">
						<?php
			if (count($la_usersData) == 0) {
			?>
						<p class="no_data_found">No user available!</p>
						<?php
		} else {
			$noImgPath = BASE_URL . 'assets/upload/user/profile/no_img.png';
			foreach ($la_usersData as $usersData) {
				if ($usersData->filename != '') {
					$path = BASE_URL . 'assets/upload/user/profile/' . $usersData->filename;
				} else {
					$path = $noImgPath;
				}
			?>
						<div class="col-sm-3 designer_loop_wrapper">
							<div class="select-des-det " id="<?php echo $usersData->user_id ?>">
								<input type="checkbox" value="<?php echo $usersData->user_id ?>" hidden name="user[]">
								<div class="select-top"><img src="<?= $path; ?>" alt="<?= $usersData->first_name ?>"></div>
								<div class="select-center-design">
									<h3><?= $usersData->company_name; ?></h3>
									<!--<p>Expert in office cubicle installation</p>-->
								</div>
								<div class="select-bottom-design">
									<a href="<?php echo base_url("profile-details/$usersData->user_type/$usersData->user_id"); ?>" target="_blank" class="btn ">View Profile</a>
								</div>
							</div>
						</div>

						<?php
		}
	}
			?>
						<div class="col-sm-12">
							<input type="hidden" name="request_id" id="uid" value="0">
							<!--<button type="submit"  class="submit-servi" style="cursor: pointer;">Submit Service Request</button>-->
							<button type="button"  class="submit-servi" style="cursor: pointer;" onclick="javascript:check_designer();">Next</button>
						</div>



<?php
	$la_usersData_count = $la_usersData_count->user_count;
	$ITEM_PRODACT = 12;
    if ($la_usersData_count > $ITEM_PRODACT) {
        $totalPage = (($la_usersData_count % $ITEM_PRODACT) == 0) ? intval($la_usersData_count / $ITEM_PRODACT) : (intval($la_usersData_count / $ITEM_PRODACT) + 1);
        $url = base_url("products/list//" . "?pg=");
        ?>
        <div class="pager_content">
            <ul class="pagination justify-content-center">
                <?php
                if ($currentPage > 1) {
                    ?>
                    <li class="page-item prev">
                        <a class="page-link" id="<?= ($currentPage - 1) ?>_insReq_pre" >
                            <img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
                        </a>
                    </li>
                    <?php
                }

                for ($i = 1; $i <= $totalPage; $i++) {
                    $activetab = ($currentPage == $i) ? "activetab" : "";
                    ?>
                    <li class="page-item <?= $activetab ?>"><a class="page-link" id="<?= $i ?>_insReq" ><?= $i; ?></a></li>
                    <?php
                }

                if ($currentPage < $totalPage) {
                    ?>
                    <li class="page-item next">
                        <a class="page-link" id="<?= $currentPage + 1 ?>_insReq_next">
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
				</form>
			</div>
            <div class="tab-pane fade" id="Service-Request-Form" >
                <?php
                if ($loggedId == 0) {
                    ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong>Please login for submit installer request</strong>
                    </div>
                    <?php
                }

                if ($this->session->flashdata('msg_error')) {
                    ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
                    </div>
                <?php } else if ($this->session->flashdata('msg_success')) { ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-dismissible" role="alert" style="display: none;">
                        <strong></strong>
                    </div>
                <?php } ?>
                <form class="Service-Request-Form-details" method="post" id="sbumit_installer_request_form" enctype="multipart/form-data" 
					action="<?php echo base_url("user/addInstallerRequest/"); ?>">
                    <h3> Installer Request </h3>

                    <div class="row">
                        
                        <div class="form-group col-sm-12">
                            <div class="Space-planning request_sec_heading">
                                <div class=" ">Request Notes :</div>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <textarea class="form-control" placeholder="Enter request notes..." rows="3" name="comments_message"></textarea >
                        </div>


                        <div class='col-md-12 form-group' style="display: contents;">
                            <div class='col-md-6 form-group'>
                                <div class="form-group">

                                    <div class="form-group">
                                        <div class="Space-planning request_sec_heading">
                                            <div class=" ">Receiving :</div>
                                        </div>
                                    </div>

									<div class="form-group">
                                        <div class="Space-planning">
                                            <div class="Space-planning-left">Service required:</div>

                                            <div class="Space-planning-right">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="service_required[]" value="installation" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">Installation</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="service_required[]" value="pickup" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">Pick up</label>
                                                </div>

												 <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="service_required[]" value="delivery" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">Delivery</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="Space-planning">
                                            <div class="Space-planning-left">Loading dock available:</div>

                                            <div class="Space-planning-right">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="loading_dock_available" value="no" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">No</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="loading_dock_available" value="yes" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">Yes</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="Space-planning">
                                            <div class="Space-planning-left">Delivery site can accept 53 trailer:</div>

                                            <div class="Space-planning-right">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="delivery_site" value="no" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">No</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="delivery_site" value="yes" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">Yes</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="Space-planning">
                                            <div class="Space-planning-left">Restricted hours of use:</div>

                                            <div class="Space-planning-right">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="restricted_hours" value="no" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">No</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="restricted_hours" value="yes" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">Yes</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="Space-planning">
                                            <div class="Space-planning-left">Receiving hours:</div>

                                            <div class="Space-planning-right">
                                                <input class="form-control" placeholder="Enter receiving hours "  name="receiving_hours">
                                                <!--<textarea class="form-control" placeholder="Enter receiving hours " rows="1" name="receiving_hours"></textarea >-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class='col-md-6 form-group'>

                                <div class="form-group">

                                    <div class="form-group">
                                        <div class="Space-planning request_sec_heading">
                                            <div class=" ">Install Location :</div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="margin-bottom: 0px">
                                        <div class="Space-planning">
                                            <div class="Space-planning-left">Delivery made to which floor :</div>

                                            <div class="Space-planning-right">
                                                <input type="number" name="delivery_made_floor" style="width: 80px"> Floor(s)
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="Space-planning" style="padding-top: 0px">
                                            <div class="Space-planning-left">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="delivery_made_floor_type" value="one" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">One Room</label>
                                                </div>
                                            </div>
                                            <div class="Space-planning-right">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="delivery_made_floor_type" value="multiple" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">Multiple Rooms</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="Space-planning">
                                            <div class="Space-planning-left">Access to freight elevator:</div>

                                            <div class="Space-planning-right">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="access_to_freight" value="no" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">No</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="access_to_freight" value="yes" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">Yes</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="Space-planning">
                                            <div class="Space-planning-left">Access to passenger elevator:</div>

                                            <div class="Space-planning-right">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="access_to_passenger" value="no" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">No</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="access_to_passenger" value="yes" >
                                                    <span class="label-after"><span class="dot"></span></span>
                                                    <label class="form-check-label">Yes</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-6">



                            <div class="form-group">

                                <div class="form-group">
                                    <div class="Space-planning request_sec_heading">
                                        <div class="">Special Installation Considerations :</div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="Space-planning">
                                        <div class="Space-planning-left">Customer to remove existing furniture:</div>

                                        <div class="Space-planning-right">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="customer_to_remove" value="no" >
                                                <span class="label-after"><span class="dot"></span></span>
                                                <label class="form-check-label">No</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="customer_to_remove" value="yes" >
                                                <span class="label-after"><span class="dot"></span></span>
                                                <label class="form-check-label">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="Space-planning">
                                        <div class="Space-planning-left">Installer to remove existing equip:</div>

                                        <div class="Space-planning-right">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="installer_to_remove" value="no" >
                                                <span class="label-after"><span class="dot"></span></span>
                                                <label class="form-check-label">No</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="installer_to_remove" value="yes" >
                                                <span class="label-after"><span class="dot"></span></span>
                                                <label class="form-check-label">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="Space-planning">
                                        <div class="Space-planning-left">Dumpster provided by customer:</div>

                                        <div class="Space-planning-right">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="dumpster_provided_by_customer" value="no" >
                                                <span class="label-after"><span class="dot"></span></span>
                                                <label class="form-check-label">No</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="dumpster_provided_by_customer" value="yes" >
                                                <span class="label-after"><span class="dot"></span></span>
                                                <label class="form-check-label">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="Space-planning">
                                        <div class="Space-planning-left">Single phase installation:</div>

                                        <div class="Space-planning-right">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="single_phase_installation" value="no" >
                                                <span class="label-after"><span class="dot"></span></span>
                                                <label class="form-check-label">No</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="single_phase_installation" value="yes" >
                                                <span class="label-after"><span class="dot"></span></span>
                                                <label class="form-check-label">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="Space-planning">
                                        <div class="Space-planning-left">Multiple phase installation:</div>

                                        <div class="Space-planning-right">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="multiple_phase_installation" value="no" >
                                                <span class="label-after"><span class="dot"></span></span>
                                                <label class="form-check-label">No</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="multiple_phase_installation" value="yes" >
                                                <span class="label-after"><span class="dot"></span></span>
                                                <label class="form-check-label">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <textarea class="form-control" placeholder="If multiple phase, please describe..." rows="1" name="multiple_phase_installation_desc"></textarea >
                                </div>


                                <div class="form-group">
                                    <div class="Space-planning">
                                        <div class="Space-planning-left">Anchor product:</div>

                                        <div class="Space-planning-right">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="anchor_product" value="no" >
                                                <span class="label-after"><span class="dot"></span></span>
                                                <label class="form-check-label">No</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="anchor_product" value="yes" >
                                                <span class="label-after"><span class="dot"></span></span>
                                                <label class="form-check-label">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-sm-12">
                                    <textarea class="form-control" placeholder="If yes, please describe..." rows="1" name="anchor_product_desc"></textarea >
                                </div>




                                <div class="form-group">
                                    <div class="Space-planning">
                                        <div class="Space-planning-left">Insurance Cert:</div>

                                        <div class="Space-planning-right">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="insurance_cert" value="no" >
                                                <span class="label-after"><span class="dot"></span></span>
                                                <label class="form-check-label">No</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="insurance_cert" value="yes" >
                                                <span class="label-after"><span class="dot"></span></span>
                                                <label class="form-check-label">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-sm-12">
                                    <textarea class="form-control" placeholder="If yes, please describe..." rows="1" name="insurance_cert_desc"></textarea >
                                </div>

                            </div>

                        </div>


                        <div class="col-sm-6">




                            <!--<div class="form-group">-->

                            <div class="form-group">
                                <div class="Space-planning request_sec_heading">
                                    <div class="">Installation :</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="Space-planning">
                                    <div class="Space-planning-left">Non-union labor :</div>

                                    <div class="Space-planning-right">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="non_union_labor" value="no" >
                                            <span class="label-after"><span class="dot"></span></span>
                                            <label class="form-check-label">No</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="non_union_labor" value="yes" >
                                            <span class="label-after"><span class="dot"></span></span>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="Space-planning">
                                    <div class="Space-planning-left">Union/Prevailing Wage labor:</div>

                                    <div class="Space-planning-right">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="union_labor" value="no" >
                                            <span class="label-after"><span class="dot"></span></span>
                                            <label class="form-check-label">No</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="union_labor" value="yes" >
                                            <span class="label-after"><span class="dot"></span></span>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="Space-planning">
                                    <div class="Space-planning-left">Security clearance required:</div>

                                    <div class="Space-planning-right">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="security_clearance" value="no" >
                                            <span class="label-after"><span class="dot"></span></span>
                                            <label class="form-check-label">No</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="security_clearance" value="yes" >
                                            <span class="label-after"><span class="dot"></span></span>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <textarea class="form-control" placeholder="Enter a additional information..." rows="2" name="additional_info_desc"></textarea >
                            </div>


                            <div class="form-group">
                                <div class="Space-planning request_sec_heading">
                                    <div class=" ">Electrical Sources :</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="Space-planning">
                                    <div class="Space-planning-left">Wall Receptacle(s):</div>

                                    <div class="Space-planning-right">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="wall_receptacle" value="no" >
                                            <span class="label-after"><span class="dot"></span></span>
                                            <label class="form-check-label">No</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="wall_receptacle" value="yes" >
                                            <span class="label-after"><span class="dot"></span></span>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="Space-planning">
                                    <div class="Space-planning-left">Floor receptacle(s):</div>

                                    <div class="Space-planning-right">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="floor_receptacle" value="no" >
                                            <span class="label-after"><span class="dot"></span></span>
                                            <label class="form-check-label">No</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="floor_receptacle" value="yes" >
                                            <span class="label-after"><span class="dot"></span></span>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--</div>-->


                            <div class="form-group">
                                <div class="Space-planning">
                                    <div class="Space-planning-left">Ceiling:</div>

                                    <div class="Space-planning-right">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="ceiling" value="no" >
                                            <span class="label-after"><span class="dot"></span></span>
                                            <label class="form-check-label">No</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="ceiling" value="yes" >
                                            <span class="label-after"><span class="dot"></span></span>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group col-sm-12">
                                <textarea class="form-control" placeholder="Enter a additional information..." rows="2" name="additional_info_desc_celling"></textarea >
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <!--<button type="submit" class="btn btn-primary" id="submit_installer_request">Next</button>-->
							<button type="button"  class="submit-servi" style="cursor: pointer;" id="submit_installer_request">Submit Service Request</button>
                           <!--  <span  class="btn btn-primary profile-tab" >Next</span>
                           
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#Select-Designer" role="tab" aria-controls="pills-profile" aria-selected="false">Select Designer</a> -->

                        </div>

                    </div>


                </form>
            </div>


			

        </div>
    </div>

</section>
<!-- Content end -->

<!--<script>
    $(document).ready(function () {

    });
</script>-->

<?php $this->load->view('frontend/user/include_script/installer_request_js.php'); ?> 
<?php // $this->load->view('frontend/products/include_script/include_search_product_script.php'); ?>
<?php // $this->load->view('frontend/user/include_script/include_search_designer_script.php'); ?>
<?php // $this->load->view('frontend/user/include_script/include_designer_installer_service_request_js.php'); ?> 
<?php // $this->load->view('frontend/products/include_script/include_search_product_script.php'); ?>
<?php // $this->load->view('frontend/user/include_script/include_search_designer_script.php'); ?>

<script type="text/javascript">

	function  check_designer()
	{
		var designer_sel = jQuery(".designer_wrapper .designer_loop_wrapper .active").length;
		//alert(designer_sel);
		if (designer_sel == 0) {

			toaster_msg('danger', '<i class="fa fa-exclamation"></i>', 'Please select designer');
		} else {
			jQuery("#role2 a").trigger('click');
		}
	}

</script>
<script>
	$('body').on('click', '.installer-req-first-wrapper .page-link', function () {
		
			var sort_by = 'latest';
            //$('body').find(".installer-req-first-wrapper .fa-spinner").show();
            var thisId = $(this).attr('id');
            var pageId = thisId.split('_')[0];
            carrentPage = pageId;
            
            ajax_installer_request(pageId, sort_by);

        });
    function ajax_installer_request(pageId, sort_by = '') {
    	
        $.ajax({
            url: '<?php echo base_url("user/ajax_installer_request?pg="); ?>' + pageId,
            type: 'post',
            dataType: 'json',
            data: {'sort_by': sort_by},
            async: false,
            success: function (response) {
            	
                console.log(response);
                if (response.success) {
                    $('body').find(".installer-req-first-wrapper").html(response.data);
                } else {
                    toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                }

            }
        });

    }
</script>
