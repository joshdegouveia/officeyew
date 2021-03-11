<div class="orders-container message_listing_parent_content">
    <i class="fa fa-spinner fa-spin fa-3x" style="display: none;"></i>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <!--<th>Product</th>-->
                <th>Datetime</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($la_myMessageListAll) == 0) { ?>
                <tr>
                    <td colspan="3" class="no_data_row">No message!</td>
                </tr>
                <?php
            }
            foreach ($la_myMessageListAll as $k => $row) {
                if ($k >= ITEM_LIST)
                    break;
                if ($user['id'] != $row->send_to) {
                    $name = ucwords($row->to_username);
                } else {
                    $name = ucwords($row->from_username);
                }


                if ($row->product_id != 0) {
                    $userRowId = $row->send_from . "__" . $row->send_to . "__" . $row->product_id . "__pro";
                } else {
                    $userRowId = $row->send_from . "__" . $row->send_to . "__" . $row->purchase_id . "__purchase";
                }
                ?>

                <tr>
                    <td class="product_name">
                        <?php echo $name ?>
                    </td>
    <!--                    <td class="order_date">
                    <?php echo $row->product_name ?>
                    </td>-->
                    <td class="order_date" title="<?php echo date('D M d, Y H:i:s', strtotime($row->created_on)) ?>">
                        <?php echo date('M d , Y H:i', strtotime($row->created_on)) ?>
                    </td>
                    <td class="payment_status processing view_msg_details" id="<?php echo "viewDetails###" . $userRowId ?>">
                        <strong class="view_msg_details_btn <?= $row->is_seen ?>"> View details
                            <?php
                            if ($row->is_seen == 'N') {
                                ?>
                                    <!--<span class="btn-danger btn-sm" title="New message">1</span>-->
                                <?php
                            }
                            ?>
                        </strong>
                    </td>

                </tr>
            <?php }
            ?>


        </tbody>
    </table>


    <?php
    if ($li_myMessageList_count > ITEM_LIST) {
        $totalPage = (($li_myMessageList_count % ITEM_LIST) == 0) ? intval($li_myMessageList_count / ITEM_LIST) : (intval($li_myMessageList_count / ITEM_LIST) + 1);
        ?>
        <div class="pager_content">
            <ul class="pagination justify-content-center">
                <?php
                if ($currentPage > 1) {
                    ?>
                    <li class="page-item prev">
                        <a class="page-link" id="<?= ($currentPage - 1) ?>_myMessageList_pre" >
                            <img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
                        </a>
                    </li>
                    <?php
                }

                for ($i = 1; $i <= $totalPage; $i++) {
                    $activetab = ($currentPage == $i) ? "activetab" : "";
                    ?>
                    <li class="page-item <?= $activetab ?>"><a class="page-link" id="<?= $i ?>_myMessageList" ><?= $i; ?></a></li>
                    <?php
                }

                if ($currentPage < $totalPage) {
                    ?>
                    <li class="page-item next">
                        <a class="page-link" id="<?= $currentPage + 1 ?>_myMessageList_next">
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

