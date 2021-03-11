<style>
	.recent_job_style{
	font-size: 16px;
    color: #000000;
    font-weight: 400;
    font-family: "Work Sans";
}
</style>

<div class="orders-container">
    <i class="fa fa-spinner fa-spin fa-3x" style="display: none;"></i>
    <table class="table table-hover custom_developer_table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Job Title</th>
                <th>Applicants Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
		<?php
			if (count($applicants_details) == 0) {
			?>
				<tr >
					<td colspan=4 class="no_data_found">No One Applied Yet</td>
				</tr>
			<?php
			}else{
				foreach($applicants_details as $appliedData){
				$proUrl = "candidate-details/$appliedData->applied_by_user_id/" . name_to_url($appliedData->first_name);
			?>
             
			<tr>
				<td class="recent_job_style">
				<?php echo date('M d, Y H:i', strtotime($appliedData->applied_date)) ?>
				</td>
				<td class="recent_job_style"><?= $appliedData->job_title;?></td>
				<td class="order_date"><?= $appliedData->first_name . " " . $appliedData->last_name ?></td>
				<td class="payment_status"> <a class="display_block" href="<?php echo base_url($proUrl)?>" target="_blank"> 
						View Details
					</a>
				</td>
                </tr>
			<?php
				}
			}
			?>
         
            <!--///=========== Status :: pending , accepted , declined  ==================-->

        </tbody>
    </table>

    <?php // echo $li_mySubmittedRequest_count ?>

    <?php
    if ($li_mySubmittedRequest_count > ITEM_LIST) {
        $totalPage = (($li_mySubmittedRequest_count % ITEM_LIST) == 0) ? intval($li_mySubmittedRequest_count / ITEM_LIST) : (intval($li_mySubmittedRequest_count / ITEM_LIST) + 1);
        $url = base_url("products/list//" . "?pg=");
        ?>
        <div class="pager_content">
            <ul class="pagination justify-content-center">
                <?php
                if ($currentPage > 1) {
                    ?>
                    <li class="page-item prev">
                        <a class="page-link" id="<?= ($currentPage - 1) ?>_submitted_request_pre" >
                            <img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
                        </a>
                    </li>
                    <?php
                }

                for ($i = 1; $i <= $totalPage; $i++) {
                    if ($currentPage == $i) {
                        ?>
                        <li class="page-item activetab"><a class="page-link" id="<?= $i ?>_submitted_request" ><?= $i; ?></a></li>
                        <?php
                    } else {
                        ?>
                        <li class="page-item"><a class="page-link" id="<?= $i ?>_submitted_request" ><?= $i; ?></a></li>
                        <?php
                    }
                }

                if ($currentPage < $totalPage) {
                    ?>
                    <li class="page-item next">
                        <a class="page-link" id="<?= $currentPage + 1 ?>_submitted_request_next">
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

