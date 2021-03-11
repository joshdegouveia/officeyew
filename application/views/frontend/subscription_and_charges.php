<!-- Office Furniture Categories start-->
<section class="ofc-hold-wrap">
    <div class="container">

        <div class="subscription_details">
            <?php $this->load->view('frontend/flash_message.php'); ?>

            <div class="subscription_inp">
                <div class="subscription_cont">
                    <h3>Subscription based product boost (Yew Promote +)</h3>
                    <ul>
                        <?php
                        foreach ($la_data as $row) {
                            if ($row->boost_cat_id != 1)
                                continue;
                            ?>
                            <li>

                                <div class="custom-control custom-checkbox ">
                                    <input type="radio" name="subscription[]" value="<?php echo ($row->boost_id . "-" . time()) ?>" class="custom-control-input subscription_confirm" id="customCheck_<?php echo $row->boost_id ?>">
                                    <label class="custom-control-label" for="customCheck_<?php echo $row->boost_id ?>">
                                        <span><?= CURRENCY . $row->month_wise_price ?>/month 
                                            <?php
                                            if ($row->boost_id == $activeSubscriptionId) {
                                                ?>
                                                <button class="active_subscription_btn">Active plan</button>
                                                <?php
                                            }
                                            ?>
                                        </span> 

                                        <?php //echo ($row->product_posting_type == 'unlimited') ? ucfirst($row->product_posting_type) : $row->no_of_product ?>  <!--products promotion per month-->
                                        <?php echo $row->description; ?>

                                    </label>
                                </div>

                            </li>

                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="subscription_cont">
                    <h3>One time product boost (Yew +)</h3>
                    <ul>
                        <?php
                        foreach ($la_data as $row) {
                            if ($row->boost_cat_id != 2)
                                continue;
                            ?>
                            <li>
                                <div class="custom-control custom-checkbox ">
                                    <input type="radio" name="subscription[]" value="<?php echo ($row->boost_id . "-" . time()) ?>" class="custom-control-input subscription_confirm" id="customCheck_<?php echo $row->boost_id ?>">
                                    <label class="custom-control-label" for="customCheck_<?php echo $row->boost_id ?>">

                                        <span><?= CURRENCY . $row->week_wise_price ?>
                                            <?php
                                            if ($row->boost_id == $activeSubscriptionId) {
                                                ?>
                                                <button class="active_subscription_btn">Active plan</button>
                                                <?php
                                            }
                                            ?>
                                        </span> 
                                       
                                        
									<?php echo $row->description; ?>

                                    </label>
                                </div>
                            </li>

                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>


            <div class="heading3">
                <h3>Job Posting Charges</h3>
            </div>
            <div class="subscription_inp">
                <div class="subscription_cont">
                    <h3>Following are the details of job posting</h3>
                    <ul>
                        <?php
                        foreach ($la_dataJobPosting['per_post'] as $row) {
                            $weekF = ($row->duration_in_week > 1) ? "weeks" : "week";
                            ?>
                            <li>

                                <div class="custom-control custom-checkbox ">
                                    <input type="radio" name="subscription[]" value="<?php echo ($row->job_posting_charges_id . "-" . time()) ?>" class="custom-control-input job_subscription_confirm" id="customJobCheck_<?php echo $row->job_posting_charges_id ?>">
                                    <label class="custom-control-label" for="customJobCheck_<?php echo $row->job_posting_charges_id ?>">
                                        <span><?= CURRENCY . $row->price ?>/post
                                            <?php
                                            //if ($row->job_posting_charges_id == $activeJobPostingSubscriptionId) {
												if (in_array($row->job_posting_charges_id, $activeJobPostingSubscriptionId)) {
                                                ?>
                                                <button class="active_subscription_btn">Active plan</button>
                                                <?php
                                            }
                                            ?>
                                        </span> 
									<?php echo $row->description; ?> 
                                    </label>
                                </div>

                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="subscription_cont">
                    <h3>For those who do not have a job posting and want to search resumes</h3>
                    <ul>
                        <li>
                            <span>Monthly Subscription</span> 
                            <?php
                            foreach ($la_dataJobPosting['monthly'] as $row) {
                                ?>

                                <div class="custom-control custom-checkbox ">
								<input type="radio" name="subscription[]" value="<?php echo ($row->job_posting_charges_id . "-" . time()) ?>" class="custom-control-input resume_search_confirm" id="customJobCheck_<?php echo $row->job_posting_charges_id ?>">
                                    <label class="custom-control-label" for="customJobCheck_<?php echo $row->job_posting_charges_id ?>">
                                        <em><?= CURRENCY . $row->price ?> for endless searches
                                            <?php
                                            //if ($row->job_posting_charges_id == $activeJobPostingSubscriptionId) {
												if (in_array($row->job_posting_charges_id, $activeJobPostingSubscriptionId)){
                                                ?>
                                                <button class="active_subscription_btn">Active plan</button>
                                                <?php
                                            }
                                            ?>
                                        </em>
                                    </label>
                                </div>

                                <?php
                            }
                            ?>
                        </li>
                        <li>
                            <span>One time searches</span>
                            <?php
                            foreach ($la_dataJobPosting['one_time'] as $row) {
                                ?>

                                <div class="custom-control custom-checkbox ">
								<input type="radio" name="subscription[]" value="<?php echo ($row->job_posting_charges_id . "-" . time()) ?>" class="custom-control-input resume_search_confirm" id="customJobCheck_<?php echo $row->job_posting_charges_id ?>">
                                    <label class="custom-control-label" for="customJobCheck_<?php echo $row->job_posting_charges_id ?>">
                                        <em><?= CURRENCY . $row->price ?> for <?= $row->resume_number ?><?php if($row->resume_number =='1' ) { ?> resume <?php } else {?> resumes<?php } ?>
                                            <?php
                                            //if ($row->job_posting_charges_id == $activeJobPostingSubscriptionId) {
												if (in_array($row->job_posting_charges_id, $activeJobPostingSubscriptionId)) {
                                                ?>
                                                <button class="active_subscription_btn">Active plan</button>
                                                <?php
                                            }
                                            ?>
                                        </em>
                                    </label>
                                </div>
                                <?php
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>


        </div> 

    </div>
</section>

<script>
    $(document).ready(function () {
        $(".subscription_confirm").click(function () {
            var thisVal = $(this).val();

            $.confirm({
                title: 'Subscribe plan',
                content: 'Subscribe this plan?',
                type: 'blue',
                typeAnimated: true,
                buttons: {
                    cancel: {
                        text: 'No',
                        btnClass: 'btn-gray'
                    },
                    confirm: {
                        text: 'Yes',
                        btnClass: 'btn-green',
                        action: function () {
//                            alert(thisVal);
                            window.location.href = '<?php echo base_url("subscription-boost/") ?>' + thisVal;

                        }
                    }
                }
            });

        });

        $(".job_subscription_confirm").click(function () {
            var thisVal = $(this).val();

            $.confirm({
                title: 'Job Posting Plan',
                content: 'Subscribe this plan?',
                type: 'green',
                typeAnimated: true,
                buttons: {
                    cancel: {
                        text: 'No',
                        btnClass: 'btn-gray'
                    },
                    confirm: {
                        text: 'Yes',
                        btnClass: 'btn-blue',
                        action: function () {
//                            alert(thisVal);
                            window.location.href = '<?php echo base_url("job-posting-subscription/") ?>' + thisVal;

                        }
                    }
                }
            });

        });
		$(".resume_search_confirm").click(function () {
			var thisVal = $(this).val();

			$.confirm({
				title: 'Resume Search',
				content: 'Subscribe this plan?',
				type: 'green',
				typeAnimated: true,
				buttons: {
					cancel: {
						text: 'No',
						btnClass: 'btn-gray'
					},
					confirm: {
						text: 'Yes',
						btnClass: 'btn-blue',
						action: function () {
							//                            alert(thisVal);
							window.location.href = '<?php echo base_url("job-posting-subscription/") ?>' + thisVal;

						}
					}
				}
			});

		});
    });


</script>
