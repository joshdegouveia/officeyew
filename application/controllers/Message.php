<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Message extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Message_model');
        $this->load->model('Users_model');
    }

    public function ajax_get_message_chat() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $thisId = $_POST['thisId'];
            $thisIdArr = explode('__', $thisId);
            $send_from = $thisIdArr[0];
            $send_to = $thisIdArr[1];
            $flagId = $thisIdArr[2];
            $flag = $thisIdArr[3];
            $frontUserId = ($user['id'] == $send_from) ? $send_to : $send_from;
            if ($flag == 'pro') {
                $this->Users_model->updateData('message_chatting', ['send_from' => $frontUserId, 'send_to' => $user['id'], 'product_id' => $flagId, 'is_seen' => 'N'], ['is_seen' => 'Y']);
            } else {
                $this->Users_model->updateData('message_chatting', ['send_from' => $frontUserId, 'send_to' => $user['id'], 'purchase_id' => $flagId, 'is_seen' => 'N'], ['is_seen' => 'Y']);
//                $la_chat = $this->Message_model->get_message_chat_data($send_from, $send_to, $flagId);
            }
            $la_chat = $this->Message_model->get_message_chat_data($send_from, $send_to, $flagId, $flag);
            ob_start();
            include(APPPATH . 'views/frontend/user/include_my_message_chat.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        }
        echo json_encode($response);
    }

    public function ajax_send_message_chat() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $post = $_POST;

            $thisId = $post['msgUrserData'];
            $thisIdArr = explode('__', $thisId);
            $send_from = $thisIdArr[0];
            $send_to = $thisIdArr[1];
            $flagId = $thisIdArr[2];
            $flag = $thisIdArr[3];

            $la_chatField = [];
            if ($flag == 'pro') {
                $la_chatField['product_id'] = $flagId;
            } else {
                $la_chatField['purchase_id'] = $flagId;
            }
            $la_chatField['send_to'] = ($user['id'] == $send_from) ? $send_to : $send_from;
            $la_chatField['send_from'] = $user['id'];
            $la_chatField['subject'] = 'chat';
            $la_chatField['message'] = $post['chat_text'];
            $la_chatField['created_on'] = $la_chatField['updated_on'] = date('Y-m-d H:i:s');
            $la_chatField['ip'] = get_client_ip();

            $insertId = $this->Users_model->insertData('message_chatting', $la_chatField);
            if ($insertId) {
                $content = "<div class='clearfix'></div><div class='send-chat' title='" . date('D d M, Y H:i:s') . "'>" . $post['chat_text'] . "</div>";

                $response['success'] = true;
                $response['content'] = $content;
                $response['data'] = $la_chatField;
                $response['msg'] = 'success';
            }
        }
        echo json_encode($response);
    }

    public function ajax_search_user_for_chat() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $post = $_POST;
            $userName = $post['userName'];

            $la_myMessageListAll = $this->Message_model->my_message_list($user['id'], [], $userName);

            ob_start();
            include(APPPATH . 'views/frontend/user/include_my_message_details_user_list.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        }
        echo json_encode($response);
    }

}
