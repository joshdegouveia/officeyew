<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $title; ?>
<!--            <a href="<?php echo base_url('admin/products/addproductcategory'); ?>">
                <button type="button" class="btn btn-default">Add Product Category</button>
            </a>-->
        </h1>
    </section>
    <style>
        input[readonly]{
            background-color:#fdff64;
        }

    </style>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">


                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>CITY</th>
                            <th>COUNTRY</th>
                            <th>Tax in flat</th>
                            <th>Tax in %</th>
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
                                    <td><?php echo $row->CITY; ?></td>
                                    <td><?php echo $row->COUNTRY; ?></td>
                                    <td><input type="text" class="city_tax_value" id="taxFlat_<?php echo $row->ID; ?>" value="<?php echo $row->tax_in_flat; ?>" title="Double click to update value" readonly=""></td>
                                    <td><input type="text" class="city_tax_value" id="taxPc_<?php echo $row->ID; ?>" value="<?php echo $row->tax_in_percentage; ?>" title="Double click to update value"  readonly=""></td>
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
        $('body').on('dblclick', '.city_tax_value', function () {
            var thisId = $(this).attr('id');
            $('#' + thisId).prop("readonly", false);
        });
        $('body').on('blur', '.city_tax_value', function () {
            $('.city_tax_value').prop("readonly", true);
        });

        $('body').on('keyup', '.city_tax_value', function (e) {

            if (e.keyCode === 13) {
                e.preventDefault(); // Ensure it is only this code that rusn

                var thisId = $(this).attr('id');
                var thisVal = $(this).val();

                $('#' + thisId).prop("readonly", false);

                $.ajax({
                    url: '<?php echo base_url("admin/products/ajax_update_tax"); ?>',
                    type: 'post',
                    dataType: 'json',
                    data: {"thisId": thisId, "thisVal": thisVal},
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            $('.city_tax_value').prop("readonly", true);
                        } else {
                            alert(response.msg);
                        }

                    }
                });
            }
        });


        $('#example1').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false
        });

        $('a.rm-user').on('click', function () {
            if (!confirm('Do you want to delete this category?')) {
                return false;
            }
        });
    })
</script>