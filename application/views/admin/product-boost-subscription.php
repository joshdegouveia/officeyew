<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper product-orders-page">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
		<?php echo $title ;?>
        <a href="<?php echo base_url('admin/products/add_product_boost'); ?>">
                <button type="button" class="btn btn-default">Add Product Boost</button>
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
                        <th>Product Post Type</th>
                        <th>Per Month Price</th>
                        <th>No Of Product</th>
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
                        <td><?php echo $row->product_posting_type; ?></td>
                        <td><?php echo $row->month_wise_price; ?></td>
                        <td><?php echo $row->no_of_product; ?></td>
                        <td>
                             <a href="<?php echo base_url('admin/products/'); ?>add_product_boost?boost_id=<?php echo $row->boost_id ; ?>">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View</button>
                            </a> 
                            <?php if($row->status) { ?>
                                <a href="<?php echo base_url('admin/products/'); ?>changeBoostStat?boost_id=<?php echo $row->boost_id; ?>&stat=<?php echo $row->status;?>&boost_type=<?php echo $row->boost_cat_id;?>" class="status-act">
                                    <button type="button" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i>
                                        Active
                                    </button>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo base_url('admin/products/'); ?>changeBoostStat?boost_id=<?php echo $row->boost_id; ?>&stat=<?php echo $row->status;?>&boost_type=<?php echo $row->boost_cat_id;?>" class="status-act">
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fa fa-close"></i>
                                        Inactive
                                    </button>
                                </a>
                            <?php } ?>

                             <a href="<?php echo base_url('admin/products/'); ?>add_product_boost?boost_id=<?php echo $row->boost_id ; ?>">
                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                            </a> 
                            <a class="rm-user" href="<?php echo base_url('admin/products/'); ?>delete?act=boost&type=<?php echo $row->boost_cat_id;?>&cid=<?php echo $row->boost_id; ?>">
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
        if (!confirm('Do you want to delete this boost?')) {
            return false;
        }
    });
  })
</script>