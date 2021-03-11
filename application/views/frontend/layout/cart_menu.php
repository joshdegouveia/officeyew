<?php
$cur_page = $this->uri->segment(2);
//pre($_SESSION['cart']);
/*$cart_link = (isset($_SESSION['cart']) && in_array('cart',$_SESSION['cart'])) ? base_url('products/customer_details') : 'javascript:void(0)';
$customer_link = (isset($_SESSION['cart']) && in_array('customer',$_SESSION['cart'])) ? base_url('products/customer_details') : 'javascript:void(0)';
$shipping_link = (isset($_SESSION['cart']) && in_array('shipping',$_SESSION['cart'])) ? base_url('products/shipping') : 'javascript:void(0)';
$payment_link = (isset($_SESSION['cart']) && in_array('payment',$_SESSION['cart'])) ? base_url('products/cartPaument') : 'javascript:void(0)';

$cart_color = (isset($_SESSION['cart']) && in_array('cart',$_SESSION['cart'])) ? '' : 'background-color: #ececec;';
$customer_color = (isset($_SESSION['cart']) && in_array('customer',$_SESSION['cart'])) ? '' : 'background-color: #ececec;';
$shipping_color = (isset($_SESSION['cart']) && in_array('shipping',$_SESSION['cart'])) ? '' : 'background-color: #ececec;';
$payment_color = (isset($_SESSION['cart']) && in_array('payment',$_SESSION['cart'])) ? '' : 'background-color: #ececec;';*/
$cart_color = ($cur_page == 'cart') ? '' : 'background-color: #ececec;';
$customer_color = ($cur_page == 'customer_details') ? '' : 'background-color: #ececec;';
$shipping_color = ($cur_page == 'shipping') ? '' : 'background-color: #ececec;';
$payment_color = ($cur_page == 'cartpayment') ? '' : 'background-color: #ececec;';
?>
<div class="d-flex">
    <div class="btn-group btn-group-nav shadow" role="group" aria-label="Basic example">
        <div class="btn-group" role="group">
            <a href="<?php echo base_url('products/cart');?>" style="<?php echo $cart_color; ?>" class="btn btn-white btn-icon">
                <span class="btn-inner--icon"><i class="fas fa-shopping-cart"></i></span>
                <span class="btn-inner--text d-none d-md-inline-block">Cart</span>
            </a>
            <a href="<?php echo base_url('products/customer_details'); ?>" style="<?php echo $customer_color; ?>" class="btn btn-white btn-icon">
                <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
                <span class="btn-inner--text d-none d-md-inline-block">Customer</span>
            </a>
            <a href="<?php echo base_url('products/shipping'); ?>" style="<?php echo $shipping_color; ?>" class="btn btn-white btn-icon">
                <span class="btn-inner--icon"><i class="fas fa-truck"></i></span>
                <span class="btn-inner--text d-none d-md-inline-block">Shipping</span>
            </a>
            <a href="<?php echo base_url('products/cartpayment'); ?>" style="<?php echo $payment_color; ?>" class="btn btn-white btn-icon">
                <span class="btn-inner--icon"><i class="fas fa-credit-card"></i></span>
                <span class="btn-inner--text d-none d-md-inline-block">Payment</span>
            </a>
        </div>
    </div>
</div>