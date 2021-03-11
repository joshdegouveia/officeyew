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
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Notification for user name</th>
                        <th>Notification by user name</th>
                        <th>Notification type</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Is view</th>
                        <th>Created at</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($la_notification)) {
                        $i = 1 ;
                        foreach($la_notification as $row){
                    ?>
                    <tr>
                        <td><?php echo $i ; ?></td>
                        <td><?php echo $row->for_f_name." ".$row->for_l_name; ?></td>
                        <td><?php echo $row->by_f_name." ".$row->by_l_name; ?></td>
                        <td><?php echo ucfirst(str_replace('_', " ", $row->notification_type)); ?></td>
                        <td><?php echo $row->notification_title; ?></td>
                        <td><?php echo $row->notification_body; ?></td>
                        <td><?php echo ($row->is_view == 'N') ? "No": "Yes"; ?></td>
                        <td><?php echo date('d-m-Y H:i', strtotime($row->created_at)); ?></td>
                        <td><?php echo ($row->status == 'A') ? "Active": "Archived"; ?></td>
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
  })
</script>