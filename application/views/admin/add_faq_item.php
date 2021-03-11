<?php
$formHeader = 'FAQ Item Add';
$submitText = 'Save';
$question = $answer = $category = '';

if (!empty($faq)) {
  $formHeader = 'FAQ Item Edit';
  $submitText = 'Update';
  $question = $faq->question;
  $answer = $faq->answer;
  $category = $faq->category_id;
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
            <h3 class="box-title"><?php echo $formHeader ;?></h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="box-body">
              
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Category</label>
                <div class="col-sm-9 input-group">
                  <select name="category" class="form-control">
                    <?php
                    if (!empty($faq_category)) {
                      pre($faq_category);
                      foreach ($faq_category as $value) {
                        $selected = ($category == $value->id) ? 'selected="selected"' : '';
                    ?>
                    <option value="<?php echo $value->id ?>" <?php echo $selected; ?>><?php echo $value->name; ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Question</label>
                <div class="col-sm-9 input-group">
                  <input type="text" name="question" class="form-control" id="question" placeholder="FAQ question" value="<?php echo $question ;?>" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Answer</label>
                <div class="col-sm-9 input-group">
                  <input type="text" name="answer" class="form-control" id="answer" placeholder="FAQ answer" value="<?php echo $answer ;?>" required>
                </div>
              </div>
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer">

              <a href="<?php echo base_url('admin/faq/items'); ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
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