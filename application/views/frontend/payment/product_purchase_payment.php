
<div class="main-content">
    <section class="slice">
        <div class="container">
            <div class="row row-grid">
                <div class="col-lg-8">
                    <?php $this->load->view('frontend/flash_message.php'); ?>

                    <form name="payment" id="payment" action="<?php echo base_url('payment/productPurchaseChargeAmountFromCard'); ?>" method="post">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="custom-control custom-checkbox">
                                          <!-- <input type="radio" class="custom-control-input" name="radio-payment" id="radio-payment-card"> -->
                                            <label class="custom-control-label h6 mb-0 lh-180" for="radio-payment-card">Credit Card</label>
                                        </div>
										<p class="text-muted mt-2 mb-0">Safe money transfer using your bank account. We support Mastercard, Visa and American Express.</p>
                                    </div>
                                    <div class="col-4 text-right">
                                        <img alt="Image placeholder" src="<?php echo FILEPATH . 'img/icons/cards/mastercard.png' ?>" width="40" class="mr-2">
                                        <img alt="Image placeholder" src="<?php echo FILEPATH . 'img/icons/cards/visa.png' ?>" width="40" class="mr-2">
                                        <!--<img alt="Image placeholder" src="<?php echo FILEPATH . 'img/icons/cards/skrill.png' ?>" width="40">-->
										<img alt="Image placeholder" src="<?php echo FILEPATH . 'img/icons/cards/American-Express-Symbol.png' ?>" width="90">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group input-group-merge">
                                                <input required name="card_no" id="card_no" type="text" class="form-control" data-mask="0000 0000 0000 0000" placeholder="0000 0000 0000 0000">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Name on card</label>
                                            <input required name="card_name" id="card_name" type="text" class="form-control" placeholder="John Doe">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Expiry date</label>
                                            <div style="display: inline-block;">
                                                <input style="width: 65px;float: left;" required name="month" id="month" type="text" class="form-control" data-mask="00/00" placeholder="MM">
                                                <input style="width: 65px;"  required name="year" id="year" type="text" class="form-control" data-mask="00/00" placeholder="YY">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">CVV code</label>
                                            <div class="input-group input-group-merge">
                                                <input required name="cvc" id="cvc" type="text" class="form-control" data-mask="000" placeholder="746">
                                                <div class="input-group-append" data-toggle="popover" data-container="body" data-placement="top" data-content="It is a three digit code that can be found only on the back of your card. Be carefull so no one sees it." data-title="What is a CVV code?">
                                                    <span class="input-group-text"><i class="fas fa-question-circle"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add money using PayPal -->

                        <div class="mt-4 text-right">
                            <a href="<?php echo base_url(''); ?>" class="btn btn-link text-sm text-dark font-weight-bold">Cancel</a>
                            <input type="button" onclick="return stripePay()" name="submit" class="btn btn-sm btn-success submit" value="Complete order" >
                            <input type="submit" id="submit" style="display:none;">
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div data-toggle="sticky" data-sticky-offset="30">
                        <div class="card" id="card-summary">
                            <div class="card-header py-3">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <span class="h6">Summary</span>
                                    </div>
                                    <div class="col-6 text-right">
                                        <span class="badge badge-pill badge-soft-success"><?php echo 1; ?> items</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
								$image = FILEPATH . 'img/default/no-image.png';
								if (!empty($pImage)) {
									$image = UPLOADPATH . 'products/product/thumb/' . $pImage;
								}
                                ?>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="media align-items-center">
                                          <img alt="Image placeholder" class="mr-2" src="<?php echo $image;?>" style="width: 42px;">
                                            <div class="media-body">
                                                <div class="text-limit lh-100">
                                                    <!--<small class="font-weight-bold mb-0"><?php echo $pName; ?></small>-->
													<strong><?php echo $pName; ?></strong>
                                                </div>
                                                <small class="text-muted"><?php // echo $value->quantity . ' x ' . 'Rs' . $value->stock_price;        ?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 text-right lh-100">
                                        <!--<small class="text-dark"><?php echo CURRENCY . $price; ?></small>-->
										<strong><?php echo $price; ?></strong>
                                    </div>
                                </div>
                                <?php
//                  }
//                  }
                                ?>
                                <!-- Subtotal -->
                                <div class="row mt-3 pt-3 border-top">
                                    <div class="col-8 text-right">
                                        <!--<small class="text-uppercase font-weight-bold">Total:</small>-->
										<strong>Total:</strong>
                                    </div>
                                    <div class="col-4 text-right">
                                        <!--<span class="text-sm font-weight-bold"><?php echo CURRENCY . $price; ?></span>-->
										<strong><?php echo CURRENCY . $price; ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <br>
    <br>
    <br>
</div>
<?php
//print_r($publish_key);die;
?>

<script>
    var pk = '<?php echo $publish_key; ?>';
</script>