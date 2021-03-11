<?php
$formHeader = 'Testimonials Management';
$submitText = 'Save';
$name = $image = $tag = $description = $add_btn_style = '';
$rating = 5;
$add_form_style = 'style="display:none;"';
if (!empty($testimonial)) {
  $add_form_style = '';
  $add_btn_style = 'style="display:none;"';
  $name = $testimonial->name;
  $tag = $testimonial->tag;
  $description = $testimonial->description;
  $rating = $testimonial->rating;
  $image = (!empty($testimonial->filename)) ? UPLOADPATH . 'setting/home_page_testimonials/' . $testimonial->filename : FILEPATH . 'img/default/no-image.png';
}
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
          <button class="btn btn-primary mar10" id="add_icon" <?php echo $add_btn_style; ?>>Add Testimonial</button>
          <div class="icon-form" <?php echo $add_form_style; ?>>
            <form method="post" enctype="multipart/form-data" class="form-horizontal" accept="image/jpeg,image/jpg,image/png,image/gif,image/svg">
              <div class="box-body">
                <div class="form-group">
                  <label for="first_button_title" class="col-sm-4 control-label">Name</label>
                  <div class="col-sm-8 input-group">
                    <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="first_button_title" class="col-sm-4 control-label">Image</label>
                  <div class="col-sm-8 input-group">
                    <input type="file" name="ufile" class="form-control">
                    <?php if (!empty($image)) { ?>
                    <img src="<?php echo $image; ?>" width="50" height="50">
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="first_button_title" class="col-sm-4 control-label">Tag</label>
                  <div class="col-sm-8 input-group">
                    <input type="text" name="tag" class="form-control" value="<?php echo $tag; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="name" class="col-sm-4 control-label">Description</label>
                  <div class="col-sm-8 input-group textarea">
                    <textarea name="description" placeholder="Description" required rows="4"><?php echo $description;?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="first_button_title" class="col-sm-4 control-label">Rating</label>
                  <div class="col-sm-8 input-group">
                    <select name="rating" class="form-control" required>
                      <?php
                      for ($i = 1; $i < 6; $i++) {
                        $selected = ($i == $rating) ? 'selected="selected"' : '';
                      ?>
                      <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                
              </div>
              <div class="box-footer">
                <a href="<?php echo base_url('admin/setting/customertestimonials'); ?>" class="btn btn-danger" <?php echo $add_form_style; ?>>Cancel</a>
                <button type="submit" class="btn btn-info pull-right wid100"><?php echo $submitText ; ?></button>
              </div>
            </form>
          </div>

          <?php if (!empty($content)) { ?>
          <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Tag</th>
                        <th>Image</th>
                        <th>Rating</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1 ;
                        foreach($content as $row) {
                          $icon = FILEPATH . 'img/default/no-image.png';
                          if (!empty($row->filename)) {
                            $icon = UPLOADPATH . 'setting/home_page_testimonials/' . $row->filename;
                          }
                    ?>
                    <tr>
                        <td><?php echo $i ; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->tag; ?></td>
                        <td><img src="<?php echo $icon; ?>" width="50" height="50"></td>
                        <td><?php echo $row->rating; ?></td>
                        <td>
                            <?php if($row->status == '1') { ?>
                                <a href="<?php echo base_url('admin/setting/'); ?>changestat?act=testimonial&cid=<?php echo $row->id ; ?>&stat=<?php echo $row->status ; ?>" class="status-act">
                                    <button type="button" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i>
                                        Active
                                    </button>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo base_url('admin/setting/'); ?>changestat?act=testimonial&cid=<?php echo $row->id ; ?>&stat=<?php echo $row->status ; ?>" class="status-act">
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fa fa-close"></i>
                                        Inactive
                                    </button>
                                </a>
                            <?php } ?>
                            <a href="<?php echo base_url('admin/setting/customertestimonials/' . $row->id); ?>">
                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                            </a>
                            <a href="<?php echo base_url('admin/setting/delete'); ?>?act=testimonial&cid=<?php echo $row->id ; ?>" class="rm-data">
                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Delete</button>
                            </a>
                        </td>
                    </tr>
                    <?php
                        $i++ ;
                        }
                    ?>
                </tbody>
            </table>
            <?php } ?>
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
  $('#add_icon').click(function() {
    $('.icon-form').toggle();
  });
  $('a.rm-data').on('click', function() {
      if (!confirm('Are you sure you want to delete this testimonial?')) {
          return false;
      }
  });
});
</script>