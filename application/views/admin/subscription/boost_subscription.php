<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $title; ?>
        </h1>
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
                            <th>Subscription Category</th>
                            <th>User name</th>
                            <th>TXN no</th>
                            <th>Price</th>
                            <th>Duration in days</th>
                            <th>Number of product</th>
                            <th>Subscribed at</th>
                            <th>Expired at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($la_data)) {
                            $i = 1;
                            foreach ($la_data as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row->cat_name; ?></td>
                                    <td><?php echo $row->first_name . " " . $row->last_name; ?></td>
                                    <td><?php echo $row->txn_no; ?></td>
                                    <td><?php echo $row->price; ?></td>
                                    <td><?php echo $row->duration_in_days; ?></td>
                                    <td><?php echo $row->product_no; ?></td>
                                    <td><?php echo date("d-m-Y H:i:s", strtotime($row->created_at)); ?></td>
                                    <td><?php echo date("d-m-Y H:i:s", strtotime("+$row->duration_in_days days", strtotime($row->created_at))); ?></td>
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