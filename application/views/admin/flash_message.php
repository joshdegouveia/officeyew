
<?php if ($this->session->flashdata('msg_error')) { ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
    </div>
<?php } else if ($this->session->flashdata('msg_success')) { ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
    </div>
<?php } else { ?>
    <div class="alert alert-danger alert-dismissible" role="alert" style="display: none;">
        <strong></strong>
    </div>
<?php } ?>