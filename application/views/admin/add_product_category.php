<?php
$formHeader = 'Product Category Add';
$submitText = 'Save';
$name = '';
$pid = 0;
$image = '';

if (!empty($product)) {
  $formHeader = 'Product Category Edit';
  $submitText = 'Update';
  $name = $product->name;
  $pid = $product->id;
  $image = $product->filename;
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
            <h3 class="box-title"><?php echo $formHeader ;?></h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="box-body">
              
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-6 input-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Product category name" value="<?php echo $name ;?>" required>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Image</label>
                <div class="col-sm-6 input-group">
                  <input type="file" name="ufile" class="form-control" id="ufile" accept="image/x-png,image/gif,image/jpeg">
                  <?php if (!empty($image)) { ?>
                  <div>
                    <img src="<?php echo UPLOADPATH . 'products/product_categories/thumb/' . $image; ?>" style="max-width: 200px;">
                  </div>
                  <?php } ?>
                </div>
              </div>
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer">

              <a href="<?php echo base_url('admin/products/categories'); ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
              <button type="submit" class="btn btn-info pull-right"><?php echo $submitText ; ?></button>
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