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
      <!-- -- Success & error showing section -->

      <div class="row">
        <div class="col-md-10">
          <div class="box box-info">
            <!-- Horizontal Form -->
            <div class="box-header with-border">
              <h3 class="box-title">Edit and update setting</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" action="<?php echo base_url('admin/setting/homepage'); ?>" enctype="multipart/form-data" class="form-horizontal setting_form">
              <div class="box-body">
                
                <div class="form-group">
                  <label for="meta_description" class="col-sm-2 control-label">Meta Description<span style="color:red;">*</span></label>
                  <div class="col-sm-9 input-group">
                    <textarea name="meta_description" class="form-control" required><?php echo $meta_description; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="meta_key" class="col-sm-2 control-label">Meta Key<span style="color:red;">*</span></label>
                  <div class="col-sm-9 input-group">
                    <textarea name="meta_key" class="form-control" required><?php echo $meta_key; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="first_heading" class="col-sm-2 control-label">First Heading<span style="color:red;">*</span></label>
                  <div class="col-sm-9 input-group">
                    <input type="text" name="first_heading" class="form-control" value="<?php echo $setting['first_heading']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="second_heading" class="col-sm-2 control-label">Second Heading<span style="color:red;">*</span></label>
                  <div class="col-sm-9 input-group">
                    <input type="text" name="second_heading" class="form-control" value="<?php echo $setting['second_heading']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="summary" class="col-sm-2 control-label">Summary<span style="color:red;">*</span></label>
                  <div class="col-sm-9 input-group">
                    <textarea name="summary" class="form-control" required><?php echo $setting['summary']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="first_button_title" class="col-sm-2 control-label">First Button Title</label>
                  <div class="col-sm-9 input-group">
                    <input type="text" name="first_button_title" class="form-control" value="<?php echo $setting['first_button_title']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="first_button_link" class="col-sm-2 control-label">First Button Link</label>
                  <div class="col-sm-9 input-group">
                    <input type="text" name="first_button_link" class="form-control" value="<?php echo $setting['first_button_link']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="second_button_title" class="col-sm-2 control-label">Second Button Title</label>
                  <div class="col-sm-9 input-group">
                    <input type="text" name="second_button_title" class="form-control" value="<?php echo $setting['second_button_title']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="second_button_link" class="col-sm-2 control-label">Second Button Link</label>
                  <div class="col-sm-9 input-group">
                    <input type="text" name="second_button_link" class="form-control" value="<?php echo $setting['second_button_link']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="register_form_heading_content" class="col-sm-2 control-label">Regsiter Form Heading<span style="color:red;">*</span></label>
                  <div class="col-sm-9 input-group">
                    <textarea name="register_form_heading_content" class="form-control wysihtml" required><?php echo $setting['register_form_heading_content']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="store_section_content" class="col-sm-2 control-label">Store Section<span style="color:red;">*</span></label>
                  <div class="col-sm-9 input-group">
                    <textarea name="store_section_content" class="form-control wysihtml" required><?php echo $setting['store_section_content']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="store_section_content" class="col-sm-2 control-label">Store Section Image<span style="color:red;">*</span></label>
                  <div class="col-sm-3">
                    <input type="file" name="store_section_image" class="form-control" value="<?php echo $setting['store_section_image']; ?>" accept="image/jpeg,image/jpg,image/png,image/gif">
                  </div>
                  <?php if (!empty($setting['store_section_image'])) { ?>
                  <div class="col-sm-3 input-group">
                    <img src="<?php echo UPLOADPATH . 'setting/home_page_setting/' . $setting['store_section_image']; ?>" width="80" height="80">
                  </div>
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label for="app_section_content" class="col-sm-2 control-label">App Section<span style="color:red;">*</span></label>
                  <div class="col-sm-9 input-group">
                    <textarea name="app_section_content" class="form-control wysihtml" required><?php echo $setting['app_section_content']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="store_section_content" class="col-sm-2 control-label">App Section Image<span style="color:red;">*</span></label>
                  <div class="col-sm-3">
                    <input type="file" name="app_section_image" class="form-control" value="<?php echo $setting['app_section_image']; ?>" accept="image/jpeg,image/jpg,image/png,image/gif">
                  </div>
                  <?php if (!empty($setting['app_section_image'])) { ?>
                  <div class="col-sm-3 input-group">
                    <img src="<?php echo UPLOADPATH . 'setting/home_page_setting/' . $setting['app_section_image']; ?>" width="80" height="80">
                  </div>
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label for="second_button_title" class="col-sm-2 control-label">About Section Title</label>
                  <div class="col-sm-9 input-group">
                    <input type="text" name="about_section_title" class="form-control" value="<?php echo $setting['about_section_title']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="about_section_sub_heading" class="col-sm-2 control-label">About Section Sub heading<span style="color:red;">*</span></label>
                  <div class="col-sm-9 input-group">
                    <textarea name="about_section_sub_heading" class="form-control" required><?php echo $setting['about_section_sub_heading']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="about_section_image" class="col-sm-2 control-label">About Section Image<span style="color:red;">*</span></label>
                  <div class="col-sm-3">
                    <input type="file" name="about_section_image" class="form-control" value="<?php echo $setting['about_section_image']; ?>" accept="image/jpeg,image/jpg,image/png,image/gif">
                  </div>
                  <?php if (!empty($setting['about_section_image'])) { ?>
                  <div class="col-sm-3 input-group">
                    <img src="<?php echo UPLOADPATH . 'setting/home_page_setting/' . $setting['about_section_image']; ?>" width="80" height="80">
                  </div>
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label for="about_application_section" class="col-sm-2 control-label">About Section<span style="color:red;">*</span></label>
                  <div class="col-sm-9 input-group">
                    <textarea name="about_application_section" class="form-control wysihtml" required><?php echo $setting['about_application_section']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="second_button_title" class="col-sm-2 control-label">About Section Link</label>
                  <div class="col-sm-9 input-group">
                    <input type="address" name="about_section_link" class="form-control" value="<?php echo $setting['about_section_link']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="second_button_title" class="col-sm-2 control-label"></label>
                  <div class="col-sm-9 input-group">
                    <a href="<?php echo base_url('admin/setting/homepageficons'); ?>" target="_blank">Add About Section Floating Icons</a>
                  </div>
                </div>
                <div class="form-group">
                  <label for="second_button_title" class="col-sm-2 control-label">Customer Review Title</label>
                  <div class="col-sm-9 input-group">
                    <input type="address" name="customer_review_title" class="form-control" value="<?php echo $setting['customer_review_title']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="customer_review_section" class="col-sm-2 control-label">Customer Review Section<span style="color:red;">*</span></label>
                  <div class="col-sm-9 input-group">
                    <textarea name="customer_review_section" id="customer_review_section" class="form-control wysihtml" required><?php echo $setting['customer_review_section']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="second_button_title" class="col-sm-2 control-label"></label>
                  <div class="col-sm-9 input-group">
                    <a href="<?php echo base_url('admin/setting/customertestimonials'); ?>" target="_blank">Add Customer Testimonials</a>
                  </div>
                </div>
                <div class="form-group">
                  <label for="footer_copy_right" class="col-sm-2 control-label">Footer Copyright Section<span style="color:red;">*</span></label>
                  <div class="col-sm-9 input-group">
                    <textarea name="footer_copy_right" id="footer_copy_right" class="form-control wysihtml" required><?php echo $setting['footer_copy_right']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="footer_copy_right" class="col-sm-2 control-label">Footer Content<span style="color:red;">*</span></label>
                  <div class="col-sm-9 input-group">
                    <textarea name="footer_logo_content" id="footer_logo_content" class="form-control wysihtml" required><?php echo $setting['footer_logo_content']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="trending_brands_heading" class="col-sm-2 control-label">Trending Brands Heading<span style="color:red;">*</span></label>
                  <div class="col-sm-9 input-group">
                    <textarea name="trending_brands_heading" id="trending_brands_heading" class="form-control wysihtml" required><?php echo $setting['trending_brands_heading']; ?></textarea>
                    <a href="<?php echo base_url('admin/setting/homepagetrending'); ?>" target="_blank">Add Trending Brands</a>
                  </div>
                </div>
                <div class="form-group">
                  <label for="second_button_title" class="col-sm-2 control-label">Show Trending Brands</label>
                  <div class="col-sm-2 input-group">
                    <select name="show_trending_brands" class="form-control">
                      <option value="yes">Yes</option>
                      <option value="no" <?php echo ($setting['show_trending_brands'] == 'no') ? 'selected="selected"' : ''; ?>>No</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="second_button_title" class="col-sm-2 control-label">Show Review Section</label>
                  <div class="col-sm-2 input-group">
                    <select name="show_review_section" class="form-control">
                      <option value="yes">Yes</option>
                      <option value="no" <?php echo ($setting['show_review_section'] == 'no') ? 'selected="selected"' : ''; ?>>No</option>
                    </select>
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

  <script src="<?php echo base_url('assets/js/ckeditor/ckeditor.js'); ?>"></script>
  <script>
  $(document).ready(function () {
    CKEDITOR.editorConfig = function (config) {
      config.extraPlugins = 'confighelper';
      config.allowedContent = true;
    };
    $('.wysihtml').each(function() {
      CKEDITOR.replace(this, {
        format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div'
      });
    });
  });
  </script>