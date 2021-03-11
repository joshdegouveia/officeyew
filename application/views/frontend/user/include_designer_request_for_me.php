<div class="orders-container">
    <i class="fa fa-spinner fa-spin fa-3x" style="display: none;"></i>
    <table class="table table-hover custom_developer_table">
        <thead>
            <tr>
                <th>Submitted By</th>
                <!--<th>Request For</th>--> 
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($la_designer_request_received) == 0) { ?>
                <tr>
                    <td colspan="4" class="no_data_row">No request submitted!</td>
                </tr>
                <?php
            }
            foreach ($la_designer_request_received as $row) {
//                echo "<pre>";
//                print_r($row);
                $status = $row->status;
                if (in_array($status, ['canceled', 'returned'])) {
                    $statusColor = 'declined';
                } elseif (in_array($status, ['delivered', 'approved'])) {
                    $statusColor = 'accepted';
                } else {
                    $statusColor = 'pending';
                }
                $viewBtnId = "dRequestForMe__$row->id" . "__" . $row->user_id;
                ?>

                <tr>
                    <td class="product_name">
                        <!--<a class="display_block" href="<?php echo base_url(); ?>" target="_blank">--> 
                            <?php echo ucwords($row->first_name." ".$row->last_name) ?>
                        <!--</a>-->
                    </td>
                    <!--<td class="order_date"><?php echo ucwords($row->request_type) ?></td>-->
                    <td class="order_date"><?php echo date('M d, Y H:i', strtotime($row->created_on)) ?></td>
                    <td class="payment_status <?= $statusColor ?>"><?= ucwords(str_replace('_', " ", $status)) ?></td>
                    <td class="payment_status processing designer_req_for_me designer_req_details" id="<?= $viewBtnId ?>">View Details</td>
                </tr>
            <?php }
            ?>
            <!--///=========== Status :: pending , accepted , declined  ==================-->

        </tbody> 
    </table>

    <?php // echo $li_mySubmittedRequest_count ?>

    <?php
    if ($la_designerRequestReceived_count > ITEM_LIST) {
        $totalPage = (($la_designerRequestReceived_count % ITEM_LIST) == 0) ? intval($la_designerRequestReceived_count / ITEM_LIST) : (intval($la_designerRequestReceived_count / ITEM_LIST) + 1);
        $url = base_url("products/list//" . "?pg=");
        ?>
        <div class="pager_content">
            <ul class="pagination justify-content-center">
                <?php
                if ($currentPage > 1) {
                    ?>
                    <li class="page-item prev">
                        <a class="page-link" id="<?= ($currentPage - 1) ?>_service_request_re_pre" >
                            <img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
                        </a>
                    </li>
                    <?php
                }

                for ($i = 1; $i <= $totalPage; $i++) {
                    if ($currentPage == $i) {
                        ?>
                        <li class="page-item activetab"><a class="page-link" id="<?= $i ?>_service_request_re" ><?= $i; ?></a></li>
                        <?php
                    } else {
                        ?>
                        <li class="page-item"><a class="page-link" id="<?= $i ?>_service_request_re" ><?= $i; ?></a></li>
                        <?php
                    }
                }

                if ($currentPage < $totalPage) {
                    ?>
                    <li class="page-item next">
                        <a class="page-link" id="<?= $currentPage + 1 ?>_service_request_re_next">
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

 
