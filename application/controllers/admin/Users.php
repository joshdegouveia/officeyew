<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * 
 */
class Users extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->load->model('users_model');

        if ($this->userLogged() == false) {
            // redirect them to the login page
            redirect('admin/auth/login', 'refresh');
            exit;
        }
    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index($type = '') {
        if ($this->input->post('upload_users')) {
            $file = $_FILES['upload'];
            if (!empty($file['name']) && $file['error'] == 0 && $file['size'] > 0) {
                $csv = fopen($file['tmp_name'], 'r');
                $fields = array('fullname' => 0, 'email' => 0, 'phone' => 0, 'password' => 0);
                $is_first = true;
                $fields_arr = array();
                while (($column = fgetcsv($csv, 10000, ',')) != false) {
                    // pre($column);
                    if ($is_first) {
                        $is_first = false;
                        foreach ($column as $k => $value) {
                            $value = strtolower(str_replace(' ', '', $value));
                            switch ($value) {
                                case 'fullname':
                                    $fields['fullname'] = $k;
                                    break;
                                case 'email':
                                    $fields['email'] = $k;
                                    break;
                                case 'phone':
                                    $fields['phone'] = $k;
                                    break;
                                case 'password':
                                    $fields['password'] = $k;
                                    break;
                            }
                        }
                        continue;
                    }

                    $fields_arr[] = array(
                        'uniqueid' => uniqid(),
                        'password' => md5($column[$fields['password']]),
                        'email' => $column[$fields['email']],
                        'first_name' => $column[$fields['fullname']],
                        'type' => $type
                    );
                }

                $this->users_model->insertBatch('users', $fields_arr);
                $this->session->set_flashdata('msg_success', 'Users upload successfully.');
                redirect('admin/' . $type, 'refresh');
            }
        }
        $this->commonData['activeMenues']['menuParent'] = 'users';
        // $this->commonData['activeMenues']['menuChild'] = 'users-list' ;

        $this->commonData['title'] = ucwords($type) . " Users";
        $this->commonData['users'] = $this->users_model->getData('users', array('type' => $type));
        // $this->commonData['superadmin'] = superAdmin();
        $this->commonData['type'] = $type;

        $this->loadScreen('users');
    }

    public function b2b() {
        $this->commonData['activeMenues']['menuChild'] = 'b2b-list';
        $this->index(B2B);
    }

    public function seller() {
        $this->commonData['activeMenues']['menuChild'] = 'seller-list';
        $this->index(SELLER);
    }

    public function customer() {
        $this->commonData['activeMenues']['menuChild'] = 'customer-list';
        $this->index(CUSTOMER);
    }

    public function user_list() {
        $ls_userType = $this->uri->segment(4);
        if ($ls_userType == '') {
            redirect('admin/auth/login', 'refresh');
            exit;
        }
        $this->commonData['activeMenues']['menuParent'] = 'users';
        $this->commonData['activeMenues']['menuChild'] = $ls_userType;

        $this->commonData['title'] = "Manage " . ucfirst($ls_userType);
        $la_userList = $this->users_model->getUserListByType($ls_userType);

        $this->commonData['userType'] = $ls_userType;
        $this->commonData['datas'] = $la_userList;
        $this->loadScreen('user/user_list');
    }

    /* public function add () {
      if ($this->input->post()) {
      $post = $this->input->post();
      $email_exist = $this->users_model->getData('users', array('email' => trim($post['email'])), 'id');

      if (empty($email_exist)) {
      // $this->load->model('Ion_auth_model');
      $password = md5($post['password']);

      // if ($post['type'] == ADMIN) {
      // $password = $this->Ion_auth_model->hash_password($post['password']);
      // }

      $fields = array(
      'first_name' => trim($post['first_name']),
      'last_name' => trim($post['last_name']),
      'ip_address' => $_SERVER['SERVER_ADDR'],
      'email' => trim($post['email']),
      'password' => $password,
      'type' => 'customer',// $post['type'],
      'created_date' => time(),
      'modified_date' => time(),
      'phone' => trim($post['phone']),
      'provinces' => $post['country'],
      'state' => trim($post['state']),
      'city' => trim($post['city']),
      );

      $uid = $this->users_model->insertUser($fields);

      /*if ($post['type'] == 'employee') {
      $departments = ($this->input->post('departments')) ? $this->input->post('departments') : array();

      if (!empty($departments)) {
      $fields = array();
      foreach ($departments as $value) {
      if (empty($value)) continue;
      $fields[] = array(
      'department_id' => $value,
      'user_id' => $uid,
      'created_date' => time(),
      );
      }

      if (!empty($fields)) {
      $this->users_model->insertBatch('department_assign', $fields);
      }
      }
      } else if ($post['type'] == ADMIN) {
      $fields = array(
      'user_id' => $uid,
      'group_id' => 1
      );

      $this->users_model->insertData('users_groups', $fields);
      } */

    /* $this->session->set_flashdata('msg_success', 'User added successfully');
      redirect('admin/users', 'refresh');
      }
      $this->session->set_flashdata('msg_error', 'Email already exist');
      }

      $this->load->helper('custom_helper');
      $countries = getCountries();

      $this->commonData['activeMenues']['menuParent'] = 'users';
      $this->commonData['activeMenues']['menuChild'] = 'add-user';

      $this->commonData['title'] = "User Profile";
      $this->commonData['countries'] = $countries;

      $this->loadScreen('add_user');
      } */

    /**
     * Function for individual user profile
     */
    public function profile() {
        $this->commonData['activeMenues']['menuParent'] = 'setting';
        $this->commonData['activeMenues']['menuChild'] = 'profile';

        $this->commonData['title'] = "My Profile";
        //echo '<pre>' ; print_r($this->session->userdata()) ;exit () ;
        $userId = $this->session->userdata('user_id');
        $userDetail = $this->users_model->getData('users', array('id' => $userId));
        $this->commonData['userDetail'] = $userDetail[0];

        $this->loadScreen('profile');
    }

    /**
     * Function for update user profile
     */
    public function updateProfile() {
        $postData = $this->input->post();

        $firstName = $postData['first_name'];
        $lastName = $postData['last_name'];
        $email = $postData['email'];
        // $phone = $postData['phone'] ;
        $userId = $postData['user_id'];

        if ($email != $this->session->userdata('email')) {
            $exist = $this->users_model->emailCheck($email);
            if ($exist) {
                $this->session->set_flashdata('eMessage', 'Email already exist.');
                redirect('admin/users/profile', 'refresh');
                exit();
            }
        }

        $data = array(
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
                // 'phone' => $phone
        );
        $this->users_model->update($userId, $data);
        $this->session->set_flashdata('sMessage', 'Profile updated successfully.');

        $this->session->set_userdata('email', $email);
        $this->session->set_userdata('identity', $email);

        redirect('admin/users/profile', 'refresh');
    }

    public function changeUserStat() {
        $user_id = ($this->input->get('uid')) ? $this->input->get('uid') : '';
        $stat = ($this->input->get('stat') && $this->input->get('stat') == '1') ? '0' : '1';
        $type = ($this->input->get('tp')) ? $this->input->get('tp') : '';

        /* echo $user_id.'<br>'.$stat.'-<br>'.$type.'<br>';
          exit; */
        if (empty($user_id)) {
            redirect('admin/users/user_list/' . $type, 'refresh');
        }

        $fields = array(
            'active' => $stat
        );
        $this->users_model->updateData('users', array('id' => $user_id), $fields);
        // echo 'done';
        redirect('admin/users/user_list/' . $type, 'refresh');
    }

    public function delete() {
        $user_id = ($this->input->get('uid')) ? $this->input->get('uid') : '';
        $type = ($this->input->get('tp')) ? $this->input->get('tp') : '';

        if (empty($user_id)) {
            redirect('admin/' . $type, 'refresh');
        }

        $this->users_model->delete($user_id);
        $this->session->set_flashdata('msg_success', 'User deleted successfully.');
        redirect('admin/' . $type, 'refresh');
    }

    public function edit() {
        $user_id = ($this->input->get('uid')) ? $this->input->get('uid') : '';

        if (empty($user_id)) {
            redirect('admin/users', 'refresh');
        }

        if ($this->input->post()) {
            $post = $this->input->post();
            $email_exist = $this->users_model->getData('users', array('email' => trim($post['email']), 'id !=' => $user_id), 'id');

            if (!empty($email_exist)) {
                $this->session->set_flashdata('msg_error', 'Email already exist.');
                redirect('admin/users/edit?uid=' . $user_id, 'refresh');
            }

            $user = $this->users_model->getData('users', array('id' => $user_id), 'type');

            $fields = array(
                'first_name' => trim($post['first_name']),
                'last_name' => trim($post['last_name']),
                'modified_date' => time(),
                'phone' => trim($post['phone']),
                    //'country' => $post['country'],
                    //'state' => (isset($post['state'])) ? $post['state'] : '',
                    //'city' => (isset($post['city'])) ? $post['city'] : '',
            );

            $this->users_model->update($user_id, $fields);

            $stripe_details = $this->users_model->getData('user_bank_details', array('user_id' => $user_id));

            if (!empty($stripe_details)) {
                $fields = array('stripe_no' => $post['stripe'], 'modified_date' => time());
                $this->users_model->updateData('user_bank_details', array('user_id' => $user_id), $fields);
            } else {
                $fields = array(
                    'user_id' => $user_id,
                    'stripe_no' => $post['stripe'],
                    'created_date' => time(),
                    'modified_date' => time()
                );
                $this->users_model->insertData('user_bank_details', $fields);
            }

            $this->session->set_flashdata('msg_success', 'User <em>' . $post['first_name'] . ' ' . $post['last_name'] . '</em> updated successfully.');
            redirect('admin/' . $user[0]->type, 'refresh');
        }

        $this->load->helper('custom_helper');
        $countries = getCountries();
        $user_detail = $this->users_model->getData('users', array('id' => $user_id));
        $stripe = $this->users_model->getData('user_bank_details', array('user_id' => $user_id), 'stripe_no');

        $this->commonData['activeMenues']['menuParent'] = 'users';
        $this->commonData['activeMenues']['menuChild'] = 'users-list';

        $this->commonData['title'] = "User Profile";
        $this->commonData['user_detail'] = $user_detail[0];
        $this->commonData['countries'] = $countries;
        $this->commonData['stripe'] = (!empty($stripe)) ? $stripe[0]->stripe_no : '';

        $this->loadScreen('add_user');
    }

    public function checkEmail() {
        $post = $this->input->post();
        $where = array('email' => trim($post['email']));

        if (!empty($post['uid'])) {
            $where = array('email' => trim($post['email']), 'id !=' => $post['uid']);
        }

        $email_exist = $this->users_model->getData('users', $where, 'id');

        if (!empty($email_exist)) {
            $response = array(
                'success' => false,
                'msg' => 'Email already exist',
            );
            echo json_encode($response);
        } else {
            $response = array(
                'success' => true,
                'msg' => 'Email is usable',
            );
            echo json_encode($response);
        }
    }

    public function detail() {
        $user_id = ($this->input->get('uid')) ? $this->input->get('uid') : '';

        if (empty($user_id)) {
            redirect('admin/' . $type, 'refresh');
        }

        $user_detail = $this->users_model->getUserListById($user_id);
//		$user_detail = $this->users_model->getData('users', array('id' => $user_id));
        $user_bank_detail = $this->users_model->getData('user_bank_details', array('user_id' => $user_id));
        $user_store_detail = array();
        if ($user_detail[0]->type == SELLER) {
            $user_store_detail = $this->users_model->getData('store', array('user_id' => $user_detail[0]->id));
            if (!empty($user_store_detail)) {
                $user_store_detail = $user_store_detail[0];
            }
        }

        $this->commonData['activeMenues']['menuParent'] = 'users';
        $this->commonData['activeMenues']['menuChild'] = $user_detail[0]->type . '-list';

        $this->commonData['title'] = "User Profile";
        $this->commonData['user_detail'] = $user_detail[0];
        $this->commonData['user_bank_detail'] = (!empty($user_bank_detail)) ? $user_bank_detail[0] : array();
        $this->commonData['user_store_detail'] = $user_store_detail;

        $this->loadScreen('user/user_detail');
    }

    public function getCity() {
        $post = $this->input->post();
        $cities = $this->users_model->getData('cities', array('state_id' => $post['val']), 'id, name');
        $response['success'] = true;
        $response['msg'] = 'done';
        $response['data'] = $cities;
        echo json_encode($response);
    }

    public function downloadusers($type) {
        if ($type == 'sample') {
            $delimiter = ',';
            $filename = 'Sample-csv-format' . '.csv';
            $fp = fopen('php://memory', 'w');
            $fields = array('Full Name', 'Email', 'Phone', 'Password');
            fputcsv($fp, $fields, $delimiter);
            $fields = array('Alex', 'alex@mail.com', '9876543210', 'password123');
            fputcsv($fp, $fields, $delimiter);
            fseek($fp, 0);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');
            fpassthru($fp);
        } else {
            $users = $this->users_model->getData('users', array('type' => $type), 'uniqueid, CONCAT(first_name, " ", last_name) AS fullname, email, phone');

            if (!empty($users)) {
                $delimiter = ',';
                $filename = ucwords($type) . '-users-list-' . date('d-m-Y') . '.csv';
                $fp = fopen('php://memory', 'w');
                $fields = array('Unique ID', 'Full Name', 'Email', 'Phone');
                fputcsv($fp, $fields, $delimiter);

                foreach ($users as $value) {
                    $line = array($value->uniqueid, $value->fullname, $value->email, $value->phone);
                    fputcsv($fp, $line, $delimiter);
                }

                fseek($fp, 0);
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '";');
                fpassthru($fp);
            } else {
                redirect(base_url('admin/users/' . $type), 'refresh');
            }
        }

        exit;
    }

    public function boost_subscription() {

        $la_data = $this->users_model->get_boost_users();

        $this->commonData['activeMenues']['menuParent'] = 'subscription';
        $this->commonData['activeMenues']['menuChild'] = 'boost_subscription';

        $this->commonData['title'] = "Boost subscription";
        $this->commonData['la_data'] = $la_data; 

        $this->loadScreen('subscription/boost_subscription');
    }

}
