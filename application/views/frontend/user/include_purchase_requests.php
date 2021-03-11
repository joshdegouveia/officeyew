<div class="orders-container">
    <i class="fa fa-spinner fa-spin fa-3x" style="display: none;"></i>
    <table class="table table-hover custom_developer_table">
        <thead>
            <tr>
                <th>Product</th>
                <!--<th>Price</th>-->
                <th>Buyer</th>
                <!--<th>Address</th>-->
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($la_purchaseRequests) == 0) { ?>
                <tr>
                    <td colspan="6" class="no_data_row">No request available!</td>
                </tr>
                <?php
            }
            foreach ($la_purchaseRequests as $request) {
                $status = $request->status;
//                'pending','approved','delivered','canceled','processing','ready_to_ship','return_request','returned'

                if (in_array($status, ['declined', 'returned'])) {
                    $statusColor = 'declined';
                } elseif (in_array($status, ['delivered', 'accepted'])) {
                    $statusColor = 'accepted';
                } else {
                    $statusColor = 'pending';
                }

                $viewBtnId = "pRequest__$request->purchase_request_id" . "__" . $request->buyer_id;
//                print_r($request);
//                die;
                ?>

                <tr id="row_<?= $viewBtnId ?>">
                    <td class="product_name">
                        <a class="display_block" href="<?php echo base_url("products/details/$request->product_id/" . name_to_url($request->product_name)); ?>"> 
                            <?php echo $request->product_name ?>
                        </a>
                    </td>
                    <!--<td class="order_date"><?php // echo ($request->price == 0) ? "--" : $request->price               ?></td>-->
                    <td class="order_date"><?php echo $request->submitted_name ?></td>
                    <!--<td class="order_date"><?php // echo $request->submitted_address               ?></td>-->
                    <td class="order_date" title="<?php echo date('D d M, Y H:i:s', strtotime($request->created_on)) ?>">
                        <?php echo date('M d, Y', strtotime($request->created_on)) ?>
                    </td>

                    <td class="payment_status purchase_status <?= $statusColor ?>">
                        <span ><?= ucfirst(str_replace('_', " ", $status)) ?></span>
                    </td>

                    <td class="payment_status processing">
                        <span class="sell-btn2 view_purchase_details_btn" id="<?= $viewBtnId ?>">View Details</span>
                    </td>
    <!--                        <td class="payment_status processing">
                       <a href="#" class="sell-btn2" data-toggle="modal" data-target="#viewproduct">View Details</a>
                   </td>-->
                </tr>
            <?php }
            ?>
            <!--///=========== Status :: pending , accepted , declined  ==================-->

        </tbody>
    </table>




    <div class="modal fade" id="viewPurchaseRequestModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Purchase Requests Details</h5>
                    <img class="close closeicon2" data-dismiss="modal" aria-label="Close" src="../assets/frontend/images/closeicon.png" alt="" />
                </div>
                <div class="modal-body">
                    <div class="inner_cont_blog">
                        <p><span>Customer Name: </span><strong class="submitted_name">--</strong></p>
                        <p><span>Customer contact: </span><strong class="submitted_phone">--</strong></p>
                        <p><span>Customer address: </span><strong class="submitted_address">--</strong></p>
                        <p><span>Date of Request: </span><strong  class="created_on">--</strong></p>
                        <p><span>Product Name: </span><strong  class="product_name">--</strong></p>
                        <!--<p><span>Quantity: </span><strong  class="submitted_name">24</strong></p>-->
                        <p><span>Price: </span><strong  class="regular_price">$1000</strong></p>

                        <div class="moreinfo">
                            <p class="message">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
                                a type specimen book. </p>
                        </div>
                        <div class="purchase_request purchase_request_message_content">
                            <a href="javascript::void(0)" class="sell-btn go_message_from_purchase_details">Message</a>
                        </div>
                        <div class="purchase_request purchase_request_update_content">
                            <!--<a href="#" class="sell-btn">Message</a>-->
                            <a href="#" class="def_btn3 purchase_request_status" id="accepted">Accept</a>
                            <a href="#" class="def_btn3 purchase_request_status" id="declined">Decline</a>
                        </div>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
        </div>
    </div>
    <!--  -->


    <?php // echo $li_purchaseRequests_count  ?>

    <?php
    if ($li_purchaseRequests_count > ITEM_LIST) {
        $totalPage = (($li_purchaseRequests_count % ITEM_LIST) == 0) ? intval($li_purchaseRequests_count / ITEM_LIST) : (intval($li_purchaseRequests_count / ITEM_LIST) + 1);
        ?>
        <div class="pager_content">
            <ul class="pagination justify-content-center">
                <?php
                if ($currentPage > 1) {
                    ?>
                    <li class="page-item prev">
                        <a class="page-link" id="<?= ($currentPage - 1) ?>_purchaseRequests_pre" >
                            <img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
                        </a>
                    </li>
                    <?php
                }

                for ($i = 1; $i <= $totalPage; $i++) {
                    $activetab = ($currentPage == $i) ? "activetab" : "";
                    ?>
                    <li class="page-item <?= $activetab ?>"><a class="page-link" id="<?= $i ?>_purchaseRequests" ><?= $i; ?></a></li>
                    <?php
                }

                if ($currentPage < $totalPage) {
                    ?>
                    <li class="page-item next">
                        <a class="page-link" id="<?= $currentPage + 1 ?>_purchaseRequests_next">
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