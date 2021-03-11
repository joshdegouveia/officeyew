<?php
$formHeader = 'Product Boost Add';
$submitText = 'Save';
$month_time = '';
$month_wise_price = '';
$week_wise_price = '';
$no_of_product = '';
$boost_id = '';
$no_of_weeks = '';
$product_posting_type = 'unlimited';
$boost_cat_id = '1';
$description = '';
if (!empty($boost_product)) {
    $formHeader = 'Product  Edit';
    $submitText = 'Update';
    $formHeader = 'Product Boost Edit';
    $submitText = 'Update';
    $month_time = $boost_product->month_time;
    $month_wise_price = $boost_product->month_wise_price;
    $week_wise_price = $boost_product->week_wise_price;
    $no_of_product = $boost_product->no_of_product;
    $boost_id = $boost_product->boost_id;
    $no_of_weeks = $boost_product->no_of_weeks;
    $product_posting_type = $boost_product->product_posting_type;
    $boost_cat_id = $boost_product->boost_cat_id;
	$description = $boost_product->description;
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo $title; ?></h1>
    </section>

    <!-- Main content -->
    <section class="content cms">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-info">
                    <!-- Horizontal Form -->
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $formHeader; ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="box-body">

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Boost Type</label>
                                <div class="col-sm-6 input-group">
                                    <select name="boost_type" id="boost_type" class="form-control">
                                        <option value=""></option>
                                        <option value="1" <?php if ($boost_cat_id == 1) { ?>selected="selected"<?php } ?>>Subscription Based</option>
                                        <option value="2" <?php if ($boost_cat_id == 2) { ?>selected="selected"<?php } ?>>One Time</option>
                                    </select>
                                </div>
                            </div>
                            <div id="boost_typee_1" <?php if ($boost_cat_id == 1) { ?>style="display:block;"<?php } else { ?>style="display:none;<?php } ?>" class="boost_typee">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Posting Type:</label>
                                    <div class="col-sm-6 input-group">
                                        <input type="radio" name="product_posting_type" class="" class="product_posting_typee" value="Unlimited"  <?php echo ($product_posting_type == 'unlimited') ? "checked": ""?>/> Unlimited
                                        <input type="radio" name="product_posting_type" class="" class="product_posting_typee" value="Individual" <?php echo ($product_posting_type == 'individual') ? "checked": ""?>/> Individual
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Monthly Price</label>
                                    <div class="col-sm-6 input-group">
                                        <input type="text" name="month_wise_price" class="form-control" id="month_wise_price" placeholder="Monthly Price" value="<?php echo $month_wise_price; ?>">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">No Of Product</label>
                                    <div class="col-sm-6 input-group">
                                        <input type="text" name="no_of_product2" class="form-control" id="no_of_product2" placeholder="No Of Product" value="<?php echo $no_of_product; ?>">
                                    </div>
                                </div>
                            </div>
                            <div id="boost_typee_2" <?php if ($boost_cat_id == 2) { ?>style="display:block;"<?php } else { ?>style="display:none;<?php } ?>" class="boost_typee">

                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Weekly Price</label>
                                    <div class="col-sm-6 input-group">
                                        <input type="text" name="week_wise_price" class="form-control" id="week_wise_price" placeholder="Weekly Price" value="<?php echo $week_wise_price; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">No of weeks</label>
                                    <div class="col-sm-6 input-group">
                                        <input type="text" name="no_of_weeks" class="form-control" id="no_of_weeks" placeholder="No of weeks" value="<?php echo $no_of_weeks; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">No of Product</label>
                                    <div class="col-sm-6 input-group">
                                        <input type="text" name="no_of_product" class="form-control" id="no_of_product" placeholder="No of Product" value="<?php echo $no_of_product; ?>">
                                    </div>
                                </div>
								

                            </div>

						<div class="form-group">
							<label for="name" class="col-sm-2 control-label">Description</label>
							<div class="col-sm-6 input-group">
									<textarea class="form-control" id="description" name="description"><?php echo $description; ?></textarea>
							</div>
						</div>







                            <!-- /.box-body -->
                            <div class="box-footer">

                                <a href="<?php echo base_url('admin/products/boost/' . $boost_cat_id); ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                                <input type="submit" class="" value="<?php echo $submitText; ?>">
                            </div>
                            <!-- /.box-footer -->
                    </form>
                    <!-- /.box -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    jQuery(document).ready(function () {
        //alert('mn');
        //console.log( "ready!" );
        jQuery("#boost_type").change(function (e) {
            jQuery(".boost_typee").hide();
            var typee_id = "boost_typee_" + jQuery(this).val();
            //alert(typee_id);
            jQuery("#" + typee_id).show();
        });
    });
	$('a.rm-user').on('click', function() {
		if (!confirm('Do you want to delete this boost product?')) {
			return false;
		}
	});
</script>