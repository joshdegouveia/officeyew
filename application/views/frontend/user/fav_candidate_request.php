<div class="orders-container">


	<div class="content_right">

		<div class="product_area">
			<div class="product_list">
				<?php
				if (count($la_fav_candidate) == 0) {
					echo "No candidate available!";
				}

				$noCandidateImg =  UPLOADPATH . 'user/profile/no_img.png';
				foreach ($la_fav_candidate as $row) {

					//$image = BASE_URL . 'assets/upload/user/profile/' . $row->filename;
					$image = UPLOADDIR . 'user/profile/' . $row->filename;
					if (!file_exists($image) || ($row->filename == '')) {
						$image = $noCandidateImg;
					} else {
						$image = BASE_URL . 'assets/upload/user/profile/' . $row->filename;
					}
					$image_no = BASE_URL . 'assets/upload/user/profile/no_img.png';
					//$proUrl = base_url("profile-details/candidate/$row->favorite_in_user_id");
					$proUrl ='#';
				?>
				<div class="item" id="candidateTr_<?php echo $row->favorite_in_user_id; ?>">
					<div class="edit_opt">
						<img src="<?php echo site_url('assets/frontend/images/closeicon2.png');?>" alt="" class="delete_candidate_my_favorites" id="candidate_<?php echo $row->favorite_in_user_id; ?>"/>
					</div>
					<?php if((count($user_subscription)>0)){?>
					<div class="ofc-item-box">
						<img src="<?= $image; ?>" alt="candidate" style="height: 100px;" />
					</div>
					<h4>
						<a href="<?php echo $proUrl ?>" target="_blank">
							<?php echo $row->first_name.'&nbsp;'.$row->last_name; ?>
						</a>
					</h4>
					<?php }else{?>
					<div class="ofc-item-box">
						<img src="<?= $image_no; ?>" alt="candidate" style="height: 100px;" />
					</div>
					<h4>
						<a href="<?php echo $proUrl ?>" target="_blank">
							<?php echo $row->profile_heading; ?>
						</a>
					</h4>
					<?php }?>

				</div>
				<?php }
				?>
			</div>
		</div>

	</div>


	<?php
	//    echo $li_myFavorites_count ;
	//    echo ITEM_MY_FAVORITES ;
	?>

	<?php
	/*if ($li_myFavorites_count > ITEM_MY_FAVORITES) {
	$totalPage = (($li_myFavorites_count % ITEM_MY_FAVORITES) == 0) ? intval($li_myFavorites_count / ITEM_MY_FAVORITES) : (intval($li_myFavorites_count / ITEM_MY_FAVORITES) + 1);
	$url = base_url("products/list//" . "?pg=");*/
	?>
	<!--<div class="pager_content">
	<ul class="pagination justify-content-center">
	<?php
	if ($currentPage > 1) {
	?>
	<li class="page-item prev">
	<a class="page-link" id="<?= ($currentPage - 1) ?>_myFavorites_pre" >
	<img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
	</a>
	</li>
	<?php
	}

	for ($i = 1; $i <= $totalPage; $i++) {
	$activetab = ($currentPage == $i) ? "activetab" : "";
	?>
	<li class="page-item <?= $activetab ?>">
	<a class="page-link" id="<?= $i ?>_myFavorites" ><?= $i; ?></a></li>
	<?php
	}

	if ($currentPage < $totalPage) {
	?>
	<li class="page-item next">
	<a class="page-link" id="<?= $currentPage + 1 ?>_myFavorites_next">
	<img src="<?= UPLOADPATH . "../frontend/images/next.png" ?>" alt="Next" />
	</a>
	</li>
	<?php
	}
	?>
	</ul>
	</div>
	-->
	<?php
	//}
	?>
</div>
<script>
	$(document).ready(function () {
		$('body').on('click', '.delete_candidate_my_favorites', function () {
			var thisId = $(this).attr('id');
			var reqId = thisId.split('_')[1];
			console.log('<?php echo base_url("user/fav_candidate/"); ?>' + reqId);
			$.confirm({
				title: 'Remove Favorite Candidate',
				content: 'Remove candidate from my favorites?',
				type: 'red',
				typeAnimated: true,
				buttons: {
					cancel: {
						text: 'CANCEL',
						btnClass: 'btn-gray'
					},
					confirm: {
						text: 'REMOVE',
						btnClass: 'btn-red',
						action: function () {

							$.ajax({
								url: '<?php echo base_url("user/fav_candidate/"); ?>' + reqId,
								type: 'post',
								dataType: 'json',
								data: '',

								async: false,
								success: function (response) {
									console.log(response);
									if (response.success) {
										if (response.flag != 'add') {
											$("#candidateTr_" + reqId).remove();
										}
										toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
									} else {
										toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
									}

								}
							});
						}
					}
				}
			});


		});


	});
</script>

