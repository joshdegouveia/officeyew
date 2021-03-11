<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    <?php
    echo $title;
    $formHeader = 'Menu Edit';
    $submitText = 'Save';
    $menu_name = $content->menu_name;
    $position = $content->position;
    ?>
    </h1>
  </section>
  
  <!-- Main content -->
  <section class="content menu">
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
                <label for="name" class="col-sm-2 control-label">Menu name</label>
                <div class="col-sm-6 input-group">
                  <input type="text" name="menu_name" class="form-control" id="menu_name" placeholder="Menu name" value="<?php echo $menu_name ;?>" required>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Position</label>
                <div class="col-sm-6 input-group textare">
                  <input type="number" step="1" min="0" name="position" class="form-control" id="position" placeholder="Position" value="<?php echo $position ;?>" 
                </div>
              </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <a href="<?php echo base_url('admin/menu'); ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
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