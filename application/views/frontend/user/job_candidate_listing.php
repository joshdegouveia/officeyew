<!-- search  result start -->

    <section class="srch_rslt_m_wpr" style="margin-bottom:20px">
        <section class="container srch_area job_search ">

            <div class="col-12">
                <h2 class="srch_header mb-4">Showing candidate list</h2>
                <div class="row">
				<?php
					if (count($la_usersData) == 0) {
				?>
					<p class="no_data_found">No user available!</p>
				<?php
					}else{
					$noImgPath = BASE_URL . 'assets/upload/user/profile/no_img.png';
					foreach ($la_usersData as $usersData) {
						if ($usersData->filename != '') {
							$path = BASE_URL . 'assets/upload/user/profile/' . $usersData->filename;
						} else {
							$path = $noImgPath;
						}
						$proUrl = "candidate-details/$usersData->userid/" . name_to_url($usersData->first_name);
						//print_r($user_subscription);
				?>
					<div class="col-sm col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="card card_item_block ">
                            <div class="card-body">
                            
                            	<?php if((count($user_subscription)>0)){?>
                                <a href="<?php echo base_url($proUrl)?>" class="image_wrpr">
                                    <img src="<?= $path; ?>" class="" alt="<?= $usersData->first_name ?>">
                                </a>
                                <a href="<?php echo base_url($proUrl)?>"><h5 class="card-title"> <?= $usersData->first_name . " " . $usersData->last_name ?></h5></a>
                                <?php }else{?>
							<a href="<?php echo base_url($proUrl) ?>" class="image_wrpr">
								<img src="<?= $noImgPath; ?>" class="" alt="">
							</a>
                                <a href="<?php echo base_url($proUrl)?>"><h5 class="card-title"> <?= $usersData->profile_heading?></h5></a>
                                <?php }?>
                                <p class="card-text mb-3" style="display: none;"> <?php echo ($usersData->candidate_skills != '')? $usersData->candidate_skills: 'Not Mentioned' ?></p>
							<p class="card-text mb-3"> <?php echo ($usersData->candidate_designation != '')? $usersData->candidate_designation: 'Not Mentioned' ?></p>                                              
                                <a href="<?php echo base_url($proUrl)?>" class="btn custom_btn">View Details</a>
                            </div>
                        </div>
                    </div>
				<?php
					}
				}
				?>
                    

                </div>
              <?php
             
			//$li_usersDataCount = count($la_usersData); 
			 /*echo USER_GRID;
			echo '<br>';
			echo $li_usersDataCount;
			*/
			  	 if ($li_usersDataCount > USER_GRID) {
					$totalPage = (($li_usersDataCount % USER_GRID) == 0) ? intval($li_usersDataCount / USER_GRID) : (intval($li_usersDataCount / USER_GRID) + 1);
					$url = base_url("job-candidate?pg=");
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
    <!-- search  result end -->