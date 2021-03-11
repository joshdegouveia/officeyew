<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo $title; ?></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Seller name</th>
                            <th>Buyer name</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Created at</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($la_review)) {
                            $i = 1;
                            foreach ($la_review as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row->seller_f_name . " " . $row->seller_l_name; ?></td>
                                    <td><?php echo $row->buyer_f_name . " " . $row->buyer_f_name; ?></td>
                                    <td><?php echo $row->rating; ?></td>
                                    <td><?php echo $row->review; ?></td>
                                    <td><?php echo date('d-m-Y H:i', strtotime($row->created_datetime)); ?></td>
                                    <td><?php echo ($row->status == 'A') ? "Active" : "Archived"; ?></td>
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
    })
</script>