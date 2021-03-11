<div class="main-content report-graph-page">
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
                        <a href="<?php echo base_url('report/customgraph'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
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
                    <div class="header">
                        <a href="<?php echo base_url('report/customgraph'); ?>"><i class="fa fa-chevron-left" aria-hidden="true"></i> Reports</a>
                        <h2 class="title"></h2>
                        <div class="act">
                            <button type="button" class="btn print"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                            <button type="button" class="btn jpg"><i class="fa fa-file-image" aria-hidden="true"></i> Save as JPEG</button>
                            <button type="button" class="btn png"><i class="fa fa-file-image" aria-hidden="true"></i> Save as PNG</button>
                        </div>
                    </div>
                    <div class="graph-container">
                        <div class="gr-title"></div>
                        <div class="graph" id="graph"></div>
                        <div class="hd-tr"></div>
                    </div>
                </div>
                <?php /* ?>
                <div class="col-lg-3 order-lg-1">
                  <?php $this->load->view('frontend/report/report-left-panel'); ?>
                </div><?php */ ?>
            </div>
        </div>
    </section>
</div>