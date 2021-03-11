<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper user-detail">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    <?php echo $title ;?>
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
          <div class="form-group">
            <label for="name" class="col-sm-4 control-label">First Name</label>
            <div class="col-sm-7 input-group">
              <?php echo $user_detail->first_name; ?>
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-sm-4 control-label">Last Name</label>
            <div class="col-sm-7 input-group">
              <?php echo $user_detail->last_name; ?>
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-sm-4 control-label">Email</label>
            <div class="col-sm-7 input-group">
              <?php echo $user_detail->email; ?>
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-sm-4 control-label">Phone</label>
            <div class="col-sm-7 input-group">
              <?php echo $user_detail->phone; ?>
            </div>
          </div>
        </div>
        <?php if (!empty($user_bank_detail)) { ?>
        <div class="info-box">
          <div class="form-group">
            <label for="name" class="col-sm-4 control-label">Stripe Account</label>
            <div class="col-sm-7 input-group">
              <?php
              if (!empty($user_bank_detail->stripe_no)) {
                echo $user_bank_detail->stripe_no;
              } else {
              ?>
              <a href="<?php echo base_url('admin/users/edit?uid=' . $user_detail->id); ?>">Please add stripe number</a>
              <?php } ?>
            </div>
          </div>
          <?php
          if (!empty($user_bank_detail->bank_detail)) {
            $bank_detail = unserialize($user_bank_detail->bank_detail);
            foreach ($bank_detail as $k => $value) {
          ?>
          <div class="form-group">
            <label for="name" class="col-sm-4 control-label"><?php echo ucwords(str_replace('_', ' ', $k)); ?></label>
            <div class="col-sm-7 input-group">
              <?php echo ucwords($value); ?>
            </div>
          </div>
          <?php } ?>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if (!empty($user_store_detail)) { ?>
        <div class="info-box">
          <div class="form-group">
            <label for="name" class="col-sm-4 control-label">Store Name</label>
            <div class="col-sm-7 input-group">
              <?php echo ucwords($user_store_detail->name); ?>
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-sm-4 control-label">Description</label>
            <div class="col-sm-7 input-group">
              <?php echo ucwords($user_store_detail->description); ?>
            </div>
          </div>
          <?php
          if (!empty($user_store_detail->image) && file_exists(UPLOADDIR . 'user/store/' . $user_store_detail->image)) {
          ?>
          <div class="form-group">
            <label for="name" class="col-sm-4 control-label">Image</label>
            <div class="col-sm-7 input-group">
              <img src="<?php echo UPLOADPATH . 'user/store/thumb/' . $user_store_detail->image; ?>">
            </div>
          </div>
          <?php } ?>
        </div>
        <?php } ?>
      </div>

      <div class="col-md-6 col-sm-6 col-xs-12" style="display:none;">
        <div class="info-box pro-pic" >
          <?php
          if (!empty($user_detail->filename)) {
            $image = UPLOADPATH . 'users/profile/' . $user_detail->filename;
            if (is_file($image)) {
          ?>
              <img src="<?php echo $image; ?>" width="200" height="200">
          <?php    
            }
          }
          ?>
          <img src="<?php echo FILEPATH; ?>img/default/profile-pic-blank.png" width="200" height="200">
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->