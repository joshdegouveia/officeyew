<?php
$title = "Upload product";
$btnText = "Upload";
$name = '';
$regular_price = '';
$original_manufacture_name = '';
$year_manufactured = '';
$warranty = '';
$product_condition = '';
$notable_defect = '';
$short_description = '';
$long_description = '';
$action = base_url("products/upload_product_form");
if (!empty($la_product) && ($la_product->name != '')) {
    $title = "Update product";
    $btnText = "Update";
    $name = $la_product->name;
    $regular_price = $la_product->regular_price;
    $original_manufacture_name = $la_product->original_manufacture_name;
    $year_manufactured = $la_product->year_manufactured;
    $warranty = $la_product->warranty;
    $product_condition = $la_product->product_condition;
    $notable_defect = $la_product->notable_defect;
    $short_description = $la_product->short_description;
    $long_description = $la_product->long_description;
    $action = base_url("products/upload_product_form/$productId");
}
?>
<section class="container">
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
            <div class="main-container web-view">
                <div class="acc_set">
                    <div class="acc_content tabcontent collapse"  id="account">
                        <h4><i class="fa fa-paper-plane"></i> <?= $title ?> </h4>

                        <div class="regd col-md-12">
                            <?php // echo base_url("products/upload_product_form/$productId"); ?>
                            <form id="send_purchase_request_form " action="<?php echo $action ?>" class="form-horizontal upload_product_form" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="text" value="<?php echo $name; ?>" id="name" class="form-control" name="name" placeholder="Product name*"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" value="<?php echo $regular_price; ?>" id="regular_price" class="form-control" name="regular_price" placeholder="Regular price*"/>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" value="<?php echo $original_manufacture_name; ?>" id="original_manufacture_name" class="form-control" name="original_manufacture_name" placeholder="Original Manufacture Name*"/>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" value="<?php echo $year_manufactured; ?>" id="year_manufactured" class="form-control" name="year_manufactured" placeholder="Product Year Manufactured*"/>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" value="<?php echo $warranty; ?>" id="warranty" class="form-control" name="warranty" placeholder="Warranty*"/>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <textarea id="product_condition" class="form-control" name="product_condition" placeholder="Enter Product Condition...* " rows="3"><?php echo $product_condition ?></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <textarea id="notable_defect" class="form-control" name="notable_defect" placeholder="Enter Notable Defect ...* " rows="3"><?php echo $notable_defect ?></textarea>
                                        </div>
                                    </div>
                                </div>                 


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea id="short_description" class="form-control" name="short_description" placeholder="Enter a short description...* " rows="3"><?php echo $short_description ?></textarea>
                                        </div>
                                    </div>
                                </div>                 


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea id="long_description" class="form-control" name="long_description" placeholder="Enter description...* " rows="5"><?php echo $long_description ?></textarea>
                                        </div>
                                    </div>
                                </div>         

                                <div class="form-group chkboxInline ">
                                    <h4>Select product category*:</h4>
                                    <?php foreach ($la_pCategory as $k => $pCategory) {
                                        ?>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="category_id[]" value="<?= $pCategory->id ?>"  id="customCheckBox<?= ++$k ?>" <?php echo (in_array($pCategory->id, $la_selectedCat) ? "checked" : "") ?>>
                                            <label class="custom-control-label" for="customCheckBox<?= $k ?>"><?= ucfirst($pCategory->name) ?></label>
                                        </label>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="custom-control custom-checkbox">
                                                <label class=" " >Product thumb image*</label>
                                                <input type="file" class="" name="filename" value=""  id="filename" accept="image/*">
                                            </label>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="custom-control custom-checkbox">
                                                <label class=" " >Product image</label>
                                            </label>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="custom-control custom-checkbox">

                                                <div class="col-md-4">
                                                    <input type="file" class="" name="pro_img[]" value=""  id="" accept="image/*">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="caption[]" value=""  id="" placeholder="Image caption">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" class="form-control" name="position[]" value=""  id="" placeholder="Image position">
                                                </div>
                                            </label>
                                        </div>        

                                        <div class="col-md-12">
                                            <label class="custom-control custom-checkbox">
                                                <div class="col-md-10"> </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-success"><i class="fa fa-plus-circle"></i> Add More</button>
                                                </div>
                                            </label>
                                        </div>

                                    </div>
                                </div>         

                                <div class="submitBtn">
                                    <button type = "submit" class = "btn btn-default" id="upload_product_form_btn"><?= $btnText ?></button>

                                </div>
                            </form>
                        </div>


                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- dashboard end -->


<!--<script>
    $(document).ready(function () {
        $('body').on('click', '#upload_product_form_btn', function () {
            $.ajax({
                url: '<?php echo base_url("products/upload_product_form/$productId"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'data': $(".upload_product_form").serialize()},

                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        toaster_msg('success', '<i class="fa fa-check"></i>', response.msg);
                        window.setTimeout(function () {
                            window.location.href = "<?php echo base_url("products/details/") ?>" + response.data.product_id + "/" + response.data.name;
                        }, 5000);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
        });

    });
</script>-->
