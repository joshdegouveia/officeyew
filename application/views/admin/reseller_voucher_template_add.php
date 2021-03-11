<?php
$formHeader = 'Reseller Voucher Add';
$submitText = 'Save';
$name = $template = $description = '';
if (!empty($content)) {
  $submitText = 'Update';
  $name = $content->name;
  $template = $content->template;
  $description = $content->description;
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    <?php echo $title; ?>
    </h1>
  </section>
  
  <!-- Main content -->
  <section class="content reseller-voucher">
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
                  <input type="text" name="name" class="form-control" id="name" placeholder="Template Name" value="<?php echo $name ;?>" required>
                </div>
              </div>

              <?php //if ($type == 'terms_condition' || $type == 'aboutus') { ?>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-9 input-group textarea">
                  <textarea name="template" id="template" placeholder="Template code" required><?php echo $template;?></textarea>
                </div>
                <div class="token"><a href="javascript:void(0)" data-target="#modal_add_template" data-toggle="modal">Browse Tokens</a></div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-9 input-group textarea">
                  <textarea name="description" id="sudescription" placeholder="Description"><?php echo $description;?></textarea>
                </div>
              </div>
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <a href="<?php echo base_url('admin/templates/resellervoucher'); ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
              <button type="submit" class="btn btn-info pull-right"><?php echo $submitText; ?></button>
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

<div class="modal fade" id="modal_add_template" tabindex="-1" role="dialog" aria-labelledby="modal-change-email" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title d-flex align-items-center" id="modal-title" style="float: left;">
          <div>
            <h4 class="mb-0">Tokens</h4>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 40px;">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table>
          <thead>
            <tr>
              <th>Token</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{name}}</td>
              <td>Replace with this token to show customer name.</td>
            </tr>
            <tr>
              <td>{{code}}</td>
              <td>Replace with this token to show voucher code for discount.</td>
            </tr>
            <tr>
              <td>{{expiry_date}}</td>
              <td>Replace with this token to show voucher code expiry date.</td>
            </tr>
            <tr>
              <td>{{discount}}</td>
              <td>Replace with this token to show discount price.</td>
            </tr>
            <tr>
              <td>{{limit}}</td>
              <td>Replace with this token to show discount limit per user.</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Done</button>
      </div>
    </div>
  </div>
</div>

<!-- <script src="<?php //echo base_url('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js'); ?>"></script>
<script src="<?php //echo base_url('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script> -->
<script src="<?php echo base_url('assets/frontend/libs/ckeditor/ckeditor.js'); ?>"></script>
<script>
$(document).ready(function () {
  // $('#template').wysihtml5();
  CKEDITOR.editorConfig = function (config) {
    config.extraPlugins = 'confighelper';
    config.allowedContent = true;
  };
  $('#template').each(function() {
    CKEDITOR.replace(this, {
      format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
      extraPlugins: 'colorbutton',
    });
  });
});
</script>