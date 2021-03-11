 
<script>
    $(document).ready(function () {  

        $(".select-all input, form.Service-Request-Form-details .form-group ul li input.form-check-input").click(function(){
                //alert("okk");
            $(this).next().toggleClass("act");
        });
        $("form.Service-Request-Form-details .form-group .Space-planning .form-check.form-check-inline input.form-check-input").click(function(){
            $("form.Service-Request-Form-details .form-group .Space-planning .form-check.form-check-inline input.form-check-input").next().not(this).removeClass("act");
            $(this).next().addClass("act");
        });

        $('.select-des-det').click(function(){
            $(this).find("input").trigger("click");
            
        });
        jQuery("body").find('.select-des-det > input[type="checkbox"]').click(function(){
			var chk_val = $(this).val();
			if ($(this).prop("checked") == true) {
				if(jQuery("#sbumit_design_part1 #chk_"+chk_val).length == 0){
				jQuery("#sbumit_design_part1").append('<input type="hidden" id="chk_'+chk_val+'" class="chk_val" name=userr[] value="'+chk_val+'">');
				}
                $(this).parent().not(this).removeClass("active");
                $(this).parent().addClass("active");
                    //alert(id_n);
            }
            else if($(this).prop("checked") == false){
                $(this).parent().removeClass("active");
				jQuery("#sbumit_design_part1").find("#chk_"+chk_val).remove();
            }
           
            // $(this).find("input").trigger("click");
            
        });
        jQuery("body").find('.select-des-det').each(function(e){
			var Id = jQuery(this).attr("id");
			console.log(Id);
			var chk_val ='chk_'+Id;
			if(jQuery("#sbumit_design_part1 #"+chk_val).length> 0){
				jQuery(this).addClass('active');
			}
			
		});
        // $('.select-all input[type="checkbox"]').click(function(){
        //     $('.select-des-det > input[type="checkbox"]').trigger("click"); 
        //     if($('.select-des-det > input[type="checkbox"]').prop("checked") == true){
                
        //         $(this).parent().not(this).removeClass("active");
        //         //alert(id_n);
        //     }      
            
        // });

        $('.select-all input[type="checkbox"]').click(function(){
        
            if($('.select-des-det > input[type="checkbox"]').prop("checked") == false){
                $('.select-des-det > input:not(:checked)').trigger("click"); 
            }
                
            if($('.select-all input[type="checkbox"]').prop("checked") == false){
                $('.select-des-det > input:checked').trigger("click"); 
            }
        });

        $('.profile-tab').click(function(){
            $("#pills-profile-tab").trigger("click");
        });




        $('#sbumit_design_part1').submit(function (e) { 
         //alert('okk');
            var formdata = new FormData($('#sbumit_design_part1')[0]);
            //console.log(formdata);return false;
            $.ajax({
                url: '<?php echo base_url("user/addDesignerRequest/"); ?>',
                type: 'post',
                dataType: 'json',
                data: formdata,

                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        if(response.success == true){
                            toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                            $('#uid').val(response.id);
                            $('#pills-profile-tab').click();
                            $('#next').prop("disabled", true);
                        }else{
                            toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                        }
                        
                    }else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
            e.preventDefault();
            return false;
        });






    });
</script>