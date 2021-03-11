<div class="orders-container include_my_product_inner">
    <i class="fa fa-spinner fa-spin fa-3x" style="display: none;"></i>

    <div class="content_right">
        <div class="cmn-header mrtb-15 productdetails">
            <h2>My Products 
            </h2>
            <select class="sort_product_in_dashboard" title="Product sort" style="cursor: pointer">
                <option value="latest" <?php echo (isset($sort_by) && ($sort_by == 'latest')) ? "selected" : "" ?>> Latest </option>
                <option value="boost" <?php echo (isset($sort_by) && ($sort_by == 'boost')) ? "selected" : "" ?>> Boost </option>
                <option value="name" <?php echo (isset($sort_by) && ($sort_by == 'name')) ? "selected" : "" ?>> Name </option>
            </select>
            <a href="#" class="sell-btn addProductOpenModalBtn" data-toggle="modal" data-target="#addProduct">Add Products</a>

        </div>
        <div class="product_area">
            <div class="product_list">
                <?php
                if (count($la_myProduct) == 0) {
                    echo "<p class='no_record'>No Product</p>";
                }
                $noProductImg = UPLOADPATH . 'products/no_product.png';
                foreach ($la_myProduct as $lo_product) {
                    $image = UPLOADDIR . 'products/product/thumb/' . $lo_product->filename;
                    if (!file_exists($image) || ($lo_product->filename == '')) {
                        $image = $noProductImg;
                    } else {
                        $image = UPLOADPATH . 'products/product/thumb/' . $lo_product->filename;
                    }
                    ?>

                    <div class="item">
                        <div class="edit_opt edit_product_by_dashboard" id="proEdit_<?php echo $lo_product->id ?>">
                            <img src="<?php echo site_url('assets/frontend/images/edit.png');?>" alt="" />
                        </div>

                        <div class="ofc-item-box">
                            <img src="<?php echo $image ?>" alt="<?php echo $lo_product->name ?>" />
                        </div>
                        <h4>
                            <a class="display_block" href="<?php echo base_url("products/details/$lo_product->id/" . name_to_url($lo_product->name)); ?>" target="_blank"> 
                                <?php
                                echo $lo_product->name;

                                if ($lo_product->is_boost == 1) {
                                    ?>
                                    &nbsp; <!--<i class="fa fa-plane" title="Boost product"></i> -->
										<img src="<?php echo site_url('assets/frontend/images/shaka.png');?>" style="height:25px;width:25px;position:absolute" title="Boost product">
                                    <?php
                                }
                                ?>
                            </a>
                        </h4>
                    </div>

                <?php }
                ?>


            </div>
        </div>

    </div>
    <!--  -->



    <!-- Modal -->
    <?php
//    $this->load->view('frontend/user/include_product_add_edit_modal.php');
    ?>
    <!--  -->



    <?php
    if ($li_myProduct_count > ITEM_PRODACT) {
        $totalPage = (($li_myProduct_count % ITEM_PRODACT) == 0) ? intval($li_myProduct_count / ITEM_PRODACT) : (intval($li_myProduct_count / ITEM_PRODACT) + 1);
        $url = base_url("products/list//" . "?pg=");
        ?>
        <div class="pager_content">
            <ul class="pagination justify-content-center">
                <?php
                if ($currentPage > 1) {
                    ?>
                    <li class="page-item prev">
                        <a class="page-link" id="<?= ($currentPage - 1) ?>_myProduct_pre" >
                            <img src="<?= UPLOADPATH . "../frontend/images/preview.png" ?>" alt="Pre" />
                        </a>
                    </li>
                    <?php
                }

                for ($i = 1; $i <= $totalPage; $i++) {
                    $activetab = ($currentPage == $i) ? "activetab" : "";
                    ?>
                    <li class="page-item <?= $activetab ?>"><a class="page-link" id="<?= $i ?>_myProduct" ><?= $i; ?></a></li>
                    <?php
                }

                if ($currentPage < $totalPage) {
                    ?>
                    <li class="page-item next">
                        <a class="page-link" id="<?= $currentPage + 1 ?>_myProduct_next">
                            <img src="<?= UPLOADPATH . "../frontend/images/next.png" ?>" alt="Next" />
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php
    }
    ?>
</div>


<!--
<script>
    $(document).ready(function () {
        $('body').on('click', '.change_product_status', function () {
            var thisId = $(this).attr('id');
            var proId = thisId.split('_')[1];

            $.confirm({
                title: 'Change status',
                content: 'Change product status?',
                type: 'blue',
                typeAnimated: true,
                buttons: {
                    cancel: {
                        text: 'No',
                        btnClass: 'btn-gray'
                    },
                    confirm: {
                        text: 'Yes',
                        btnClass: 'btn-green',
                        action: function () {

                            $.ajax({
                                url: '<?php echo base_url("products/change_product_status/"); ?>' + proId,
                                type: 'post',
                                dataType: 'json',
                                data: '',

                                async: false,
                                success: function (response) {
                                    console.log(response);
                                    if (response.success) {
                                        if (response.flag == 1) {
                                            $('#' + thisId).addClass('fa-trash declined');
                                            $('#' + thisId).removeClass('fa-check-circle-o accepted');
                                            $('#productStatus_' + proId).html('Active');
                                            $('#productStatus_' + proId).addClass('accepted');
                                            $('#productStatus_' + proId).removeClass('declined');
                                        } else {
                                            $('#' + thisId).addClass('fa-check-circle-o accepted');
                                            $('#' + thisId).removeClass('fa-trash declined');
                                            $('#productStatus_' + proId).html('Archived');
                                            $('#productStatus_' + proId).addClass('declined');
                                            $('#productStatus_' + proId).removeClass('accepted');
                                        }
                                        toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                                    } else {
                                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                                    }

                                }
                            });
                        }
                    }
                }
            });


        });


    });
</script>-->