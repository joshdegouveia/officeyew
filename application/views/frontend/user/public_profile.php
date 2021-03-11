<?php
$user_profile_image = $profile_image = $user_profile_image_thumb = $profile_image_thumb = FILEPATH . 'img/default/profile-pic-blank.png';
$company_name = '';
$company_logo = FILEPATH . 'img/default/no-image.png';
if (!empty($user_detail->filename)) {
  $profile_image = UPLOADPATH . 'user/profile/' . $user_detail->filename;
  // $profile_image_thumb = UPLOADPATH . 'user/profile/thumb/' . $user_detail->filename;
}
if (!empty($company_detail)) {
  $company_name = $company_detail->company_name;
  $company_logo = (!empty($company_detail->company_logo)) ? UPLOADPATH . 'business/logo/thumb/' . $company_detail->company_logo : $company_logo;
}
if (!empty($user['filename'])) {
  $user_profile_image = UPLOADPATH . 'user/profile/' . $user['filename'];
  $user_profile_image_thumb = UPLOADPATH . 'user/profile/thumb/' . $user['filename'];
}
?>
<div class="main-content public-profile-page" data-cm="<?php echo $user_detail->id; ?>">
  <!-- Header (account) -->
  <section class="header-account-page bg-primary d-flex align-items-end" data-offset-top="#header-main">
    <!-- Header container -->
    <div class="container pt-4 pt-lg-0">
      <div class="row justify-content-end">
        <div class=" col-lg-8">
          <!-- Salute + Small stats -->
          <?php
            if ($user_detail->id == $user['id']) {
              $this->load->view('frontend/layout/account_heaer'); 
            } else {
              $name = (!empty($company_detail)) ? ucwords($company_detail->company_name) : ucwords($user_detail->first_name . ' ' . $user_detail->last_name);
          ?>
          <div class="row align-items-center mb-4 middle-header">
            <div class="col-md-5 mb-4 mb-md-0">
              <span class="h2 mb-0 text-white d-block"><?php echo $name; ?></span>
              <span class="h6 text-white">ID: <?php echo ucwords($user_detail->uniqueid); ?></span>
            </div>
          </div>
          <?php } ?>
          <!-- Account navigation -->
          <div class="d-flex res-action">
          <?php if ($user_detail->id == $user['id']) { ?>
            <a href="<?php echo base_url('user/profile'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">Profile</span>
            </a>
          <?php } else { ?>
            <a href="javascript:void(0)" class="btn btn-icon btn-group-nav shadow btn-neutral post active">
              <span class="btn-inner--icon"><i class="fas fa-envelope"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">Post</span>
            </a>
            <a href="javascript:void(0)" class="btn btn-icon btn-group-nav shadow btn-neutral procat">
              <span class="btn-inner--icon"><i class="fas fa-th"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">Categories</span>
            </a>
            <a href="javascript:void(0)" class="btn btn-icon btn-group-nav shadow btn-neutral voucher">
              <span class="btn-inner--icon"><i class="fas fa-gift"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">Vouchers</span>
            </a>
          <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="pt-5 pt-lg-0 minh600p">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div data-toggle="sticky" data-sticky-offset="30" data-negative-margin=".card-profile-cover">
            <div class="card card-profile border-0">
              <div class="card-profile-cover">
                <img alt="Image placeholder" src="<?php echo $profile_image; ?>" class="card-img-top">
              </div>
              <a href="<?php echo $profile_image; ?>" class="mx-auto" data-fancybox>
                <div class="profile-image" style="background-image: url('<?php echo $profile_image; ?>');"></div>
                <!-- <img alt="Image placeholder" src="<?php //echo $profile_image; ?>" class="card-profile-image1 avatar rounded-circle shadow hover-shadow-lg" style="display: none;"> -->
              </a>
              <div class="card-body p-3 pt-0 text-center">
                <!-- <h5 class="mb-0"><?php //echo ucwords($user_detail->first_name . ' ' . $user_detail->last_name); ?></h5> -->
                <?php /*if ($user_detail->type == B2B ){ ?>
                <span class="d-block text-muted mb-3"><?php echo $company_name; ?></span>
                <div>
                  <a href="javascript:void(0)" class="rounded-circle">
                    <img alt="Image placeholder" src="<?php echo $company_logo; ?>" class="wid100p">
                  </a>
                </div>
                <?php }*/ ?>
                <?php if ($user_detail->type == B2B && $user['type'] == SELLER) { ?>
                <div class="follow-wrap">
                  <div class="follow-inner-wrap">
                    <?php if ($follow) { ?>
                    <a href="javascript:void(0)" class="btn btn-default follow active">Following</a>
                    <div class="dropdown-content cnt-drp">
                      <div class="inner-detail">
                        <a href="javascript:void(0)" class="unfollow">Unfollow</a>
                      </div>
                    </div>
                    <?php } else { ?>
                    <a href="javascript:void(0)" class="btn btn-default follow">Follow</a>
                    <?php } ?>
                  </div>
                  <div class="follow-inner-wrap">
                    <?php if (!empty($endorse)) { ?>
                      <?php if ($endorse->status == 1) { ?>
                    <a href="javascript:void(0)" class="btn btn-default endorses active">Endorsing</a>
                    <div class="dropdown-content cnt-drp">
                      <div class="inner-detail">
                        <a href="javascript:void(0)" class="unendorse">Unendorse</a>
                      </div>
                    </div>
                      <?php } else { ?>
                      <a href="javascript:void(0)" class="btn btn-default endorsereq">Requested</a>
                      <?php } ?>
                    <?php } else { ?>
                    <a href="javascript:void(0)" class="btn btn-default endorse">Endorse</a>
                    <?php } ?>
                  </div>
                </div>
                <!-- <div class="follow-wrap wid100">
                  <div class="post-links-wrap marb5p">
                    <a href="javascript:void(0)" class="post-links post active">Post</a>
                  </div>
                  <div class="post-links-wrap marb5p">
                    <a href="javascript:void(0)" class="post-links procat">Categories</a>
                  </div>
                  <div class="post-links-wrap marb5p">
                    <a href="javascript:void(0)" class="post-links voucher">Vouchers</a>
                  </div>
                </div> -->
                <?php } else if ($user_detail->type == CUSTOMER && $user['type'] == SELLER) { ?>
                <div class="follow-wrap">
                  <div class="follow-inner-wrap">
                    <?php if ($follow) { ?>
                    <a href="javascript:void(0)" class="btn btn-default follow active">Follow</a>
                    <div class="dropdown-content cnt-drp">
                      <div class="inner-detail">
                        <a href="javascript:void(0)" class="unfollow">Unfollow</a>
                      </div>
                    </div>
                    <?php } else { ?>
                    <a href="javascript:void(0)" class="btn btn-default follow">Follow</a>
                    <?php } ?>
                  </div>
                </div>
                <?php } ?>
                <?php /* ?>
                <div class="avatar-group hover-avatar-ungroup mb-3">
                  <a href="javascript:void(0)" class="avatar rounded-circle avatar-sm">
                    <img alt="Image placeholder" src="<?php echo FILEPATH; ?>img/theme/light/team-1-800x800.jpg" class="">
                  </a>
                  <a href="javascript:void(0)" class="avatar rounded-circle avatar-sm">
                    <img alt="Image placeholder" src="<?php echo FILEPATH; ?>img/theme/light/team-2-800x800.jpg" class="">
                  </a>
                  <a href="javascript:void(0)" class="avatar rounded-circle avatar-sm">
                    <img alt="Image placeholder" src="<?php echo FILEPATH; ?>img/theme/light/team-3-800x800.jpg" class="">
                  </a>
                </div>
                <div class="actions d-flex justify-content-between mt-3 pt-3 px-5 delimiter-top">
                  <a href="javascript:void(0)" class="action-item">
                    <i class="fas fa-envelope"></i>
                  </a>
                  <a href="javascript:void(0)" class="action-item">
                    <i class="fas fa-user"></i>
                  </a>
                  <a href="javascript:void(0)" class="action-item">
                    <i class="fas fa-chart-pie"></i>
                  </a>
                  <a href="javascript:void(0)" class="action-item text-danger">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </div><?php */ ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8 mt-lg-5 procat-list" style="display: none;"></div>
        <div class="col-lg-8 mt-lg-5 post-list">
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
          <!-- Timeline -->
          <?php if ($user_detail->id == $user['id']) { ?>
          <div class="card">
            <div class="card-body">
              <form method="post" enctype="multipart/form-data" id="wall_post_form">
                <textarea id="post" name="post" placeholder="What do you want to talk about?"></textarea>
                <div class="post-submit">
                  <input type="file" name="file" id="file" style="display: none;" accept="image/jpeg,image/jpg,image/png,image/gif">
                  <a href="javascript:void(0)" id="file_clear" title="Clear attach file" style="display: none;"><i class="fa fa-recycle" aria-hidden="true"></i> Clear</a>
                  <a href="javascript:void(0)" id="fileo" title="Add image"><i class="fa fa-paperclip" aria-hidden="true"></i> Attach</a>
                  <button type="button" class="btn btn-sm btn-primary submit" id="wall_post">Post</button>
                </div>
              </form>
            </div>
          </div>
          <?php } ?>
          <!-- Post -->
          <?php
          if (!empty($post)) {
            $post_image_path = UPLOADPATH . 'post/wall_post/';
            foreach ($post as $value) {
              $like_cls = $comment_cls = $review_cls = '';
              if (!empty($value->like_users)) {
                $likes = explode(',', $value->like_users);
                if (in_array($user['id'], $likes)) {
                  $like_cls = 'like';
                }
              }
              if (!empty($value->comment_users)) {
                $comments = explode(',', $value->comment_users);
                if (in_array($user['id'], $comments)) {
                  $comment_cls = 'comment';
                }
              }
              if (!empty($value->review_users)) {
                $reviews = explode(',', $value->review_users);
                if (in_array($user['id'], $reviews)) {
                  $review_cls = 'voted';
                }
              }
          ?>
          <div class="card mt-4 posts" data-post="post-<?php echo $value->id; ?>">
            <div class="card-header pt-4 pb-2">
              <div class="d-flex align-items-center">
                <!-- <a href="javascript:void(0)" class="avatar rounded-circle shadow">
                  <img alt="Image placeholder" src="<?php //echo $profile_image; ?>">
                </a> -->
                <a href="<?php echo $profile_image; ?>" class="" data-fancybox>
                  <div class="profile-image-post" style="background-image: url('<?php echo $profile_image; ?>');"></div>
                </a>
                <div class="avatar-content">
                  <h6 class="mb-0"><?php echo ucwords($user_detail->first_name . ' ' . $user_detail->last_name); ?></h6>
                  <small class="d-block text-muted"><i class="fas fa-clock mr-2"></i><?php echo date('d M Y h:i A', $value->created_date); ?></small>
                </div>
              </div>
            </div>
            <div class="card-body">
              <p><?php echo $value->content; ?></p>
              <?php if (!empty($value->image)) { ?>
              <a href="<?php echo $post_image_path . $value->image; ?>" data-fancybox>
                <img alt="Image placeholder" src="<?php echo $post_image_path . $value->image; ?>" class="img-fluid rounded">
              </a>
              <?php } ?>
              <div class="row align-items-center my-3 pb-3 border-bottom">
                <div class="col-sm-6">
                  <div class="icon-actions">
                    <a href="javascript:void(0)" class="love active lks <?php echo $like_cls; ?>">
                      <i class="fas fa-heart"></i>
                      <span class="text-muted"><?php echo $value->likes; ?> likes</span>
                    </a>
                    <a href="javascript:void(0)" class="cmt <?php echo $comment_cls; ?>">
                      <i class="fas fa-comment"></i>
                      <span class="text-muted"><?php echo $value->comments; ?> comments</span>
                    </a>
                    <a href="javascript:void(0)" class="rvw">
                      <span class="static-rating static-rating-sm d-block">
                        <i class="star fas fa-star <?php echo $review_cls; ?>"></i>
                        <span class="text-muted"><?php echo $value->reviews; ?> reviews</span>
                      </span>
                    </a>
                  </div>
                </div>
                <?php /* ?>
                <div class="col-sm-6 d-none d-sm-block">
                  <div class="d-flex align-items-center justify-content-sm-end">
                    <small class="pr-2 font-weight-bold">Seen by</small>
                    <div class="avatar-group">
                      <a href="javascript:void(0)" class="avatar avatar-sm" data-toggle="tooltip" data-original-title="Alexis Ren">
                        <img alt="Image placeholder" src="<?php echo FILEPATH; ?>img/theme/light/thumb-1.jpg" class="rounded-circle">
                      </a>
                      <a href="javascript:void(0)" class="avatar avatar-sm" data-toggle="tooltip" data-original-title="Michael Jhonson">
                        <img alt="Image placeholder" src="<?php echo FILEPATH; ?>img/theme/light/thumb-2.jpg" class="rounded-circle">
                      </a>
                      <a href="javascript:void(0)" class="avatar avatar-sm" data-toggle="tooltip" data-original-title="Daniel Lewis">
                        <img alt="Image placeholder" src="<?php echo FILEPATH; ?>img/theme/light/thumb-3.jpg" class="rounded-circle">
                      </a>
                    </div>
                    <small class="pl-2 font-weight-bold">and 30+ more</small>
                  </div>
                </div><?php */ ?>
              </div>
              <!-- Comments -->
              <div class="mb-3 post-review" style="display: none;">
                <div class="row align-items-center">
                  <div class="col-6 text-left">
                    <ul class="list-inline mb-0">
                      <li class="list-inline-item">
                        <span class="badge badge-pill badge-soft-info">Please give your review</span>
                      </li>
                    </ul>
                  </div>
                  <div class="col-6">
                    <span class="static-rating static-rating-sm d-block review">
                      <i class="star fas fa-star"></i>
                      <i class="star fas fa-star"></i>
                      <i class="star fas fa-star"></i>
                      <i class="star fas fa-star"></i>
                      <i class="star fas fa-star"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="mb-3 post-comments">
                <!-- <div class="media media-comment post-comment-content">
                  <img alt="Image placeholder" class="rounded-circle shadow mr-4" src="<?php //echo FILEPATH; ?>img/theme/light/team-2-800x800.jpg" style="width: 64px;">
                  <div class="media-body">
                    <div class="media-comment-bubble left-top">
                      <h6 class="mt-0">Alexis Ren</h6>
                      <p class="text-sm lh-160">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                    </div>
                  </div>
                </div> -->
                <div class="media media-comment align-items-center comment-action" style="display: none;">
                  <!-- <img alt="Image placeholder" class="avatar rounded-circle shadow mr-4" src="<?php echo $user_profile_image; ?>"> -->
                <a href="<?php echo $profile_image; ?>" class="" data-fancybox>
                  <div class="profile-image-post" style="background-image: url('<?php echo $profile_image; ?>');"></div>
                </a>
                  <div class="media-body">
                    <form>
                      <div class="form-group mb-0">
                        <div class="input-group input-group-merge">
                          <textarea class="form-control comment-area" data-toggle="autosize" placeholder="Write your comment" rows="1"></textarea>
                          <div class="input-group-append">
                            <button class="btn btn-primary submit" type="button">
                            <span class="far fa-paper-plane"></span>
                            </button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="sh-cmt" title="Hide comments"><i class="fa fa-arrow-up" aria-hidden="true"></i> Hide</div>
              </div>
            </div>
          </div>
          <?php
            }
          }
          ?>
        </div>
      </div>
    </div>
  </section>
</div>