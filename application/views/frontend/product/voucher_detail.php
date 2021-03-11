<?php
$uid = (!empty($user)) ? $user['id'] : '';
$currency = '$';
$discount_amount = ($voucher->flat_rate > 0) ? $voucher->flat_rate : $voucher->percentage;
$qty = 1;
// if (!empty($select_voucher)) {
//   $qty = $select_voucher['qty'];
// }
?>
<div class="main-content voucher-detail-page" data-pid="pid-<?php echo $voucher->id; ?>">
    <section class="slice slice-lg delimiter-bottom bg-primary" id="sct-products">
      <!--for menue backgroung color -->
     
    </section>
    <section class="slice">
      <div class="container">
        <div class="row row-grid">
          <div class="col-lg-8">
            <div class="pl-lg-5">
              <!-- Product title -->
              <h5 class="h4">Voucher: <?php echo $voucher->name; ?></h5>
              <span class="badge badge-pill badge-soft-success"><?php echo $stock = ($voucher->status == 1)?'In stock': 'Not in stock'; ?></span>
              <!-- Description -->
              <div class="py-4 my-4 border-top border-bottom">
                <h6 class="text">Description:</h6>
                <?php echo $voucher->description; ?>
              </div>
              <div class="my-4 details">
                <div class="items">
                  <h6 class="text">Discount type:</h6>
                  <span>For <?php echo ucwords($voucher->discount_type); ?></span>
                </div>
                <div class="items">
                  <h6 class="text">Discount amount:</h6>
                  <span><?php echo $currency . $discount_amount; ?></span>
                </div>
                <div class="items">
                  <h6 class="text">Discount start date:</h6>
                  <span><?php echo $voucher->start_date; ?></span>
                </div>
                <div class="items">
                  <h6 class="text">Discount expiry date:</h6>
                  <span><?php echo $voucher->expiry_date; ?></span>
                </div>
                <div class="items">
                  <h6 class="text">Total use for per customer:</h6>
                  <span><?php echo $voucher->total_use; ?></span>
                </div><div class="items">
                  <h6 class="text">Total use for per customer:</h6>
                  <span><?php echo $voucher->total_use; ?></span>
                </div>
                <?php
                $discount_amount = ($voucher->loyal_flat_rate > 0) ? $voucher->loyal_flat_rate : $voucher->loyal_percentage;
                if ($voucher->voucher_amount > 0 && $discount_amount > 0) {
                ?>
                <div class="items">
                  <h6 class="text">Voucher discount </h6>
                  <span><?php echo $currency . $discount_amount; ?></span>
                  <h6> purchase more than or </h6>
                  <span><?php echo $voucher->voucher_amount; ?></span>
                  <h6> vouchers</h6>
                </div>
                <?php } ?>
              </div>
              <div class="py-4 my-4 border-top border-bottom">
                <div class="row align-items-center">
                  <div class="col-6 mb-4 mb-0 qty-price">
                    <span class="d-block h3 mb-0">Price: <?php echo $currency.$voucher->voucher_price; ?></span>
                    <?php /* ?>
                    <span class="d-block mb-0 qty-item">Qty: <?php echo $qty; ?></span>
                    <span class="d-block h3 mb-0 total-price">Total: <?php echo $currency . (($qty > 1) ? ($qty * $voucher->voucher_price) : $voucher->voucher_price); ?></span><?php */ ?>
                  </div>
                  <div class="col-6 buy-voucher">
                    <?php /* ?>
                    <div class="qty">
                      Qty: <input type="number" step="1" min="1" name="qty" id="qty" data-price="<?php echo $voucher->voucher_price; ?>" data-currency=<?php echo $currency; ?> value="<?php echo $qty; ?>">
                    </div><?php */ ?>
                    <form method="post" id="voucher_stock" action="<?php echo base_url('products/businessvoucher/' . $cid . '/payment'); ?>">
                      <button type="submit" class="btn btn-primary btn-icon adcrt">
                        <span class="btn-inner--icon"><i class="fas fa-shopping-bag"></i></span>
                        <span class="btn-inner--text">Buy</span>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>