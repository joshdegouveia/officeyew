<?php
$formHeader = 'Product Add';
$submitText = 'Save';
$name = '';
$short_desription = '';
$long_description = '';
$regular_price = '';
$status = '';
$pid = '';
$user_id='';
$image = '';
if (!empty($product)) {
  $formHeader = 'Product  Edit';
  $submitText = 'Update';
  $name = $product->name;
  $short_description = $product->short_description;
  $long_description = $product->long_description;
  $regular_price = $product->regular_price;
  $status = $product->status;
  $pid = $product->id;
  $user_id = $product->user_id;
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
          <input type="hidden" name="pid"  value="<?php echo $pid;?>"/>
            <div class="box-body">
              
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Product Name</label>
                <div class="col-sm-6 input-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Product Name" value="<?php echo $name ;?>" required>
                </div>
              </div>
              
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Short Drescription</label>
                <div class="col-sm-6 input-group">
                  
                   <textarea name="short_description" id="short_description" class="form-control wysihtml" placeholder="Short Description" required><?php echo $short_description;?></textarea>
                </div>
              </div>
             
              
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Long Description</label>
                <div class="col-sm-9 input-group textare">
                  <textarea name="long_description" id="long_description" class="form-control wysihtml" placeholder="Long Description" required><?php echo $long_description;?></textarea>
                </div>
              </div>
              
              
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Price</label>
                <div class="col-sm-6 input-group">
                  <input type="text" name="regular_price" class="form-control" id="regular_price" placeholder="Price" value="<?php echo $regular_price ;?>" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Product Category</label>
                <div class="col-sm-6 input-group">
                  
               <?php if(count($categories)>0){?>
                <select name="category_id[]" id="category_id" class="form-control" multiple="multiple">
                <?php foreach($categories as $category){?>
                <option value="<?php echo $category->id;?>" <?php if(in_array($category->id,$prod_cat)){?>selected="selected"<?php }?>><?php echo $category->name;?><option>
                <?php } ?>
                </select>
                <?php } ?>

                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Seller</label>
                <div class="col-sm-6 input-group">
				<?php if(count($sellers)>0){?>
                <select name="user_id" id="user_id" class="form-control">
                <?php foreach($sellers as $seller){?>
                <option value="<?php echo $seller->id;?>" <?php if($user_id==$seller->id){?>selected="selected"<?php }?>><?php echo $seller->first_name.''.$seller->last_name;?><option>
                <?php } ?>
                </select>
                <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Status</label>
                <div class="col-sm-6 input-group">
                  <input type="radio" name="status" value="1" <?php if(($status==1)||($status=='')){?>checked="checked"<?php }?> />Active
                  <input type="radio" name="status" value="0" <?php if($status==0){?>checked="checked"<?php }?>/>Inactive

                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Image</label>
                <div class="col-sm-6 input-group">
                  <input type="file" name="ufile" class="form-control" id="ufile" accept="image/x-png,image/gif,image/jpeg">
                  <?php if (!empty($image)) { ?>
                  <div>
                    <img src="<?php echo UPLOADPATH . 'products/product/thumb/' . $image; ?>" style="max-width: 200px;">
                  </div>
                  <?php } ?>
                </div>
              </div>
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer">

              <a href="<?php echo base_url('admin/products/lists/seller'); ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
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
<script src="<?php echo base_url('assets/js/ckeditor/ckeditor.js'); ?>"></script>
<script>
$(document).ready(function () {
  // $('#body').wysihtml5();
  CKEDITOR.editorConfig = function (config) {
    config.extraPlugins = 'confighelper';
    config.allowedContent = true;
  };
  $('.wysihtml').each(function() {
    CKEDITOR.replace(this, {
      format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div'
    });
  });
  var extra_fields = '<div class="form-group"><label for="name" class="col-sm-2 control-label">Label</label><div class="col-sm-9 input-group textarea"><input type="text" name="attached_lebel[]" class="form-control" placeholder="Label..." value="<?php echo '' ;?>" required></div></div><div class="form-group"><label for="name" class="col-sm-2 control-label">Content</label><div class="col-sm-9 input-group textarea"><textarea name="attached_content[]" placeholder="You content..." required></textarea></div></div>';
});
</script>