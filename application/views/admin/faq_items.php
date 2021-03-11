<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $title ;?>
            <a href="<?php echo base_url('admin/faq/itemadd'); ?>">
                <button type="button" class="btn btn-default">Add Item</button>
            </a>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <?php if ($this->session->flashdata('msg_error')) { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
            <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
            </div>
            <?php } else if ($this->session->flashdata('msg_success')) { ?>
            <div class="alert alert-success alert-dismissible" role="alert">
            <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
            </div>
            <?php } else { ?>
            <div class="alert alert-danger alert-dismissible" role="alert" style="display: none;">
            <strong></strong>
            </div>
            <?php } ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($faq)) {
                        $i = 1 ;
                        foreach($faq as $row){
                    ?>
                    <tr>
                        <td><?php echo $i ; ?></td>
                        <td><?php echo $row->question; ?></td>
                        <td><?php echo $row->answer; ?></td>
                        <td>
                            <?php if($row->status == '1') { ?>
                                <a href="<?php echo base_url('admin/faq/'); ?>changeStat?cid=<?php echo $row->id ; ?>&stat=<?php echo $row->status ; ?>" class="status-act">
                                    <button type="button" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i>
                                        Active
                                    </button>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo base_url('admin/faq/'); ?>changeStat?cid=<?php echo $row->id ; ?>&stat=<?php echo $row->status ; ?>" class="status-act">
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fa fa-close"></i>
                                        Inactive
                                    </button>
                                </a>
                            <?php } ?>
                            <a href="<?php echo base_url('admin/faq/itemedit'); ?>?cid=<?php echo $row->id ; ?>">
                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                            </a>
                            <a href="<?php echo base_url('admin/faq/itemdelete'); ?>?cid=<?php echo $row->id ; ?>" class="rm-user">
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
        <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
  $(document).ready(function () {
    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });

    $('a.rm-user').on('click', function() {
        if (!confirm('Do you want to delete this FAQ item?')) {
            return false;
        }
    });
  })
</script>