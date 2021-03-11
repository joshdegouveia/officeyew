<?php
$formHeader = 'Trending Brands Management';
$submitText = 'Save';
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    <?php echo $title; ?>
    </h1>
  </section>
  
  <!-- Main content -->
  <section class="content trending-brands">
    <div class="row">
      <div class="col-md-10">
        <div class="box box-info">
          <!-- Horizontal Form -->
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo $formHeader ;?></h3>
          </div>
          <?php if($this->session->flashdata('msg_error')){ ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Error Message!</h4>
            <?php echo $this->session->flashdata('msg_error') ; ?>
          </div>
          <?php }?>
          <?php if($this->session->flashdata('msg_success')){ ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success Message!</h4>
            <?php echo $this->session->flashdata('msg_success') ; ?>
          </div>
          <?php } ?>
          <!-- /.box-header -->
          <!-- form start -->
          <form method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="box-body">
              <?php
              if (!empty($content)) {
                foreach ($content as $value) {
                  $name = ucwords($value->first_name . ' ' . $value->last_name);
                  $company_logo = FILEPATH . 'img/default/no-image.png';
                  if (!empty($value->company_name)) {
                    $name = $value->company_name;
                  }
                  if (!empty($value->company_logo)) {
                    $company_logo = UPLOADPATH . 'business/logo/thumb/' . $value->company_logo;
                  } else if (!empty($value->filename)) {
                    $company_logo = UPLOADPATH . 'user/profile/thumb/' . $value->filename;
                  }
                  $checked = (in_array($value->id, $select_brands)) ? 'checked="checked"' : '';
              ?>
              <div class="items">
                <label>
                  <input type="checkbox" name="brands[]" value="<?php echo $value->id; ?>" <?php echo $checked; ?>>
                  <img alt="Image placeholder" src="<?php echo $company_logo; ?>" class="company-logo">
                  <span><?php echo $name; ?></span>
                </label>
              </div>
              <?php
                }
              }
              ?>
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <input type="hidden" name="page" value="trending-brands">
              <a href="<?php echo base_url('admin/setting/homepage'); ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
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

<script src="<?php echo base_url('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js'); ?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
<script>
$(document).ready(function () {
  $('#body').wysihtml5();
  var extra_fields = '<div class="form-group"><label for="name" class="col-sm-2 control-label">Label</label><div class="col-sm-9 input-group textarea"><input type="text" name="attached_lebel[]" class="form-control" placeholder="Label..." value="<?php echo '' ;?>" required></div></div><div class="form-group"><label for="name" class="col-sm-2 control-label">Content</label><div class="col-sm-9 input-group textarea"><textarea name="attached_content[]" placeholder="You content..." required></textarea></div></div>';
});
</script>