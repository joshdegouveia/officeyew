<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    <?php
    echo $title;
    $formHeader = 'CMS Edit';
    $submitText = 'Save';
    $name = $cms->name;
    $body = $cms->body;
    $sub_description = $cms->sub_description;
    $video_link = $cms->link;
    $type = $cms->type;
    $extra_fields_value = (!empty($cms->attached)) ? unserialize($cms->attached) : array();
    $meta_key = '';
    $meta_description = '';
    if (!empty($meta_data)) {
      $meta_key = $meta_data->meta_key;
      $meta_description = $meta_data->meta_description;
    }
    ?>
    </h1>
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
                  <input type="text" name="name" class="form-control" id="name" placeholder="CMS Name" value="<?php echo $name ;?>" required>
                </div>
              </div>

              <?php //if ($type == 'terms_condition' || $type == 'aboutus') { ?>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-9 input-group textare">
                  <textarea name="body" id="body" class="form-control wysihtml" placeholder="CMS Text" required><?php echo $body;?></textarea>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Sub Description</label>
                <div class="col-sm-9 input-group textarea">
                  <textarea name="sub_description" class="form-control" id="sub_description" placeholder="Sub description" required><?php echo $sub_description;?></textarea>
                </div>
              </div>

              <?php
              if (!empty($extra_fields)) {
                foreach ($extra_fields as $k => $value) {
                  $extra_value = (array_key_exists($k, $extra_fields_value)) ? $extra_fields_value[$k] : '';
                  if ($value['type'] == 'textbox') {
              ?>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label"><?php echo $value['title']; ?></label>
                <div class="col-sm-9 input-group">
                  <input type="text" name="<?php echo $k; ?>" class="form-control" value="<?php echo $extra_value; ?>">
                </div>
              </div>
              <?php } else if ($value['type'] == 'textarea') { ?>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label"><?php echo $value['title']; ?></label>
                <div class="col-sm-9 input-group textarea">
                  <textarea name="<?php echo $k; ?>" class="form-control <?php echo ($value['wysihtml']) ? 'wysihtml' : ''; ?>"><?php echo $extra_value; ?></textarea>
                </div>
              </div>
              <?php
                    } else if ($value['type'] == 'file') {
                      $accept = (array_key_exists('accept', $value)) ? 'accept="' . $value['accept'] . '"' : '';
              ?>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label"><?php echo $value['title']; ?></label>
                <div class="col-sm-9 input-group">
                  <input type="file" name="<?php echo $k; ?>" class="form-control" <?php echo $accept; ?>>
                  <?php if (!empty($extra_value) && file_exists(UPLOADDIR . 'pages/' . $extra_value)) { ?>
                  <img src="<?php echo UPLOADPATH . 'pages/' . $extra_value; ?>" width="100" height="100">
                  <?php } ?>
                  <input type="hidden" name="old_<?php echo $k; ?>" value="<?php echo $extra_value; ?>">
                </div>
              </div>
              <?php } ?>
              <?php
                }
              }
              ?>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Meta Description</label>
                <div class="col-sm-9 input-group textarea">
                  <textarea name="meta_description" class="form-control" id="meta_description" placeholder="Meta description" required><?php echo $meta_description;?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Meta Key</label>
                <div class="col-sm-9 input-group textarea">
                  <textarea name="meta_key" class="form-control" id="meta_key" placeholder="Meta key" required><?php echo $meta_key;?></textarea>
                </div>
              </div>
              <?php /* ?><fieldset>
                <legend>Extra fields</legend>

                <div class="extra-fields">
                  <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Label</label>
                    <div class="col-sm-7 input-group textarea">
                      <input type="text" name="attached_lebel[]" class="form-control" placeholder="Label..." value="<?php echo '' ;?>" required>
                    </div>
                    <div class="col-sm-2">
                      <a href="javascript:void(0)">Remove</a>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Content</label>
                    <div class="col-sm-9 input-group textarea">
                      <textarea name="attached_content[]" placeholder="You content..." required></textarea>
                    </div>
                  </div>
                </div>

                <button type="button" class="btn btn-default" id="addFields();">Add+</button>
              </fieldset><?php */ ?>
              <?php /*} else if ($type == 'video_link') { ?>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Link</label>
                <div class="col-sm-9 input-group">
                  <input type="text" name="video_link" class="form-control" id="video_link" placeholder="Video link" value="<?php echo $video_link ;?>" required>
                </div>
              </div>
              <?php }*/ ?>
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <a href="<?php echo base_url('admin/cms'); ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
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

<!-- <script src="<?php //echo base_url('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js'); ?>"></script>
<script src="<?php //echo base_url('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script> -->
<script src="<?php echo base_url('assets/js/ckeditor/ckeditor.js'); ?>"></script>
<script>
$(document).ready(function () {
  // $('#body').wysihtml5();
  CKEDITOR.editorConfig = function (config) {
    config.extraPlugins = 'confighelper';
    config.allowedContent = true;
  };
  $('.wysihtml').each(function() {
    CKEDITOR.replace(this, {
      format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div'
    });
  });
  var extra_fields = '<div class="form-group"><label for="name" class="col-sm-2 control-label">Label</label><div class="col-sm-9 input-group textarea"><input type="text" name="attached_lebel[]" class="form-control" placeholder="Label..." value="<?php echo '' ;?>" required></div></div><div class="form-group"><label for="name" class="col-sm-2 control-label">Content</label><div class="col-sm-9 input-group textarea"><textarea name="attached_content[]" placeholder="You content..." required></textarea></div></div>';
});
</script>