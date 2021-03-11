
<div class="orders-container">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Order Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($la_myProductOrder) == 0) { ?>
                <tr>
                    <td colspan="4" class="no_data_row">No Order!</td>
                </tr>
                <?php
            }
            foreach ($la_myProductOrder as $lo_order) {
                $status = $lo_order->delivery_status;
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
                        <!--<a class="display_block" href="<?php echo base_url("products/details/$lo_order->product_id/" . name_to_url($lo_order->product_name)); ?>"> -->
						<a class="display_block" href="#"> 
                            <?php echo $lo_order->name ?>
                        </a>
                    </td>
                    <td class="order_date"><?php echo ($lo_order->order_price == 0) ? "--" : $lo_order->order_price ?></td>
                    <td class="order_date"><?php echo date('M d, Y', strtotime($lo_order->created_date)) ?></td>
                    <td class="payment_status <?= $statusColor ?>"><?= ucwords(str_replace('_', " ", $lo_order->delivery_status)) ?></td>
                </tr>
            <?php }
            ?>
            <!--///=========== Status :: pending , accepted , declined  ==================-->

        </tbody>
    </table>
</div>