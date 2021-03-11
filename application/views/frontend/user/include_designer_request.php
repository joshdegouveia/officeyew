<ul class="nav nav-tabs" id="myTab" role="tablist">

    <?php if ($user['type'] == 'designer') {
        ?> 
        <li class="nav-item ">
            <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#designer_Submitted_Request" role="tab" aria-controls="designer_Submitted_Request" aria-selected="true">Submitted Request</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="home-tab" data-toggle="tab" href="#designer_Incoming_Request" role="tab" aria-controls="designer_Incoming_Request" aria-selected="false">Incoming Request</a>
        </li>
        <?php }
    ?>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="designer_Submitted_Request" role="tabpanel" aria-labelledby="profile-tab">

        <h5> Submitted Request</h5>
        <div class="include_designer_request_by_me">
            <?php $this->load->view('frontend/user/include_designer_request_by_me.php'); ?> 
        </div>                               
    </div>

    <div class="tab-pane fade " id="designer_Incoming_Request" role="tabpanel" aria-labelledby="home-tab">
        <h5>Incoming Request</h5>

        <div class="include_designer_request_for_me">
            <?php $this->load->view('frontend/user/include_designer_request_for_me.php'); ?>
        </div>
        <?php // $this->load->view('frontend/user/include_script/include_manage_profile_js.php'); ?>
    </div>

</div>





<div class="modal fade" id="viewDesignerPurchaseRequestModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Service Request Details</h5>
                <img class="close closeicon2" data-dismiss="modal" aria-label="Close" src="../assets/frontend/images/closeicon.png" alt="" />
            </div>
            <div class="modal-body">
                <div class="inner_cont_blog">
                    <p><span>Request Type: </span><strong class="request_type">--</strong></p>
                    <p><span>Space planning needed: </span><strong class="planning_needed">--</strong></p>
                    <p><span>Project scope: </span><strong class="project_scope">--</strong></p>
                    <p><span>What do you want to achieve with this space: </span><strong class="acheive_space">--</strong></p>
                    <p><span>Style preference: </span><strong  class="style_preference">--</strong></p>
                    <p><span>Technology requirements: </span><strong  class="technology_requirement">--</strong></p>
                    <p><span>Construction involved: </span><strong  class="construction_involved">--</strong></p>
                    <p><span>Time frame: </span><strong  class="time_frame">--</strong></p>
                    <p><span>Check off areas required for: </span><strong  class="areas_required">--</strong></p> 
                    <!--<p><span>Collaboration: </span><strong  class="collaboration">--</strong></p>--> 
                    <p class='selected_designer_user'><span>Selected Designer: </span><strong  class="selected_designer">--</strong></p> 
                    <p><span>Message: </span><strong  class="message">--</strong></p> 

                </div>
            </div> 
        </div>
    </div>
</div>
<!--  -->