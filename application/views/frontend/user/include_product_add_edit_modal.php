<div class="modal fade" id="addProduct" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <span class="boost_product_checkbox_content"><i><strong>Boost Product: </strong></i> <input type="checkbox" class="boost_product_checkbox"> &nbsp; &nbsp; &nbsp; &nbsp;</span>
                <img class="close closeicon2" data-dismiss="modal" aria-label="Close" src="../assets/frontend/images/closeicon.png" alt="" />


            </div>
            <form id="upload_product_form" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="productId" value="" id="productId">
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control selectpicker" data-style="btn-primary"  name="category_id[]" id="category_id">
                            <option value="">- Choose category --</option>
                            <?php foreach ($la_pCategory as $k => $pCategory) {
                                ?>
                                <option value="<?= $pCategory->id ?>"><?= ucfirst($pCategory->name) ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Product name" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="regular_price" id="regular_price" placeholder="Regular price" />
                    </div>
                    <div class="form-group">
                        <textarea   class="form-control" name="long_description" id="long_description" placeholder="Product description"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="original_manufacture_name" id="original_manufacture_name" placeholder="Original manufacture name" />
                    </div>
                    <div class="form-group">
                        <select class="form-control selectpicker" data-style="btn-primary" name="year_manufactured" id="year_manufactured">
                            <option value="">-- Product manufactured year --</option>
                            <?php
                            for ($i = date("Y"); $i >= 2000; $i--) {
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="inp_row3">
                        <span> Warranty:</span>
                        <div class="checkopt">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="warranty" id="warrantyOpt1" value="Yes" >
                                <label class="form-check-label" for="warrantyOpt1">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="warranty" id="warrantyOpt2" value="No" checked>
                                <label class="form-check-label" for="warrantyOpt2">No</label>
                            </div>
                        </div>


                    </div>
                    <div class="form-group">
                        <select class="form-control selectpicker" name="product_condition_id" id="product_condition_id" data-style="btn-primary">
                            <option value="">-- Product condition --</option>
                            <?php
                            foreach ($la_productsCondition as $row) {
                                ?>
                                <option value="<?= $row->products_condition_id ?>"><?= $row->products_condition ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control selectpicker" name="notable_defect_id" id="notable_defect_id" data-style="btn-primary">
                            <option value="">-- Notable defects --</option>
                            <?php
                            foreach ($la_notableDefects as $row) {
                                ?>
                                <option value="<?= $row->products_notable_defects_id ?>"><?= $row->notable_defects ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>


                    <div class="form-group location_autocomplete_list_parent">
                        <input type="text" class="form-control location_autocomplete_search_input" name="" placeholder="Search city name">
                        <div class="location_autocomplete_list"></div>
                    </div>
                    <div class="selected_location_autocomplete">
                        <!--<input type="text" class="selected_location_input" name="location_id[]" readonly="">-->
                    </div>


                    <div class="form-group">
                        <label class="custom-file" id="customFile">
                            <input type="file" class="custom-file-input filename_thumb" name="filename" id="exampleInputFile" aria-describedby="fileHelp" accept="image/*">
                            <span class="custom-file-control2 form-control-file2"></span>
                        </label>
                    </div>

                    <div class=" more_image_append_content" id="more_image_append_content"></div>


                    <div class="pro_more_saved_image_content" id="pro_more_saved_image_content"></div>

                    <div class="" id="more_pro_img_content_hide" style="display: none">
                        <div class="form-group" >
                            <label class="custom-file" id="customFile">
                                <input type="file" class="custom-file-input pro_img" name="pro_img_0"  aria-describedby="fileHelp" accept="image/*">
                                <span class="custom-file-control2 form-control-file2"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="">
                        <button type="button" class="add_more_image_modal">Add image</button>
                    </div>

                    <div class="def_btn_cap">
                        <button type="submit" class="add_more_image_modal_1" id="upload_product_form_btn">Add Product</button>

                    </div>




                </div>
            </form>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
    </div>
</div>