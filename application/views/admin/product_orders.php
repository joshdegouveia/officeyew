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
                        <th>Product</th>
                        <th>Image</th>
                        <th>Ordered By</th>
                        <th>Seller Name</th>
                        <th>Product Price</th>
                        <th>Delivery Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($products)) {
                        $i = 1 ;
                        foreach($products as $row){
                            $image = FILEPATH . 'img/default/no-image.png';
                            if (!empty($row->filename) && file_exists(UPLOADDIR . 'products/product/thumb/' . $row->filename)) {
                                $image = UPLOADPATH . 'products/product/thumb/' . $row->filename;
                            }
                            $customer = (!empty($row->first_name) || !empty($row->last_name)) ? ucwords($row->first_name . ' ' . $row->last_name) : $row->email;
                    ?>
                    <tr>
                        <td><?php echo $i ; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><img src="<?php echo $image; ?>"></td>
                        <td><?php echo $customer; ?></td>
                        <td><a href="<?php echo base_url('user/profile/' . $row->seller_id); ?>" target="_blank"><?php echo ucwords($row->seller_first_name . ' ' . $row->seller_last_name); ?></a></td>
                        
                        <td><?php echo $currency . $row->order_price; ?></td>
                        <td><?php echo ucwords($row->delivery_status); ?></td>
                        <td>
                            <!-- <a href="<?php //echo base_url('admin/products/'); ?>orderdetail?pid=<?php //echo $row->id ; ?>">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View</button>
                            </a> -->
                            <?php /*if($row->status) { ?>
                                <a href="<?php echo base_url('admin/products/'); ?>changestat?act=pord&stat=<?php echo $row->status ; ?>&pid=<?php echo $row->id; ?>" class="status-act">
                                    <button type="button" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i>
                                        Active
                                    </button>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo base_url('admin/products/'); ?>changestat?act=pord&stat=<?php echo $row->status ; ?>&pid=<?php echo $row->id; ?>" class="status-act">
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fa fa-close"></i>
                                        Inactive
                                    </button>
                                </a>
                            <?php }*/ ?>

                            <!-- <a href="<?php //echo base_url('admin/products/'); ?>categoryedit?pid=<?php //echo $row->id ; ?>">
                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                            </a> -->
                            <a class="rm-user" href="<?php echo base_url('admin/products/'); ?>delete?act=pord_order&pid=<?php echo $row->id; ?>">
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