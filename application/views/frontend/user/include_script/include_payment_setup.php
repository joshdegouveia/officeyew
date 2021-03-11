<style>
.image-contan{
	border:1px dashed #ccc;
	height:200px;
	border-radius:10px;

}
.img{
	height:100px;
	
	margin-top:25px;
	
	
}
.title{
	text-align:center;
	padding:10px;
	margin-top:10px;
}
.highlight{
	font-weight:bold;
}
</style>

<div class="content_right job_posting_dashboard" style="margin-top:20px;">
        <!-- card box start -->
		
		<!--<form id="" class="profile_resume_upload_form" enctype="multipart/form-data"  method="post">-->
		<div class="change_password">
			<h4 style="line-height:50px;font-size:20px;"> Upload Identity Document</h4>
			<form  class="identity_doc_upload_form" enctype="multipart/form-data" action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="image-contan" >
						<p style="text-align:center;">
							 <?php
									$path = BASE_URL . 'assets/frontend/images/upload.png';
									if ($paymentDetailsData->front_file != '') {
										$path = BASE_URL . 'assets/upload/user/stripedoc/' . $paymentDetailsData->front_file;
									}
								?>
							<img src="<?php echo $path;?>"  id="OpenFrontUpload" class="img">
						</p>
						<div class="title">
							<p class="">Click To Upload</p>
							<p class="highlight">Upload Front Side Of Your Document</p>
							<input Type="file" id="front-file" name="front-file" style="display:none" aria-describedby="fileHelp">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="image-contan">
						<p style="text-align:center;">
						<?php
							$backpath = BASE_URL . 'assets/frontend/images/upload.png';
							if ($paymentDetailsData->back_file != '') {
								$backpath = BASE_URL . 'assets/upload/user/stripedoc/' . $paymentDetailsData->back_file;
							}
						?>
						<img src="<?php echo $backpath;?>" class="img" id="OpenBackUpload">
						</p>
						<div class="title">
							<p class="">Click To Upload </p>
							<p class="highlight">Upload Back Side Of Your Document</p>
							<input type="file" id="back-file" name="back-file" style="display:none">
						</div>
					</div>
				</div>
				<div class="submitBtn" style="padding:20px;margin-top:20px">
					<button type = "button" id="identity_document_submit_btm" class = "btn btn-default" style="width:40%;">Save</button>
				</div>
			</div>
		</form>
	</div>
		<hr />
		<div class="change_password">
		<h4 style="line-height:50px;font-size:20px;"> Add Your Bank Details</h4>
		<form id="basicBootstrapForm " class="form-horizontal upload_bank_details_form" action="" method="post">
			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<input type="text" class="form-control" name="acc_number" value="<?php echo $paymentDetailsData->bank_account_number !== ''?$paymentDetailsData->bank_account_number:
							'';?>" placeholder="Enter Account Number"/>
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<input type="text" value="<?php echo $paymentDetailsData->bank_routing_number !== ''?$paymentDetailsData->bank_routing_number:
							'';?>" class="form-control" name="routing_number" placeholder="Enter Routing Number" />
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
			</div>       
			<div class="submitBtn" style="padding:20px">
				<button type = "button" id="bank_details_submit_btm" class = "btn btn-default" style="width:40%;">Save</button>
			</div>
		</form>
		<hr />
		<h4 style="line-height:50px;font-size:20px;"> Connect With Gateway</h4>
		<div class="row">
				
				<div class="form-group col-md-12 text-center image" style="padding:20px">
					<p style="text-align:center;">
						<?php
							if(isset($paymentDetailsData->stripe_account_id) && $paymentDetailsData->stripe_account_id != ''){
						?>
							<button type = "button"  class = "btn btn-success" style="width:50%;padding:20px">Successfully Connected With Gateway</button>
						<?php
							}else{
						?>
						<img src="<?php echo base_url('assets/frontend/images/blue-on-light@3x.png');?>" id="stripe_btn"  style="height:50px !important" />
						<?php
							}
						?>
					</p>
				</div>
			</div>
	</div>
	
  
	
		
    </div>

<script>
	$("document").ready(function(){
		$('#stripe_btn').click(function () {
			alert('yoo')
			  $.ajax({
                url: '<?php echo base_url('/user/connectstripe'); ?>',
                type: 'post',
                dataType: 'json',
                async: false,
                success: function (response) {
                    if (response.success) {
						$('body').find("#stripe_btn").hide();
						toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }
                }
            });
		})

		$('#OpenFrontUpload').click(function(){ 
			$('#front-file').trigger('click'); 
		
		});
		$('body').on('change', '#front-file', function () {
			var filename = $('#front-file')[0].files[0]
			$('#OpenFrontUpload').attr('src', URL.createObjectURL(event.target.files[0]));
			
		});
      
		$('#OpenBackUpload').click(function(){ $('#back-file').trigger('click'); });

		$('body').on('change', '#back-file', function () {
			var filename = $('#back-file')[0].files[0]
			$('#OpenBackUpload').attr('src', URL.createObjectURL(event.target.files[0]));
			
	
		});

		
		

	})
</script>