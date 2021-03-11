<script>
	$(document).ready(function () {

		$('body').on('click', '.view_subscriptionCharges_details_btn', function () { //
			$('body').find("#viewSubscriptionDetailsModal .inner_cont_blog .top_subscription_check").hide();
			var thisId = $(this).attr('id');
			$.ajax({
				url: '<?php echo base_url("user/ajax_subscription_charges_details_emp"); ?>',
				type: 'post',
				dataType: 'json',
				data: {'thisId': thisId},
				async: false,
				success: function (response) {
					console.log(response);
					if (response.success) {

						$('body').find("#viewSubscriptionDetailsModal .inner_cont_blog .cat_name").html(response.data.cat_name);
						$('body').find("#viewSubscriptionDetailsModal .inner_cont_blog .txn_no").html(response.data.txn_no);
						$('body').find("#viewSubscriptionDetailsModal .inner_cont_blog .price").html("<?= CURRENCY ?> " + response.data.price);
						$('body').find("#viewSubscriptionDetailsModal .inner_cont_blog .duration_in_days").html(response.data.duration_in_days);
						$('body').find("#viewSubscriptionDetailsModal .inner_cont_blog .product_no").html(response.data.product_no);
						$('body').find("#viewSubscriptionDetailsModal .inner_cont_blog .created_at").html(response.created_at);
						$('body').find("#viewSubscriptionDetailsModal .inner_cont_blog .expired_at").html(response.expired_at);
						if (response.top_subscription == 0) {
							$('body').find("#viewSubscriptionDetailsModal .inner_cont_blog .top_subscription_check").show();
						}
						$("#viewSubscriptionDetailsModal").modal('show');
					} else {
						toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
					}

				}
			});
		});




		$('body').on('click', '.include_subscription_charges .page-link', function () {
			$('body').find(".include_subscription_charges .fa-spinner").show();
			var thisId = $(this).attr('id');
			var pageId = thisId.split('_')[0];
			$.ajax({
				url: '<?php echo base_url("user/ajax_subscription_charges?pg="); ?>' + pageId,
				type: 'post',
				dataType: 'json',
				data: '',
				async: false,
				success: function (response) {
					console.log(response);
					if (response.success) {
						$('body').find(".include_subscription_charges").html(response.data);
					} else {
						toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
					}
				}
			});
		});


	});
</script>