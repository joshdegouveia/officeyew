<?php $this->load->view('frontend/user/include_script/include_designer_installer_service_request_js.php'); ?>
						<?php
			if (count($la_usersData) == 0) {
			?>
						<p class="no_data_found">No user available!</p>
						<?php
		} else {
			$noImgPath = BASE_URL . 'assets/upload/user/profile/no_img.png';
						/*echo '<pre>';
						print_r($la_usersData);
						echo '</pre>';
						*/
			foreach ($la_usersData as $usersData) {
				if ($usersData->filename != '') {
					$path = BASE_URL . 'assets/upload/user/profile/' . $usersData->filename;
				} else {
					$path = $noImgPath;
				}
			?>
						<div class="col-sm-3 designer_loop_wrapper">
							<div class="select-des-det " id="<?php echo $usersData->user_id ?>">
								<input type="checkbox" value="<?php echo $usersData->user_id ?>" hidden name="user[]">
								<div class="select-top"><img src="<?= $path; ?>" alt="<?= $usersData->first_name ?>"></div>
								<div class="select-center-design">
									<h3><?= $usersData->company_name; ?></h3>
									<!--<p>Expert in office cubicle installation</p>-->
								</div>
								<div class="select-bottom-design">
									<a href="<?php echo base_url("profile-details/$usersData->user_type/$usersData->user_id"); ?>" target="_blank" class="btn ">View</a>
								</div>
							</div>
						</div>

						<?php
		}
	}
			?>
						<div class="col-sm-12">
							<input type="hidden" name="request_id" id="uid" value="0">
							<button type="button"  class="submit-servi" style="cursor: pointer;" onclick="javascript:check_designer();">Next</button>
						</div>

					<?php
	$la_usersData_count = $la_usersData_count->user_count;
	$ITEM_PRODACT = 2;
    if ($la_usersData_count > $ITEM_PRODACT) {
        $totalPage = (($la_usersData_count % $ITEM_PRODACT) == 0) ? intval($la_usersData_count / $ITEM_PRODACT) : (intval($la_usersData_count / $ITEM_PRODACT) + 1);
        $url = base_url("products/list//" . "?pg=");
        ?>
        <div class="pager_content">
            <ul class="pagination justify-content-center">
                <?php
                if ($currentPage > 1) {
                    ?>
                    <li class="page-item prev">
                        <a class="page-link" id="<?= ($currentPage - 1) ?>_designReq_pre" >
                            <img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
                        </a>
                    </li>
                    <?php
                }

                for ($i = 1; $i <= $totalPage; $i++) {
                    $activetab = ($currentPage == $i) ? "activetab" : "";
                    ?>
                    <li class="page-item <?= $activetab ?>"><a class="page-link" id="<?= $i ?>_designReq" ><?= $i; ?></a></li>
                    <?php
                }

                if ($currentPage < $totalPage) {
                    ?>
                    <li class="page-item next">
                        <a class="page-link" id="<?= $currentPage + 1 ?>_designReq_next">
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