<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $title ;?>
      </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <!-- ++ Success & error showing section -->
      <div class="alert alert-danger alert-dismissible error_msg" style="display:none;">
          <h4><i class="icon fa fa-ban"></i> Error Message!</h4>
          <span></span>
      </div>
      <?php if($this->session->flashdata('msg_error')){ ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Error Message!</h4>
        <?php echo $this->session->flashdata('eMessage') ; ?>
      </div>
      <?php }?>
      <?php if($this->session->flashdata('msg_success')){ ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Success Message!</h4>
        <?php echo $this->session->flashdata('sMessage') ; ?>
      </div>
      <?php }?>
      <!-- -- Success & error showing section -->

      <div class="row">
        <div class="col-md-10">
          <div class="box box-info">
            <!-- Horizontal Form -->
            <div class="box-header with-border">
              <h3 class="box-title">Edit and update commission setting</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" action="<?php echo base_url(); ?>admin/products/commission" class="form-horizontal commission_setting_form">
              <div class="box-body">
                
                <div class="form-group">
                    <label for="first_name" class="col-sm-2 control-label">Commission Type<span style="color:red;">*</span></label>
                    <div class="col-sm-9 input-group padt7 price-choose">
                      <!-- <input type="radio" name="type" value="flat_rate" class="flat-red"> Flat Price -->
                      <input type="radio" name="type" value="percentage" checked="checked" class="flat-red"> Percentage
                    </div>
                </div>

                <div class="form-group" style="display: none;">
                    <label for="flat_rate" class="col-sm-3 control-label">Commission (Flat Rate)<span style="color:red;">*</span></label>
                    <div class="col-sm-8 input-group">
                      <input type="number" step="0.01" name="flat_rate" id="flat_rate" class="form-control wid100" value="<?php echo $commission->flat_rate; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="flat_rate" class="col-sm-3 control-label">Commission (Percentage)<span style="color:red;">*</span></label>
                    <div class="col-sm-8 input-group">
                      <input type="number" step="0.01" name="percentage" id="percentage" class="form-control wid100" value="<?php echo $commission->percentage; ?>"><span class="per-sign">%</span>
                    </div>
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Update</button>
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
  $(document).ready(function () {
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    });

    $('.commission_setting_form .price-choose .iradio_flat-green').on('ifClicked', function() {
      var sid = $(this).find('.flat-red').val();
      $('#flat_rate, #percentage').closest('.form-group').hide();
      $('#' + sid).closest('.form-group').show();
    });

  });
</script>