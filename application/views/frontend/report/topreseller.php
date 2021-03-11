<div class="main-content top-reseller-page">
    <!-- Header (account) -->
    <section class="header-account-page bg-primary d-flex align-items-end" data-offset-top="#header-main">
        <!-- Header container -->
        <div class="container pt-4 pt-lg-0">
            <div class="row">
                <div class=" col-lg-12">
                    <!-- Salute + Small stats -->
                    <?php
                    $data['user'] = $user;
                    $this->load->view('frontend/layout/account_heaer', $data);
                    ?>
                    <!-- Account navigation -->
                    <div class="d-flex">
                        <a href="<?php echo base_url('report/averagesale'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
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
                <div class="col-lg-9 order-lg-2">
                    <!-- Section title -->
                    <?php /* ?>
                    <div class="actions-toolbar py-2 mb-4">
                        <div class="actions-search" id="actions-search">
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-flush" placeholder="Type and hit enter ...">
                                <div class="input-group-append">
                                    <a href="javascript:void(0)" class="input-group-text bg-transparent" data-action="search-close" data-target="#actions-search"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <h5 class="mb-1"><?php echo $title; ?></h5>
                                <p class="text-sm text-muted mb-0 d-none d-md-block">Manage pending orders and track invoices.</p>
                            </div>
                            <div class="col text-right">
                                <div class="actions">
                                    <a href="javascript:void(0)" class="action-item mr-2" data-action="search-open" data-target="#actions-search"><i class="fas fa-search"></i></a>
                                    <div class="dropdown mr-2">
                                        <a href="javascript:void(0)" class="action-item" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-filter"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0)">
                                                <i class="fas fa-sort-amount-down"></i>Newest
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0)">
                                                <i class="fas fa-sort-alpha-down"></i>From A-Z
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0)">
                                                <i class="fas fa-sort-alpha-up"></i>From Z-A
                                            </a>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0)" class="action-item mr-2"><i class="fas fa-sync"></i></a>
                                    <div class="dropdown" data-toggle="dropdown">
                                        <a href="javascript:void(0)" class="action-item" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:void(0)" class="dropdown-item">Refresh</a>
                                            <a href="javascript:void(0)" class="dropdown-item">Settings</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><?php */ ?>
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
                                    <th scope="col" class="sort">Reseller ID</th>
                                    <th scope="col" class="sort">Reseller Name</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col" class="sort">Units Sold</th>
                                    <th scope="col" class="sort">Amount Sold</th>
                                    <th scope="col" class="sort">Date</th>
                                    <!-- <th scope="col">Transaction/Order ID</th> -->
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($content)) {
                                foreach ($content as $value) {
                                    $customer_name = ucwords($value->first_name . ' ' . $value->last_name);
                            ?>
                                <tr>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><?php echo $value->name; ?></span>
                                    </td>
                                    <td>
                                        <span class="client"><?php echo $value->total_price; ?></span>
                                    </td>
                                    <td>
                                        <span class="client"><?php echo $value->total_unit; ?></span>
                                    </td>
                                    <td>
                                        <span class="client"><?php echo $value->user_id; ?></span>
                                    </td>
                                    <td>
                                        <span class="client"><?php echo $customer_name; ?></span>
                                    <td>
                                        <span class="taxes text-sm mb-0"><?php echo date('d/m/Y', $value->created_date); ?></span>
                                    </td>
                                </tr>
                                <tr class="table-divider"></tr>
                            <?php } ?>
                            <?php } else { ?>
                                <tr><td colspan="7">No data found.</td></tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Load more -->
                    <!-- <div class="mt-4 text-center">
                        <a href="javascript:void(0)" class="btn btn-sm btn-neutral rounded-pill shadow hover-translate-y-n3">Load more ...</a>
                    </div> -->
                </div>
                <div class="col-lg-3 order-lg-1">
                  <?php $this->load->view('frontend/report/report-left-panel'); ?>
                </div>
            </div>
        </div>
    </section>
</div>