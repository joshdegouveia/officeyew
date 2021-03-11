<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo $title; ?></h1>
        <a href="<?php echo base_url(); ?>admin/cms/add_job_posting_charge">
            <button class="btn btn-success">Add</button>
        </a>
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
                            <th>Job category</th>
                            <th>Price</th>
                            <th>Duration in week</th>
                            <th>Resume number</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($la_data)) {
                            $i = 1;
                            foreach ($la_data as $row) {
                                $job_category = ($row->job_category == 'per_post') ? "Per post" : (($row->job_category == 'monthly') ? "Monthly" : "One time");
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $job_category; ?></td>
                                    <td><?php echo $row->price; ?></td>
                                    <td><?php echo $row->duration_in_week; ?></td>
                                    <td><?php echo $row->resume_number; ?></td>
                                    <td><?php echo $row->description; ?></td>

                                    <td>
                                        <?php if ($row->status == 'A') { ?>
                                                    <!--<a href="<?php echo base_url('admin/products/'); ?>changestat?act=prod&stat=<?php echo $row->status; ?>&cid=<?php echo $row->job_posting_charges_id; ?>" class="status-act">-->
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fa fa-check"></i>
                                                Active
                                            </button>
                                            <!--</a>-->
                                        <?php } else { ?>
                                            <!--<a href="<?php echo base_url('admin/products/'); ?>changestat?act=prod&stat=<?php echo $row->status; ?>&cid=<?php echo $row->job_posting_charges_id; ?>" class="status-act">-->
                                            <button type="button" class="btn btn-danger btn-sm">
                                                <i class="fa fa-close"></i>
                                                Inactive
                                            </button>
                                            <!--</a>-->
                                        <?php } ?>

                                        <a href="<?php echo base_url('admin/cms/add_job_posting_charge'); ?>?id=<?php echo $row->job_posting_charges_id; ?>">
                                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                                        </a>
<!--                                        <a class="rm-user" href="<?php echo base_url('admin/products/'); ?>delete?act=prod&cid=<?php echo $row->job_posting_charges_id; ?>">
                                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-remove"></i> Delete</button>
                                        </a>-->
                                    </td>
                                </tr>
                                <?php
                                $i++;
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
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false
        });

        $('.rm-user').on('click', function () {
            if (!confirm('Do you want to delete this product?')) {
                return false;
            }
        });
    })
</script>