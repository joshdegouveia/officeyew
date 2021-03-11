<?php if ($this->session->flashdata('msg_error')) { ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <strong>
            <i class="fa fa-exclamation-triangle"></i> <?php echo $this->session->flashdata('msg_error'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        </strong>
    </div>
<?php } else if ($this->session->flashdata('msg_success')) { ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <strong>
            <i class="fa  fa-check"></i> <?php echo $this->session->flashdata('msg_success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

        </strong>
    </div>
<?php } ?>