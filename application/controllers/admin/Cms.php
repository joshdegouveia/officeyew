<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * 
 */
class Cms extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Cms_model');

        if ($this->userLogged() == false) {
            // redirect them to the login page
            redirect('admin/auth/login', 'refresh');
            exit;
        }
    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index($inactive = false) {
        $this->commonData['activeMenues']['menuParent'] = 'cms';
        $this->commonData['activeMenues']['menuChild'] = 'cms-list';

        $this->commonData['title'] = "CMS";
        $cms = $this->Users_model->getData('cms',array(),'',array(),array(), array('order_by'=>'id','sort'=>'desc'));
        $this->commonData['cms'] = $cms;

        $this->loadScreen('cms');
    }

    public function edit() {

        $cid = ($this->input->get('cid')) ? $this->input->get('cid') : '';

        if (empty($cid)) {
            redirect('admin/cms', 'refresh');
        }

        $this->commonData['activeMenues']['menuParent'] = 'cms';
        $this->commonData['activeMenues']['menuChild'] = 'cms-list';

        $this->commonData['title'] = "CMS";
        $cms = $this->Users_model->getData('cms', array('id' => $cid));

        if (empty($cms)) {
            redirect('admin/cms', 'refresh');
        }

        $extra_fields = array();
        switch ($cms[0]->type) {
            case 'contactus':
                $extra_fields = array(
                    'header_text' => array('type' => 'textarea', 'title' => 'Header Text', 'wysihtml' => true),
                    'header_address1' => array('type' => 'textarea', 'title' => 'Header Address1', 'wysihtml' => true),
                    'header_address2' => array('type' => 'textarea', 'title' => 'Header Address2', 'wysihtml' => true)
                );
                break;
            case 'aboutus':
                $extra_fields = array(
                    'header_image' => array('type' => 'file', 'title' => 'Header Image', 'accept' => 'image/*'),
                    'bottom_image' => array('type' => 'file', 'title' => 'Bottom Image', 'accept' => 'image/*'),
                );
                break;
        }

        if ($this->input->post('name')) {
            $post = $this->input->post();
            $extra_fields_arr = array();

            if (!empty($extra_fields)) {
                $path = 'pages/';
                $upload_dir = UPLOADDIR . $path;
                if ($_SERVER['HTTP_HOST'] == 'localhost') {
                    $path = 'pages\\';
                    $upload_dir = UPLOADDIR . $path;
                }

                folderCheck($upload_dir);
                $folder_path = $upload_dir . "/";

                foreach ($extra_fields as $k => $value) {
                    if ($value['type'] != 'file') {
                        if ($post[$k]) {
                            $extra_fields_arr[$k] = $post[$k];
                        }
                    } else if ($value['type'] == 'file') {
                        if (!empty($_FILES[$k]['name'])) {
                            $files = $_FILES[$k];
                            $image_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');

                            if (in_array($files['type'], $image_types)) {
                                $ext_arr = explode('.', $files['name']);

                                $config['upload_path'] = $folder_path;
                                $config['allowed_types'] = '*';
                                $config['max_size'] = '0';
                                $config['max_width'] = '0';
                                $config['max_height'] = '0';
                                $config['overwrite'] = TRUE;
                                $image = 'pgimg_' . time() . '_' . rand(111, 999) . '.' . end($ext_arr);
                                $config['file_name'] = $image;
                                $config['orig_name'] = $files['name'];
                                $config['image'] = $image;
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                                if ($this->upload->do_upload($k)) {
                                    $extra_fields_arr[$k] = $image;
                                    if (file_exists(UPLOADDIR . 'pages/' . $post['old_' . $k])) {
                                        @unlink($upload_dir . $post['old_' . $k]);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $fields = array(
                'name' => $post['name'],
                'modified_date' => time(),
                'attached' => (!empty($extra_fields_arr)) ? serialize($extra_fields_arr) : '',
            );

            if ($cms[0]->type == 'video_link') {
                $fields['link'] = $post['video_link'];
            } else {
                $fields['body'] = $post['body'];
                $fields['sub_description'] = $post['sub_description'];
            }

            $this->Users_model->updateData('cms', array('id' => $cid), $fields);
            /* update meta */
            $fields = array(
                'meta_key' => $post['meta_key'],
                'meta_description' => $post['meta_description'],
                'modified_date' => time()
            );
            $meta_data = $this->Users_model->getData('seo_data', array('page_id' => $cid));
            if (empty($meta_data)) {
                $fields['created_date'] = time();
                $fields['page_id'] = $cid;
                $this->Users_model->insertData('seo_data', $fields);
            } else {
                $this->Users_model->updateData('seo_data', array('page_id' => $cid), $fields);
            }
            /* update meta */
            $this->session->set_flashData('msg_success', '<em>' . $this->input->post('name') . '</em> successfully updated.');
            redirect(base_url('admin/cms'), 'refresh');
        }

        $meta_data = $this->Users_model->getData('seo_data', array('page_id' => $cid));

        $this->commonData['cms'] = $cms[0];
        $this->commonData['meta_data'] = (!empty($meta_data)) ? $meta_data[0] : array();
        $this->commonData['extra_fields'] = $extra_fields;
        $this->loadScreen('add_cms');
    }

    public function notification_list($inactive = false) {
        $this->commonData['activeMenues']['menuParent'] = 'cms';
        $this->commonData['activeMenues']['menuChild'] = 'notification-list';

        $this->commonData['title'] = "Notification";
        $la_notification = $this->Cms_model->getNotificationListAdmin();
        $this->commonData['la_notification'] = $la_notification;

        $this->loadScreen('cms/notification_list');
    }

    public function seller_review() {
        $this->commonData['activeMenues']['menuParent'] = 'cms';
        $this->commonData['activeMenues']['menuChild'] = 'seller_review';

        $this->commonData['title'] = "Seller review";
        $la_review = $this->Cms_model->get_seller_review();
        $this->commonData['la_review'] = $la_review;

        $this->loadScreen('cms/seller_review');
    }

    public function job_posting_charge_list() {
        $this->commonData['activeMenues']['menuParent'] = 'boost';
        $this->commonData['activeMenues']['menuChild'] = 'job_posting';

        $this->commonData['title'] = "Job posting charge";
        $la_data = $this->Cms_model->job_posting_charge_list();

        $this->commonData['la_data'] = $la_data;

        $this->loadScreen('job_posting/job_posting_charge_list');
    }

    public function add_job_posting_charge() {
        $this->commonData['activeMenues']['menuParent'] = 'boost';
        $this->commonData['activeMenues']['menuChild'] = 'job_posting';

        $this->commonData['title'] = "Add Job posting charge";

        $la_data = [];
        if (isset($_GET['id']) && ($_GET['id'] > 0)) {

            $this->db->select('jpc.*')->from('job_posting_charges jpc')->where("jpc.job_posting_charges_id", $_GET['id']);
            $la_data = $this->db->get()->row();
        }
//        print_r($_REQUEST);
//        die;
        if (isset($_POST) && (!empty($_POST))) {
            $post = $_POST;
            $data['job_category'] = $post['job_category'];
            $data['price'] = $post['price'];
            $data['description'] = $post['description'];
            $data['duration_in_week'] = ($post['job_category'] == 'per_post') ? $post['duration_in_week'] : 0;
            $data['status'] = $post['status'];
            if (isset($_REQUEST['id'])) {
                $update_id = $this->db->update('job_posting_charges', $data, ['job_posting_charges_id' => $_REQUEST['id']]);
                if ($update_id) {
                    redirect(base_url('admin/cms/job_posting_charge_list'), 'refresh');
                    $this->session->set_flashData('msg_success', 'Successfully updated.');
                }
            } else {
                $insert_id = $this->db->insert('job_posting_charges', $data);
                if ($insert_id) {
                    redirect(base_url('admin/cms/job_posting_charge_list'), 'refresh');
                    $this->session->set_flashData('msg_success', 'Successfully added.');
                }
            }
        }


        $this->commonData['la_data'] = $la_data;
        $this->loadScreen('job_posting/add_job_posting_charge');
    }

}
