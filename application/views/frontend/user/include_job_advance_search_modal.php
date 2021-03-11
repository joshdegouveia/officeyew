<style>
.chkboxInline .custom-control {
    display: inline-flex;
    margin: 0 0 15px 0;
    align-items: center;
    padding-left: 30px;
    width: 30% !important;
}
</style>

<div class="modal fade" id="advancejobsearch" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Advanced Search</h5>
                <img class="close closeicon2" data-dismiss="modal" aria-label="Close" src="../assets/frontend/images/closeicon.png" alt="" />
            </div>
            <form id="upload_job_advance_form" action="<?php echo base_url("user/candidate_dashboard_employer_job_advance_search"); ?>" method="get">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="job_title" id="job_title" placeholder="Job Title" />
                    </div>
                    <div class="form-group">
                        <textarea   class="form-control" name="job_description" id="job_description" placeholder="Job description"></textarea>
                    </div>
                    <div class="form-group">
                   		<select name="experience" class="years_of_experience form-control">
                            <option value="">Experience</option>
                            <?php for ($i = 1; $i <= 10; $i++) { ?>
                                <option value="<?= $i ?>"><?= $i ?> Years</option>
                            <?php } ?>   
                            <option value="11">10+ Years</option> 
                        </select>
                    </div>
					 <!--<div class="form-group">
                        <input type="text" class="form-control" name="preferred_location" id="preferred_location" placeholder="Location" />
                    </div>-->
					  <div class="form-group">
                   		<select name="designation" class="years_of_experience form-control">
                            <option value="">Designation</option>
                            <option value="Executive">Executive</option>
							<option value="Accounting">Accounting</option> 
							<option value="Sales Management">Sales Management</option> 
							<option value="Inside Sales">Inside Sales</option> 
							<option value="Administration">Administration</option> 
							<option value="Marketing">Marketing</option> 
							<option value="Service">Service</option> 
							<option value="Designer">Designer</option> 
							<option value="Installer">Installer</option> 
							<option value="Other">Other</option>
                        </select>
                    </div>
					<div class="form-group">
                        <input type="text" class="form-control" name="avl_time_frame" id="avl_time_frame" placeholder="Availability Time-Frame" />
                    </div>
                    <!--<div class="inp_row3">
                        <span style="font-size:20px !important"> Travel:</span>
                      	<div class="form-group chkboxInline">
							<label class="custom-control custom-checkbox">
								<input type="radio" class="custom-control-input" name="travel_required" value="Yes"  id="customCheckBox" checked>
								<label class="custom-control-label" for="customCheckBox"style="margin-top:5px;font-size:15px">Yes</label>
							</label>
							<label class="custom-control custom-checkbox">
								<input type="radio" class="custom-control-input" name="travel_required" value="No"  id="customCheckBox" >
								<label class="custom-control-label" for="customCheckBox"style="margin-top:5px;font-size:15px">No</label>
							</label>
						</div>
                    </div>-->

                    <div class="def_btn_cap">
                        <button type="submit" class="add_more_image_modal_1" style="width:200px !important;font-size:18px !important" id="">Advanced Search</button>
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