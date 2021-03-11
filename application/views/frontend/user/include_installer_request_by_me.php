<div class="orders-container">
    <i class="fa fa-spinner fa-spin fa-3x" style="display: none;"></i>
    <table class="table table-hover custom_developer_table">
        <thead>
            <tr>
                <th>Service required</th> 
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
			
			if (count($la_installer_request_data) == 0) { ?>
                <tr>
                    <td colspan="4" class="no_data_row">No request submitted!</td>
                </tr>
                <?php
            }
            foreach ($la_installer_request_data as $row) {
//                echo "<pre>";
//                print_r($row);
                $status = ($row->status == 'A') ? "Active" : "Archived";
                if (in_array($status, ['Ar'])) {
                    $statusColor = 'declined';
                } elseif (in_array($status, ['A'])) {
                    $statusColor = 'accepted';
                } else {
                    $statusColor = 'pending';
                }
                $viewBtnId = "insRequestByMe__$row->installer_request_id" . "__" . $row->user_id;
                ?>

                <tr>
                    <td class="order_date">
                        <?php 
                        if(!empty($row->service_required)){
                            $pickup_arr = explode(",",$row->service_required);
                             $str_pick = '';
                            if(count($pickup_arr)>0){
                               
                                foreach($pickup_arr as $pickup){
                                     $str_pick .='&nbsp;'.ucfirst($pickup).' : '.'Yes'.',';
                                }
                            }
                        }else{
                            $str_pick = '';
                        }
                        echo substr($str_pick, 0, -1);
                        ?>
                    </td>
                    <td class="order_date" title="<?php echo date('M d, Y H:i:s', strtotime($row->create_datetime)) ?>"><?php echo date('M d, Y', strtotime($row->create_datetime)) ?></td>
                    <td class="payment_status <?= $statusColor ?>"><?= ucwords(str_replace('_', " ", $status)) ?></td>
                    <td class="payment_status processing installer_req_by_me installer_req_details" id="<?= $viewBtnId ?>">View Details</td>
                </tr>
            <?php }
            ?>
            <!--///=========== Status :: pending , accepted , declined  ==================-->

        </tbody> 
    </table>

    <?php // echo $li_mySubmittedRequest_count ?>

    <?php
    if ($li_installerRequestData_count > ITEM_LIST) {
        $totalPage = (($li_installerRequestData_count % ITEM_LIST) == 0) ? intval($li_installerRequestData_count / ITEM_LIST) : (intval($li_installerRequestData_count / ITEM_LIST) + 1);
        $url = base_url("products/list/" . "?pg=");
        ?>
        <div class="pager_content">
            <ul class="pagination justify-content-center">
                <?php
                if ($currentPage > 1) {
                    ?>
                    <li class="page-item prev">
                        <a class="page-link" id="<?= ($currentPage - 1) ?>_ins_service_request_pre" >
                            <img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
                        </a>
                    </li>
                    <?php
                }

                for ($i = 1; $i <= $totalPage; $i++) {
                    if ($currentPage == $i) {
                        ?>
                        <li class="page-item activetab"><a class="page-link" id="<?= $i ?>_ins_service_request" ><?= $i; ?></a></li>
                        <?php
                    } else {
                        ?>
                        <li class="page-item"><a class="page-link" id="<?= $i ?>_ins_service_request" ><?= $i; ?></a></li>
                        <?php
                    }
                }

                if ($currentPage < $totalPage) {
                    ?>
                    <li class="page-item next">
                        <a class="page-link" id="<?= $currentPage + 1 ?>_ins_service_request_next">
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




