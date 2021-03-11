<?php
$add_report = $report_name = '';
$add_form = 'style="display:none;"';
$report_fields = array();
$submit_button = 'Create';
if (!empty($report)) {
    $add_report = 'style="display:none;"';
    $add_form = '';
    $report_name = $report->name;
    $report_fields = unserialize($report->fields);
    $submit_button = 'Update';
}
?>
<div class="main-content custom-report-page">
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
                        <a href="<?php echo base_url('report/customreport'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
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
                    <?php if ($report_create) { ?>
                    <button class="btn btn-primary add-report" <?php echo $add_report; ?>>+ Add Report</button>
                    <div class="add-form" <?php echo $add_form; ?>>
                        <form id="profile_form" enctype="multipart/form-data" method="post" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control flatpickr-input" placeholder="Report name" value="<?php echo $report_name; ?>" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Select Fields</label>
                                        <div class="field-items">
                                            <?php
                                            foreach ($fields as $k => $value) {
                                                $selected = (in_array($k, $report_fields)) ? 'checked="checked"' : '';
                                            ?>
                                            <div class="item" title="<?php echo $value; ?>">
                                                <label><input type="checkbox" name="fields[]" value="<?php echo $k; ?>" <?php echo $selected; ?>> <?php echo $value; ?></label>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="delimiter-top text-left">
                                <?php if (!empty($report_name)) { ?>
                                <a href="<?php echo base_url('report/customreport'); ?>" class="btn btn-sm btn-danger">Cancel</a>
                                <?php } ?>
                                <button type="submit" class="btn btn-sm btn-success"><?php echo $submit_button; ?></button>
                            </div>
                        </form>
                    </div>
                    <?php } ?>

                    <div class="table-responsive">
                        <table class="table table-cards align-items-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Reports</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($content)) {
                                $ind = 1;
                                foreach ($content as $value) {
                            ?>
                                <tr>
                                    <td>
                                        <span class="taxes text-sm mb-0">#<?php echo $ind++; ?></span>
                                    </td>
                                    <td class="name">
                                        <span class="d-block text-sm text-muted"><?php echo $value->name; ?></span>
                                    </td>
                                    <td>
                                        <span class="taxes text-sm mb-0">
                                            <a href="<?php echo base_url('report/customreport/view/' . $value->id); ?>">
                                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</button>
                                            </a>
                                        </span>
                                        <?php /* ?>
                                        <span class="taxes text-sm mb-0">
                                            <a href="<?php echo base_url('report/reportgraph/' . $value->id); ?>">
                                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Graph</button>
                                            </a>
                                        </span><?php */ ?>
                                        <span class="taxes text-sm mb-0">
                                            <a href="<?php echo base_url('report/customreport/edit/' . $value->id); ?>">
                                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                                            </a>
                                        </span>
                                        <span class="taxes text-sm mb-0">
                                            <a href="<?php echo base_url('report/delete'); ?>?tp=creport&cid=<?php echo $value->id ; ?>" class="rm-data">
                                                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-remove"></i> Delete</button>
                                            </a>
                                        </span>
                                        <!-- <span class="taxes text-sm mb-0">
                                            <label for="show_dashboard" class="show_dashboard">
                                                <input type="radio" name="show_dashboard[]" class="" value="1"> Show on Dashboard
                                            </label>
                                        </span> -->
                                    </td>
                                </tr>
                                <tr class="table-divider"></tr>
                            <?php } ?>
                            <?php } else { ?>
                                <tr><td colspan="7">No custom report found.</td></tr>
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