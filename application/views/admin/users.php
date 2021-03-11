<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $title ;?>
            <a href="javascript:void(0)" class="user-download">
                <button type="button" class="btn btn-default"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Download <?php echo $title; ?></button>
            </a>
            <a href="javascript:void(0)" class="user-upload">
                <button type="button" class="btn btn-default"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Upload <?php echo $title; ?></button>
            </a>
            <a href="javascript:void(0)" class="sample-csv" title="Download sample csv file">
                <button type="button" class="btn btn-default"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Sample CSV</button>
            </a>
        </h1>
    </section>
    <form method="post" id="upload_form" enctype="multipart/form-data">
        <input type="file" name="upload" id="upload" style="display: none;" accept=".csv">
        <input type="hidden" name="upload_users" value="<?php echo $type; ?>" style="display: none;">
    </form>

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
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(isset($users) && count($users) > 0){
                        $i = 1 ;
                        foreach($users as $user){
                            if ($user->type == 'admin') {
                                continue;
                            }
                    ?>
                    <tr>
                        <td><?php echo $i ; ?></td>
                        <td><?php echo $user->first_name.' '.$user->last_name ; ?></td>
                        <td><?php echo $user->email ; ?></td>
                        <td>
                            <a href="<?php echo base_url('admin/users/'); ?>detail?uid=<?php echo $user->id ; ?>">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View</button>
                            </a>
                            <?php if($user->active == '1'){?>
                                <a href="<?php echo base_url('admin/users/'); ?>changeUserStat?uid=<?php echo $user->id ; ?>&stat=<?php echo $user->active ; ?>&tp=<?php echo $type; ?>" class="status-act">
                                    <button type="button" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i>
                                        Active
                                    </button>
                                </a>
                            <?php }else{?>
                                <a href="<?php echo base_url('admin/users/'); ?>changeUserStat?uid=<?php echo $user->id ; ?>&stat=<?php echo $user->active ; ?>&tp=<?php echo $type; ?>" class="status-act">
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fa fa-close"></i>
                                        Inactive
                                    </button>
                                </a>
                            <?php } ?>

                            <a href="<?php echo base_url('admin/users/'); ?>edit?uid=<?php echo $user->id ; ?>">
                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                            </a>
                            <a class="rm-user" href="<?php echo base_url('admin/users/'); ?>delete?uid=<?php echo $user->id ; ?>&tp=<?php echo $type; ?>">
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

    $(document).on('click', 'a.rm-user', function() {
        if (!confirm('Do you want to delete this user?')) {
            return false;
        }
    });

    if ($('.alert').is(':visible')) {
        setTimeout(function() {
            $('.alert').hide();
        }, 5000);
    }

    $('.user-download').on('click', function() {
        location.href = base_url + 'admin/users/downloadusers/<?php echo $type; ?>';
    });

    $('.sample-csv').on('click', function() {
        location.href = base_url + 'admin/users/downloadusers/sample';
    });

    $('.user-upload').on('click', function() {
        $('#upload').trigger('click');
    });

    $('#upload').on('change', function() {
        $('.overlay').show();
        $('#upload_form').submit();
    });
  })
</script>