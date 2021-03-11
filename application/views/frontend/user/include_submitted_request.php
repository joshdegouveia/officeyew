<div class="orders-container">
    <i class="fa fa-spinner fa-spin fa-3x" style="display: none;"></i>
    <table class="table table-hover custom_developer_table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Seller name</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($la_mySubmittedRequest) == 0) { ?>
                <tr>
                    <td colspan="4" class="no_data_row">No request submitted!</td>
                </tr>
                <?php
            }
            foreach ($la_mySubmittedRequest as $row) {
                $status = $row->status;
//                'pending','approved','delivered','canceled','processing','ready_to_ship','return_request','returned'
                if (in_array($status, ['canceled', 'returned'])) {
                    $statusColor = 'declined';
                } elseif (in_array($status, ['delivered', 'approved'])) {
                    $statusColor = 'accepted';
                } else {
                    $statusColor = 'pending';
                }
                ?>

                <tr>
                    <td class="product_name">
                        <a class="display_block" href="<?php echo base_url("products/details/$row->product_id/" . name_to_url($row->product_name)); ?>" target="_blank"> 
                            <?php echo $row->product_name ?>
                        </a>
                    </td>
                    <td class="order_date"><?php echo ucwords($row->seller_f_name . " " . $row->seller_l_name) ?></td>
                    <td class="order_date"><?php echo date('M d, Y H:i', strtotime($row->created_on)) ?></td>
                    <td class="payment_status <?= $statusColor ?>"><?= ucwords(str_replace('_', " ", $status)) ?></td>
                </tr>
            <?php }
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

