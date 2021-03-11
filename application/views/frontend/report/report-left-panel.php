<div data-toggle="sticky" data-sticky-offset="30" data-negative-margin=".card-profile-cover">
  <div class="card">
    <div class="card-header py-3">
      <span class="h6">Settings</span>
    </div>
    <div class="list-group list-group-sm list-group-flush">
      <a href="<?php echo base_url('report/averagesale'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fa fa-desktop mr-2"></i>
          <span>Average Sale</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <!-- <a href="<?php //echo base_url('report/averagesalegraph'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fa fa-desktop mr-2"></i>
          <span>Average Sale Graph</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a> -->
      <?php if ($user['type'] == B2B) { ?>
      <a href="<?php echo base_url('report/topreseller'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-user-circle mr-2"></i>
          <span>Top Reseller</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <!-- <a href="<?php //echo base_url('report/topresellergraph'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-user-circle mr-2"></i>
          <span>Top Reseller Graph</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a> -->
      <?php } else if ($user['type'] == SELLER) { ?>
      <a href="<?php echo base_url('report/trendingreport'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-user-circle mr-2"></i>
          <span>Trending Report</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <!-- <a href="<?php //echo base_url('report/trendingreportgraph'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-user-circle mr-2"></i>
          <span>Trending Report Graph</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a> -->
      <?php } ?>
      <a href="<?php echo base_url('report/customreport'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-user-circle mr-2"></i>
          <span>Custom Report</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <a href="<?php echo base_url('report/customgraph'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-user-circle mr-2"></i>
          <span>Custom Graph</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
    </div>
  </div>
</div>