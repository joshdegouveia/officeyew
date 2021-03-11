<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    <?php
    echo $title ;
    $uid = $first_name = $last_name = $email = $dob = $phone = $gender = $type = $phone = $country = $state = $city = '';
    $formHeader = 'Add a new User' ;
    $submitText = 'Add User';
    if(isset($user_detail)){
      $formHeader = 'Edit User';
      $submitText = 'Save User';
      $uid = $user_detail->id;
      $first_name = $user_detail->first_name;
      $last_name = $user_detail->last_name;
      $email = $user_detail->email;
      $dob = $user_detail->dob;
      $phone = $user_detail->phone;
      $gender = $user_detail->gender;
      $type = $user_detail->type;
      $phone = $user_detail->phone;
      $country = $user_detail->country;
      $state = $user_detail->state;
      $city = $user_detail->city;
    }
    ?>
    </h1>
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-10">
        <div class="box box-info">
          <!-- Horizontal Form -->
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo $formHeader ;?></h3>
          </div>
          <?php if ($this->session->flashdata('msg_error')) { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
            <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
            </div>
            <?php } else if ($this->session->flashdata('msg_success')) { ?>
            <div class="alert alert-success alert-dismissible" role="alert">
            <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
            </div>
            <?php } else { ?>
            <div class="alert alert-dismissible" role="alert" style="display: none;">
            <strong></strong>
            </div>
            <?php } ?>
          <form method="post" enctype = "multipart/form-data" class="form-horizontal" id="user_edit_form">
            <div class="box-body">
              
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">First Name</label>
                <div class="col-sm-9 input-group">
                  <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First name" value="<?php echo $first_name ;?>" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Last Name</label>
                <div class="col-sm-9 input-group">
                  <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last name" value="<?php echo $last_name ;?>" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-9 input-group">
                  <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo $email ;?>" <?php //echo (!empty($email)) ? 'readonly disabled' : ''; ?> required style="width: 84%; margin-right: 10px;">
                  <!--<button type="button" class="btn btn-success" style="width: 14%" id="check_email">Check Email</button>-->
                </div>
              </div>
             
              <?php if (empty($uid)) { ?>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-9 input-group">
                  <input type="password" name="password" class="form-control" id="password" placeholder="Password"" required>
                </div>
              </div>
              <?php } ?>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Mobile Number</label>
                <div class="col-sm-9 input-group">
                  <input type="text" name="phone" class="form-control" id="phone" placeholder="Mobile number" value="<?php echo $phone ;?>">
                </div>
              </div>
              
              
              <?php if (!empty($uid)) { ?>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Stripe Account No</label>
                <div class="col-sm-9 input-group">
                  <input type="text" name="stripe" class="form-control" id="stripe" placeholder="Stripe account number" value="<?php echo $stripe ;?>" required>
                </div>
              </div>
              <?php } ?>

            </div>
            <div class="box-footer">
              <input type="hidden" name="uid" id="uid" value="<?php echo $uid ;?>">
              <a href="<?php echo base_url('admin/users/' . $type); ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
              <button type="submit" class="btn btn-info pull-right" name="submit"><?php echo $submitText ; ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- <script src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> -->
<script>
$(document).ready(function () {
  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass   : 'iradio_flat-green'
  }) ;
  $(document).ready(function(){
    $(":input").inputmask();
  });

  $('#check_email').click(function() {
    var email = $('#email').val().trim();
    var uid = $('#uid').val();

    if (email == '') {
      return false;
    }

    $.ajax({
      url: base_url + 'admin/users/checkemail',
      type: 'post',
      dataType: 'json',
      data: { email: email, uid: uid },
      success: function(response) {
        if (response.success) {
          $('.alert').removeClass('alert-success alert-danger').addClass('alert-success').show();
          $('.alert strong').html(response.msg);
        } else {
          $('.alert').removeClass('alert-success alert-danger').addClass('alert-danger').show();
          $('.alert strong').html(response.msg);
        }
      }
    });
  });

  /*$('.utype .iradio_flat-green').on('ifClicked', function() {
    var val = $(this).children().val();
    if (val == 'employee') {
      $('.assign-dep').show();
    } else {
      $('.assign-dep').hide();
    }
  });*/

  var countries, states, cities;
  var sel_country = $('#country').attr('data-country');
  var sel_state = $('#state').attr('data-state');
  var sel_city = $('#city').attr('data-city');

  $.ajax({
      url: base_url + 'assets/frontend/js/country.json',
      type: 'get',
      dataType: 'json',
      async: false,
      success: function(response) {
          countries = response;
          var options = '';
          var selected = '';
          var sel_option = $('#country').attr('data-country');
          options += '<option value="">-- Select --</option>';
          for (var i = 0; i < response.countries.length; i++) {
              selected = (response.countries[i].id == sel_option) ? 'selected="selected"' : '';
              options += '<option value="' + response.countries[i].id + '" ' + selected + '>' + response.countries[i].name + '</option>';
          }
          $('#country').html(options);
      }
  });
  $('#country').on('change', function() {
      var val = $(this).val();
      var sel_option = '';
      if (typeof states == 'undefined') {
          $.ajax({
              url: base_url + 'assets/frontend/js/states.json',
              type: 'get',
              dataType: 'json',
              async: false,
              success: function(response) {
                  states = response;
                  var options = '';
                  for (var i = 0; i < response.states.length; i++) {
                      if (response.states[i].country_id == val) {
                          selected = (response.states[i].id == sel_state) ? 'selected="selected"' : '';
                          options += '<option value="' + response.states[i].id + '" ' + selected + '>' + response.states[i].name + '</option>';
                      }
                  }
                  $('#state').html(options);
              }
          });
      } else {
          var options = '';
          var selected = '';
          for (var i = 0; i < states.states.length; i++) {
              if (states.states[i].country_id == val) {
                  selected = (states.states[i].id == sel_option) ? 'selected="selected"' : '';
                  options += '<option value="' + states.states[i].id + '" ' + selected + '>' + states.states[i].name + '</option>';
              }
          }
          $('#state').html(options);
      }
  });
  $('#state').on('change', function() {
      var val = $(this).val();
      var sel_option = '';
      $.ajax({
          url: base_url + 'admin/users/getcity?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
          type: 'post',
          dataType: 'json',
          data: {
              'val': val
          },
          async: false,
          success: function(response) {
              if (response.success) {
                  if (response.data != '') {
                      var options = '';
                      var selected = '';
                      for (var i = 0; i < response.data.length; i++) {
                          selected = (response.data[i].id == sel_city) ? 'selected="selected"' : '';
                          options += '<option value="' + response.data[i].id + '" ' + selected + '>' + response.data[i].name + '</option>';
                      }
                      $('#city').html(options);
                  }
              }
          }
      });
  });

  if (sel_country != '') {
      $('#country').trigger('change');
  }
  if (sel_state != '') {
      $('#state').trigger('change');
  }
});
// $('.textarea').wysihtml5();
</script>