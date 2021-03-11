<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    <?php
    echo $title ;
    $formHeader = '';
    ?>
    </h1>
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-10">
        <div class="box box-info">
          <?php if ($this->session->flashdata('msg_error')) { ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
          </div>
          <?php } else if ($this->session->flashdata('msg_success')) { ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
          </div>
          <?php } else { ?>
          <div class="alert alert-danger alert-dismissible" role="alert" style="display: none;">
            <strong></strong>
          </div>
          <?php } ?>
          <!-- Horizontal Form -->
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo $formHeader ;?></h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <?php echo form_open("admin/auth/change_password");?>
          <div class="box-body">
            
            <div class="form-group">
              <label for="phone" class="col-sm-2 control-label">Old Password</label>
              <div class="col-sm-9 input-group">
                <?php echo form_input($old_password); ?>
              </div>
            </div>
            
            <div class="form-group">
              <label for="phone" class="col-sm-2 control-label">New Password</label>
              <div class="col-sm-9 input-group">
                <?php echo form_input($new_password);?>
              </div>
            </div>
            
            <div class="form-group">
              <label for="phone" class="col-sm-2 control-label">Confirm Password</label>
              <div class="col-sm-9 input-group">
                <?php echo form_input($new_password_confirm);?>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <?php echo form_input($user_id);?>
            <button type="submit" class="btn btn-info pull-right">Submit</button>
          </div>
          <?php echo form_close();?>
          <!-- /.box -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
$(document).ready(function () {
  
});
</script>