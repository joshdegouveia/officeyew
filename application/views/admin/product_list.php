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
                        <th>Image</th>
                        <th>Product</th>
                        <th>Product category</th>
                        <th>Seller Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($products)) {
                        $i = 1 ;
                        foreach($products as $row){
							$image =$row->filename;
                    ?>
                    <tr>
                        <td><?php echo $i ; ?></td>
                        <td>
						<?php if (!empty($image)) { ?>
                        <img src="<?php echo UPLOADPATH . 'products/product/thumb/' . $image; ?>" style="max-width: 70px;">
                        <?php } ?>
                        </td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo str_replace(',', ', ',$row->category); ?></td>
                        <td><?php echo ucwords($row->first_name . ' ' . $row->last_name); ?></td>
                        <td><?php echo $row->regular_price; ?></td>
                       
                        
                        
                        <td>
                            <?php if($row->status) { ?>
                                <a href="<?php echo base_url('admin/products/'); ?>changestat?act=prod&stat=<?php echo $row->status ; ?>&cid=<?php echo $row->id; ?>" class="status-act">
                                    <button type="button" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i>
                                        Active
                                    </button>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo base_url('admin/products/'); ?>changestat?act=prod&stat=<?php echo $row->status ; ?>&cid=<?php echo $row->id; ?>" class="status-act">
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fa fa-close"></i>
                                        Inactive
                                    </button>
                                </a>
                            <?php } ?>

                            <a href="<?php echo base_url('admin/products/'); ?>edit?pid=<?php echo $row->id ; ?>">
                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                            </a>
                            <a class="rm-user" href="<?php echo base_url('admin/products/'); ?>delete?act=prod&cid=<?php echo $row->id; ?>">
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

    $('.rm-user').on('click', function() {
        if (!confirm('Do you want to delete this product?')) {
            return false;
        }
    });
  })
</script>