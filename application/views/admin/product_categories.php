<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $title ;?>
            <a href="<?php echo base_url('admin/products/addproductcategory'); ?>">
                <button type="button" class="btn btn-default">Add Product Category</button>
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
                        <th>Category Name</th>
                        <th>Image</th>
                        <!--<th>Created By</th>--> 
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($product_categories)) {
                        $i = 1 ;
                        foreach($product_categories as $row){
                            $image = FILEPATH . 'img/default/no-image.png';
                            if (!empty($row->filename)) {
                                $image = UPLOADPATH . 'products/product_categories/thumb/' . $row->filename;
                            }
                    ?>
                    <tr>
                        <td><?php echo $i ; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><img src="<?php echo $image; ?>" style="max-width: 50px;"></td>
                        <!--<td><?php //echo ucwords($row->first_name . ' ' . $row->last_name); ?></td>-->
                        <td>
                            <?php if($row->status) { ?>
                                <a href="<?php echo base_url('admin/products/'); ?>changestat?act=pcat&stat=<?php echo $row->status ; ?>&cid=<?php echo $row->id; ?>" class="status-act">
                                    <button type="button" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i>
                                        Active
                                    </button>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo base_url('admin/products/'); ?>changestat?act=pcat&stat=<?php echo $row->status ; ?>&cid=<?php echo $row->id; ?>" class="status-act">
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fa fa-close"></i>
                                        Inactive
                                    </button>
                                </a>
                            <?php } ?>

                            <a href="<?php echo base_url('admin/products/'); ?>editproductcategory?pid=<?php echo $row->id ; ?>">
                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                            </a>
                            <a class="rm-user" href="<?php echo base_url('admin/products/'); ?>delete?act=pcat&cid=<?php echo $row->id; ?>">
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
        if (!confirm('Do you want to delete this category?')) {
            return false;
        }
    });
  })
</script>