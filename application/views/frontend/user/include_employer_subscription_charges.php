<div class="orders-container">
	<i class="fa fa-spinner fa-spin fa-3x" style="display: none;"></i>
	<table class="table table-hover custom_developer_table">
		<thead>
			<tr>
				<!--<th>TXN no</th>-->
				<th>Price</th>
				<th>Duration</th>
				<!--<th>Product no</th>-->
				<th>Purchase</th>
				<th>Expired</th>
				<th>Status</th>
				<!--<th>Action</th>-->
			</tr>
		</thead>
		<tbody>
			<?php
			if (count($la_subscriptionCharges_employee) == 0) { ?>
			<tr>
				<td colspan="5" class="no_data_row">No data available!</td>
			</tr>
			<?php
		}
		foreach ($la_subscriptionCharges_employee as $row) {
			$status = $row->status;
			$ls_status = ($status == 'A') ? "Active" : "Archived";
			if (in_array($status, ['A'])) {
				$statusColor = 'accepted';
			} else {
				$statusColor = ' declined';
			}

			$viewBtnId = "subscriptionCharges__$row->subscription_for_boost_id";
			?>

			<tr id="row_<?= $viewBtnId ?>">
				<!--                    <td class="product_name">
				<?php echo $row->txn_no ?>
				</td>-->
				<td class="product_name"><?php echo ($row->price == 0) ? "--" : CURRENCY . " " . $row->price; ?></td>
				<td class="product_name"><?php echo $row->duration_in_days . " days" ?></td>
				<!--<td class="order_date"><?php // echo $row->product_no;   ?></td>-->
				<td class="order_date" title="<?php echo date('D d M, Y H:i:s', strtotime($row->created_at)) ?>">
					<?php echo date('M d, Y', strtotime($row->created_at)) ?>
				</td>

				<td class="order_date" title="">
					<?php if (!empty($row->valid_upto)){echo date("M d, Y", strtotime($row->valid_upto)); }?>
				</td>

				<td class="payment_status purchase_status <?= $statusColor ?>">
					<span ><?= $ls_status; ?></span>
				</td>

				<td class="payment_status processing">
					<!--<span class="sell-btn2 view_subscriptionCharges_details_btn" id="<?= $viewBtnId ?>">
						<i class="fa fa-eye"></i></span>-->
				</td>
				<!--                            <td class="payment_status processing">
				<a href="#" class="sell-btn2" data-toggle="modal" data-target="#viewproduct">View Details</a>
				</td>-->
			</tr>
			<?php }
			?>
			<!--///=========== Status :: pending , accepted , declined  ==================-->

		</tbody>
	</table>




	<div class="modal fade" id="viewSubscriptionDetailsModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Subscription Details</h5>
					<img class="close closeicon2" data-dismiss="modal" aria-label="Close" src="../assets/frontend/images/closeicon.png" alt="" />
				</div>
				<div class="modal-body">
					<div class="inner_cont_blog">
						<p>
							<span>Subscription Category: </span>
							<strong class="cat_name">--</strong></p>
						<p>
							<span>TXN no: </span>
							<strong class="txn_no">--</strong></p>
						<p>
							<span>Price: </span>
							<strong class="price">--</strong></p>
						<p>
							<span>Duration in days: </span>
							<strong  class="duration_in_days">--</strong></p>
						<p>
							<span>Number of product: </span>
							<strong  class="product_no">--</strong></p>
						<p>
							<span>Subscribed at: </span>
							<strong  class="created_at">--</strong></p>
						<p>
							<span>Expired at: </span>
							<strong  class="expired_at">--</strong></p>

						<div class="purchase_request top_subscription_check" >
							<a href="<?php echo base_url('subscription-charges'); ?>" class="def_btn3 ">Upgrade</a>
						</div>
						<!--                        <div class="moreinfo">
						<p class="message">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
						a type specimen book. </p>
						</div>-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--  -->


	<?php // echo $li_subscriptionCharges_count ?>

	<?php
	if ($li_subscriptionCharges_count > ITEM_LIST) {
		$totalPage = (($li_subscriptionCharges_count % ITEM_LIST) == 0) ? intval($li_subscriptionCharges_count / ITEM_LIST) : (intval($li_subscriptionCharges_count / ITEM_LIST) + 1);
	?>
	<div class="pager_content">
		<ul class="pagination justify-content-center">
			<?php
			if ($currentPage > 1) {
			?>
			<li class="page-item prev">
				<a class="page-link" id="<?= ($currentPage - 1) ?>_subscriptionCharges_pre" >
					<img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
				</a>
			</li>
			<?php
		}

		for ($i = 1; $i <= $totalPage; $i++) {
			$activetab = ($currentPage == $i) ? "activetab" : "";
			?>
			<li class="page-item <?= $activetab ?>">
				<a class="page-link" id="<?= $i ?>_subscriptionCharges" ><?= $i; ?></a></li>
			<?php
		}

		if ($currentPage < $totalPage) {
			?>
			<li class="page-item next">
				<a class="page-link" id="<?= $currentPage + 1 ?>_subscriptionCharges_next">
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