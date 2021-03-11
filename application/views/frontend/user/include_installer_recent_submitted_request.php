<div class="orders-container">
    <i class="fa fa-spinner fa-spin fa-3x" style="display: none;"></i>
    <table class="table table-hover custom_developer_table">
        <thead>
            <tr>
                <th>Submitted By</th> 
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($la_installer_request_received_2) == 0) { ?>
                <tr>
                    <td colspan="4" class="no_data_row">No request submitted!</td>
                </tr>
                <?php
            }
            foreach ($la_installer_request_received_2 as $row) {
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
                    <td class="product_name"><?php echo $row->first_name." ".$row->last_name ?></td>
                    <td class="order_date" title="<?php echo date('d M, Y H:i:s', strtotime($row->create_datetime)) ?>"><?php echo date('M d, Y', strtotime($row->create_datetime)) ?></td>
                    <td class="payment_status <?= $statusColor ?>"><?= ucwords(str_replace('_', " ", $status)) ?></td>
                    <td class="payment_status processing installer_req_by_me installer_req_details" id="<?= $viewBtnId ?>">View Details</td>
                </tr>
            <?php }
            ?>
            <!--///=========== Status :: pending , accepted , declined  ==================-->

        </tbody> 
    </table>

    <?php // echo $li_mySubmittedRequest_count ?>

    
</div>




