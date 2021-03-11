<div class="main-content product-order-report-page">
    <!-- Header (account) -->
    <section class="header-account-page bg-primary d-flex align-items-end" data-offset-top="#header-main">
        <!-- Header container -->
        <div class="container pt-4 pt-lg-0">
            <div class="row">
                <div class=" col-lg-12">
                    <!-- Salute + Small stats -->
                    <?php
                    $this->load->view('frontend/layout/account_heaer');
                    ?>
                    <!-- Account navigation -->
                    <div class="d-flex">
                        <a href="<?php echo base_url('report/productorders'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
                            <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
                            <span class="btn-inner--text d-none d-md-inline-block"><?php echo $title; ?></span>
                        </a>
                        <?php /*if ($user['type'] == B2B) { ?>
                        <?php $this->load->view('frontend/business/header_menu'); ?>
                        <?php } else if ($user['type'] == SELLER) { ?>
                        <?php $this->load->view('frontend/seller/header_menu'); ?>
                        <?php }*/ ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="slice bg-section-secondary">
        <div class="container">
            <div class="row row-grid">
                <div class="col-lg-12 order-lg-2">
                    <?php if ($this->session->flashdata('msg_error')) { ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
                    </div>
                    <?php } else if ($this->session->flashdata('msg_success')) { ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
                    </div>
                    <?php } else { ?>
                    <div class="alert alert-dismissible" role="alert" style="display: none;">
                        <strong></strong>
                    </div>
                    <?php } ?>
                    <!-- Orders table -->
                    <div class="table-responsive">
                        <table class="table table-cards align-items-center">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Image</th>
                                    <th scope="col" class="sort">Product Price</th>
                                    <th scope="col" class="sort">Sale Price</th>
                                    <th scope="col" class="sort">Quantity</th>
                                    <th scope="col" class="sort">Customer</th>
                                    <?php if ($user['type'] == B2B) { ?>
                                    <th scope="col" class="sort">Reseller</th>
                                    <?php } ?>
                                    <th scope="col" class="sort">Status</th>
                                    <th scope="col" class="sort">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($content)) {
                                foreach ($content as $value) {
                                    $image = FILEPATH . 'img/default/no-image.png';
                                    if (!empty($value->image) && file_exists(UPLOADDIR . 'products/' . $value->image)) {
                                        $image = UPLOADPATH . 'products/' . $value->image;
                                    }
                            ?>
                                <tr>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><?php echo $value->name; ?></span>
                                    </td>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><img src="<?php echo $image; ?>"></span>
                                    </td>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><?php echo $value->product_price; ?></span>
                                    </td>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><?php echo $value->sale_price; ?></span>
                                    </td>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><?php echo $value->quantity; ?></span>
                                    </td>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><?php echo ucwords($value->first_name . ' ' . $value->last_name); ?></span>
                                        <span class="d-block text-sm text-muted"><?php echo $value->email; ?></span>
                                    </td>
                                    <?php if ($user['type'] == B2B) { ?>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><a href="<?php echo base_url('user/profile/' . $value->seller_id); ?>" target="_blank"><?php echo ucwords($value->seller_first_name . ' ' . $value->seller_last_name); ?></a>
                                    </td>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted prod-status" title="change status"><?php echo ucwords($value->product_status); ?></span>
                                        <div class="action" data-pid="pid-<?php echo $value->id; ?>" style="display: none;">
                                            <select class="product-status">
                                                <option value="pending">Pending</option>
                                                <option value="cancel">Cancel</option>
                                                <option value="complete">Complete</option>
                                            </select>
                                            <input type="button" class="change" value="Change" title="change">
                                            <a class="cancel" title="cancel">X</a>
                                        </div>
                                    </td>
                                    <?php } else { ?>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><?php echo ucwords($value->product_status); ?></span>
                                    </td>
                                    <?php } ?>
                                    <td>
                                        <span class="taxes text-sm mb-0"><?php echo date('d/m/Y', $value->created_date); ?></span>
                                    </td>
                                </tr>
                                <!-- <tr class="table-divider"></tr> -->
                            <?php } ?>
                            <?php } else { ?>
                                <tr><td colspan="7">No data found.</td></tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>