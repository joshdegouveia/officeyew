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
                <th>Job Title</th>
                <th>Posted Date</th>
                <th>Expiry Date</th>
            </tr>
        </thead>
        <tbody>
			<?php
				if (count($posted_jobs) == 0) {
			?>
				<tr >
					<td colspan=3 class="no_data_found">No Jobs Posted Yet</td>
				</tr>
			<?php
				}else{
				foreach($posted_jobs as $jobsData){
			?>
				<tr>
				<td class="recent_job_style"><?= $jobsData->job_title?></td>
				<td class="order_date"> <?php echo date('M d, Y H:i', strtotime($jobsData->job_upload_date)) ?></td>
				<td class="order_date"> <?php echo date('M d, Y H:i', strtotime($jobsData->job_expiry_date)) ?></td>
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

