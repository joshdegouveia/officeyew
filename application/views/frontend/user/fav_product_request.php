<div class="orders-container">
	<i class="fa fa-spinner fa-spin fa-3x" style="display: none;"></i>
	<table class="table table-hover custom_developer_table">
		<thead>
			<tr>
				<th>Product name</th>
				<th>Date</th>

			</tr>
		</thead>
		<tbody>
			<?php

			if (count($la_fav_products) == 0) { ?>
			<tr>
				<td colspan="4" class="no_data_row">No Products Found</td>
			</tr>
			<?php
		}
		foreach ($la_fav_products as $row) {

			?>

			<tr>

				<td class="order_date" title="">

					<?php echo $row->name; ?>
				</td>
				<td><?php echo date('M d, Y', strtotime($row->added_datetime)) ?></td>

			</tr>
			<?php }
			?>


		</tbody>
	</table>




</div>




