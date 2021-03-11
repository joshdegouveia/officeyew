<div class="main-content average-report-page">
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
                        <a href="<?php echo base_url('report/voucherorders'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
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
                    <?php } ?>
                    <!-- Orders table -->
                    <div class="table-responsive">
                        <table class="table table-cards align-items-center">
                            <thead>
                                <tr>
                                    <th scope="col">Voucher</th>
                                    <th scope="col" class="sort">Voucher Price</th>
                                    <th scope="col" class="sort">Voucher Discount</th>
                                    <th scope="col" class="sort">Customer Name</th>
                                    <th scope="col" class="sort">Customer Email</th>
                                    <th scope="col" class="sort">Customer Phone</th>
                                    <th scope="col" class="sort">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($content)) {
                                foreach ($content as $value) {
                                    $discount = ($value->discount_flat_rate > 0) ? $value->discount_flat_rate : $value->discount_percentage;
                            ?>
                                <tr>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><?php echo $value->name; ?></span>
                                    </td>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><?php echo $value->voucher_price; ?></span>
                                    </td>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><?php echo $discount; ?></span>
                                    </td>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><?php echo $value->customer_name; ?></span>
                                    </td>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><?php echo $value->customer_email; ?></span>
                                    </td>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><?php echo $value->customer_phone; ?></span>
                                    </td>
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