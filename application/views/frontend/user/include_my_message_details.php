<div class="orders-container message_details_parent_content" style="display: none;">
    <div class="row">
        <i class="fa fa-times-circle-o fa-2x" id="message_details_to_listing" ></i>
    </div>
    <div class="row">
        <div class="col-lg-5">            
            <div class="chat-list">
                <div class="search-in">
                    <input type="search" class="form-control search-input search_user_for_chat" id="gsearch" name="gsearch" placeholder="Search user name" title="Enter to search"  autocomplete="off">
                </div>

                <?php
                $noImgPath = BASE_URL . 'assets/upload/user/profile/no_img.png';
                ?>

                <div class="list-column include_my_message_details_user_list">
                    <?php
                    $this->load->view('frontend/user/include_my_message_details_user_list.php');
                    ?>


                </div>                
            </div>
        </div>

        <div class="col-lg-7">
            <div class="chat-message">
                <div class="profile-info-head" id="msg_chat_head">
                    <div class="img-profile">
                        <img src="<?php echo $noImgPath; ?>" alt="user-1">
                    </div>
                    <div class="profile-name">
                        <span id="msg_chat_head_profile_name">Ada Lovelace</span>
                    </div>                    
                </div>
                <div class="message-body user_message_chat">
                    <center><br><br><i class="fa fa-spin fa-spinner fa-5x"></i></center>
                    <?php
//                    $this->load->view('frontend/user/include_my_message_chat.php');
                    ?>

                </div>
                <div class="message-box">
                    <input type="text" class="chat_message_text" name="send_message" placeholder="Write here">
                    <button type="button" class="btn btn-light chat_message_send">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>

