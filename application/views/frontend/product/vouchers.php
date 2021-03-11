<div class="main-content vouchers-page">
    <!-- Products -->
    <section class="slice slice-lg delimiter-bottom bg-primary">
        <!--for menue backgroung color -->
        <div class="spotlight-holder pt-9 pb-6 py-lg-0">
            <div class="container d-flex align-items-center px-0">
                <div class="col">
                    <div class="row row-grid align-item-center">
                        <div class="col-lg-12">
                            <div class="py-5">
                                <h1 class="text-white mb-4"><?php echo $title; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="slice slice-lg delimiter-bottom wrapper">
        <div class="container">
            <div class="row">
                <?php
                if(!empty($vouchers)) {
                    foreach($vouchers as $voucher) {
                        $discount = ($voucher->flat_rate > 0) ? 'Rs ' . $voucher->flat_rate : $voucher->percentage . '%';
                        $image = FILEPATH . 'img/default/no-image.png';
                        if (!empty($voucher->filename) && file_exists(UPLOADDIR . 'vouchers/' . $voucher->filename)) {
                            $image = UPLOADPATH . 'vouchers/' . $voucher->filename;
                        }
                ?>
                <div class="col-xl-6 col-lg-4 col-sm-6 lst">
                    <div class="listing">
                        <div class="listing-content">
                            <a href="javascript:void(0)" class="view">
                                <figure class="listing-image">
                                    <img alt="<?php echo strip_tags($voucher->description); ?>" src="<?php echo $image; ?>">
                                    <figcaption>
                                    <?php echo $voucher->description; ?>
                                    </figcaption>
                                </figure>
                                <section class="listing-details">
                                    <header class="listing-details-header">
                                        <h3><?php echo ucwords($voucher->name); ?></h3>
                                        <!-- <p class="listing-vendor">
                                            <span class="listing-vendor-display-name">Vivo Hair and Beauty</span>
                                            <br> <span class="listing-location">Auckland</span>
                                        </p> -->
                                    </header>
                                    <div class="listing-purchase-count">
                                        <?php echo $discount; ?> &nbsp;<span>OFF</span>
                                    </div>
                                    <div class="listing-price-container">
                                        <span class="listing-price-from">price</span>
                                        <div class="listing-price-current">
                                            <!-- <span class="listing-price-value">$239</span> -->
                                            <?php echo $voucher->sale_price; ?>
                                        </div>
                                        <span class="listing-price-per-item">
                                        </span>
                                    </div>
                                </section>
                            </a>
                            <div class="listing-touch-info"></div>
                        </div>
                    </div>

                    <div class="voucher-detail-container" data-pid="<?php echo $voucher->id; ?>" style="display: none;">
                        <p class="bld"><?php echo ucwords($voucher->name); ?></p>
                        <p class="bld"><?php echo $discount; ?> <span>OFF</span></p>
                        <div class="description"><?php echo $voucher->description; ?></div>
                        <p>Start date: <?php echo $voucher->start_date; ?></p>
                        <p>Expiry date: <?php echo $voucher->expiry_date; ?></p>
                        <p>Price: <?php echo $voucher->sale_price; ?></p>
                        <p class="text-center"><a href="javascript:void(0)" class="pop-cancel">Cancel</a><button type="button" class="btn btn-primary buy-voucher">Buy</button></p>
                    </div>

                </div>
                <?php
                    }
                ?>
                <?php
                } else {
                    echo '<strong style="color:red">No voucher found!</strong>';
                }
                ?>
            </div>
        </div>
    </section>
    <div class="voucher-overlay"></div>
    <div class="voucher-detail" data-pid="" style="display: none;"></div>
</div>