<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper product-orders-page">
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
                        <th>Email</th>
                        
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($datas)) {
                        $i = 1 ;
                        foreach($datas as $row){
                            
                    ?>
                    <tr>
                        <td><?php echo $i ; ?></td>
                        <td><a href="<?php echo base_url('user/profile/' . $row->id); ?>" target="_blank"><?php echo ucwords($row->first_name . ' ' . $row->last_name); ?></a></td>
                        <td><?php echo $row->email; ?></td>
                        
                        <td>
                             <a href="<?php echo base_url('admin/users/'); ?>detail?uid=<?php echo $row->id ; ?>">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View</button>
                            </a> 
                            <?php if($row->active) { ?>
                                <a href="<?php echo base_url('admin/users/'); ?>changeUserStat?tp=seller&stat=<?php echo $row->active ; ?>&uid=<?php echo $row->id; ?>" class="status-act">
                                    <button type="button" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i>
                                        Active
                                    </button>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo base_url('admin/users/'); ?>changeUserStat?tp=seller&stat=<?php echo $row->active ; ?>&uid=<?php echo $row->id; ?>" class="status-act">
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fa fa-close"></i>
                                        Inactive
                                    </button>
                                </a>
                            <?php } ?>

                             <a href="<?php echo base_url('admin/users/'); ?>edit?uid=<?php echo $row->id ; ?>">
                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                            </a> 
                            <a class="rm-user" href="<?php echo base_url('admin/users/'); ?>delete?tp=seller&uid=<?php echo $row->id; ?>">
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

    $('a.rm-user').on('click', function() {
        if (!confirm('Do you want to delete this order?')) {
            return false;
        }
    });
  })
</script>