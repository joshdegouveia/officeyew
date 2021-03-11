<?php
$bank_details =array();
$bank_acc_no = $bank_acc_name = $bank_name = $ifsc_code = '';
if (!empty($account_detail)) {
  $bank_details = unserialize( $account_detail->bank_detail );
  //pre($bank_details);
  $bank_acc_no = $bank_details['bank_acc_no'];
  $bank_acc_name = $bank_details['bank_acc_name'];
  $bank_name = $bank_details['bank_name'];
  $ifsc_code = $bank_details['ifsc_code'];
}
?>
<div class="main-content billing-page">
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
            <a href="<?php echo base_url('user/billing'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">Billing</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="slice">
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

          <?php if ($user['type'] == CUSTOMER) { ?>
          <!-- Section title -->
          <div class="actions-toolbar py-2 mb-4">
            <h5 class="mb-1">Save cards</h5>
            <p class="text-sm text-muted mb-0">Add you credit card for faster checkout process.</p>
          </div>
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-5 col-lg-8">
                  <span class="h6">Credit Card</span>
                </div>
                <div class="col-7 col-lg-4 text-right">
                  <img alt="Image placeholder" src="../../assets/img/icons/cards/mastercard.png" width="40" class="mr-2">
                  <img alt="Image placeholder" src="../../assets/img/icons/cards/visa.png" width="40" class="mr-2">
                  <img alt="Image placeholder" src="../../assets/img/icons/cards/skrill.png" width="40">
                </div>
              </div>
            </div>
            <div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-sm-4"><small class="h6 text-sm mb-3 mb-sm-0">Credit or debit cards</small></div>
                    <div class="col-sm-8">
                      <!-- First card -->
                      <div class="row mb-3">
                        <div class="col-9">
                          <img alt="Image placeholder" src="../../assets/img/icons/cards/visa.png" class="mr-1" width="30">
                          x-1023 (Expires on 11/2018)
                        </div>
                        <div class="col-3 actions text-right">
                          <a href="#" class="action-item" data-toggle="tooltip" data-original-title="Remove card">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                        </div>
                      </div>
                      <!-- Second card -->
                      <div class="row">
                        <div class="col-9">
                          <img alt="Image placeholder" src="../../assets/img/icons/cards/skrill.png" class="mr-1" width="30">
                          x-3165 (Expires on 09/2017)
                        </div>
                        <div class="col-3 actions text-right">
                          <a href="#" class="action-item" data-toggle="tooltip" data-original-title="Remove card">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <!-- Attach a new card -->
          <div class="mt-5">
            <div class="actions-toolbar py-2 mb-4">
              <h5 class="mb-1">Attach a new card</h5>
              <p class="text-sm text-muted mb-0">Add you credit card for faster checkout process.</p>
            </div>
            <form>
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-5 col-lg-8">
                      <span class="h6">Credit Card</span>
                      <p class="text-muted text-sm mt-2 mb-0 d-none d-lg-block">Safe money transfer using your bank account. We support Mastercard, Visa, Maestro and Skrill.</p>
                    </div>
                    <div class="col-7 col-lg-4 text-right">
                      <img alt="Image placeholder" src="../../assets/img/icons/cards/mastercard.png" width="40" class="mr-2">
                      <img alt="Image placeholder" src="../../assets/img/icons/cards/visa.png" width="40" class="mr-2">
                      <img alt="Image placeholder" src="../../assets/img/icons/cards/skrill.png" width="40">
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row mt-3">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label">Card number</label>
                        <div class="input-group input-group-merge">
                          <input type="text" class="form-control" data-mask="0000 0000 0000 0000" placeholder="4789 5697 0541 7546">
                          <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label">Name on card</label>
                        <input type="text" class="form-control" placeholder="John Doe">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-control-label">Expiry date</label>
                        <input type="text" class="form-control" data-mask="00/00" placeholder="MM/YY">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-control-label">CVV code</label>
                        <div class="input-group input-group-merge">
                          <input type="text" class="form-control" data-mask="000" placeholder="746">
                          <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-question-circle"></i></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-right">
                    <button type="button" class="btn btn-sm btn-primary">Save card</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <?php } else if ($user['type'] == B2B || $user['type'] == SELLER) { ?>
          <div class="mt-5">
            <div class="actions-toolbar py-2 mb-4">
              <h5 class="mb-1">Add your Bank Account Credentials</h5>
              <p class="text-sm text-muted mb-0">Add you Bank Account credentials for further customer products processing.</p>
            </div>
            <form id="acocunt_detail_form" method="post">
              <div class="card">
                <div class="card-body">
                  <div class="row mt-3">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label">Bank Account no</label>
                        <div class="input-group input-group-merge">
                          <input type="text" class="form-control" name="bank_acc_no" id="bank_acc_no" value="<?php echo $bank_acc_no; ?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label">Bank Account Name</label>
                        <div class="input-group input-group-merge">
                          <input type="text" class="form-control" name="bank_acc_name" id="bank_acc_name" value="<?php echo $bank_acc_name; ?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label">Bank Name</label>
                        <div class="input-group input-group-merge">
                          <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo $bank_name; ?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label">IFSC code</label>
                        <div class="input-group input-group-merge">
                          <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" value="<?php echo $ifsc_code; ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-right">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <?php } ?>
          <?php if (!empty($payment)) { ?>
          <!-- Payment history -->
          <div class="mt-5">
            <div class="actions-toolbar py-2 mb-4">
              <h5 class="mb-1">Payment history</h5>
              <p class="text-sm text-muted mb-0">Add you credit card for faster checkout process.</p>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-cards align-items-center">
                <tbody>
                  <tr>
                    <th scope="row">
                      <span class="badge badge-lg badge-dot">
                        <i class="bg-success"></i>
                      </span>
                    </th>
                    <td>
                      <i class="fas fa-calendar-alt mr-2"></i>
                      <span class="h6 text-sm">May 20, 2018</span>
                    </td>
                    <td>#10015</td>
                    <td><i class="fas fa-credit-card mr-2"></i>Visa ending in 2035</td>
                    <td>$49.00 USD</td>
                    <td class="text-right">
                      <div class="actions">
                        <div class="dropdown">
                          <a class="action-item" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><i class="fas fa-file-pdf"></i>Download invoice</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-file-archive"></i>See details</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-trash-alt"></i>Delete</a>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr class="table-divider"><td colspan="6"></td></tr>
                  <tr>
                    <th scope="row">
                      <span class="badge badge-lg badge-dot">
                        <i class="bg-danger"></i>
                      </span>
                    </th>
                    <td>
                      <i class="fas fa-calendar-alt mr-2"></i>
                      <span class="h6 text-sm">Apr 15, 2018</span>
                    </td>
                    <td>#10015</td>
                    <td><i class="fas fa-credit-card mr-2"></i>Visa ending in 2035</td>
                    <td><span class="text-danger">$39.00 USD</span></td>
                    <td class="text-right">
                      <div class="actions">
                        <div class="dropdown">
                          <a class="action-item" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><i class="fas fa-file-pdf"></i>Download invoice</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-file-archive"></i>See details</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-trash-alt"></i>Delete</a>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <?php } ?>

        </div>
        <?php /* ?>
        <div class="col-lg-3 order-lg-1">
          <?php $this->load->view('frontend/user/profile-left-panel'); ?>
        </div><?php */ ?>
      </div>
    </div>
  </section>
</div>