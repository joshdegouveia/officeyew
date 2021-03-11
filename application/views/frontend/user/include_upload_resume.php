 <style>
 .custom-file-control2.imageclass:{
 	position: absolute !important;
    left: 10px !important;
    top: 8px !important;
	padding: 4px 15px !important;
    top: 3px !important;
 }
 </style>
 
 <div class="content_right job_posting_dashboard">
        <!-- card box start -->
		<form id="" class="profile_resume_upload_form" enctype="multipart/form-data" action="<?php echo base_url('/user/profile_resume_upload'); ?>" method="post">
		<!--<form id="" class="profile_resume_upload_form" enctype="multipart/form-data"  method="post">-->
		
        <div class="inner_cont_blog">
			<div class="row">
					<?php
					if($candidateDetailsData){
						if ($candidateDetailsData->candidate_resume != '') {
							$path = BASE_URL . 'assets/upload/user/resume/' . $candidateDetailsData->candidate_resume;
						}
						if($candidateDetailsData->candidate_resume != '') {
					?>
						<a href="<?php echo $path?>" target="_blank" style="color:#760091;font-size:14px;margin-bottom:10px;cursor:pointer">Download Resume <?php echo $candidateDetailsData->candidate_resume ?> </a>
					<?php
					}else {
					?>
						<p style="color:#760091;font-size:14px;margin-bottom:10px">No Resume Uploaded Yet</p>
					<?php
					}
					}else{
					?>
						<p style="color:#760091;font-size:14px;margin-bottom:10px">No Resume Uploaded Yet</p>
					<?php
					}
					?>
					
					<div class="form-group col-md-10" style="padding:0 !important;">
						<label class="custom-file" id="customFile">
							<input type="file" class="custom-file-input filename_thumb" name="resume_image" id="resume_image" aria-describedby="fileHelp" accept="pdf/*">
							<span class="custom-file-control2 form-control-file2"></span>
						</label>
					</div>
					<div class="col-md-2" style="padding-left:5px !important;">
						<button type="submit" class="resume_upload" id="upload_resume_btn">Upload</button>
					</div>
			</div>
        </div>
	
		</form>
    </div>

<script>
$("document").ready(function(){
    $("#resume_image").change(function(e) {
		var filename = e.target.files[0].name; 
		var ext = filename.split(".");
		ext = ext[ext.length-1].toLowerCase(); 
		var arrayExtensions = ["pdf" , "doc", "docs","txt"];
		 if (arrayExtensions.lastIndexOf(ext) == -1) {
				toaster_msg('danger', '<i class="fa fa-exclamation"></i>', 'Only Pdf,Docs and Txt File Allowed');
				$("#resume_image").val("");
		}else{
			$(".custom-file-control2").addClass("selected");
			$(".custom-file-control2").addClass("imageclass");
			$(".custom-file-control2").html(filename);
		}
    });

 /*$('body').on('click', '#upload_resume_btn', function () {
	$.ajax({
		    url: '<?php echo base_url('/user/profile_resume_upload_another'); ?>',
			type: 'post',
            dataType: 'json',
            data: $(".profile_resume_upload_form").submit(),
            async: false,
			success: function (response) {
			alert(response);
			if (response.success) {

				toaster_msg('success', '<i class="fa fa-check"></i>', 'Resume has been successfully update.');
			} else {
				toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
			}
		  }
	})
 });*/
});
</script>
