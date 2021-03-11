<?php
$formHeader = 'FAQ Category Add';
$submitText = 'Save';
$name = '';
$cid = 0;

if (!empty($faq)) {
  $formHeader = 'FAQ Category Edit';
  $submitText = 'Update';
  $name = $faq->name;
  $cid = $faq->id;
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
                <div class="col-sm-9 input-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="FAQ category name" value="<?php echo $name ;?>" required>
                </div>
              </div>
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer">

              <a href="<?php echo base_url('admin/faq/categories'); ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
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