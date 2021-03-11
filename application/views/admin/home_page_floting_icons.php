<?php
$formHeader = 'Floating Icons Management';
$submitText = 'Save';
$title = $image = $add_btn_style = '';
$add_form_style = 'style="display:none;"';
$icon_required = "required";
if (!empty($icon)) {
  $add_form_style = '';
  $add_btn_style = 'style="display:none;"';
  $title = $icon->title;
  $image = (!empty($icon->filename)) ? UPLOADPATH . 'setting/home_page_ficons/' . $icon->filename : FILEPATH . 'img/default/no-image.png';
  $icon_required = '';
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
          <button class="btn btn-primary mar10" id="add_icon" <?php echo $add_btn_style; ?>>Add Icon</button>
          <div class="icon-form" <?php echo $add_form_style; ?>>
            <form method="post" enctype="multipart/form-data" class="form-horizontal" accept="image/jpeg,image/jpg,image/png,image/gif,image/svg">
              <div class="box-body">
                <div class="form-group">
                  <label for="first_button_title" class="col-sm-4 control-label">Title</label>
                  <div class="col-sm-8 input-group">
                    <input type="text" name="title" class="form-control" value="<?php echo $title; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="first_button_title" class="col-sm-4 control-label">Add Icon</label>
                  <div class="col-sm-8 input-group">
                    <input type="file" name="ufile" class="form-control" <?php echo $icon_required; ?>>
                    <?php if (!empty($image)) { ?>
                    <img src="<?php echo $image; ?>" width="50" height="50">
                    <?php } ?>
                  </div>
                </div>
                
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right"><?php echo $submitText ; ?></button>
              </div>
            </form>
          </div>

          <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Icon</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($content)) {
                        $i = 1 ;
                        foreach($content as $row) {
                          $icon = FILEPATH . 'img/default/no-image.png';
                          if (!empty($row->filename)) {
                            $icon = UPLOADPATH . 'setting/home_page_ficons/' . $row->filename;
                          }
                    ?>
                    <tr>
                        <td><?php echo $i ; ?></td>
                        <td><?php echo $row->title; ?></td>
                        <td><img src="<?php echo $icon; ?>" width="50" height="50"></td>
                        <td>
                            <?php if($row->status == '1') { ?>
                                <a href="<?php echo base_url('admin/setting/'); ?>changestat?act=ficon&cid=<?php echo $row->id ; ?>&stat=<?php echo $row->status ; ?>" class="status-act">
                                    <button type="button" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i>
                                        Active
                                    </button>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo base_url('admin/setting/'); ?>changestat?act=ficon&cid=<?php echo $row->id ; ?>&stat=<?php echo $row->status ; ?>" class="status-act">
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fa fa-close"></i>
                                        Inactive
                                    </button>
                                </a>
                            <?php } ?>
                            <a href="<?php echo base_url('admin/setting/homepageficons/' . $row->id); ?>">
                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                            </a>
                            <a href="<?php echo base_url('admin/setting/delete'); ?>?act=ficon&cid=<?php echo $row->id ; ?>" class="rm-data">
                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Delete</button>
                            </a>
                        </td>
                    </tr>
                    <?php
                        $i++ ;
                        }
                    }
                    ?>
                </tbody>
            </table>

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
      if (!confirm('Are you sure you want to delete this icon?')) {
          return false;
      }
  });
});
</script>