<?php
$formHeader = 'Manage site logos';
$submitText = 'Save';
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
      <?php if ($this->session->flashdata('msg_error')){ ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Error Message!</h4>
        <?php echo $this->session->flashdata('msg_error') ; ?>
      </div>
      <?php } else if ($this->session->flashdata('msg_success')){ ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Success Message!</h4>
        <?php echo $this->session->flashdata('msg_success') ; ?>
      </div>
      <?php } ?>
      <div class="col-md-10">
        <div class="box box-info">
          <!-- Horizontal Form -->
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo $formHeader ;?></h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form method="post" enctype="multipart/form-data" class="form-horizontal" enctype="multipart/form-data">
            <div class="box-body">
              
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Add Logo For All Login and Registration Page</label>
                <div class="col-sm-3 input-group">
                  <input type="file" name="ufile" class="form-control" id="ufile" accept="image/x-png,image/gif,image/jpeg">
                  <img src="<?php echo $logos['ufile']; ?>" style="max-width: 100px; max-height: 150px;">
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Reseller Login Page</label>
                <div class="col-sm-3 input-group">
                  <input type="file" name="slfile" class="form-control" id="slfile" accept="image/x-png,image/gif,image/jpeg">
                  <img src="<?php echo $logos['slfile']; ?>" style="max-width: 100px; max-height: 150px;">
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Reseller Registration Page</label>
                <div class="col-sm-3 input-group">
                  <input type="file" name="srfile" class="form-control" id="srfile" accept="image/x-png,image/gif,image/jpeg">
                  <img src="<?php echo $logos['srfile']; ?>" style="max-width: 100px; max-height: 150px;">
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Reseller Forgot Password Page</label>
                <div class="col-sm-3 input-group">
                  <input type="file" name="sffile" class="form-control" id="sffile" accept="image/x-png,image/gif,image/jpeg">
                  <img src="<?php echo $logos['sffile']; ?>" style="max-width: 100px; max-height: 150px;">
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Business Login Page</label>
                <div class="col-sm-3 input-group">
                  <input type="file" name="blfile" class="form-control" id="blfile" accept="image/x-png,image/gif,image/jpeg">
                  <img src="<?php echo $logos['blfile']; ?>" style="max-width: 100px; max-height: 150px;">
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Business Registration Page</label>
                <div class="col-sm-3 input-group">
                  <input type="file" name="brfile" class="form-control" id="brfile" accept="image/x-png,image/gif,image/jpeg">
                  <img src="<?php echo $logos['brfile']; ?>" style="max-width: 100px; max-height: 150px;">
                </div>
              </div>
               <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Business Forgot Password Page</label>
                <div class="col-sm-3 input-group">
                  <input type="file" name="bffile" class="form-control" id="bffile" accept="image/x-png,image/gif,image/jpeg">
                  <img src="<?php echo $logos['bffile']; ?>" style="max-width: 100px; max-height: 150px;">
                </div>
              </div>
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
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