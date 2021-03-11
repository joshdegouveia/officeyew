<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $title; ?>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <?php //if ($user_type == ADMIN) { ?>

        <div class="row">
            <?php
            $color = ['green', 'yellow', 'red', 'blue', 'aqua', 'purple', 'fuchsia'];
            foreach ($la_userCount as $k => $userCount) {
                ?>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <a href="<?php echo base_url(); ?>admin/users/user_list/<?= $userCount->name ?>">
                            <span class="info-box-icon bg-<?= $color[$k] ?>"><i class="ion ion-ios-people-outline"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total <?= $userCount->name ?></span>
                                <span class="info-box-number"><?php echo $userCount->user_count; ?></span>
                            </div>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
            <!--            <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <a href="javascript:void(0)">
                                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Buyers</span>
                                        <span class="info-box-number"><?php echo $total_buyer; ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>-->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="<?php echo base_url('admin/cms'); ?>">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-firefox" aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">CMS List</span>
                            <span class="info-box-number"><?php echo $total_cms; ?></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">

            </div>
            <!--<div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <a href="<?php //echo base_url('admin/faq/categories');       ?>">
                  <span class="info-box-icon bg-yellow"><i class="fa fa-share-alt" aria-hidden="true"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">FAQ Category List</span>
                    <span class="info-box-number"><?php echo $total_faq_category; ?></span>
                  </div>
                </a>
              </div>
            </div>-->
            <!--<div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <a href="<?php //echo base_url('admin/faq/items');       ?>">
                  <span class="info-box-icon bg-yellow"><i class="fa fa-question" aria-hidden="true"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">FAQ Item List</span>
                    <span class="info-box-number"><?php //echo $total_faq_item;       ?></span>
                  </div>
                </a>
              </div>
            </div>-->

        </div>

        <?php //} ?>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->