<div class="main-content faq">
  <!-- Spotlight -->
  <section class="slice slice-lg bg-gradient-primary" data-offset-top="#header-main">
    <div class="container pt-5">
      <div class="row">
        <div class="col-lg-8">
          <h2 class="display-4 text-white">Faq</h2>
          <h5 class="mb-4 text-white">Frequently asked questions</h5>
        </div>
      </div>
    </div>
    <a href="#sct-faq" class="tongue tongue-bottom tongue-section-primary scroll-me">
      <i class="fas fa-angle-down"></i>
    </a>
  </section>
  <section class="slice slice-lg" id="sct-faq">
    <div class="container">
      <div class="row row-grid">
        <div class="col-lg-3">
          <!-- Side menu -->
          <div data-toggle="sticky" data-sticky-offset="30">
            <div class="card">
              <div class="list-group list-group-flush">
                <?php
                if (!empty($faq_categories)) {
                  foreach ($faq_categories as $value) {
                    if (!array_key_exists($value->id, $faq_active_categories)) {
                      continue;
                    }
                    $faq_active_categories[$value->id] = $value->name;
                ?>
                <a href="#cat<?php echo $value->id; ?>" data-scroll-to data-scroll-to-offset="50" class="list-group-item list-group-item-action d-flex justify-content-between">
                  <div>
                    <i class="fas fa-hand-pointer mr-2"></i>
                    <span><?php echo $value->name; ?></span>
                  </div>
                  <div>
                    <i class="fas fa-angle-right"></i>
                  </div>
                </a>
                <?php
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8 ml-lg-auto">
          <?php
          if (!empty($faq_items)) {
            $category = 0;
            $first = true;
            $last_category = '';
            foreach ($faq_items as $value) {
              if (empty($last_category)) {
                $last_category = $value->category_id;
              }
          ?>
          
          <?php
          if ($value->category_id != $category) {
            if (!$first) {
          ?>
          </div>
            <!-- Scroll to top -->
            <div class="text-right py-4">
              <a href="#cat<?php echo $last_category; ?>" data-scroll-to data-scroll-to-offset="50" class="text-sm font-weight-bold">Back to top<i class="fas fa-long-arrow-alt-up ml-2"></i></a>
            </div>
          </div>
          <?php
            }
          ?>
          <div class="mb-5 faq-items">
            <h4 class="mb-4" id="cat<?php echo $value->category_id; ?>"><?php echo $faq_active_categories[$value->category_id]; ?></h4>
            <!-- Accordion -->
            <div id="accordion-1" class="accordion accordion-spaced">
          <?php
            $first = false;
            $category = $last_category = $value->category_id;
          }
          ?>
              <!-- Accordion card 1 -->
              <div class="card">
                <div class="card-header py-4" id="heading-1-1" data-toggle="collapse" role="button" data-target="#collapse_<?php echo $value->id; ?>" aria-expanded="false" aria-controls="collapse-1-1">
                  <h6 class="mb-0"><i class="fas fa-file-pdf mr-3"></i><?php echo $value->question; ?></h6>
                </div>
                <div id="collapse_<?php echo $value->id; ?>" class="collapse" aria-labelledby="heading-1-1" data-parent="#accordion-1">
                  <div class="card-body">
                    <p><?php echo $value->answer; ?></p>
                  </div>
                </div>
              </div>
          <?php } ?>
            </div>
            <!-- Scroll to top -->
            <div class="text-right py-4">
              <a href="#cat<?php echo $last_category; ?>" data-scroll-to data-scroll-to-offset="50" class="text-sm font-weight-bold">Back to top<i class="fas fa-long-arrow-alt-up ml-2"></i></a>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>
</div>