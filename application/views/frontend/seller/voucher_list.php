<div class="main-content seller-voucher-page">
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
            <a href="<?php echo base_url('seller/vouchers'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">My Vouchers</span>
            </a>
            <?php //$this->load->view('frontend/seller/header_menu'); ?>
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
          <div class="alert alert-success alert-dismissible" role="alert" style="display: none;">
            <strong></strong>
          </div>
          <?php } ?>
          <div class="table-responsive row-w100p">
            <table id="list_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Discount</th>
                  <th>Start Date</th>
                  <th>Expiry Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(!empty($vouchers)) {
                  $i = 1 ;
                  foreach($vouchers as $row) {
                    $discount = ($row->percentage > 0) ? $row->percentage . ' %' : $row->flat_rate . ' rupees';
                ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $row->name; ?></td>
                  <td><?php echo $discount; ?></td>
                  <td><?php echo $row->start_date; ?></td>
                  <td><?php echo $row->expiry_date; ?></td>
                  <td>
                    <a href="javascript:void(0)" class="send-mail" data-cid="<?php echo $row->id; ?>" data-toggle="modal" data-target="#modal_send_mail">
                      <button type="button" class="btn btn-info btn-sm"> Send</button>
                    </a>
                    <a href="<?php echo base_url('seller/editvoucher'); ?>?cid=<?php echo $row->id ; ?>">
                      <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                    </a>
                    <a href="<?php echo base_url('seller/delete'); ?>?tp=voucher&cid=<?php echo $row->id ; ?>" class="rm-data">
                      <button type="button" class="btn btn-info btn-sm"><i class="fa fa-remove"></i> Delete</button>
                    </a>
                  </td>
                </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php /* ?>
        <div class="col-lg-3 order-lg-1">
          <?php $this->load->view('frontend/user/profile-left-panel'); ?>
        </div><?php */ ?>
      </div>
    </div>
  </section>

  <div class="modal fade" id="modal_send_mail" tabindex="-1" role="dialog" aria-labelledby="modal-send-email" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <form method="post" id="send_voucher" style="width: 100%;" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title d-flex align-items-center" id="modal-title-change-email">
              <div>
                <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                  <i class="fa fa-envelope" aria-hidden="true"></i>
                </div>
              </div>
              <div>
                <h6 class="mb-0">Send Voucher to Customer</h6>
              </div>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger alert-dismissible" role="alert" style="display: none;">
              <strong></strong>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label class="form-control-label">Template</label>
                  <select class="form-control" name="template" id="template" required>
                    <option value="">-- Select --</option>
                    <?php
                    if (!empty($templates)) {
                      foreach ($templates as $value) {
                    ?>
                    <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label class="form-control-label">Select Customers</label>
                  <div class="customer-wrapper">
                    <?php
                    if (!empty($customers)) {
                      foreach ($customers as $value) {
                    ?>
                    <div class="inner-wrapper">
                      <label>
                        <input class="" type="checkbox" name="customers[]" value="<?php echo $value->follow_by; ?>"> <?php echo ucwords($value->first_name . ' ' . $value->last_name); ?>
                      </label>
                    </div>
                    <?php
                      }
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary preview">Preview</button>
            <button type="button" class="btn btn-sm btn-secondary submit">Send Mail</button>
          </div>
        </div>
      </form>
      <div class="preview-area" style="display: none;">
        <div class="modal-content content"></div>
      </div>
    </div>
  </div>
</div>