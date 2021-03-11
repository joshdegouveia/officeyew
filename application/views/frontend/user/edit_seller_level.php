<!-- Designer search cont start-->
<section class="designer_search_min-cont">
    <div class="container">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#Service-Request-Form" role="tab" aria-controls="pills-home" aria-selected="true">Service Request Form</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#Select-Designer" role="tab" aria-controls="pills-profile" aria-selected="false">Select Designer</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="Service-Request-Form" >
                <?php
                if ($loggedId == 0) {
                    ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong>Please login for submit Service Request</strong>
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
                <form class="Service-Request-Form-details" method="post" id="sbumit_design_part1" enctype="multipart/form-data">
                    <h3>
                        Service Request
                    </h3>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <textarea class="form-control" placeholder="Enter a request message..." rows="3" name="message"></textarea >
                        </div>
                        <div class="form-group col-sm-6">
                            <select class="form-control" name="request_type" required>
                                <option value="">-- Request Type --</option>
                                <option value="home">Home</option>
                                <option value="business">Business Office</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <div class="Space-planning">
                                <div class="Space-planning-left">
                                    Space planning needed:
                                </div>
                                <div class="Space-planning-right">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="space_planning_needed" value="No" >
                                        <span class="label-after">
                                            <span class="dot"></span>
                                        </span>
                                        <label class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="space_planning_needed" value="Yes" >
                                        <span class="label-after">
                                            <span class="dot"></span>
                                        </span>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="form-group col-sm-6">
                            <input class="form-control" type="text" placeholder="Space/office size Sq ft" name="space_size">
                        </div>
                        <div class="form-group col-sm-6">
                            <input class="form-control" type="text" placeholder="Project scope" name="project_scope">
                        </div>
                        <div class="form-group col-sm-6">
                            <input class="form-control" type="text" placeholder="What do you want to achieve with this space" name="acheive_space">
                        </div>
                        <div class="form-group col-sm-6">
                            <input class="form-control" type="text" placeholder="Style preference" name="style_preference">
                        </div>
                        <div class="form-group col-sm-6">
                            <input class="form-control" type="text" placeholder="Technology requirements" name="technology_requirement">
                        </div>
                        <div class="form-group col-sm-6">
                            <input class="form-control" type="text" placeholder="Construction involved" name="construction_involved">
                        </div>
                        <div class="form-group col-sm-6">
                            <input class="form-control" type="text" placeholder="Time frame" name="time_frame">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="formGroupExampleInput">Check off Areas required for Furniture:</label>
                            <ul>
                                <?php
                                foreach ($la_designerArea as $designerArea) {
                                    ?>

                                    <li><input class="form-check-input" type="checkbox" name="area_required[]" value="<?= $designerArea->designer_area_id ?>">
                                        <span class="label-after">
                                            <span class="dot"></span>
                                        </span>
                                        <label class="form-check-label" ><?= $designerArea->name ?></label>
                                    </li>
                                    <?php
                                }
                                ?>  
                            </ul>
                        </div>
<!--                        <div class="form-group col-sm-12">
                            <label for="formGroupExampleInput">Collaboration:</label>
                            <ul>
                                <?php
                                foreach ($la_collaboration as $row) {
                                    ?>

                                    <li><input class="form-check-input" type="checkbox" name="collaboration[]" value="<?= $row->collaboration_id ?>">
                                        <span class="label-after">
                                            <span class="dot"></span>
                                        </span>
                                        <label class="form-check-label" ><?= $row->collaboration ?></label>
                                    </li>
                                    <?php
                                }
                                ?>  
                            </ul>
                        </div>-->
                        <div class="form-group col-sm-12">
                            <button type="submit" class="btn btn-primary" id="next">Next</button>
                           <!--  <span  class="btn btn-primary profile-tab" >Next</span>
                           
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#Select-Designer" role="tab" aria-controls="pills-profile" aria-selected="false">Select Designer</a> -->

                        </div>

                    </div>


                </form>
            </div>

            <div class="tab-pane fade" id="Select-Designer">
                <form action="<?php echo base_url('user/updateDesignerId'); ?>" class="Select-Designer" method="post">
                    <div class="select-all">
                        <input class="form-check-input" type="checkbox" value="option1">
                        <span class="label-after">
                            <span class="dot"></span>
                        </span>
                        <label class="form-check-label" >Select All</label>
                    </div>
                    <div class="row">
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
                                <div class="col-sm-3">
                                    <div class="select-des-det " id="<?php echo $usersData->id ?>">
                                        <input type="checkbox" value="<?php echo $usersData->id ?>" hidden name="user[]">
                                        <div class="select-top"><img src="<?= $path; ?>" alt="<?= $usersData->first_name ?>"></div>
                                        <div class="select-center-design">
                                            <h3><?= $usersData->first_name . " " . $usersData->last_name ?></h3>
                                            <!--<p>Expert in office cubicle installation</p>-->
                                        </div>
                                        <div class="select-bottom-design">
                                            <a href="<?php echo base_url("profile-details/$usersData->user_type/$usersData->id"); ?>" target="_blank" class="btn ">View Profile</a>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>
                        <div class="col-sm-12">
                            <input type="hidden" name="request_id" id="uid" value="0">
                            <button type="submit"  class="submit-servi" style="cursor: pointer;">Submit Service Request</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
<!-- Content end -->


<?php $this->load->view('frontend/user/include_script/include_designer_installer_service_request_js.php'); ?> 
<?php $this->load->view('frontend/products/include_script/include_search_product_script.php'); ?>
<?php $this->load->view('frontend/user/include_script/include_search_designer_script.php'); ?>


<script type="text/javascript">



</script>
