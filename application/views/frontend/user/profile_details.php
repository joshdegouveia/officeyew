<!-- Banner start -->

<!--<section class="banner-hold-wrapper bg2">
    <section class="seahching-hold-wrap prod_search padd-tb60 details_bg">
        <div class="container">

        </div>
    </section>
</section>-->
<!-- Banner End -->

<?php
$path = BASE_URL . 'assets/upload/user/profile/no_img.png';
if ($lo_userDetail->filename != '') {
    $path = BASE_URL . 'assets/upload/user/profile/' . $lo_userDetail->filename;
}

?> 
<?php $fav_group = $this->uri->segment(2);?>
<!-- Office Furniture Categories start-->
<section class="product_details_info">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="product_details_area">
                    <div class="product_cont_left">
                        <div class="bradcam_details">

                            <span><a href="<?php echo base_url("$userType") ?>"> <?php echo ucfirst($userType) ?></a></span>
                            <span class="activePage"><a href="<?php echo base_url("profile-details/$userType/$userId") ?>"> <?php echo $lo_userDetail->first_name . " " . $lo_userDetail->last_name; ?></a></span>

                        </div>
                        <div class="product_lft_cont">


                            <div class="prod_slider">
                                <div id="sync1" class="">
                                    <div class="item">
                                        <img src="<?php echo $path; ?>" style="max-height:300px !important;width:auto !important" alt="<?= $lo_userDetail->first_name . " " . $lo_userDetail->last_name ?>" />
                                    </div>


                                </div>

                            </div>
                            <div class="product_des">


                                <div class="prodect_des_info">
                                    <ul>
                                        <li>Business Name: <span><?php echo (isset($user_business->company_name)) ? $user_business->company_name : "--" ?></span></li>
                                        <li>Year of Experience: <span><?php echo isset($user_business->years_of_experience) ? "$user_business->years_of_experience years" : ""; ?></span></li>
                                        <li>Insured : <span><?php echo isset($user_business->insured) ? $user_business->insured : "--" ?></span></li>
                                        <li>License and Bonded: <span><?php echo isset($user_business->license_and_bonded) ? $user_business->license_and_bonded : "--" ?></span></li>
                                        <li>Business Address: <span><?php echo isset($user_business->company_address) ? $user_business->company_address : "--" ?></span></li>
                                        <li>Business location: <span><?php echo isset($user_business->business_locations) ? $user_business->business_locations : "--" ?></span></li>
										<?php
											
											if($this->uri->segment(2) == 'installer'){
											$get_service_array = explode(",",$user_business->ins_service);
											$search = array(",Other: Explain","Other: Explain,","Other: Explain");
											$replace = array("","","");

											
											//$found = array_search('Other: Explain', array_keys($get_service_array));
											//unset($get_service_array[$found]); 
											
											
										?>
											<li>Installation Services  : <span><?php echo isset($user_business->ins_service) ? str_replace($search,$replace, $user_business->ins_service) : "--" ?> <?php echo $user_business->business_services_info != ''?$user_business->business_services_info:''?></span></li>
										<?php
										}else{
											$search_business = array(",Other: Explain","Other: Explain,","Other: Explain");
											$replace_business = array("","","");
										?>
											<li>Interior Design Specialty : <span><?php echo isset($user_business->business_services) ?str_replace($search_business,$replace_business, $user_business->business_services) : "--" ?><?php echo $user_business->business_services_info != ''?$user_business->business_services_info:''?></span></li>
										<?php
										}
										?>
                                        <!--<li> <?php echo (($this->uri->segment(2) == 'installer')?'Installation Services':'Interior Design Specialty');?>: <span><?php echo isset($user_business->business_services) ? $user_business->business_services : "--" ?></span></li>-->
                                    </ul>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="product_cont_right">
                        <div class="purchase_request">
                            <?php
                            if (isset($my_favorites->favorites_user_id)) {
                                ?>
                                <a href="#" id="favorite_button_user_profile" class="def_btn3 active_favorite_btn"><i class="fa fa-heart"></i> Favorite</a>
                            <?php } else {
                                ?>
                                <a href="#" id="favorite_button_user_profile" class="def_btn3"><i class="fa fa-heart-o"></i> Favorite</a>    
                                <?php
                            }
                            ?>
                            <!--<a href="#" class="sell-btn purchase_request_on_product_details">Purchase Request</a>-->
                        </div>

                        <!--                        <div class="inp_form_details">
                        <?php
                        if ((isset($user['id']) && ($user['id'] != ''))) {
                            ?>
                            <?php $this->load->view('frontend/products/include_product_purchase.php'); ?>
                            <?php
                        }
                        ?>
                                                </div>-->


                        <!--                        <div class="inp_form_details">
                                                    <form id=" " class="form-horizontal message_to_seller_form" method="post">
                                                        <div class="form-details">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="subject" placeholder="Full Name*" />
                                                            </div>
                        
                                                            <div class="form-group">
                                                                <textarea class="form-control" name="message" placeholder="Message*"></textarea>
                        
                                                            </div>
                        
                                                            <div class="form-group">
                                                                <div class="submitBtn"><button type="button" class="btn btn-default message_to_user_pro_form_btn">Message <?php echo ucfirst($userType) ?></button></div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>-->


                    </div>
                </div>

            </div>
        </div>
    </div>
</section>



<!--<div class="submitBtn" ><a href="<?php // echo base_url("products/product-purchase/$productId/" . name_to_url($productName))                                     ?>"><button type="button" id="" class = "btn btn-default">Send purchase request</button></a></div>-->



<script>
    $(document).ready(function () {
        $('body').on('click', '#favorite_button_user_profile', function () {
            $.ajax({
                url: '<?php echo base_url("user/add_favorite_user/$userId/$fav_group"); ?>',
                type: 'post',
                dataType: 'json',
                data: '',

                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $("#favorite_button_user_profile").html(response.text);
                        if (response.flag == 'add') {
                            $("#favorite_button_user_profile").addClass('active_favorite_btn');
                        } else {
                            $("#favorite_button_user_profile").removeClass('active_favorite_btn');
                        }
                        toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });


        $('body').on('click', '.purchase_request_on_product_details', function () {

            $(".message_to_seller_form").slideToggle();
            $("#send_purchase_request_form_content").slideToggle();
        });


        $('body').on('click', '.message_to_user_pro_form_btn', function () {
            $.ajax({
                url: '<?php // echo base_url("products/message_to_seller/$productId/$sellerId");          ?>',
                type: 'post',
                dataType: 'json',
                data: $(".message_to_seller_form").serialize(),

                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $(".message_to_seller_form input, .message_to_seller_form textarea").val('');
//                        
                        toaster_msg('success', '<i class="fa fa-check"></i> ', response.msg);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });
    });
</script>



