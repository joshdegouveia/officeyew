<?php
$add_btn_style = '';
$form_style = 'style="display:none;"';
$formHeader = 'Menu Item Add';
$submitText = 'Save';
$menu_name = '';
$menu_link = '';
$position = '';
$cancel_link = base_url('admin/menu');
if (isset($item)) {
  $menu_name = $item->name;
  $menu_link = $item->link;
  $position = $item->position;
  $add_btn_style = 'style="display:none;"';
  $form_style = '';
  $cancel_link = base_url('admin/menu/lists?cid=' . $item->menu_id);
}
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
    <?php echo $title; ?>
    </h1>
  </section>

  <?php if ($this->session->flashdata('msg_error')) { ?>
  <div class="alert alert-danger alert-dismissible" role="alert">
    <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
    <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
  </div>
  <?php } else if ($this->session->flashdata('msg_success')) { ?>
  <div class="alert alert-success alert-dismissible" role="alert">
    <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
    <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
  </div>
  <?php } else { ?>
  <div class="alert alert-danger alert-dismissible" role="alert" style="display: none;">
    <strong></strong>
  </div>
  <?php } ?>
  
  <section class="content" style="min-height: 0;">
    <input type="button" class="btn btn-primary" id="show_hide_item" value="Add menu item" <?php echo $add_btn_style; ?>>
  </section>
  <section class="content menu-item-form" <?php echo $form_style; ?>>
    <div class="row">
      <div class="col-md-10">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo $formHeader ;?></h3>
          </div>
          <form method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="box-body">
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Menu name</label>
                <div class="col-sm-6 input-group">
                  <input type="text" name="menu_name" class="form-control" id="menu_name" placeholder="Menu name" value="<?php echo $menu_name ;?>" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Menu link</label>
                <div class="col-sm-6 input-group">
                  <input type="text" name="menu_url" class="form-control" id="menu_url" placeholder="Menu link" value="<?php echo $menu_link ;?>">
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Position</label>
                <div class="col-sm-6 input-group textare">
                  <input type="number" step="1" min="0" name="position" class="form-control" id="position" placeholder="Position" value="<?php echo $position ;?>" required>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <a href="<?php echo $cancel_link; ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
              <button type="submit" class="btn btn-info pull-right"><?php echo $submitText ; ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <?php if(isset($content)) { ?>
  <section class="content">
    <div class="box">
      <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Link</th>
              <th>Position</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!empty($content)) {
              $i = 1 ;
              foreach($content as $row) {
            ?>
            <tr>
              <td><?php echo $i ; ?></td>
              <td><?php echo $row->name; ?></td>
              <td><?php echo $row->link; ?></td>
              <td><?php echo $row->position; ?></td>
              <td>
                <?php if($row->status == '1') { ?>
                    <a href="<?php echo base_url('admin/menu/'); ?>changeStat?tp=list_item&cid=<?php echo $row->menu_id ;?>&mid=<?php echo $row->id ; ?>&stat=<?php echo $row->status ; ?>" class="status-act">
                        <button type="button" class="btn btn-success btn-sm">
                            <i class="fa fa-check"></i>
                            Active
                        </button>
                    </a>
                <?php } else { ?>
                    <a href="<?php echo base_url('admin/menu/'); ?>changeStat?tp=list_item&cid=<?php echo $row->menu_id ;?>&mid=<?php echo $row->id ; ?>&stat=<?php echo $row->status ; ?>" class="status-act">
                        <button type="button" class="btn btn-danger btn-sm">
                            <i class="fa fa-close"></i>
                            Inactive
                        </button>
                    </a>
                <?php } ?>
                <a href="<?php echo base_url('admin/menu/lists'); ?>?cid=<?php echo $row->menu_id ; ?>&tp=edit&mid=<?php echo $row->id; ?>">
                  <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                </a>
                <a href="<?php echo base_url('admin/menu/delete'); ?>?cid=<?php echo $row->menu_id ;?>&tp=list_item&mid=<?php echo $row->id ; ?>" class="rm-data">
                  <button type="button" class="btn btn-info btn-sm"><i class="fa fa-remove"></i> Delete</button>
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
  </section>
  <?php } ?>

</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#show_hide_item').click(function() {
      $('.content.menu-item-form').toggle();
    });
    $('a.rm-data').on('click', function() {
      if (!confirm('Are you sure you want to delete this menu item?')) {
        return false;
      }
    });
  });
</script>