<h4>
    Recent Purchase Requests
    <a href="javascript::void(0)" class="sell-btn"  onclick="openCity('purchase_request_tab', 'purchase_request')" style="width: 200px; float: right">View All</a>
</h4>
<!--Purchase Request-->
<br>
<div class="clearfix"></div>
<div class="orders-container">
    <table class="table table-hover custom_developer_table">
        <thead>
            <tr>
                <th>Product</th>
                <!--<th>Price</th>-->
                <th>Buyer</th>
                <!--<th>Address</th>-->
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($la_purchaseRequests) == 0) { ?>
                <tr>
                    <td colspan="6" class="no_data_row">No request available!</td>
                </tr>
                <?php
            }
            foreach ($la_purchaseRequests as $k => $request) {
                if ($k == 4)
                    break;
                $status = $request->status;
                if (in_array($status, ['declined', 'returned'])) {
                    $statusColor = 'declined';
                } elseif (in_array($status, ['delivered', 'accepted'])) {
                    $statusColor = 'accepted';
                } else {
                    $statusColor = 'pending';
                }
                ?>

                <tr>
                    <td class="product_name">
                        <a class="display_block" href="<?php echo base_url("products/details/$request->product_id/" . name_to_url($request->product_name)); ?>"> 
                            <?php echo $request->product_name ?>
                        </a>
                    </td>
                    <!--<td class="order_date"><?php echo ($request->price == 0) ? "--" : $request->price ?></td>-->
                    <td class="order_date"><?php echo $request->submitted_name ?></td>
                    <!--<td class="order_date"><?php echo $request->submitted_address ?></td>-->
                    <td class="order_date" title="<?php echo date('D d M, Y H:i:s', strtotime($request->created_on)) ?>">
                        <?php echo date('M d, Y', strtotime($request->created_on)) ?>
                    </td>
                    <td class="payment_status <?= $statusColor ?>"><?= ucfirst(str_replace('_', " ", $status)) ?></td>
<!--                    <td class="payment_status processing">
                        <a href="#" class="sell-btn2" data-toggle="modal" data-target="#viewproduct">View Details</a>
                    </td>-->
                </tr>
            <?php }
            ?>

        </tbody>
    </table>


</div>