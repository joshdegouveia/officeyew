<!-- Banner start -->
<?php if (count($homePageAbout) > 0) {
    ?>

    <section class="banner-hold-wrapper">
        <div class="container">
            <div class="slide-caption">
                <h1>About <span>Officeyew</span></h1>
                <p>
                    <?php
                    echo $homePageAbout[0]->body;
                    ?> 
                </p>
            </div>
        </div>
    </section>
    <?php
}
?>
<!-- Banner End -->
<!-- Office Furniture Categories start-->
<?php // print_r($categories);?>
<?php if (count($categories) > 0) {
    ?>
    <section class="ofc-hold-wrap">
        <div class="container">
            <div class="cmn-header mrtb-15">
                <h2>Office Furniture Categories</h2>
            </div>
            <div class="owl-carousel owl-theme" id="ofc-item-slider">
                <?php foreach ($categories as $cat) { ?>
                    <?php
                    $cat_img_src = UPLOADPATH . 'products/product_categories/thumb/' . $cat->filename;
                    ?>
                    <a href="<?php echo base_url("products/list/$cat->id/" . str_replace([' ', '_', "'"], '-', $cat->name)) ?>">
                        <div class="item">
                            <div class="ofc-item-box">
                                <!--<i class="ofc-icons" style="background-image:url('<?php echo $cat_img_src; ?>')"></i>-->
                                <span class="ofc-icons">
                                    <img src="<?php echo $cat_img_src; ?>" alt="<?php echo $cat->name; ?>" class="def_img">
                                    <img src="<?php echo $cat_img_src; ?>" alt="<?php echo $cat->name; ?>" class="def_img_hover">
                                </span>
                                <h4><?php echo $cat->name; ?></h4>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>

                                                                <!--<div class="submitBtn" ><a href="<?php echo base_url("products/categories") ?>"><button type="button" id="" class = "btn btn-default">View Categories</button></a></div>-->

        </div>
    </section>
<?php } ?>
<!-- Office Furniture Categories end-->
<section class="container text-center">
    <img src="<?php echo base_url(); ?>assets/frontend/images/google-ad.png" alt="">
</section>
<section class="seahching-hold-wrap padd-tb60">
    <div class="container">
        <form class="form-inline" action="<?php echo base_url("products/search"); ?>" method="get">
            <div class="form-group sm-width-100">
                <label class="search-label">Searching for:</label>
            </div>
            <div class="form-group col-4 sm-width-45">
        <!--<input id="autocomplete" placeholder="Enter a city" type="text" />-->
                <select class="form-control select2 select_categories_dropdown" name="category">
                    <option value="">Select Category</option>
                    <?php if (count($categories) > 0) { ?>
                        <?php foreach ($categories as $cat) { ?>
                            <option value="<?php echo $cat->id; ?>" ><?php echo $cat->name; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label class="at-label">at</label>
            </div>
            <div class="form-group col-4 sm-width-45">

                <div class="form-group">
                    <input type="text" class="form-control location_autocomplete_search_input" name="location" placeholder="Search city name" autocomplete="off">
                    <input type="hidden" class=" location_autocomplete_id" name="location_id" >
                </div>
                <div class="form-group clearfix">
                    <div class="location_autocomplete_list" style="background: white; z-index: 999;"></div>
                </div> 



                <?php //print_r($locations);?>
<!--                <select class="form-control select2 select_location_dropdown" name="location">
    <option value="">Select location</option>
                <?php if (count($locations) > 0) { ?>
                    <?php
                    foreach ($locations as $location) {
                        if ($location->city == '')
                            continue;
                        ?>
                                                                    <option value="<?php echo $location->city; ?>" ><?php echo $location->city; ?></option>
                    <?php } ?>
                <?php } ?>
</select>-->
            </div>
            <div class="form-group sm-width-100">
                <button type="submit" class="btn btn-search">Search</button>
            </div>
        </form>
    </div>
</section>
<!-- Content end -->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYTkpH8ZtI8vKHNiJMMT9dbIxVDwxEB68&callback=initMap&libraries=places&v=weekly" defer ></script>-->
<script>
    $(document).ready(function () {

        $('body').on('keyup', '.location_autocomplete_search_input', function (e) {
            var searchVal = $(".location_autocomplete_search_input").val();
            e.preventDefault(); // Ensure it is only this code that rusn

            $.ajax({
                url: '<?php echo base_url("user/location_autocomplete_search"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'searchVal': searchVal},
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find(".location_autocomplete_list").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });


        });

        $('body').on('click', '.auto_location_city_name', function (e) { // == Auto complete search ====
            var thisName = $(this).html();
            var locName = thisName.replace('<b>', '');
            locName = locName.replace('</b>', '', );
            $(".location_autocomplete_id").val($(this).attr('id'));
            $(".location_autocomplete_search_input").val(locName);
            $('body').find(".location_autocomplete_list").html('');
            console.log(locName);
        });



    });
</script>