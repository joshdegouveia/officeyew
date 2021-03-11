
<section class="srch_rslt_m_wpr" style="margin-bottom:20px">
        <section class="container srch_area">

            <div class="col-12">
                <h2 class="srch_header">Showing Job Lists</h2>
				<?php
					if (count($la_jobsData) == 0) {
				?>
				<p class="no_data_found">No Jobs available!</p>
				<?php
					}else{
					foreach ($la_jobsData as $jobsData) {
					$proUrl = "job-details/$jobsData->id/" . name_to_url($jobsData->job_title);
				?>
                <div class="card card_item_block mt-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= $jobsData->job_title?> </h5>
                        <p class="card-text mb-3"> <?= $jobsData->job_description?></p>
                        <a href="#"  type="button" id="apply_button" class="btn btn-primary custom_btn">Apply</a>
                        <a href="<?php echo base_url($proUrl)?>"  class="btn custom_btn">View Details</a> 
                    </div>
                </div>
				<?php
					}
				}
				?>
            
                 
            </div>
			<?php
			//echo USER_GRID;
			//echo '<br>';
			//echo $li_jobsDataCount;
			
			  	 if ($li_jobsDataCount > USER_GRID) {
					$totalPage = (($li_jobsDataCount % USER_GRID) == 0) ? intval($li_jobsDataCount / USER_GRID) : (intval($li_jobsDataCount / USER_GRID) + 1);
					//$url = base_url("job-candidate?pg=");
					$url = base_url("user/employer_job_search?designation=".$uName."&location=".$ls_location."&location_id=".$location_id."&pg=");
			  ?>
                <div class="pager_content">
                    <ul class="pagination justify-content-center">
					<?php
						if ($currentPage > 1) {
					?>
						<li class="page-item prev">
							<a class="page-link" href="<?php echo $url . ($currentPage - 1) ?>">
								<img src="<?php echo base_url('assets/frontend/images/preview.png')?>" alt="Pre" />
							</a>
						</li>
					   <?php
                    }

                    for ($i = 1; $i <= $totalPage; $i++) {
                        if ($currentPage == $i) {
                            ?>
                            <li class="page-item activetab"><a class="page-link" href="#"><?= $i; ?></a></li>
                            <?php
                        } else {
                            ?>
                            <li class="page-item"><a class="page-link" href="<?php echo $url . $i ?>"><?= $i; ?></a></li>
                            <?php
                        }
                    }

                    if ($currentPage < $totalPage) {
                        ?>
                        <li class="page-item next">
                            <a class="page-link" href="<?php echo $url . ($currentPage + 1) ?>">
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
        </section>
    </section>

<script>
	$(document).ready(function () {
		 $('body').on('click', '#apply_button', function () {
			   $.ajax({
                url: '<?php echo base_url("user/apply_job/$jobsData->id"); ?>',
                type: 'post',
                dataType: 'json',
                data: '',

                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $("#apply_button").html(response.text);
                        if (response.flag == 'add') {
                            $("#apply_button").addClass('active_favorite_btn');
                        } else {
                            $("#apply_button").removeClass('active_favorite_btn');
                        }
                        toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });

		 })
	})
</script>