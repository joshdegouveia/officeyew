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
      <?php if($this->session->flashdata('eMessage')){ ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Error Message!</h4>
        <?php echo $this->session->flashdata('eMessage') ; ?>
      </div>
      <?php }?>
      <?php if($this->session->flashdata('sMessage')){ ?>
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
                <h3 class="box-title">Edit and update profile</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form method="post"  action="<?php echo base_url(); ?>admin/users/updateProfile" class="form-horizontal profile_form">
                <div class="box-body">
                  
                  <div class="form-group">
                      <label for="first_name" class="col-sm-2 control-label">First Name<span style="color:red;">*</span></label>
                      <div class="col-sm-9 input-group">
                          <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name" value="<?php echo $userDetail->first_name ;?>" required>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="last_name" class="col-sm-2 control-label">Last Name<span style="color:red;">*</span></label>
                      <div class="col-sm-9 input-group">
                          <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name" value="<?php echo $userDetail->last_name ;?>" required>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="email" class="col-sm-2 control-label">Email<span style="color:red;">*</span></label>
                      <div class="col-sm-9 input-group">
                          <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo $userDetail->email ;?>" required>
                      </div>
                  </div>
                  <?php /* ?>
                  <div class="form-group">
                      <label for="phone" class="col-sm-2 control-label">Phone No<span style="color:red;">*</span></label>
                      <div class="col-sm-9 input-group">
                          <input type="text" name="phone" class="form-control" id="email" placeholder="Phone No" value="<?php echo $userDetail->phone ;?>" required>
                      </div>
                  </div><?php */ ?>
                  
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <input type="hidden" name="user_id" value="<?php echo $userDetail->id ;?>">
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
    // ++ Package form validation work
    $(document).on('submit', 'form.profile_form', function(){
      var error = 0 ;
      var errorMsg = '' ;
      var first_name = $('input[name=first_name]').val() ;
      var last_name = $('input[name=last_name]').val() ;
      var email = $('input[name=email]').val() ;
      // var phone = $('input[name=phone]').val() ;

      if($.trim(first_name) == '' && $.trim(last_name) == ''){
          error = 1 ;
          errorMsg += '<p>First name or Last name should not be blank.</p>' ;
      }
      if($.trim(email) == ''){
          error = 1 ;
          errorMsg += '<p>Email should not be blank.</p>' ;
      }
      /*if($.trim(phone) == ''){
          error = 1 ;
          errorMsg += '<p>Phone number should not be blank.</p>' ;
      }*/
      if(error){
        $('div.error_msg').find('span').html(errorMsg) ;
        $('div.error_msg').slideDown(500).delay(3000).slideUp(300) ;
        $("html, body").animate({ scrollTop: 0 }, "first");
        return false ;
      }
    }) ;
    // -- Package form validation work
  })
</script>