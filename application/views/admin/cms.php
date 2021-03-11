<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo $title ;?></h1>
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
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($cms)) {
                        $i = 1 ;
                        foreach($cms as $row){
                    ?>
                    <tr>
                        <td><?php echo $i ; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td>
                            <a href="<?php echo base_url('admin/cms/'); ?>edit?cid=<?php echo $row->id ; ?>">
                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
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

    $('.rm-user').on('click', function() {
        if (!confirm('Do you want to delete this CMS page?')) {
            return false;
        }
    });
  })
</script>