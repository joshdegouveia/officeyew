<style>
.chkboxInline .custom-control {
    display: inline-flex;
    margin: 0 0 15px 0;
    align-items: center;
    padding-left: 30px;
    width: 30% !important;
}
</style>

<div class="modal fade" id="addjobs" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Jobs</h5>
                <img class="close closeicon2" data-dismiss="modal" aria-label="Close" src="../assets/frontend/images/closeicon.png" alt="" />
            </div>
            <form id="upload_jobs_form" method="post" action=""   >
                <input type="hidden" name="productId" value="" id="productId">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Job Title" />
                    </div>

                    <div class="form-group">
                        <textarea   class="form-control" name="long_description" id="long_description" placeholder="Job description"></textarea>
                    </div>
					   <span style="font-size:16px !important;color:#a4a4a4;"> Salary range</span>
					  <div class="inp_row3 col-md-12 " >
						 <div class="form-group col-md-6" style="padding:0;margin:3px">
							<input type="text" class="form-control" name="minsal" id="minsal" placeholder="Minimum" />
						</div>
						<div class="form-group col-md-6" style="padding:0;margin:3px">
							<input type="text" class="form-control" name="maxsal" id="maxsal" placeholder="Maximum" />
						</div>
                    </div>
					 <div class="form-group">
                        <input type="text" class="form-control" name="educationlevel" id="educationlevel" placeholder="Education Level" />
                    </div>
					<div class="form-group">
                   		<select name="years_of_experience" class="years_of_experience form-control">
                            <option value="">Years Of Experience</option>
                            <?php for ($i = 1; $i <= 10; $i++) { ?>
                                <option value="<?= $i ?>"><?= $i ?> Years</option>
                            <?php } ?>   
                            <option value="11">10+ Years</option> 
                        </select>
                    </div>
					 <div class="form-group">
                        <!--<input type="text" class="form-control" name="location" id="location" placeholder="Location" />-->
                        <input type="text" class="form-control location_autocomplete_search_jobposting_input" name="" placeholder="Search city name">
                        <div class="location_autocomplete_list"></div>
                    </div>
					<div class="selected_location_autocomplete jobs_autocomplete">
                        <!--<input type="text" class="selected_location_input" name="location_id[]" readonly="">-->
                    </div>
					<div class="form-group">
                   		<select name="designation" class="designation form-control">
                            <option value="">Designation</option>
                            <option value="Executive">Executive</option>
							<option value="Accounting">Accounting</option> 
							<!--<option value="Accounting">Accounting</option> -->
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
                    <div class="form-group">
                        <input type="text" class="form-control" name="travelreq" id="travelreq" placeholder="Travel Required" />
                    </div>
                    
                    <div class="inp_row3 col-md-12">
                        <span class="col-md-6" style="font-size:16px !important"> Post Anonymous</span>
                      	<div class="form-group chkboxInline col-md-6">
							<label class="custom-control custom-checkbox">
								<input type="radio" class="custom-control-input" name="postanonymous" value="Yes"  id="customCheckBox" checked>
								<label class="custom-control-label" for="customCheckBox"style="margin-top:5px;font-size:15px">Yes</label>
							</label>
							<label class="custom-control custom-checkbox">
								<input type="radio" class="custom-control-input" name="postanonymous" value="No"  id="customCheckBox" >
								<label class="custom-control-label" for="customCheckBox"style="margin-top:5px;font-size:15px">No</label>
							</label>
						</div>
                    </div>

                    <div class="def_btn_cap">
                        <button type="submit" class="add_more_image_modal_1" style="width:300px !important;font-size:16px !important" id="">Submit</button>
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
<script>
$(function(){
    $("#upload_jobs_form").submit(function(){
		$.ajax({
                url: '<?php echo base_url("user/upload_job_form/"); ?>',
                type: 'post',
                dataType: 'json',
                data: $("#upload_jobs_form").serialize(),

                async: false,
                success: function (response) {
					console.log(response);
                    if (response.success) {
                        addImgCount = 1;
                        
                        $('body').find("#addjobs").modal('hide');
                        /*if (addOrEdit == 'add') {
                            ajax_my_product(1);
                        } else {
                            ajax_my_product(carrentPage);
                        }*/
                        toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
	                     //window.setTimeout(function () {
                         //window.location.href = "<?php // echo base_url("user/profile/") ?>";
						//window.location.href = "<?php // echo base_url("products/details/")?>" + response.data.product_id + "/"+ response.data.name;
                       //}, 10000);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });


            e.preventDefault();
            return false;

    });
});
$('body').on('keyup', '.location_autocomplete_search_jobposting_input', function (e) {
            var searchVal = $(".location_autocomplete_search_jobposting_input").val();
            e.preventDefault(); // Ensure it is only this code that rusn

            $.ajax({
                url: '<?php echo base_url("user/location_autocomplete_search"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'searchVal': searchVal},
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find(".location_autocomplete_list").show();
                        $('body').find(".location_autocomplete_list").html(response.data);
                        
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });


        });
        $('body').on('click', '.auto_location_city_name', function () {
            var thisId = $(this).attr('id');
            var thisVal = $(this).html();

            var cityName = thisVal.replace('<b>', '');
            cityName = cityName.replace('</b>', '', );
            var appendText = '<span class="selected_location_span" id="'+thisId+'">\n\
                    <input type="hidden" class="selected_location_input" name="location_id[]" value="' + thisId + '" readonly="">' + cityName + '\
                    <i class="fa fa-times remove_selected_location"></i>\n\
                    </span>';
            $(".selected_location_autocomplete").append(appendText);
            $(".location_autocomplete_search_jobposting_input").val('');
            $('body').find(".location_autocomplete_list").hide();
        });
        $('body').on('click', '.remove_selected_location', function () {
            $(this).closest('.selected_location_span').remove();
        });
        
</script>