<?php
$facebook = $insta = $twitter = $linkdin = '';
if (!empty($sociallinks)) {
    foreach ($sociallinks as $social) {
        if ($social->type == 'facebook') {
            $facebook = $social->value;
        }
        if ($social->type == 'insta') {
            $insta = $social->value;
        }
        if ($social->type == 'twitter') {
            $twitter = $social->value;
        }
        if ($social->type == 'linkdin') {
            $linkdin = $social->value;
        }
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper site-setting">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
<?php echo $title; ?>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- ++ Success & error showing section -->
        <div class="alert alert-danger alert-dismissible error_msg" style="display:none;">
            <h4><i class="icon fa fa-ban"></i> Error Message!</h4>
            <span></span>
        </div>
<?php if ($this->session->flashdata('msg_error')) { ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error Message!</h4>
    <?php echo $this->session->flashdata('msg_error'); ?>
            </div>
            <?php } ?>
        <?php if ($this->session->flashdata('msg_success')) { ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success Message!</h4>
    <?php echo $this->session->flashdata('msg_success'); ?>
            </div>
            <?php } ?>
        <!-- -- Success & error showing section -->

        <div class="row">
            <div class="col-md-10">
                <div class="box box-info">
                    <!-- Horizontal Form -->
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit and update Social Links</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post" action="<?php echo base_url(); ?>admin/setting/social_links" class="form-horizontal setting_form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="site_name" class="col-sm-2 control-label">Facebook link<span style="color:red;">*</span></label>
                                <div class="col-sm-9 input-group">
                                    <input type="text" name="facebook" class="form-control" value="<?php echo $facebook; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="site_email" class="col-sm-2 control-label">Instagram<span style="color:red;">*</span></label>
                                <div class="col-sm-9 input-group">
                                    <input type="text" name="insta" class="form-control" value="<?php echo $insta; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="site_email" class="col-sm-2 control-label">Twitter<span style="color:red;">*</span></label>
                                <div class="col-sm-9 input-group">
                                    <input type="text" name="twitter" class="form-control" value="<?php echo $twitter; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="site_email" class="col-sm-2 control-label">Linkdin<span style="color:red;">*</span></label>
                                <div class="col-sm-9 input-group">
                                    <input type="text" name="linkdin" class="form-control" value="<?php echo $linkdin; ?>" required>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-info pull-right">Update</button>
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
        //color picker with addon
        // $('.my-colorpicker2').colorpicker() ;
    });
</script>