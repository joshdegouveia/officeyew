<div class="orders-container">


	<div class="content_right">

			   <div class="row designer_wrapper">
				<?php
				if (count($la_fav_installer) == 0) {
					echo "No installer available!";
				}
				?>
				
				<?php
				$noInstallerImg =  UPLOADPATH . 'user/profile/no_img.png';
				foreach ($la_fav_installer as $row) {
					
					//$image = BASE_URL . 'assets/upload/user/profile/' . $row->filename;
					$image = UPLOADDIR . 'user/profile/' . $row->filename;
					if (!file_exists($image) || ($row->filename == '')) {
						$image = $noInstallerImg;
					} else {
						$image = BASE_URL . 'assets/upload/user/profile/' . $row->filename;
					}

					$proUrl = base_url("profile-details/$row->name/$row->user_id"); 
				?>
				<div class="col-sm-3 designer_loop_wrapper">
							<div class="select-des-det " id="installerTr_<?php echo $row->user_id; ?>">
								<div class="edit_opt">
								<img src="<?php echo site_url('assets/frontend/images/closeicon2.png');?>" alt="" class="delete_installer_my_favorites" id="installer_<?php echo $row->user_id; ?>" onclick="javascript:delete_fav_installer(this.id);"/>
								</div>
								
								<div class="select-top"><img src="<?= $image; ?>" alt="<?= $row->first_name ?>"></div>
								<div class="select-center-design">
									<h3><?php echo $row->first_name.'&nbsp;'.$row->last_name; ?></h3>
									
								</div>
								<div class="select-bottom-design">
									<a href="<?php echo $proUrl ?>" target="_blank" class="btn ">View Profile</a>
								</div>
							</div>
						</div>
				
				
				<?php }
				?>
				</div>
			

	</div>


	<?php
	  
	    $li_myFavorites_count = count($la_fav_installer_count);
	   
	    $ITEM_MY_FAVORITES =12;
	?>

	<?php
	if ($li_myFavorites_count > $ITEM_MY_FAVORITES) {
		$totalPage = (($li_myFavorites_count % $ITEM_MY_FAVORITES) == 0) ? intval($li_myFavorites_count / $ITEM_MY_FAVORITES) : (intval($li_myFavorites_count / $ITEM_MY_FAVORITES) + 1);
		$url = base_url("products/list//" . "?pg=");
	?>
	<div class="pager_content">
		<ul class="pagination justify-content-center">
			<?php
			if ($currentPage > 1) {
			?>
			<li class="page-item prev">
				<a class="page-link" id="<?= ($currentPage - 1) ?>_myFavorites_ins_pre" >
					<img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
				</a>
			</li>
			<?php
		}

		for ($i = 1; $i <= $totalPage; $i++) {
			$activetab = ($currentPage == $i) ? "activetab" : "";
			?>
			<li class="page-item <?= $activetab ?>">
				<a class="page-link" id="<?= $i ?>_myFavorites_ins" ><?= $i; ?></a></li>
			<?php
		}

		if ($currentPage < $totalPage) {
			?>
			<li class="page-item next">
				<a class="page-link" id="<?= $currentPage + 1 ?>_myFavorites_ins_next">
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
</div>
<script>
function delete_fav_installer(thisId){
	var reqId = thisId.split('_')[1];
	$.confirm({
				title: 'Remove Favorite Installer',
				content: 'Remove installer from my favorites?',
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
								url: '<?php echo base_url("user/add_favorite_user/"); ?>' + reqId+'/installer',
								type: 'post',
								dataType: 'json',
								data: '',

								async: false,
								success: function (response) {
									console.log(response);
									if (response.success) {
										if (response.flag != 'add') {
											$("#installerTr_" + reqId).remove();
											window.location.href='<?php echo base_url("user/profile/"); ?>';
										}
										//toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
									} else {
										toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
									}

								}
							});
						}
					}
				}
			});
}
	
</script>

<script>
    $(document).ready(function () {
    	var sort_by = 'latest';
        $('body').on('click', '.include_fav_installer_request .page-link', function () {
            //$('body').find(".include_fav_installer_request .fa-spinner").show();
            var thisId = $(this).attr('id');
            var pageId = thisId.split('_')[0];
            carrentPage = pageId;
            ajax_my_fav_ins(pageId, sort_by);

        });
       

    });
    function ajax_my_fav_ins(pageId, sort_by = '') {
        $.ajax({
            url: '<?php echo base_url("user/ajax_my_fav_ins?pg="); ?>' + pageId,
            type: 'post',
            dataType: 'json',
            data: {'sort_by': sort_by},
            async: false,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    $('body').find(".include_fav_installer_request").html(response.data);
                } else {
                    toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                }

            }
        });

    }
</script>