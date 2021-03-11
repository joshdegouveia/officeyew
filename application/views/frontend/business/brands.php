<div class="main-content">   
   <!-- Products -->
   <section style="padding-bottom: 0px;" class="slice slice-lg delimiter-bottom bg-primary" id="sct-products">
      <!--for menue backgroung color -->
        <div class="spotlight-holder pt-9 pb-6 py-lg-0">
            <div class="container d-flex align-items-center px-0">
                <div class="col">
                    <div class="row row-grid align-item-center">
                        <div class="col-lg-12">
                            <div class="py-5">
                                <h1 class="text-white mb-4"><?php echo $title; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="slice slice-lg delimiter-bottom" id="sct-products">
      <div class="container">
        <div class="row">
          <?php
          if(!empty($content)) { 
            foreach($content as $value) {
              $name = (!empty($value->company_name)) ? ucfirst($value->company_name) : ucwords($value->first_name . ' ' . $value->last_name);
              $image = FILEPATH . 'img/default/no-image.png';

              if (!empty($value->company_logo)) {
                $image = UPLOADPATH . 'business/logo/thumb/' . $value->company_logo;
              } else if (!empty($value->filename)) {
                $image = UPLOADPATH . 'user/profile/thumb/' . $value->filename;
              }
          ?>
          <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="card card-product">
              <div class="card-image">
                <a href="<?php echo base_url('user/profile/' . $value->id); ?>">
                  <img alt="Image placeholder" src="<?php echo $image; ?>" class="img-center img-fluid">
                </a>
              </div>
              <div class="card-body text-center pt-0">
                <h6><a href="<?php echo base_url('user/profile/' . $value->id); ?>"><?php echo $name?></a></h6>
                <?php if (!empty($value->about_company)) { ?>
                <p class="text-sm">
                <?php echo $value->about_company; ?>
                </p>
                <?php } ?>
              </div>
            </div>
          </div>
          <?php 
            }
          ?>
        </div>
        <!-- Load more -->
        <div class="mt-4 text-center">
          <a href="" class="btn btn-sm btn-white rounded-pill shadow hover-translate-y-n3">See all products</a>
        </div>
          <?php } else {
            echo '<strong style="color:red">No brand found</strong>';
          } ?>
      </div>
    </section>
</div>  
<script>

</script>
