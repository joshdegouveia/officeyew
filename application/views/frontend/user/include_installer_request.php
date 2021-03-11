<ul class="nav nav-tabs" id="myTab" role="tablist">

    <?php if ($user['type'] == 'installer') {
        ?> 
        <li class="nav-item ">
            <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#installer_Submitted_Request" role="tab" aria-controls="installer_Submitted_Request" aria-selected="true">Submitted Request</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="home-tab" data-toggle="tab" href="#installer_Incoming_Request" role="tab" aria-controls="installer_Incoming_Request" aria-selected="false">Incoming Request</a>
        </li>
    <?php }
    ?>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active installer_Submitted_Request" id="installer_Submitted_Request" role="tabpanel" aria-labelledby="profile-tab">

        <h5> Submitted Request</h5>
        <div class="include_installer_request_by_me">
            <?php $this->load->view('frontend/user/include_installer_request_by_me.php'); ?> 
        </div>                               
    </div>

    <div class="tab-pane fade " id="installer_Incoming_Request" role="tabpanel" aria-labelledby="home-tab">
        <h5>Incoming Request</h5>

        <div class="include_installer_request_for_me">
            <?php $this->load->view('frontend/user/include_installer_request_for_me.php'); ?>
        </div>
    </div>

</div>





<div class="modal fade" id="viewInstallerRequestModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Service Request Details</h5>
                <img class="close closeicon2" data-dismiss="modal" aria-label="Close" src="../assets/frontend/images/closeicon.png" alt="" />
            </div>
            <div class="modal-body">
                <div class="inner_cont_blog">


                </div>
            </div> 
        </div>
    </div>
</div>
<!--  -->