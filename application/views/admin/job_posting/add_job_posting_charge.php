<?php
$formHeader = 'Add job posting charge';
$submitText = 'Save';
$job_category = '';
$price = '';
$description = '';
$regular_price = '';
$duration_in_week = '';
$resume_number = '';
$status = '';
$pid = '';
//$user_id = '';
if (!empty($la_data)) {
    $formHeader = 'Edit job posting charge';
    $submitText = 'Update';
    $job_category = $la_data->job_category;
    $price = $la_data->price;
    $description = $la_data->description;
    $duration_in_week = $la_data->duration_in_week;
    $resume_number = $la_data->resume_number;
    $status = $la_data->status;
    $pid = $la_data->job_posting_charges_id;
//    $user_id = $la_data->user_id;
}
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
            <div class="col-md-10">
                <div class="box box-info">
                    <!-- Horizontal Form -->
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $formHeader; ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post" enctype="multipart/form-data" class="form-horizontal">
                        <input type="hidden" name="pid"  value="<?php echo $pid; ?>"/>
                        <div class="box-body">

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Product Name</label>
                                <div class="col-sm-6 input-group">
                                    <select name="job_category" class="form-control">
                                        <option value="per_post" <?php echo ($job_category == 'per_post') ? "selected" : "" ?>>Per post</option>
                                        <option value="monthly" <?php echo ($job_category == 'monthly') ? "selected" : "" ?>>Monthly</option>
                                        <option value="one_time" <?php echo ($job_category == 'one_time') ? "selected" : "" ?>>One time</option>
                                    </select>
<!--                                    <input type="text" name="job_category" class="form-control" id="name" placeholder="Job category" value="<?php echo $job_category; ?>" required>-->
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-6 input-group">
                                    <input type="text" name="price" class="form-control" id="regular_price" placeholder="Price" value="<?php echo $price; ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-6 input-group">

                                    <textarea name="description" id="short_description" class="form-control wysihtml" placeholder="Description" required><?php echo $description; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Duration in week</label>
                                <div class="col-sm-6 input-group">
                                    <input type="number" name="duration_in_week" class="form-control" id="duration_in_week" placeholder="Duration in week" value="<?php echo $duration_in_week; ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-6 input-group">
                                    <input type="radio" name="status" value="A" <?php if (($status == 'A') || ($status == '')) { ?>checked="checked"<?php } ?> />Active
                                    <input type="radio" name="status" value="Ar" <?php if ($status == 'Ar') { ?>checked="checked"<?php } ?>/>Inactive

                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">

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
<!--<script src="<?php echo base_url('assets/js/ckeditor/ckeditor.js'); ?>"></script>
<script>
    $(document).ready(function () {
        // $('#body').wysihtml5();
        CKEDITOR.editorConfig = function (config) {
            config.extraPlugins = 'confighelper';
            config.allowedContent = true;
        };
        $('.wysihtml').each(function () {
            CKEDITOR.replace(this, {
                format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div'
            });
        });
        var extra_fields = '<div class="form-group"><label for="name" class="col-sm-2 control-label">Label</label><div class="col-sm-9 input-group textarea"><input type="text" name="attached_lebel[]" class="form-control" placeholder="Label..." value="<?php echo ''; ?>" required></div></div><div class="form-group"><label for="name" class="col-sm-2 control-label">Content</label><div class="col-sm-9 input-group textarea"><textarea name="attached_content[]" placeholder="You content..." required></textarea></div></div>';
    });
</script>-->